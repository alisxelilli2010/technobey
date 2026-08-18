<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->posts() as $i => $p) {
            $p['sort_order'] = $i;
            Post::updateOrCreate(['slug' => $p['slug']], $p);
        }
    }

    private function posts(): array
    {
        return [
            // ===================== TƏMİR =====================
            [
                'slug'  => 'komputer-temiri-en-cox-rast-gelinen-nasazliqlar',
                'title' => 'Kompüter təmiri: ən çox rast gəlinən 9 nasazlıq və həlli',
                'icon'  => '🖥️',
                'cat'   => 'temir',
                'image' => '/uploads/blog/komputer-temiri.jpg',
                'meta_title' => 'Kompüter təmiri Bakı – 9 əsas nasazlıq və həlli | Texnobəy',
                'meta_desc'  => 'Kompüter yanmır, yavaşlayır, mavi ekran verir? Bakıda kompüter təmiri üzrə 9 ən çox rast gəlinən nasazlığın səbəbi və həlli — Texnobəy servis mərkəzinin təcrübəsi.',
                'excerpt' => 'Kompüter açılmır, səs-küy salır, mavi ekran verir və ya sadəcə yavaşlayıb? Servis masamıza gələn nasazlıqların böyük hissəsi eyni 9 səbəbdən yaranır. Hansının evdə həll oluna biləcəyini, hansının usta işi olduğunu izah edirik.',
                'body' => <<<'HTML'
<p>Servis masamıza gətirilən stasionar kompüterlərin təxminən dörddə üçü mürəkkəb yox, tanış nasazlıqlarla gəlir. Aşağıda hər birinin əlaməti, ehtimal olunan səbəbi və nə etmək lazım olduğu var. Bəzilərini evdə 10 dəqiqəyə həll etmək olar — hansıların olduğunu açıq yazmışıq.</p>

<h2>1. Kompüter ümumiyyətlə yanmır</h2>
<p>Düyməni basırsınız, heç bir səs, işıq yoxdur. Əvsəlcə ən sadəsini yoxlayın: qidalanma kabeli, uzadıcı, qida bloku arxasındakı 0/1 açarı. Bunlar qaydasındadırsa, çox vaxt problem <strong>qida blokundadır (PSU)</strong> — xüsusən ucuz, adı bilinməyən bloklar 2–3 ildən sonra sıradan çıxır.</p>
<p><em>Evdə həll oluna bilər:</em> kabel və açar yoxlaması. <em>Servis işi:</em> qida blokunun ölçülməsi və dəyişdirilməsi.</p>

<h2>2. Yanır, amma ekran qaranlıq qalır</h2>
<p>Ventilyatorlar işləyir, işıqlar yanır, ekranda isə "No signal". Adətən səbəb <strong>RAM yaddaş modulunun kontaktı</strong> və ya videokartın yuvada tam oturmamasıdır. Toz və rütubət kontaktları oksidləşdirir.</p>
<p>Monitor kabelini başqa portla (HDMI əvəzinə DisplayPort) sınayın — problem bəzən sadəcə kabeldədir.</p>

<h2>3. Mavi ekran (BSOD) təkrarlanır</h2>
<p>Windows-un mavi ekranı təsadüfi deyil — həmişə bir səbəbi var. Ən çoxu: səhv və ya köhnə <strong>sürücülər</strong>, nasaz <strong>RAM</strong>, ya da sıradan çıxmağa başlayan <strong>disk</strong>. Ekrandakı xəta kodunu şəkil çəkin: usta üçün bu, diaqnostikanın yarısıdır.</p>

<h2>4. Kompüter çox yavaşlayıb</h2>
<p>Ən çox verilən sual budur. Səbəblərin sıralaması təcrübəmizdə belədir:</p>
<ul>
  <li><strong>HDD hələ də sistem diskidir</strong> — SSD-yə keçid tək başına kompüteri 5–10 dəfə cəld edir;</li>
  <li><strong>RAM azdır</strong> — 2026-da 8 GB minimum, rahat iş üçün 16 GB;</li>
  <li><strong>Avtoyüklənmədə onlarla proqram var</strong>;</li>
  <li><strong>Termopasta quruyub</strong> — prosessor qızınca özünü ləngidir (throttling).</li>
</ul>

<h2>5. Səs-küy artıb, ventilyator uğuldayır</h2>
<p>Toz radiatorun qanadlarını bağlayır, hava axını dayanır, ventilyator isə daha sürətli fırlanmağa məcbur olur. İldə bir dəfə <strong>profilaktik təmizlik və termopasta dəyişimi</strong> həm səsi, həm də temperaturu normaya salır.</p>

<h2>6. Kompüter öz-özünə söndürülür</h2>
<p>Xüsusən oyun və ya render zamanı baş verirsə, iki əsas ehtimal var: <strong>həddindən artıq qızma</strong> və ya <strong>qida blokunun gücünün çatmaması</strong>. Videokart dəyişdirdikdən sonra bu problem yaranıbsa, demək ki, blokun vatı yeni kartı çəkmir.</p>

<h2>7. Diskdən qəribə səslər gəlir</h2>
<p>Klik-klik səsi eşidirsinizsə, <strong>dərhal dayanın</strong>. Bu, mexaniki diskin ölüm ərəfəsində olduğunun ən aydın işarəsidir. Kompüteri işlətməyə davam etmək məlumatın xilas olma şansını hər saat azaldır. Diski çıxarıb servis mərkəzinə gətirin.</p>

<h2>8. USB portları işləmir</h2>
<p>Bütün portlar birdən işləmirsə, səbəb adətən proqram tərəfindədir — sürücü və ya BIOS parametri. Yalnız ön panel portları işləmirsə, korpusun daxili kabeli ana platadan çıxıb.</p>

<h2>9. Tarix və saat hər açılışda sıfırlanır</h2>
<p>Bu, ən ucuz təmirlərdən biridir: ana platadakı <strong>CMOS batareyası</strong> (CR2032) bitib. Batareyanın ömrü təxminən 4–6 ildir.</p>

<h2>Servisə müraciət etməzdən əvvəl</h2>
<ul>
  <li>Xəta mesajının şəklini çəkin — kod diaqnostikanı sürətləndirir;</li>
  <li>Nasazlığın nə vaxt və hansı əməliyyatdan sonra başladığını qeyd edin;</li>
  <li>Mühüm fayllarınız varsa, bunu ustaya <strong>əvvəlcədən</strong> deyin — bəzi əməliyyatlar diski silir;</li>
  <li>Zəmanət müddəti bitməyibsə, korpusu özünüz açmayın.</li>
</ul>
HTML,
                'faq' => [
                    ['q' => 'Kompüter təmiri nə qədər vaxt aparır?', 'a' => 'Profilaktik təmizlik, termopasta dəyişimi və proqram nasazlıqları adətən elə həmin gün həll olunur. Ehtiyat hissəsi sifariş tələb edən hallarda müddət 1–3 iş gününə uzana bilər.'],
                    ['q' => 'Diaqnostika ödənişlidir?', 'a' => 'Texnobəy-də ilkin diaqnostika pulsuzdur. Təmirin dəyəri diaqnostikadan sonra dəqiqləşdirilir və sizin razılığınız olmadan heç bir iş görülmür.'],
                    ['q' => 'Təmirdən sonra məlumatlarım qalacaqmı?', 'a' => 'Disk sağlamdırsa, məlumatlar toxunulmaz qalır. Sistem yenidən qurulacaqsa və ya disk dəyişəcəksə, əvvəlcədən sizinlə razılaşır və mümkün olduqda ehtiyat nüsxə götürürük.'],
                ],
            ],
            [
                'slug'  => 'noutbuk-temiri-ekran-batareya-ve-qizma',
                'title' => 'Noutbuk təmiri: ekran, batareya və qızma problemləri',
                'icon'  => '💻',
                'cat'   => 'temir',
                'image' => '/uploads/blog/noutbuk-temiri.jpg',
                'meta_title' => 'Noutbuk təmiri Bakı – ekran, batareya, qızma | Texnobəy',
                'meta_desc'  => 'Noutbuk qızır, batareya tez bitir, ekranda zolaqlar var? Noutbuk təmirində ən çox rast gəlinən problemlərin səbəbləri və Bakıda peşəkar həll yolları.',
                'excerpt' => 'Noutbuk stasionar kompüterdən fərqli olaraq hər şeyi bir neçə santimetrlik korpusa sığışdırır — buna görə də nasazlıqları özünəməxsusdur. Ekran, batareya, qızma və klaviatura problemlərini ayrı-ayrı nəzərdən keçiririk.',
                'body' => <<<'HTML'
<p>Noutbukun bütün komponentləri bir-birinə çox yaxın yerləşir: istilik, toz və mexaniki təsir burada stasionar kompüterdəkindən qat-qat tez problem yaradır. Aşağıdakı dörd qrup bizim servis jurnalımızda ən çox təkrarlananlardır.</p>

<h2>Qızma: ən çox yayılmış problem</h2>
<p>Noutbuk isti olur, ventilyator dayanmadan işləyir, oyun və ya video zamanı FPS düşür — bunlar klassik <strong>throttling</strong> əlamətləridir. Prosessor təhlükəli temperatura çatanda özünü qəsdən ləngidir ki, yanmasın.</p>
<p>Səbəb demək olar ki, həmişə eynidir: radiatorun qanadları arasında toz keçəsi yığılıb və <strong>termopasta quruyub</strong>. Həlli — korpusun açılıb tam təmizlənməsi və pastanın dəyişdirilməsi. Bu, ildə bir dəfə edilməli profilaktikadır, xüsusən Bakının tozlu yay aylarından sonra.</p>
<p><strong>Vacib:</strong> noutbuku yumşaq səth üzərində — yorğan, yastıq, çarpayı — işlətməyin. Alt paneldəki hava dəlikləri bağlanır və temperatur dərhal 10–15 dərəcə qalxır.</p>

<h2>Batareya: nə vaxt dəyişmək lazımdır</h2>
<p>Litium batareyaların ömrü şarj dövrləri ilə ölçülür — orta hesabla 500–800 dövr, yəni 2–4 il. Aşağıdakılardan biri varsa, batareya artıq öz resursunu bitirib:</p>
<ul>
  <li>Doluluq 100% göstərir, amma kabeli çıxaran kimi noutbuk sönür;</li>
  <li>İş müddəti əvvəlki 5 saatdan 40 dəqiqəyə düşüb;</li>
  <li>Faiz göstəricisi sıçrayır: 60%-dən birdən 15%-ə düşür;</li>
  <li><strong>Korpus qabarıb</strong>, touchpad yuxarı qalxıb — bu təhlükəlidir, dərhal istifadəni dayandırın.</li>
</ul>
<p>Batareyanı həmişə orijinal və ya keyfiyyətli analoqla dəyişdirin. Ucuz batareyalar həm tez bitir, həm də qidalanma sxemini zədələyə bilər.</p>

<h2>Ekran: zolaqlar, ləkələr və qaranlıq təsvir</h2>
<p>Ekran problemləri üç fərqli səbəbdən yaranır və hər birinin qiyməti tamam başqadır:</p>
<ul>
  <li><strong>Matris zədəsi</strong> — rəngli zolaqlar, qara ləkələr, sınıq görüntü. Matris dəyişdirilməlidir;</li>
  <li><strong>Şleyf problemi</strong> — təsvir qapağın müəyyən bucağında itir və ya titrəyir. Kabelin dəyişdirilməsi kifayət edir, ucuz təmirdir;</li>
  <li><strong>İşıqlandırma (backlight)</strong> — ekran qaranlıqdır, amma güclü işıq altında təsvir seçilir. Adətən inverter və ya LED lenti.</li>
</ul>
<p>Fərqi dəqiqləşdirmək üçün noutbuku xarici monitora qoşun: xarici ekranda görüntü qüsursuzdursa, problem yalnız noutbukun ekranındadır.</p>

<h2>Klaviatura və touchpad</h2>
<p>Bir neçə düymə işləmirsə, çox vaxt kontakt lövhəsi çirklənib. Üstünə maye tökülübsə, vəziyyət daha ciddidir: <strong>dərhal söndürün, batareyanı ayırın və noutbuku çevirib qurudun</strong>. Şirin içkilər (çay, şirə, qazlı su) sudan qat-qat təhlükəlidir — quruduqdan sonra kontaktlarda keçirici qat qoyur və ana plataya çatarsa təmir bahalaşır.</p>

<h2>Nə vaxt təmir, nə vaxt yeni noutbuk?</h2>
<p>Sadə qayda: təmirin dəyəri eyni sinifdən yeni noutbukun qiymətinin <strong>yarısını keçirsə</strong>, təmir artıq sərfəli deyil. Bu, xüsusən ana plata və ya prosessor zədələnəndə baş verir. Belə hallarda diaqnostikadan sonra sizə hər iki variantın rəqəmlərini göstəririk — qərar sizindir.</p>
HTML,
                'faq' => [
                    ['q' => 'Noutbukun qızmasının qarşısını necə almaq olar?', 'a' => 'İldə bir dəfə profilaktik təmizlik və termopasta dəyişimi etdirin, cihazı sərt səth üzərində işlədin və hava dəliklərini bağlamayın. Soyuducu altlıq (cooling pad) uzun iş saatlarında əlavə kömək edir.'],
                    ['q' => 'Batareya qabarıbsa nə etməli?', 'a' => 'Cihazı dərhal söndürün, şarja qoymayın və özünüz çıxarmağa çalışmayın. Qabarmış litium batareya yanğın riski yaradır — noutbuku servis mərkəzinə gətirin.'],
                    ['q' => 'Ekran dəyişimi nə qədər çəkir?', 'a' => 'Matris anbarda varsa, dəyişim adətən 1–2 saat çəkir. Nadir modellər üçün matris sifariş edilir və müddət bir neçə iş gününə uzana bilər.'],
                ],
            ],
            [
                'slug'  => 'printer-temiri-cap-keyfiyyeti-ve-kagiz-sixismasi',
                'title' => 'Printer təmiri: çap keyfiyyəti və kağız sıxışması problemləri',
                'icon'  => '🖨️',
                'cat'   => 'temir',
                'image' => '/uploads/blog/printer-temiri.jpg',
                'meta_title' => 'Printer təmiri Bakı – çap keyfiyyəti, kağız sıxışması | Texnobəy',
                'meta_desc'  => 'Printer zolaqlı çap edir, kağız sıxışır, kartric tanınmır? Lazer və mürəkkəbli printerlərdə ən çox rast gəlinən nasazlıqlar və həlləri.',
                'excerpt' => 'Printerin nasazlıqlarının çoxu mexaniki deyil, istismar qaydalarından yaranır. Zolaqlı çap, sıxışan kağız, tanınmayan kartric — hər birinin öz konkret səbəbi var.',
                'body' => <<<'HTML'
<p>Printer ofisdə ən çox işlədilən, amma ən az baxılan avadanlıqdır. Servis çağırışlarının böyük hissəsi əslində düzgün istismarla qarşısı alına bilən problemlərdir. Nasazlıqları texnologiyaya görə ayıraq.</p>

<h2>Lazer printerdə zolaqlı çap</h2>
<p>Səhifədə uzununa ağ və ya qara zolaqlar görünürsə, ardıcıllıqla yoxlayın:</p>
<ul>
  <li><strong>Toner azalıb</strong> — kartrici çıxarıb üfüqi istiqamətdə yumşaqca yellədin, bu bir neçə yüz səhifə əlavə verir;</li>
  <li><strong>Fotobaraban cızılıb</strong> — zolaq həmişə eyni yerdədirsə və dövri təkrarlanırsa, bu ehtimal yüksəkdir;</li>
  <li><strong>Termoblok (fuser) köhnəlib</strong> — çap ləkəli, yaxılmış görünür və barmaqla sürtəndə toner silinir.</li>
</ul>

<h2>Mürəkkəbli printerdə solğun və kəsik çap</h2>
<p>Ən çox yayılan səbəb odur ki, printer <strong>uzun müddət işlədilməyib</strong>. Mürəkkəb başlıqda quruyur və kanalları bağlayır. Həlli — sürücü panelindən "başlığın təmizlənməsi" (head cleaning) əməliyyatını 2–3 dəfə ardıcıl işə salmaq.</p>
<p>Ən yaxşı profilaktika isə çox sadədir: <strong>həftədə ən azı bir dəfə rəngli test səhifəsi çap edin</strong>. Bu, aylarla dayanan printerdə başlıq təmizliyinə xərclənən mürəkkəbdən qat-qat ucuz başa gəlir.</p>

<h2>Kağız sıxışması (paper jam)</h2>
<p>Sıxışan kağızı çıxararkən əsas qayda: <strong>həmişə kağızın hərəkət istiqaməti ilə eyni tərəfə çəkin</strong> və yavaş hərəkət edin. Əks istiqamətə çəkmək valikləri və ötürücü mexanizmi zədələyir.</p>
<p>Sıxışma təkrarlanırsa, səbəb adətən bunlardır:</p>
<ul>
  <li>Kağız rütubət çəkib və bir-birinə yapışıb — açıq qalmış dəstəni saxlamayın;</li>
  <li>Lotokda həddindən artıq çox kağız var;</li>
  <li>Kağız çəkən valiklər hamarlanıb — dəyişdirilməlidir;</li>
  <li>Sıxılmış kağızın bir parçası içəridə qalıb.</li>
</ul>

<h2>Kartric tanınmır</h2>
<p>Yenidən doldurulmuş və ya analoq kartriclərdə çip çox vaxt köhnə sayğac dəyərini saxlayır. Bəzi modellərdə çipin sıfırlanması, bəzilərində isə dəyişdirilməsi tələb olunur. Firmware yeniləməsindən sonra analoq kartricin "yox olması" da tez-tez rast gəlinən haldır — bu səbəbdən analoq kartric istifadə edirsinizsə, avtomatik firmware yeniləməsini söndürün.</p>

<h2>Printer şəbəkədə görünmür</h2>
<p>Wi-Fi printerlərdə ən çox rast gəlinən səbəb, printerin və kompüterin <strong>müxtəlif şəbəkələrdə</strong> olmasıdır (məsələn, biri 2.4 GHz, digəri 5 GHz). Printerə statik IP təyin etmək bu problemi birdəfəlik həll edir — router yenidən başlayanda ünvan dəyişmir.</p>

<h2>Printerin ömrünü uzadan 5 qayda</h2>
<ul>
  <li>Yalnız uyğun sıxlıqda (80 q/m²) və quru kağız işlədin;</li>
  <li>Printeri tozdan qoruyun, istifadə etmədikdə üstünü örtün;</li>
  <li>Mürəkkəbli modeldə həftədə bir test çapı edin;</li>
  <li>Kartrici tam bitənə qədər gözləməyin — quru işləmə başlığı zədələyir;</li>
  <li>İldə bir dəfə daxili təmizlik və valiklərin yoxlanışını etdirin.</li>
</ul>
HTML,
                'faq' => [
                    ['q' => 'Kartric doldurmaq yoxsa yenisini almaq daha sərfəlidir?', 'a' => 'Lazer kartriclər keyfiyyətli tonerlə 2–3 dəfə doldurula bilər və bu, açıq-aydın sərfəlidir. Mürəkkəbli printerlərdə isə orijinal kartric və ya zavod SDM sistemi uzunmüddətdə daha az problem yaradır.'],
                    ['q' => 'Printer çap etmir, amma növbəyə göndərir. Səbəb nədir?', 'a' => 'Adətən çap növbəsi ilişib qalır. Növbəni tam təmizləyin, printeri söndürüb 30 saniyə sonra yandırın. Təkrarlanırsa, sürücünü silib yenidən quraşdırmaq lazımdır.'],
                    ['q' => 'Printerə profilaktika nə vaxtdan bir lazımdır?', 'a' => 'Ev istifadəsində ildə bir dəfə kifayətdir. Gündə yüzlərlə səhifə çap edən ofis printerləri üçün 6 ayda bir daxili təmizlik və valiklərin yoxlanışı tövsiyə olunur.'],
                ],
            ],
            [
                'slug'  => 'proyektor-temiri-lampa-reng-ve-fokus',
                'title' => 'Proyektor təmiri: lampa, rəng və fokus problemləri',
                'icon'  => '📽️',
                'cat'   => 'temir',
                'image' => '/uploads/blog/proyektor-temiri.jpg',
                'meta_title' => 'Proyektor təmiri Bakı – lampa, rəng, fokus | Texnobəy',
                'meta_desc'  => 'Proyektorun təsviri solğunlaşıb, rənglər dəyişib, ekranda ləkələr var? Proyektor nasazlıqlarının səbəbləri və Bakıda peşəkar təmir.',
                'excerpt' => 'Proyektor konfrans otağının və sinif otağının ən çox yüklənən cihazıdır. Təsvirin solğunlaşması, rənglərin pozulması və avtomatik sönmə — hər üçünün konkret texniki səbəbi var.',
                'body' => <<<'HTML'
<p>Proyektorlar yüksək temperaturda və uzun saatlar işləyən cihazlardır. Ona görə də nasazlıqlarının əksəriyyəti işıq mənbəyi və soyutma sistemi ilə bağlıdır. Ən çox rast gəlinənləri sıralayaq.</p>

<h2>Təsvir solğunlaşıb, parlaqlıq düşüb</h2>
<p>Bu, nasazlıq deyil — təbii prosesdir. Lampalı (UHP) proyektorlarda lampa öz resursunu tədricən itirir və 2000–4000 saatdan sonra ilkin parlaqlığın təxminən yarısını verir. Menyudakı <strong>lampa saatı sayğacı</strong> vəziyyəti dəqiq göstərir.</p>
<p>Lampanı dəyişdirməzdən əvvəl bir şeyi yoxlayın: <strong>hava filtri</strong>. Tozlanmış filtr həm parlaqlığı, həm də lampanın ömrünü kəskin azaldır və çox vaxt problem elə burada bitir.</p>
<p>Lazer proyektorlarda isə işıq mənbəyinin resursu 20 000 saatdan çoxdur — praktikada bu, dəyişdirilməsi tələb olunmayan komponentdir.</p>

<h2>Rənglər pozulub, təsvirdə ləkələr var</h2>
<p>Sarımtıl, yaşımtıl və ya bənövşəyi çalar, ya da ekranda sabit ləkələr:</p>
<ul>
  <li><strong>Optikaya toz düşüb</strong> — ləkə həmişə eyni yerdədir və fokusdan asılı olaraq dəyişir;</li>
  <li><strong>Rəng çarxı (color wheel) nasazdır</strong> — DLP modellərdə rənglər sıçrayır, bəzən cırıltılı səs gəlir;</li>
  <li><strong>LCD panel yanıb</strong> — 3LCD modellərdə uzun müddət sabit təsvir göstərildikdə baş verir.</li>
</ul>

<h2>Proyektor işləyərkən özü sönür</h2>
<p>Demək olar ki, həmişə <strong>həddindən artıq qızma</strong> deməkdir. Yoxlanılmalı olanlar: hava filtri təmizdirmi, cihazın ətrafında ən azı 30 sm boş sahə varmı, ventilyator işləyirmi. Bu, təxirə salınmalı problem deyil — qızma lampanı və elektronikanı sıradan çıxarır.</p>

<h2>Fokus tutmur, təsvir trapesiya formasındadır</h2>
<p>Təsvirin künclərindən biri digərindən enlidirsə, bu nasazlıq deyil — quraşdırma məsələsidir. <strong>Keystone</strong> düzəlişi trapesiyanı proqram yolu ilə düzəldir, amma təsvirin bir hissəsini itirir. Ən yaxşı nəticə proyektoru ekrana perpendikulyar quraşdırmaqla alınır.</p>
<p>Fokus heç bir vəziyyətdə tutmursa və ya bir tərəf kəskin, digəri bulanıqdırsa, obyektiv blokunun yerdəyişməsi ehtimalı var — bu, servis işidir.</p>

<h2>Proyektorun ömrünü uzatmaq üçün</h2>
<ul>
  <li>Cihazı <strong>heç vaxt kabeldən ayırmaqla söndürməyin</strong> — ventilyator lampanı soyutmalıdır. Söndürmə düyməsini basın və ventilyator dayanana qədər gözləyin;</li>
  <li>Hava filtrini 3 ayda bir təmizləyin;</li>
  <li>Tez-tez yandırıb-söndürməyin — hər start lampa üçün ən yüklü andır;</li>
  <li>Tavana quraşdırılan modellərdə ildə bir dəfə tam profilaktika etdirin.</li>
</ul>
HTML,
                'faq' => [
                    ['q' => 'Proyektor lampası nə qədər davam edir?', 'a' => 'UHP lampalar normal rejimdə 2000–4000 saat, ekonom rejimdə 5000–6000 saata qədər işləyir. Lazer proyektorlarda işıq mənbəyi 20 000 saatdan çox davam edir.'],
                    ['q' => 'Lampanı özüm dəyişə bilərəm?', 'a' => 'Bir çox modeldə lampa modulu xüsusi qapaqla dəyişdirilir, amma lampa yüksək təzyiqlidir və sınarsa təhlükəlidir. Dəyişimi servisə etibar etmək və eyni zamanda filtri təmizlətmək daha düzgündür.'],
                    ['q' => 'Zəif parlaqlıq lampanın bitdiyini bildirir?', 'a' => 'Həmişə yox. Əvvəlcə hava filtrini və ekonom rejimin aktiv olub-olmadığını yoxlayın. Lampa saatı sayğacı resursun yarısından azdırsa, səbəb çox güman ki, tozdur.'],
                ],
            ],

            // ===================== SEÇİM VƏ ALIŞ =====================
            [
                'slug'  => 'komputer-almaq-duzgun-konfiqurasiya-secimi',
                'title' => 'Kompüter almaq: düzgün konfiqurasiya necə seçilir?',
                'icon'  => '🛒',
                'cat'   => 'satis',
                'image' => '/uploads/blog/komputer-satisi.jpg',
                'meta_title' => 'Kompüter almaq Bakı – konfiqurasiya seçimi bələdçisi | Texnobəy',
                'meta_desc'  => 'Ofis, tədris, dizayn və ya oyun üçün kompüter alırsınız? Prosessor, RAM, SSD və videokartı büdcəyə görə düzgün seçmək qaydaları.',
                'excerpt' => 'Kompüter alarkən ən çox edilən səhv — bahalı prosessorla ucuz diski birləşdirmək. Büdcənin komponentlər arasında düzgün bölünməsi cihazın sürətini qiymətindən çox müəyyən edir.',
                'body' => <<<'HTML'
<p>"Hansı kompüteri alım?" sualının tək cavabı yoxdur, çünki düzgün seçim yalnız bir şeydən asılıdır: <strong>kompüterdə nə edəcəksiniz</strong>. Aşağıda dörd tipik ssenari və hər biri üçün minimum ağıllı konfiqurasiya var.</p>

<h2>Əvvəlcə: büdcəni necə bölmək lazımdır</h2>
<p>Ən çox təkrarlanan səhv — bütün pulu prosessora verib, sistemi mexaniki diskə qurmaqdır. Nəticə: kağız üzərində güclü, real istifadədə ləng kompüter. Praktik qayda:</p>
<ul>
  <li><strong>SSD şərtdir</strong> — istənilən büdcədə, istənilən konfiqurasiyada. Bu, hiss olunan sürətə ən çox təsir edən tək komponentdir;</li>
  <li><strong>RAM 16 GB</strong> — 2026-da bu, rahat işin başlanğıc nöqtəsidir;</li>
  <li><strong>Qida bloku ucuz olmasın</strong> — sıradan çıxanda özü ilə başqa komponentləri də aparır.</li>
</ul>

<h2>Ofis və sənəd işi</h2>
<p>Word, Excel, e-poçt, brauzerdə 20 tab. Burada güclü prosessora ehtiyac yoxdur:</p>
<ul>
  <li>Prosessor: Intel Core i3 və ya Ryzen 3 səviyyəsi;</li>
  <li>RAM: 8 GB (16 GB rahat ehtiyat);</li>
  <li>Disk: 256 GB SSD;</li>
  <li>Videokart: inteqrasiya olunmuş qrafika kifayətdir.</li>
</ul>

<h2>Tədris və uzaqdan iş</h2>
<p>Onlayn dərslər, video zənglər, eyni anda bir neçə proqram. Fərq əsasən yaddaşdadır:</p>
<ul>
  <li>Prosessor: Core i5 və ya Ryzen 5;</li>
  <li>RAM: 16 GB;</li>
  <li>Disk: 512 GB SSD;</li>
  <li>Əlavə: keyfiyyətli veb-kamera və qulaqlıq — bu ikisi təəssüratı prosessordan çox dəyişir.</li>
</ul>

<h2>Dizayn, montaj və 3D</h2>
<p>Photoshop, Illustrator, video montaj və render. Burada həm nüvə sayı, həm də yaddaş vacibdir:</p>
<ul>
  <li>Prosessor: Core i7 / Ryzen 7 və yuxarı;</li>
  <li>RAM: 32 GB (4K montajda daha az tövsiyə olunmur);</li>
  <li>Disk: 1 TB NVMe SSD — layihə faylları üçün sürət kritikdir;</li>
  <li>Videokart: 8 GB və daha çox video yaddaş;</li>
  <li>Monitor: rəng dəqiqliyi üçün IPS panel.</li>
</ul>

<h2>Oyun</h2>
<p>Oyun kompüterində büdcənin ən böyük hissəsi <strong>videokarta</strong> gedir — prosessora yox. Tipik nisbət: videokart üçün büdcənin təxminən 40–50%-i.</p>
<ul>
  <li>Videokart: hədəf monitorun icazəsinə görə seçilir (1080p, 1440p, 4K);</li>
  <li>Prosessor: Core i5 / Ryzen 5 əksər oyunlar üçün kifayətdir;</li>
  <li>RAM: 16 GB, iki modul şəklində (dual channel);</li>
  <li>Qida bloku: sertifikatlı, videokartın tələbindən 150 W artıq;</li>
  <li>Korpus: yaxşı hava axını — oyun kompüterində bu, estetika deyil, zərurətdir.</li>
</ul>

<h2>Alarkən yoxlanılmalı 6 nöqtə</h2>
<ul>
  <li>Zəmanət müddəti və şərtləri sənədlə təsdiqlənirmi;</li>
  <li>Komponentlərin dəqiq modelləri göstərilibmi (yalnız "8 GB RAM" yox);</li>
  <li>SSD-nin növü — SATA yoxsa NVMe;</li>
  <li>Qida blokunun real gücü və brendi;</li>
  <li>Gələcəkdə RAM və disk artırmaq üçün boş yuva varmı;</li>
  <li>Servis dəstəyi yerlidirmi — nasazlıq halında kimə müraciət edəcəksiniz.</li>
</ul>
<p>Texnobəy-də bütün kompüterlər zəmanətlə satılır və konfiqurasiyanı istifadə məqsədinizə uyğun birlikdə seçirik. <a href="/#products">Məhsul kataloqumuza baxın</a> və ya <a href="/#order">konsultasiya üçün sifariş buraxın</a>.</p>
HTML,
                'faq' => [
                    ['q' => 'Hazır kompüter almaq yoxsa yığdırmaq daha yaxşıdır?', 'a' => 'Yığılan kompüter eyni büdcəyə adətən daha güclü olur və komponentləri özünüz seçirsiniz. Hazır sistemlər isə tək zəmanət və dərhal istifadə üstünlüyü verir. Texnobəy hər iki variantı təklif edir.'],
                    ['q' => '8 GB RAM 2026-da kifayətdirmi?', 'a' => 'Yalnız sənəd işi və brauzer üçün kifayətdir. Bir neçə proqramı eyni anda işlədirsinizsə və ya video zənglər edirsinizsə, 16 GB açıq şəkildə daha rahatdır və qiymət fərqi böyük deyil.'],
                    ['q' => 'İkinci əl kompüter almaq riskli deyil?', 'a' => 'Yoxlanılmış və zəmanətlə satılan cihazlar sərfəli seçim ola bilər. Əsas şərt — diskin sağlamlığının (SMART) və batareyanın vəziyyətinin satışdan əvvəl yoxlanılmasıdır.'],
                ],
            ],
            [
                'slug'  => 'noutbuk-secimi-is-tedris-ve-oyun-ucun',
                'title' => 'Noutbuk seçimi: iş, tədris və oyun üçün hansı model?',
                'icon'  => '🎒',
                'cat'   => 'satis',
                'image' => '/uploads/blog/noutbuk-satisi.jpg',
                'meta_title' => 'Noutbuk almaq Bakı – iş, tədris və oyun üçün seçim | Texnobəy',
                'meta_desc'  => 'Noutbuk seçərkən prosessor, RAM, disk, ekran və batareyanı necə balanslaşdırmaq lazımdır? Ehtiyaca görə praktik seçim bələdçisi.',
                'excerpt' => 'Noutbuku stasionar kompüterdən fərqli edən şey ondan sonra dəyişdirə bilməyəcəyiniz hissələrdir: ekran, klaviatura və batareya. Seçimi məhz onlardan başlamaq lazımdır.',
                'body' => <<<'HTML'
<p>Stasionar kompüterdə səhv seçilmiş komponenti sonradan dəyişmək olar. Noutbukda isə <strong>ekran, klaviatura, batareya və çəki</strong> sizinlə cihazın bütün ömrü boyu qalır. Buna görə də seçimə xarakteristikalardan yox, istifadə şəraitindən başlayırıq.</p>

<h2>Əvvəlcə bu üç suala cavab verin</h2>
<ul>
  <li><strong>Gündə neçə saat rozetkadan uzaq işləyəcəksiniz?</strong> Cavab 4 saatdan çoxdursa, batareya prosessordan vacibdir;</li>
  <li><strong>Cihazı hər gün gəzdirəcəksinizmi?</strong> Elədirsə, 1.5 kq-dan ağır model gündəlik yükə çevrilir;</li>
  <li><strong>Ən ağır proqramınız hansıdır?</strong> Konfiqurasiya orta yükə görə yox, məhz ona görə seçilməlidir.</li>
</ul>

<h2>Tədris və gündəlik istifadə</h2>
<p>Dərslər, referatlar, onlayn görüşlər, video izləmə:</p>
<ul>
  <li>Prosessor: Core i3 / i5 və ya Ryzen 3 / 5;</li>
  <li>RAM: 8–16 GB;</li>
  <li>Disk: 256–512 GB SSD;</li>
  <li>Ekran: 14–15.6", mütləq <strong>Full HD və IPS</strong> — ucuz TN panellər saatlarla oxumaq üçün yorucudur;</li>
  <li>Batareya: 6 saatdan çox.</li>
</ul>

<h2>Ofis və biznes</h2>
<p>Burada üstünlük gücə yox, etibarlılığa və portativliyə verilir:</p>
<ul>
  <li>Çəki: 1.2–1.5 kq;</li>
  <li>Klaviatura: işıqlandırma və rahat gediş — gündə minlərlə simvol yazırsınızsa bu vacibdir;</li>
  <li>Portlar: HDMI və USB-C (Power Delivery ilə) — adapter daşımaqdan xilas edir;</li>
  <li>Təhlükəsizlik: barmaq izi oxuyucusu, TPM;</li>
  <li>Batareya: bütün iş günü.</li>
</ul>

<h2>Dizayn və montaj</h2>
<ul>
  <li>Prosessor: Core i7 / Ryzen 7;</li>
  <li>RAM: 16 GB minimum, 32 GB rahat;</li>
  <li>Disk: 1 TB NVMe SSD;</li>
  <li>Ekran: rəng əhatəsi göstərilmiş panel (sRGB 100%) — rəngli işdə bu, mərkəzi tələbdir;</li>
  <li>Ayrıca videokart: montaj və 3D-də render vaxtını hiss olunacaq qədər azaldır.</li>
</ul>

<h2>Oyun</h2>
<ul>
  <li>Videokart: seçimin mərkəzi — model adına diqqət edin, eyni ad altında fərqli güc versiyaları olur;</li>
  <li>Ekran: 144 Hz və daha yüksək yenilənmə tezliyi;</li>
  <li>Soyutma: oyun noutbukunda ən çox fərq yaradan, amma ən az baxılan xarakteristika;</li>
  <li>Çəki və batareya: oyun modellərində hər ikisi zəifdir — bunu əvvəlcədən qəbul edin.</li>
</ul>

<h2>Mağazada 5 dəqiqədə yoxlaya biləcəkləriniz</h2>
<ul>
  <li>Klaviaturada bir abzas yazın — düymələrin gedişi sizə rahatdırmı;</li>
  <li>Ekranı yan bucaqdan baxın — rənglər solurmusa, panel IPS deyil;</li>
  <li>Qapağı bir əllə açın — korpusun bərkliyi haqqında çox şey deyir;</li>
  <li>Portları sayın və gündəlik ehtiyacınızla tutuşdurun;</li>
  <li>Ventilyatorun səsini yüklü rejimdə dinləyin.</li>
</ul>
<p><a href="/#products">Texnobəy kataloqunda</a> hər büdcə üçün noutbuk var və seçimi ehtiyacınıza görə birlikdə edirik.</p>
HTML,
                'faq' => [
                    ['q' => 'Noutbuk üçün 14" yoxsa 15.6" daha yaxşıdır?', 'a' => 'Hər gün gəzdirirsinizsə 14" daha rahatdır. Noutbuk əsasən masada qalırsa, 15.6" ekran gözə daha yumşaqdır və klaviaturada tam rəqəm bloku olur.'],
                    ['q' => 'Noutbukda RAM-ı sonradan artırmaq olar?', 'a' => 'Modeldən asılıdır. Bəzi noutbuklarda yaddaş ana plataya lehimlənir və artırmaq mümkün olmur. Alışdan əvvəl boş yaddaş yuvasının olub-olmadığını mütləq soruşun.'],
                    ['q' => 'Oyun noutbuku gündəlik iş üçün uyğundurmu?', 'a' => 'Uyğundur, amma güzəştlərlə: daha ağırdır, batareya daha tez bitir və ventilyatorlar daha səslidir. Yalnız arabir oyun oynayırsınızsa, orta sinif noutbuk daha balanslı seçimdir.'],
                ],
            ],
            [
                'slug'  => 'printer-secimi-lazer-murekkeb-yoxsa-mfp',
                'title' => 'Printer seçimi: lazer, mürəkkəb yoxsa MFP?',
                'icon'  => '🧾',
                'cat'   => 'satis',
                'image' => '/uploads/blog/printer-satisi.jpg',
                'meta_title' => 'Printer almaq Bakı – lazer, mürəkkəbli və MFP seçimi | Texnobəy',
                'meta_desc'  => 'Ev və ofis üçün printer seçimi: lazer və mürəkkəbli texnologiyaların fərqi, bir səhifənin real dəyəri və MFP nə vaxt lazımdır.',
                'excerpt' => 'Printerin əsl qiyməti kassada ödədiyiniz məbləğ deyil — bir səhifənin dəyəridir. Ucuz printer bəzən ən bahalı seçim olur.',
                'body' => <<<'HTML'
<p>Printer alarkən yeganə düzgün müqayisə meyarı cihazın qiyməti deyil, <strong>bir çap olunmuş səhifənin dəyəridir</strong>. Ucuz printer bahalı kartricləri ilə bir ildə öz qiymətindən artıq xərc çıxara bilər. Seçimi buradan başlayaq.</p>

<h2>Lazer printer</h2>
<p><strong>Kimə uyğundur:</strong> ayda 200-dən çox səhifə, əsasən mətn çap edənlərə — ofislərə, tədris mərkəzlərinə, sənədlə işləyənlərə.</p>
<ul>
  <li>Bir səhifənin dəyəri ən aşağıdır;</li>
  <li>Çap sürəti yüksəkdir;</li>
  <li>Toner quruyub bağlanmır — <strong>aylarla işlədilməsə belə problem yaratmır</strong>;</li>
  <li>Mətn kənarları kəskin çıxır;</li>
  <li>Zəif tərəfi: rəngli lazer modellər bahalıdır və foto keyfiyyəti verməz.</li>
</ul>

<h2>Mürəkkəbli printer</h2>
<p><strong>Kimə uyğundur:</strong> rəngli çap, foto və qrafika ilə işləyənlərə; az həcmdə, amma keyfiyyətli rəng lazım olan evlərə.</p>
<ul>
  <li>Rəng keçidləri və fotolar üçün ən yaxşı nəticə;</li>
  <li>Cihazın özü ucuzdur;</li>
  <li>Zəif tərəfi: <strong>uzun fasilələrdə başlıq quruyur</strong>;</li>
  <li>Adi kartriclərlə səhifə dəyəri yüksəkdir.</li>
</ul>
<p>Əgər həm rəng, həm də ucuz səhifə lazımdırsa, <strong>zavod SDM (davamlı mürəkkəb təchizatı) sistemli</strong> modellərə baxın — kartric əvəzinə doldurulan çənlərlə işləyir və rəngli çapda səhifə dəyərini kəskin aşağı salır.</p>

<h2>MFP — çoxfunksiyalı cihaz</h2>
<p>Printer, skaner və surətçıxaran bir korpusda. Ayrı-ayrı cihaz almaqdan həm ucuz, həm də az yer tutur.</p>
<p>MFP seçərkən diqqət ediləsi iki nöqtə:</p>
<ul>
  <li><strong>ADF</strong> (avtomatik sənəd ötürücü) — çoxsəhifəli sənədləri skan edirsinizsə, bu, gündə saatlarla vaxt qazandırır;</li>
  <li><strong>Duplex</strong> — kağızın hər iki üzünə avtomatik çap; kağız xərcini iki dəfə azaldır.</li>
</ul>

<h2>Ayda neçə səhifə çap edirsiniz?</h2>
<ul>
  <li><strong>50 səhifəyə qədər:</strong> SDM sistemli mürəkkəbli MFP;</li>
  <li><strong>50–300 səhifə, əsasən mətn:</strong> ağ-qara lazer printer və ya MFP;</li>
  <li><strong>300+ səhifə:</strong> duplex və ADF ilə ofis sinfi lazer MFP;</li>
  <li><strong>Foto və qrafika:</strong> çoxrəngli mürəkkəbli foto printer.</li>
</ul>

<h2>Qiymət etiketində görünməyən xərclər</h2>
<ul>
  <li>Kartricin qiyməti və resursu (neçə səhifəyə hesablanıb);</li>
  <li>Analoq kartric bazarda varmı;</li>
  <li>Rəngli modeldə hər rəng ayrıca kartricdirmi — birləşik kartricdə bir rəng bitəndə hamısını dəyişirsiniz;</li>
  <li>Duplex olmaması kağız xərcini iki dəfə artırır;</li>
  <li>Wi-Fi və mobil çap dəstəyi — sonradan əlavə edilə bilməyən funksiyadır.</li>
</ul>
<p>Texnobəy-də HP, Canon və Epson printerləri zəmanətlə satılır, quraşdırma və sonrakı servis dəstəyi bizim tərəfimizdən verilir. <a href="/#products">Modellərə baxın</a> və ya <a href="/#order">sizin həcmə uyğun model üçün bizə yazın</a>.</p>
HTML,
                'faq' => [
                    ['q' => 'Ev üçün lazer yoxsa mürəkkəbli printer?', 'a' => 'Əsasən sənəd çap edirsinizsə və printer həftələrlə boş qala bilirsə, lazer daha az problem verir. Uşaqların rəngli işləri və fotolar üçün SDM sistemli mürəkkəbli model daha uyğundur.'],
                    ['q' => 'SDM (davamlı mürəkkəb) sistemi zəmanəti pozurmu?', 'a' => 'Zavodda quraşdırılmış SDM sistemli modellərdə zəmanət tam qüvvədədir. Sonradan kənar sistem quraşdırılması isə istehsalçı zəmanətini ləğv edə bilər.'],
                    ['q' => 'Wi-Fi printer nə üstünlük verir?', 'a' => 'Kabel çəkmədən bir neçə kompüter və telefondan çap edə bilirsiniz. Ofisdə bu, printeri hamı üçün əlçatan edir; evdə isə telefondan birbaşa çap rahatlığı yaradır.'],
                ],
            ],
            [
                'slug'  => 'proyektor-secimi-lumen-kontrast-ve-ekran-olcusu',
                'title' => 'Proyektor seçimi: lümen, kontrast və ekran ölçüsü',
                'icon'  => '🎬',
                'cat'   => 'satis',
                'image' => '/uploads/blog/proyektor-satisi.jpg',
                'meta_title' => 'Proyektor almaq Bakı – lümen və ekran ölçüsü bələdçisi | Texnobəy',
                'meta_desc'  => 'Ofis, tədris və ev kinoteatrı üçün proyektor seçimi: neçə lümen lazımdır, hansı icazə, lampa yoxsa lazer? Praktik seçim bələdçisi.',
                'excerpt' => 'Proyektor seçimində bir səhv bütün digərlərini üstələyir: otağın işığına uyğun olmayan parlaqlıq. Nə qədər lümen lazım olduğunu otaq həll edir, kataloq yox.',
                'body' => <<<'HTML'
<p>Proyektor alarkən ən çox rast gəlinən məyusluq eyni cümlə ilə başlayır: "Mağazada təsvir çox gözəl idi, otaqda isə solğun görünür." Səbəb demək olar ki, həmişə birdir — <strong>parlaqlıq otağın işığına uyğun seçilməyib</strong>.</p>

<h2>Neçə lümen lazımdır?</h2>
<p>Lümen (ANSI lumens) proyektorun ən vacib göstəricisidir və otağın işıqlanmasına görə seçilir:</p>
<ul>
  <li><strong>Tam qaranlıq otaq</strong> (ev kinoteatrı, pərdəli): 1500–2000 lümen kifayətdir;</li>
  <li><strong>Qismən işıqlı otaq</strong> (yaşayış otağı, kiçik iclas otağı): 2500–3000 lümen;</li>
  <li><strong>İşıqlı otaq</strong> (sinif, ofis, pəncərələr açıq): <strong>3500 lümen və yuxarı</strong>;</li>
  <li><strong>Çox işıqlı zal və ya konfrans salonu:</strong> 4500+ lümen.</li>
</ul>
<p>Diqqət: bəzi kataloqlarda "LED lumen" və ya sadəcə "lumens" yazılır — bu rəqəmlər ANSI standartından qat-qat yüksək görünə bilər. Müqayisə üçün həmişə <strong>ANSI lümen</strong> göstəricisini soruşun.</p>

<h2>İcazə (rezolyusiya)</h2>
<ul>
  <li><strong>SVGA / XGA</strong> — sadə slaydlar və mətn üçün; ucuz, sinif otaqlarında hələ də işlənir;</li>
  <li><strong>WXGA</strong> — geniş ekran təqdimatları, ofis üçün ən balanslı seçim;</li>
  <li><strong>Full HD (1080p)</strong> — film, video və detallı qrafika üçün minimum;</li>
  <li><strong>4K</strong> — böyük ekranlı ev kinoteatrı.</li>
</ul>
<p>Slaydlarda kiçik şrift və cədvəl çox olursa, icazəni bir pillə yuxarı götürün — mətnin oxunaqlığı birbaşa bundan asılıdır.</p>

<h2>Ekran ölçüsü və məsafə</h2>
<p>Təsvirin ölçüsü proyektorun ekrandan məsafəsindən asılıdır. Praktik ölçü: adi (standard throw) proyektorlarda <strong>2.5–3 metr məsafə təxminən 100 düym təsvir</strong> verir.</p>
<p>Otaq kiçikdirsə və proyektoru ekrana yaxın qoymalısınızsa, <strong>short throw</strong> modellərə baxın — 1 metrdən az məsafədən böyük təsvir verir və təqdimatçının kölgəsi ekrana düşmür.</p>

<h2>Lampa yoxsa lazer?</h2>
<ul>
  <li><strong>Lampalı (UHP):</strong> cihaz ucuzdur, lakin lampa 2000–4000 saatdan sonra dəyişdirilməlidir və bu, əlavə xərcdir;</li>
  <li><strong>Lazer:</strong> ilkin qiymət yüksəkdir, amma 20 000 saatdan çox işləyir, dərhal yanır və parlaqlığını uzun müddət saxlayır.</li>
</ul>
<p>Proyektor gündə bir neçə saat işləyəcəksə (sinif, iclas otağı), lazer model 3–4 ildə lampalı modeldən ucuz başa gəlir.</p>

<h2>Nəzərdən qaçırılan, sonra problem yaradan detallar</h2>
<ul>
  <li><strong>Səs səviyyəsi</strong> — kiçik otaqda 35 dB-dən yüksək ventilyator səsi filmi korlayır;</li>
  <li><strong>Portlar</strong> — HDMI sayı, USB-C, simsiz ekran ötürməsi;</li>
  <li><strong>Daxili dinamik</strong> — təqdimat üçün kifayətdir, film üçün yox;</li>
  <li><strong>Keystone və lens shift</strong> — quraşdırma çevikliyi;</li>
  <li><strong>Ekran səthi</strong> — ağ divar heç vaxt normal ekranı əvəz etmir.</li>
</ul>
<p>Texnobəy-də Epson və digər brendlərin proyektorları zəmanətlə satılır, quraşdırma və sazlama xidmətini də biz göstəririk. <a href="/#products">Modellərə baxın</a> və ya <a href="/#order">otağınıza uyğun seçim üçün bizimlə əlaqə saxlayın</a>.</p>
HTML,
                'faq' => [
                    ['q' => 'Ev kinoteatrı üçün neçə lümen kifayətdir?', 'a' => 'Otağı tam qaralda bilirsinizsə, 1500–2000 ANSI lümen kifayətdir. Otaqda işıq varsa, 2500–3000 lümen götürmək lazımdır.'],
                    ['q' => 'Proyektor televizoru əvəz edə bilərmi?', 'a' => 'Böyük təsvir və film təəssüratı baxımından bəli. Amma gündüz işıqlı otaqda televizor həmişə daha parlaqdır — proyektor pərdə və ya qaranlıq otaq tələb edir.'],
                    ['q' => 'Ekran almaq şərtdirmi, ağ divar bəs etmir?', 'a' => 'Ağ divar işləyir, amma kontrast və rəng dəqiqliyi hiss olunacaq qədər aşağı olur. Xüsusi ekran səthi eyni proyektordan daha parlaq və təmiz təsvir alır.'],
                ],
            ],
        ];
    }
}
