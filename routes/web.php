<?php

use App\Mail\AdminOrderNotification;
use App\Mail\CustomerOrderConfirmation;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\Testimonial;
use App\Models\User;
use App\Models\Visit;
use App\Support\SiteContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

$sections = ['hero', 'trust', 'services', 'why', 'about', 'contact', 'products', 'orders'];

Route::get('/', function (Request $request) use ($sections) {
    // Track visit (bot/admin filter ola bilər; sadə implementasiya)
    try {
        Visit::create([
            'ip'         => $request->ip(),
            'user_agent' => substr((string) $request->userAgent(), 0, 255),
            'path'       => '/',
        ]);
    } catch (\Throwable) {
        // silent
    }
    $data = [];
    foreach ($sections as $s) {
        $data[$s] = SiteContent::get($s);
    }
    $data['categories'] = Category::orderBy('sort_order')->orderBy('id')->get();
    $data['testimonials'] = Testimonial::where('published', true)
        ->orderBy('sort_order')->orderBy('id')->get();
    return view('home', $data);
});

Route::get('/admin', function () {
    return view('admin');
})->name('admin');

Route::post('/admin/login', function (Request $request) {
    $data = $request->validate([
        'username' => 'required|string|max:120',
        'password' => 'required|string|max:200',
    ]);
    $user = User::where('name', $data['username'])->first();
    if (!$user || !Hash::check($data['password'], $user->password)) {
        return response()->json(['error' => 'İstifadəçi adı və ya şifrə yanlışdır'], 401);
    }
    Auth::login($user, remember: false);
    $request->session()->regenerate();
    return response()->json(['ok' => true]);
})->name('admin.login');

Route::post('/admin/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return response()->json(['ok' => true]);
})->name('admin.logout');

Route::post('/order', function (Request $request) {
    $data = $request->validate([
        'name'    => 'required|string|max:120',
        'phone'   => 'required|string|max:40',
        'email'   => 'nullable|email|max:120',
        'service' => 'required|string|max:80',
        'notes'   => 'nullable|string|max:2000',
    ]);

    $order = SiteContent::appendOrder($data);

    // Bildiriş email-ləri — sifariş uğurla yadda saxlandı, mail xətası
    // müştəriyə sızmamalıdır.
    try {
        $adminMail = config('technobey.admin_mail');
        if ($adminMail) {
            Mail::to($adminMail)->send(new AdminOrderNotification($order));
        }
    } catch (\Throwable $e) {
        Log::error('Admin mail send failed: ' . $e->getMessage());
    }

    if (!empty($order->email)) {
        try {
            Mail::to($order->email)->send(new CustomerOrderConfirmation($order));
        } catch (\Throwable $e) {
            Log::error('Customer mail send failed: ' . $e->getMessage());
        }
    }

    if ($request->expectsJson() || $request->ajax()) {
        return response()->json(['ok' => true]);
    }
    return back()->with('ok', true);
})->name('order.store');

// ===== STATS API =====
Route::get('/api/stats', function () {
    $tz = new \DateTimeZone('Asia/Baku');
    $now = new \DateTimeImmutable('now', $tz);
    $start = $now->modify('-11 months')->modify('first day of this month')->setTime(0, 0, 0);

    // Son 12 ayın etiketləri
    $months = [];
    $monthKeys = [];
    for ($i = 0; $i < 12; $i++) {
        $m = $start->modify("+{$i} months");
        $months[] = $m->format('M Y');
        $monthKeys[] = $m->format('Y-m');
    }

    $monthlyOrders = array_fill_keys($monthKeys, 0);
    $monthlyVisits = array_fill_keys($monthKeys, 0);

    // Orders qrupla
    Order::where('created_at', '>=', $start->format('Y-m-d H:i:s'))
        ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as ym, COUNT(*) as c")
        ->groupBy('ym')
        ->get()
        ->each(function ($row) use (&$monthlyOrders) {
            if (isset($monthlyOrders[$row->ym])) {
                $monthlyOrders[$row->ym] = (int) $row->c;
            }
        });

    // Visits qrupla
    Visit::where('created_at', '>=', $start->format('Y-m-d H:i:s'))
        ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as ym, COUNT(*) as c")
        ->groupBy('ym')
        ->get()
        ->each(function ($row) use (&$monthlyVisits) {
            if (isset($monthlyVisits[$row->ym])) {
                $monthlyVisits[$row->ym] = (int) $row->c;
            }
        });

    // Kateqoriya üzrə məhsullar
    $byCat = Product::selectRaw('cat, COUNT(*) as c')
        ->groupBy('cat')
        ->pluck('c', 'cat')
        ->all();

    // Xidmət növü üzrə sifarişlər (top 6)
    $byService = Order::selectRaw('service, COUNT(*) as c')
        ->groupBy('service')
        ->orderByDesc('c')
        ->limit(6)
        ->pluck('c', 'service')
        ->all();

    // İcmal kartları
    $thisMonthStart = $now->modify('first day of this month')->setTime(0, 0, 0);
    $monthOrders = Order::where('created_at', '>=', $thisMonthStart->format('Y-m-d H:i:s'))->count();
    $monthVisits = Visit::where('created_at', '>=', $thisMonthStart->format('Y-m-d H:i:s'))->count();
    $totalOrders = Order::count();
    $totalVisits = Visit::count();
    $totalProducts = Product::count();

    // Həftəlik müqayisə
    $thisWeekStart = $now->modify('monday this week')->setTime(0, 0, 0);
    $lastWeekStart = $thisWeekStart->modify('-7 days');
    $ordersThisWeek = Order::where('created_at', '>=', $thisWeekStart->format('Y-m-d H:i:s'))->count();
    $ordersLastWeek = Order::whereBetween('created_at', [
        $lastWeekStart->format('Y-m-d H:i:s'),
        $thisWeekStart->format('Y-m-d H:i:s'),
    ])->count();
    $visitsThisWeek = Visit::where('created_at', '>=', $thisWeekStart->format('Y-m-d H:i:s'))->count();
    $visitsLastWeek = Visit::whereBetween('created_at', [
        $lastWeekStart->format('Y-m-d H:i:s'),
        $thisWeekStart->format('Y-m-d H:i:s'),
    ])->count();
    $pctChange = function ($cur, $prev) {
        if ($prev == 0) return $cur > 0 ? 100 : 0;
        return (int) round((($cur - $prev) / $prev) * 100);
    };

    // Sifariş statusları paylanması
    $statusCounts = Order::selectRaw('status, COUNT(*) as c')
        ->groupBy('status')->pluck('c', 'status')->all();

    // Son 5 sifariş
    $recentOrders = Order::orderByDesc('id')->limit(5)->get()->map(function ($o) {
        return [
            'id'         => $o->id,
            'name'       => $o->name,
            'service'    => $o->service,
            'status'     => $o->status ?: 'new',
            'track_code' => $o->track_code,
            'date'       => optional($o->created_at)->setTimezone('Asia/Baku')->format('d.m H:i'),
        ];
    })->all();

    // Aşağı ehtiyat xəbərdarlığı
    $lowStock = Product::where('stock', '<=', 3)->orderBy('stock')->limit(6)->get()
        ->map(fn ($p) => ['id' => $p->id, 'name' => $p->name, 'stock' => (int) $p->stock, 'emoji' => $p->emoji, 'image' => $p->image])
        ->all();

    // Son 7 gün ziyarətçi (günlük)
    $weekStart = $now->modify('-6 days')->setTime(0, 0, 0);
    $weekLabels = [];
    $weekKeys = [];
    for ($i = 0; $i < 7; $i++) {
        $d = $weekStart->modify("+{$i} days");
        $weekLabels[] = $d->format('d.m');
        $weekKeys[] = $d->format('Y-m-d');
    }
    $dailyVisits = array_fill_keys($weekKeys, 0);
    Visit::where('created_at', '>=', $weekStart->format('Y-m-d H:i:s'))
        ->selectRaw("DATE(created_at) as d, COUNT(*) as c")
        ->groupBy('d')
        ->get()
        ->each(function ($row) use (&$dailyVisits) {
            if (isset($dailyVisits[$row->d])) {
                $dailyVisits[$row->d] = (int) $row->c;
            }
        });

    return response()->json([
        'summary' => [
            'monthOrders'    => $monthOrders,
            'monthVisits'    => $monthVisits,
            'totalOrders'    => $totalOrders,
            'totalVisits'    => $totalVisits,
            'totalProducts'  => $totalProducts,
            'ordersDeltaPct' => $pctChange($ordersThisWeek, $ordersLastWeek),
            'visitsDeltaPct' => $pctChange($visitsThisWeek, $visitsLastWeek),
            'ordersThisWeek' => $ordersThisWeek,
            'visitsThisWeek' => $visitsThisWeek,
        ],
        'monthly' => [
            'labels' => $months,
            'orders' => array_values($monthlyOrders),
            'visits' => array_values($monthlyVisits),
        ],
        'weekly' => [
            'labels' => $weekLabels,
            'visits' => array_values($dailyVisits),
        ],
        'byCat'        => $byCat,
        'byService'    => $byService,
        'statusCounts' => $statusCounts,
        'recentOrders' => $recentOrders,
        'lowStock'     => $lowStock,
    ]);
});

// ===== ADMIN API =====
Route::get('/api/site/{section}', function (string $section) use ($sections) {
    if (!in_array($section, $sections, true)) {
        return response()->json(['error' => 'Unknown section'], 404);
    }
    return response()->json(SiteContent::get($section));
});

Route::post('/api/site/{section}', function (Request $request, string $section) use ($sections) {
    if (!in_array($section, $sections, true)) {
        return response()->json(['error' => 'Unknown section'], 404);
    }
    $payload = $request->json()->all();
    if (!is_array($payload)) {
        return response()->json(['error' => 'Invalid payload'], 422);
    }
    SiteContent::save($section, $payload);
    return response()->json(['ok' => true]);
})->middleware('auth');

// ===== PROFILE =====
Route::get('/api/me', function () {
    $u = Auth::user();
    return response()->json([
        'id'     => $u->id,
        'name'   => $u->name,
        'email'  => $u->email,
        'avatar' => $u->avatar,
    ]);
})->middleware('auth');

Route::post('/api/profile', function (Request $request) {
    $u = Auth::user();
    $data = $request->validate([
        'name'   => 'required|string|max:120',
        'email'  => 'required|email|max:180|unique:users,email,' . $u->id,
        'avatar' => 'nullable|string|max:255',
    ]);
    $u->name   = $data['name'];
    $u->email  = $data['email'];
    $u->avatar = $data['avatar'] ?? null;
    $u->save();
    return response()->json(['ok' => true, 'user' => [
        'id' => $u->id, 'name' => $u->name, 'email' => $u->email, 'avatar' => $u->avatar,
    ]]);
})->middleware('auth');

Route::post('/api/profile/password', function (Request $request) {
    $u = Auth::user();
    $data = $request->validate([
        'current_password' => 'required|string',
        'new_password'     => 'required|string|min:6|max:200|confirmed',
    ]);
    if (!Hash::check($data['current_password'], $u->password)) {
        return response()->json(['error' => 'Cari şifrə yanlışdır'], 422);
    }
    $u->password = Hash::make($data['new_password']);
    $u->save();
    return response()->json(['ok' => true]);
})->middleware('auth');

// ===== IMAGE UPLOAD =====
Route::post('/api/upload', function (Request $request) {
    $request->validate([
        'file' => 'required|file|image|mimes:jpg,jpeg,png,webp,gif|max:4096',
    ]);
    $file = $request->file('file');
    $ext = strtolower($file->getClientOriginalExtension() ?: $file->extension());
    $dir = 'uploads/' . date('Y/m');
    $absDir = public_path($dir);
    if (!is_dir($absDir)) {
        mkdir($absDir, 0755, true);
    }
    $name = bin2hex(random_bytes(8)) . '.' . $ext;
    $file->move($absDir, $name);
    return response()->json(['url' => '/' . $dir . '/' . $name]);
})->middleware('auth');

// ===== PRODUCT VIEW COUNTER =====
Route::post('/api/products/{product}/view', function (Request $request, Product $product) {
    // Session-dedupe — eyni ziyarətçi eyni məhsulu sayğaca 1 dəfə əlavə edir
    $seen = $request->session()->get('viewed_products', []);
    if (in_array($product->id, $seen, true)) {
        return response()->json(['ok' => true, 'views' => $product->views, 'skipped' => true]);
    }
    $seen[] = $product->id;
    $request->session()->put('viewed_products', array_slice($seen, -200));
    $product->increment('views');
    return response()->json(['ok' => true, 'views' => $product->views + 1]);
});

// ===== CATEGORIES =====
Route::get('/api/categories', function () {
    return response()->json(
        Category::orderBy('sort_order')->orderBy('id')->get()->map(fn ($c) => [
            'id'   => $c->id,
            'slug' => $c->slug,
            'name' => $c->name,
            'icon' => $c->icon,
            'sort' => $c->sort_order,
        ])->all()
    );
});

Route::post('/api/categories', function (Request $request) {
    $data = $request->validate([
        'items'        => 'required|array',
        'items.*.id'   => 'nullable|integer',
        'items.*.slug' => 'required|string|max:60|regex:/^[a-z0-9_-]+$/',
        'items.*.name' => 'required|string|max:80',
        'items.*.icon' => 'nullable|string|max:8',
        'items.*.sort' => 'nullable|integer',
    ]);
    $incoming = collect($data['items']);
    $existingIds = Category::pluck('id')->all();
    $keptIds = [];
    foreach ($incoming as $item) {
        $payload = [
            'slug'       => $item['slug'],
            'name'       => $item['name'],
            'icon'       => $item['icon'] ?: '📦',
            'sort_order' => (int)($item['sort'] ?? 0),
        ];
        if (!empty($item['id']) && in_array($item['id'], $existingIds, true)) {
            Category::where('id', $item['id'])->update($payload);
            $keptIds[] = $item['id'];
        } else {
            $keptIds[] = Category::create($payload)->id;
        }
    }
    Category::whereNotIn('id', $keptIds)->delete();
    return response()->json(['ok' => true]);
})->middleware('auth');

// ===== TESTIMONIALS =====
Route::get('/api/testimonials', function () {
    return response()->json(
        Testimonial::where('published', true)
            ->orderBy('sort_order')->orderBy('id')
            ->get()->map(fn ($t) => [
                'id'       => $t->id,
                'name'     => $t->name,
                'position' => $t->position,
                'text'     => $t->text,
                'avatar'   => $t->avatar,
                'rating'   => (int) $t->rating,
            ])->all()
    );
});

Route::get('/api/admin/testimonials', function () {
    return response()->json(
        Testimonial::orderBy('sort_order')->orderBy('id')->get()->map(fn ($t) => [
            'id'        => $t->id,
            'name'      => $t->name,
            'position'  => $t->position,
            'text'      => $t->text,
            'avatar'    => $t->avatar,
            'rating'    => (int) $t->rating,
            'sort'      => (int) $t->sort_order,
            'published' => (bool) $t->published,
        ])->all()
    );
})->middleware('auth');

Route::post('/api/admin/testimonials', function (Request $request) {
    $data = $request->validate([
        'items'             => 'required|array',
        'items.*.id'        => 'nullable|integer',
        'items.*.name'      => 'required|string|max:120',
        'items.*.position'  => 'nullable|string|max:160',
        'items.*.text'      => 'required|string|max:2000',
        'items.*.avatar'    => 'nullable|string|max:255',
        'items.*.rating'    => 'nullable|integer|min:1|max:5',
        'items.*.sort'      => 'nullable|integer',
        'items.*.published' => 'nullable|boolean',
    ]);
    $existingIds = Testimonial::pluck('id')->all();
    $keptIds = [];
    foreach ($data['items'] as $item) {
        $payload = [
            'name'       => $item['name'],
            'position'   => $item['position'] ?? null,
            'text'       => $item['text'],
            'avatar'     => $item['avatar']   ?? null,
            'rating'     => (int) ($item['rating'] ?? 5),
            'sort_order' => (int) ($item['sort'] ?? 0),
            'published'  => (bool) ($item['published'] ?? true),
        ];
        if (!empty($item['id']) && in_array($item['id'], $existingIds, true)) {
            Testimonial::where('id', $item['id'])->update($payload);
            $keptIds[] = $item['id'];
        } else {
            $keptIds[] = Testimonial::create($payload)->id;
        }
    }
    Testimonial::whereNotIn('id', $keptIds)->delete();
    return response()->json(['ok' => true]);
})->middleware('auth');

// ===== ORDER TRACKING (public) =====
Route::get('/order-status', function (Request $request) {
    $code = trim((string) $request->query('code', ''));
    $order = null;
    $notFound = false;
    if ($code !== '') {
        $order = Order::where('track_code', $code)->first();
        if (!$order) $notFound = true;
    }
    return view('order-status', [
        'code'     => $code,
        'order'    => $order,
        'notFound' => $notFound,
        'labels'   => Order::STATUS_LABELS,
    ]);
})->name('order.status');
