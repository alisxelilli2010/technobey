<?php

use App\Support\SiteContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

$sections = ['hero', 'services', 'why', 'about', 'contact', 'products', 'orders'];

Route::get('/', function () use ($sections) {
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

    return back()->with('ok', true);
})->name('order.store');

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
