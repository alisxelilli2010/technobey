<?php

use App\Models\Order;
use App\Models\Product;
use App\Models\Visit;
use App\Support\SiteContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

$sections = ['hero', 'services', 'why', 'about', 'contact', 'products', 'orders'];

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
    return view('home', $data);
});

Route::get('/admin', function () {
    return view('admin');
});

Route::post('/order', function (Request $request) {
    $data = $request->validate([
        'name'    => 'required|string|max:120',
        'phone'   => 'required|string|max:40',
        'email'   => 'nullable|email|max:120',
        'service' => 'required|string|max:80',
        'notes'   => 'nullable|string|max:2000',
    ]);

    SiteContent::appendOrder($data);
    \Illuminate\Support\Facades\Log::info('TechnoBey order', $data);

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
            'monthOrders'   => $monthOrders,
            'monthVisits'   => $monthVisits,
            'totalOrders'   => $totalOrders,
            'totalVisits'   => $totalVisits,
            'totalProducts' => $totalProducts,
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
        'byCat'     => $byCat,
        'byService' => $byService,
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
    if ($request->header('X-Admin-Password') !== SiteContent::ADMIN_PASSWORD) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }
    $payload = $request->json()->all();
    if (!is_array($payload)) {
        return response()->json(['error' => 'Invalid payload'], 422);
    }
    SiteContent::save($section, $payload);
    return response()->json(['ok' => true]);
});

// ===== IMAGE UPLOAD =====
Route::post('/api/upload', function (Request $request) {
    if ($request->header('X-Admin-Password') !== SiteContent::ADMIN_PASSWORD) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }
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
});
