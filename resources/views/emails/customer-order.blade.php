<!DOCTYPE html>
<html lang="az">
<head>
<meta charset="UTF-8">
<title>Sifarişiniz qəbul edildi</title>
</head>
<body style="margin:0;padding:0;background:#f5f7fb;font-family:Arial,sans-serif;color:#1e2d4a">
  <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background:#f5f7fb;padding:32px 12px">
    <tr>
      <td align="center">
        <table role="presentation" width="620" cellspacing="0" cellpadding="0" style="max-width:620px;background:#ffffff;border-radius:14px;overflow:hidden;box-shadow:0 4px 20px rgba(0,0,0,0.06)">
          <tr>
            <td style="background:linear-gradient(135deg,#0057ff,#00c2ff);padding:28px;color:#ffffff;text-align:center">
              <div style="font-size:38px;line-height:1;margin-bottom:8px">✅</div>
              <div style="font-size:22px;font-weight:800">Sifarişiniz qəbul edildi</div>
              <div style="font-size:13px;opacity:0.9;margin-top:6px">Texnobəy — texnologiyanız güvənilir əllərdə</div>
            </td>
          </tr>
          <tr>
            <td style="padding:28px">
              <p style="margin:0 0 16px;font-size:15px;line-height:1.6;color:#1e2d4a">
                Salam, <strong>{{ $order->name }}</strong>!
              </p>
              <p style="margin:0 0 20px;font-size:14px;line-height:1.7;color:#6b7280">
                Sifarişiniz üçün təşəkkür edirik. Komandamız qısa müddət ərzində sizinlə əlaqə saxlayacaq.
                Aşağıda sifariş məlumatlarınızın xülasəsi göstərilib.
              </p>
              @if ($order->track_code)
              <div style="background:#f0f9ff;border:1px solid #bae6fd;border-radius:10px;padding:14px 18px;margin:14px 0;text-align:center">
                <div style="font-size:12px;color:#6b7280;margin-bottom:4px">İzləmə kodu</div>
                <div style="font-family:monospace;font-size:18px;font-weight:800;color:#0057ff;letter-spacing:1px">{{ $order->track_code }}</div>
                <div style="font-size:12px;color:#6b7280;margin-top:6px">Sifarişinizin statusunu bu kod ilə <a href="{{ route('order.status', ['code' => $order->track_code]) }}" style="color:#0057ff;text-decoration:none">buradan</a> izləyə bilərsiniz.</div>
              </div>
              @endif
              <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse;margin-top:8px">
                <tr>
                  <td style="padding:10px 0;border-bottom:1px solid #e4e9f2;font-size:13px;color:#6b7280;width:140px">Ad Soyad</td>
                  <td style="padding:10px 0;border-bottom:1px solid #e4e9f2;font-size:14px;color:#1e2d4a;font-weight:600">{{ $order->name }}</td>
                </tr>
                <tr>
                  <td style="padding:10px 0;border-bottom:1px solid #e4e9f2;font-size:13px;color:#6b7280">Telefon</td>
                  <td style="padding:10px 0;border-bottom:1px solid #e4e9f2;font-size:14px;color:#1e2d4a;font-weight:600">{{ $order->phone }}</td>
                </tr>
                <tr>
                  <td style="padding:10px 0;border-bottom:1px solid #e4e9f2;font-size:13px;color:#6b7280">Xidmət</td>
                  <td style="padding:10px 0;border-bottom:1px solid #e4e9f2;font-size:14px;color:#1e2d4a;font-weight:600">{{ $order->service }}</td>
                </tr>
                @if ($order->notes)
                <tr>
                  <td style="padding:10px 0;border-bottom:1px solid #e4e9f2;font-size:13px;color:#6b7280;vertical-align:top">Qeyd</td>
                  <td style="padding:10px 0;border-bottom:1px solid #e4e9f2;font-size:14px;color:#1e2d4a;line-height:1.6;white-space:pre-wrap">{{ $order->notes }}</td>
                </tr>
                @endif
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
              Texnobəy — Bakı, Azərbaycan &nbsp;|&nbsp; Bu email avtomatik göndərilib, cavab vermək məcburi deyil.
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>
</html>
