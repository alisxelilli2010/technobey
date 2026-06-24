<?php

namespace App\Support;

class SiteContent
{
    public const ADMIN_PASSWORD = 'totuTbrufuzor26';

    public static function path(string $section): string
    {
        return storage_path('app/site/' . $section . '.json');
    }

    public static function get(string $section): array
    {
        $path = self::path($section);
        if (is_file($path)) {
            $data = json_decode(file_get_contents($path), true);
            if (is_array($data)) {
                return $data;
            }
        }
        return self::defaults()[$section] ?? [];
    }

    public static function save(string $section, array $data): void
    {
        $dir = dirname(self::path($section));
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        file_put_contents(self::path($section), json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    }

    public static function appendOrder(array $data): void
    {
        $orders = self::get('orders');
        if (!isset($orders['list']) || !is_array($orders['list'])) {
            $orders = ['list' => []];
        }
        $data['date'] = date('Y-m-d H:i');
        $orders['list'][] = $data;
        self::save('orders', $orders);
    }

    public static function defaults(): array
    {
        return [
            'hero' => [
                'badge' => '🟢 Bakıda №1 Texnologiya Mağazası',
                'title' => 'Texnologiyanı<br><span class="accent">Güvənilir</span> Əllərdə<br>Kəşf Edin',
                'sub' => 'Kompüter, printer, proyektor satışı və peşəkar texniki servis. 500-dən çox məhsul, 7/24 müştəri dəstəyi – hamısı bir çatıda.',
                'btn1Text' => '🛍️ Məhsullara bax', 'btn1Link' => '#products',
                'btn2Text' => '📞 Bizimlə əlaqə', 'btn2Link' => '#contact',
                'stats' => [
                    ['num' => '5K+', 'label' => 'Məmnun müştəri'],
                    ['num' => '8+',  'label' => 'İl təcrübə'],
                    ['num' => '500+', 'label' => 'Məhsul çeşidi'],
                ],
                'devices' => [
                    ['emoji' => '🖥️', 'title' => 'Gaming & Office PC', 'desc' => 'Intel Core i5–i9, 16–64GB RAM, SSD seçimləri'],
                    ['emoji' => '🖨️', 'title' => 'Printerlər', 'desc' => 'HP, Canon, Epson brendləri'],
                    ['emoji' => '📽️', 'title' => 'Proyektorlar', 'desc' => '4K, Full HD, portativ'],
                ],
            ],
            'services' => [
                'eyebrow' => 'Xidmətlərimiz',
                'title' => 'Hər Texnoloji Ehtiyacınız<br>Üçün Buradayıq',
                'sub' => 'Satışdan sonrakı dəstəkdən peşəkar təmirə qədər – TechnoBey ilə texnologiya dünyası əlinizdədir.',
                'cards' => [
                    ['icon' => '🔧', 'title' => 'Kompüter Təmiri', 'desc' => 'Laptop, masaüstü, notebook – hər növ kompüterin diaqnostikası, ehtiyat hissəsi dəyişimi və proqram xidmətləri. Eyni gün xidmət seçimi mövcuddur.', 'linkText' => 'Sifariş et →', 'link' => '#order'],
                    ['icon' => '🖨️', 'title' => 'Printer Servis & Kartrij', 'desc' => 'Printer təmiri, kartrij doldurulması, drum dəyişimi. HP, Canon, Epson, Brother – bütün modellər üçün peşəkar xidmət.', 'linkText' => 'Sifariş et →', 'link' => '#order'],
                    ['icon' => '📽️', 'title' => 'Proyektor Quraşdırma', 'desc' => 'Proyektor satışı, quraşdırılması və kalibrasyonu. Ev kinoteatrından korporativ təqdimatа qədər eksiksiz həll.', 'linkText' => 'Sifariş et →', 'link' => '#order'],
                    ['icon' => '💡', 'title' => 'Texniki Konsultasiya', 'desc' => 'Büdcənizə uyğun ən yaxşı avadanlığın seçimi üçün pulsuz məsləhət. Ev istifadəçisindən korporativ alımlara qədər.', 'linkText' => 'Əlaqə saxla →', 'link' => '#contact'],
                    ['icon' => '🛡️', 'title' => 'Zəmanət & Müddət Sonrası Servis', 'desc' => 'Satdığımız bütün məhsullar üçün 1 il zəmanət. Zəmanət müddəti bitdikdən sonra da güvənilir servis dəstəyi.', 'linkText' => 'Ətraflı →', 'link' => '#contact'],
                    ['icon' => '🚀', 'title' => 'Korporativ Təchizat', 'desc' => 'Şirkətlər üçün topdan avadanlıq alışı, quraşdırma və müntəzəm texniki xidmət paketləri. Xüsusi qiymətlər mövcuddur.', 'linkText' => 'Təklif al →', 'link' => '#contact'],
                ],
            ],
            'why' => [
                'eyebrow' => 'Niyə TechnoBey?',
                'title' => 'Bakıda 8 İllik Etibar, Hər Gün Yenilənən Texnologiya',
                'sub' => '2016-cı ildən bəri Bakıdakı minlərlə müştəriyə texnoloji həllər təqdim edirik. Bizə güvənin, çünki biz yalnız texnologiya satmırıq – işinizin arxasında dayanırıq.',
                'features' => [
                    ['icon' => '⚡', 'title' => 'Eyni Gün Çatdırılma', 'desc' => 'Bakı daxilindəki bütün sifarişlər 4-6 saat ərzində çatdırılır.'],
                    ['icon' => '🔒', 'title' => 'Orijinal & Lisenziyalı Məhsullar', 'desc' => 'Satdığımız bütün məhsullar orijinal, rəsmi idxal edilmiş və zəmanətlidir.'],
                    ['icon' => '🛠️', 'title' => 'Sertifikatlı Texniklər', 'desc' => 'Komandamız Microsft, HP, Epson sertifikatlı mütəxəssislərdən ibarətdir.'],
                    ['icon' => '💬', 'title' => '7/24 WhatsApp Dəstəyi', 'desc' => 'Sualınız istənilən vaxt gəlsin – biz həmişə buradayıq.'],
                ],
                'metrics' => [
                    ['num' => '5K', 'suffix' => '+', 'label' => 'Məmnun müştəri'],
                    ['num' => '98', 'suffix' => '%', 'label' => 'Müştəri məmnuniyyəti'],
                    ['num' => '8', 'suffix' => 'il', 'label' => 'Bazarda təcrübə'],
                    ['num' => '24h', 'suffix' => '', 'label' => 'Ortalama servis müddəti'],
                    ['num' => '500', 'suffix' => '+', 'label' => 'Mövcud məhsul çeşidi'],
                ],
            ],
            'about' => [
                'badge1' => '🏆 2016-dan bəri', 'badge2' => '✅ Rəsmi distribütor', 'badge3' => '🇦🇿 Yerli şirkət',
                'title' => 'Bakının Etibarlı Texnologiya Ortağı',
                'text' => 'TechnoBey 2016-cı ildə Bakıda kiçik bir texnologiya mağazası kimi fəaliyyətə başladı. Bu gün biz 5,000-dən çox müştəriyə xidmət göstərən tam profilli bir texnologiya şirkətinə çevrilmişik.',
                'btnText' => '📞 Bizimlə tanış olun', 'btnLink' => '#contact',
                'icon' => '🏪', 'centerName' => 'TechnoBey Servis Mərkəzi',
                'centerAddr' => 'Nəsimi rayonu, Bakı şəhəri',
                'met1Num' => '12', 'met1Lbl' => 'Texniki mütəxəssis',
                'met2Num' => '3', 'met2Lbl' => 'Xidmət sahəsi',
            ],
            'contact' => [
                'eyebrow' => 'Əlaqə', 'title' => 'Bizə Çatın',
                'sub' => 'Sual, sifariş, xidmət tələbi – istənilən mövzuda bizimlə əlaqə saxlayın.',
                'addr' => 'Nəsimi rayonu, Bakı şəhəri, Azərbaycan',
                'addrNote' => 'Metro: 28 May, 5 dəq piyada',
                'phone' => '+994 55 789 57 45',
                'hours' => "B.e. – Şənbə: 09:00 – 19:00\nBazar: 10:00 – 17:00",
                'email' => 'info@technobey.az',
                'whatsapp' => '994557895745',
                'mapSrc' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3038.5!2d49.8671!3d40.4093!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNDDCsDI0JzMzLjUiTiA0OcKwNTInMDEuNiJF!5e0!3m2!1saz!2saz!4v1234567890',
            ],
            'products' => [
                'eyebrow' => 'Məhsullar',
                'title' => 'Premium Texnologiya,<br>Əlverişli Qiymət',
                'sub' => 'Bakıda kompüter, printer və proyektor satışında ən geniş çeşid TechnoBey-dədir.',
                'list' => [
                    ['id' => 1, 'name' => 'Gaming PC – Core i7 / RTX 4060', 'cat' => 'komputer', 'price' => '1.850', 'unit' => 'ədəd', 'desc' => '16GB DDR5, 512GB NVMe SSD, Windows 11 Pro', 'emoji' => '🖥️'],
                    ['id' => 2, 'name' => 'Business Laptop – Core i5 / 15.6"', 'cat' => 'komputer', 'price' => '950', 'unit' => 'ədəd', 'desc' => '8GB RAM, 256GB SSD, Full HD IPS ekran', 'emoji' => '💻'],
                    ['id' => 3, 'name' => 'HP LaserJet Pro MFP M227', 'cat' => 'printer', 'price' => '480', 'unit' => 'ədəd', 'desc' => 'Çap, surətçıxarma, skan – Wi-Fi dəstəkli', 'emoji' => '🖨️'],
                    ['id' => 4, 'name' => 'Epson EcoTank L3250 Rəngli', 'cat' => 'printer', 'price' => '390', 'unit' => 'ədəd', 'desc' => 'Tank sistemli, yüksək tutumlu, 3-ü 1-də', 'emoji' => '🖨️'],
                    ['id' => 5, 'name' => 'Epson EB-X51 XGA Proyektor', 'cat' => 'proyektor', 'price' => '620', 'unit' => 'ədəd', 'desc' => '3,800 lümen, HDMI, USB, portativ dizayn', 'emoji' => '📽️'],
                    ['id' => 6, 'name' => 'Wireless Keyboard & Mouse Dəsti', 'cat' => 'aksesuar', 'price' => '85', 'unit' => 'dəst', 'desc' => 'Logitech MK295, pil ilə 24 ay iş müddəti', 'emoji' => '🖱️'],
                ],
            ],
            'orders' => ['list' => []],
        ];
    }
}
