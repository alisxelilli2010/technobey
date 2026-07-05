<!DOCTYPE html>
<html lang="az">
<head>
<meta charset="UTF-8">
<title>Yeni sifariş</title>
</head>
<body style="margin:0;padding:0;background:#f5f7fb;font-family:Arial,sans-serif;color:#1e2d4a">
  <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background:#f5f7fb;padding:32px 12px">
    <tr>
      <td align="center">
        <table role="presentation" width="620" cellspacing="0" cellpadding="0" style="max-width:620px;background:#ffffff;border-radius:14px;overflow:hidden;box-shadow:0 4px 20px rgba(0,0,0,0.06)">
          <tr>
            <td style="background:linear-gradient(135deg,#0057ff,#00c2ff);padding:24px 28px;color:#ffffff">
              <div style="font-size:22px;font-weight:800">🔔 Yeni sifariş</div>
              <div style="font-size:13px;opacity:0.9;margin-top:4px">Texnobəy İdarəetmə paneli</div>
            </td>
          </tr>
          <tr>
            <td style="padding:28px">
              <p style="margin:0 0 20px;font-size:14px;color:#6b7280">
                Sayta yeni bir sifariş qəbul edildi. Detallar aşağıdadır.
              </p>
              <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
                <tr>
                  <td style="padding:10px 0;border-bottom:1px solid #e4e9f2;font-size:13px;color:#6b7280;width:140px">Ad Soyad</td>
                  <td style="padding:10px 0;border-bottom:1px solid #e4e9f2;font-size:14px;color:#1e2d4a;font-weight:600">{{ $order->name }}</td>
                </tr>
                <tr>
                  <td style="padding:10px 0;border-bottom:1px solid #e4e9f2;font-size:13px;color:#6b7280">Telefon</td>
                  <td style="padding:10px 0;border-bottom:1px solid #e4e9f2;font-size:14px;color:#1e2d4a;font-weight:600">
                    <a href="tel:{{ $order->phone }}" style="color:#0057ff;text-decoration:none">{{ $order->phone }}</a>
                  </td>
                </tr>
                @if ($order->email)
                <tr>
                  <td style="padding:10px 0;border-bottom:1px solid #e4e9f2;font-size:13px;color:#6b7280">Email</td>
                  <td style="padding:10px 0;border-bottom:1px solid #e4e9f2;font-size:14px;color:#1e2d4a;font-weight:600">
                    <a href="mailto:{{ $order->email }}" style="color:#0057ff;text-decoration:none">{{ $order->email }}</a>
                  </td>
                </tr>
                @endif
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
                  <td style="padding:10px 0;font-size:13px;color:#6b7280">Tarix</td>
                  <td style="padding:10px 0;font-size:14px;color:#1e2d4a;font-weight:600">
                    {{ optional($order->created_at)->setTimezone('Asia/Baku')->format('d.m.Y H:i') }}
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td style="padding:16px 28px 24px;background:#f8fafc;color:#6b7280;font-size:12px;text-align:center;border-top:1px solid #e4e9f2">
              Bu email Texnobəy admin sistemindən avtomatik göndərilib.
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>
</html>
