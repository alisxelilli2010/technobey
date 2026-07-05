<!DOCTYPE html>
<html lang="az">
<head>
<meta charset="UTF-8">
<title>Sifariş statusu yeniləndi</title>
</head>
@php
  $label = \App\Models\Order::STATUS_LABELS[$order->status] ?? $order->status;
  $palette = [
    'new'        => ['#0057ff', '#00c2ff', '🆕'],
    'processing' => ['#d97706', '#fbbf24', '⚙️'],
    'shipped'    => ['#0057ff', '#60a5fa', '🚚'],
    'delivered'  => ['#16a34a', '#4ade80', '✅'],
    'cancelled'  => ['#dc2626', '#f87171', '❌'],
  ];
  [$c1, $c2, $ico] = $palette[$order->status] ?? $palette['new'];
@endphp
<body style="margin:0;padding:0;background:#f5f7fb;font-family:Arial,sans-serif;color:#1e2d4a">
  <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background:#f5f7fb;padding:32px 12px">
    <tr>
      <td align="center">
        <table role="presentation" width="620" cellspacing="0" cellpadding="0" style="max-width:620px;background:#ffffff;border-radius:14px;overflow:hidden;box-shadow:0 4px 20px rgba(0,0,0,0.06)">
          <tr>
            <td style="background:linear-gradient(135deg,{{ $c1 }},{{ $c2 }});padding:28px;color:#ffffff;text-align:center">
              <div style="font-size:38px;line-height:1;margin-bottom:8px">{{ $ico }}</div>
              <div style="font-size:22px;font-weight:800">Sifariş statusu yeniləndi</div>
              <div style="font-size:13px;opacity:0.9;margin-top:6px">TechnoBey — sifarişinizin yeni vəziyyəti aşağıdadır</div>
            </td>
          </tr>
          <tr>
            <td style="padding:28px">
              <p style="margin:0 0 16px;font-size:15px;line-height:1.6;color:#1e2d4a">
                Salam, <strong>{{ $order->name }}</strong>!
              </p>
              <p style="margin:0 0 20px;font-size:14px;line-height:1.7;color:#6b7280">
                Sifarişinizin statusu <strong style="color:{{ $c1 }}">{{ $label }}</strong> olaraq yeniləndi.
              </p>
              @if ($order->track_code)
              <div style="background:#f0f9ff;border:1px solid #bae6fd;border-radius:10px;padding:14px 18px;margin:14px 0;text-align:center">
                <div style="font-size:12px;color:#6b7280;margin-bottom:4px">İzləmə kodu</div>
                <div style="font-family:monospace;font-size:18px;font-weight:800;color:#0057ff;letter-spacing:1px">{{ $order->track_code }}</div>
                <div style="font-size:12px;color:#6b7280;margin-top:6px">
                  Sifariş vəziyyətini <a href="{{ route('order.status', ['code' => $order->track_code]) }}" style="color:#0057ff;text-decoration:none">buradan</a> izləyə bilərsiniz.
                </div>
              </div>
              @endif
              <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse;margin-top:8px">
                <tr>
                  <td style="padding:10px 0;border-bottom:1px solid #e4e9f2;font-size:13px;color:#6b7280;width:140px">Xidmət</td>
                  <td style="padding:10px 0;border-bottom:1px solid #e4e9f2;font-size:14px;color:#1e2d4a;font-weight:600">{{ $order->service }}</td>
                </tr>
                <tr>
                  <td style="padding:10px 0;border-bottom:1px solid #e4e9f2;font-size:13px;color:#6b7280">Yeni status</td>
                  <td style="padding:10px 0;border-bottom:1px solid #e4e9f2;font-size:14px;color:{{ $c1 }};font-weight:700">{{ $label }}</td>
                </tr>
                <tr>
                  <td style="padding:10px 0;font-size:13px;color:#6b7280">Sifariş vaxtı</td>
                  <td style="padding:10px 0;font-size:14px;color:#1e2d4a;font-weight:600">
                    {{ optional($order->created_at)->setTimezone('Asia/Baku')->format('d.m.Y H:i') }}
                  </td>
                </tr>
              </table>
              <p style="margin:24px 0 0;font-size:13px;line-height:1.7;color:#6b7280">
                Suallarınız varsa, bizə <a href="tel:+994557895745" style="color:#0057ff;text-decoration:none">+994 55 789 57 45</a> nömrəsi və ya
                <a href="mailto:info@technobey.az" style="color:#0057ff;text-decoration:none">info@technobey.az</a> ünvanı vasitəsilə müraciət edə bilərsiniz.
              </p>
            </td>
          </tr>
          <tr>
            <td style="padding:16px 28px 24px;background:#f8fafc;color:#6b7280;font-size:12px;text-align:center;border-top:1px solid #e4e9f2">
              TechnoBey — Bakı, Azərbaycan &nbsp;|&nbsp; Bu email avtomatik göndərilib, cavab vermək məcburi deyil.
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>
</html>
