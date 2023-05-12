<?php

namespace App\Console\Commands;

use App\Models\Category;
use Illuminate\Console\Command;

class AddCategorySlug extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'category:slug';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $parentSlugs = [
            'Продукты питания, напитки' => 'produkty-pitaniya-napitki-optom',
            'Товары для детей' => 'tovary-dlya-detej-optom',
            'Одежда, обувь' => 'odezhda-obuv-optom',
            'Мебель' => 'mebel-optom',
            'Сельское хозяйство' => 'selskokhozyaystvennaya-produktsiya-optom',
            'Электрооборудование' => 'elektrooborudovanie',
            'Строительные материалы, услуги' => 'stroitelnye-materialy-uslugi-optom',
            'Оборудование для предоставления услуг' => 'oborudovanie-dlya-predostavleniya-uslug',
            'Красота и здоровье' => 'cosmetics-perfume',
            'Транспортные средства' => 'transport',
            'Досуг, праздники' => 'tovary-dlya-prazdnika-khobbi',
            'Деловые услуги' => 'delovye-uslugi',
            'Бытовые услуги' => 'bytovye-uslugi',
            'Галантерея, аксессуары' => 'galantereya-aksessuary-optom',
            'Текстиль, оформление интерьера' => 'interior-design-textiles',
            'Бытовая техника, компьютеры' => 'bytovaya-tekhnika-kompyutery-optom',
            'Товары для животных' => 'tovary-dlya-zhivotnyh-optom',
            'Металлы' => 'metall-optom',
            'Бытовая химия, хозтовары' => 'bytovaya-himiya-hoztovary-optom',
            'Туризм, спорт, отдых' => 'turiizm-sport-otdyh-optom',
            'Промышленное оборудование' => 'promyshlennoe-oborudovanie-optom',
            'Табак и табачные изделия' => 'tabak-tabachnye-izdeliya-optom',
            'Прочее' => 'prochee',
        ];

        foreach ($parentSlugs as $pName => $pSlug) {
            Category::where(['name' => $pName])->update(['slug' => $pSlug]);
        }


        $slugs = [
			'Овощи, фрукты' => 'ovoshchi-frukty',
			'Мука, крупы' => 'muka-krupy',
			'Кондитерские товары' => 'konditerskie-tovary',
			'Макаронные изделия' => 'makaronnye-izdeliya',
			'Алкогольные напитки' => 'alkogol',
			'Молочная продукция' => 'milk-products',
			'Мясная продукция' => 'meat',
			'Рыба, морепродукты' => 'fish-seafood',
			'Яйца' => 'eggs',
			'Консервация' => 'konservaciya',
			'Сахар, мед' => 'sugar-honey',
			'Масло растительное' => 'maslo-rastitelnoe',
			'Чай, кофе' => 'tea-coffee',
			'Безалкогольные напитки' => 'bezalkogolnye-napitki',
			'Полуфабрикаты' => 'polufabrikaty',
			'Семечки, орехи, снеки' => 'semechki-orekhi-sneki',
			'Пищевые добавки, специи' => 'pishchevye-dobavki-specii',
			'Здоровое питание' => 'zdorovoe-pitanie',

			'Детское питание' => 'detskoe-pitanie',
			'Одежда и обувь' => 'odezhda-shoes',
			'Гигиена, памперсы' => 'gigiena-pampersy',
			'Игрушки, аксессуары' => 'toys-accessories',
			'Коляски, кроватки и аксессуары' => 'kolyaski-krovatki-aksessuary',
			'Текстиль детский' => 'textiles-for-children',

			'Одежда' => 'odezhda',
			'Спецодежда' => 'specodezhda',
			'Нижнее белье' => 'underwear',
			'Головные уборы' => 'golovnye-ubory',
			'Обувь' => 'obuv',

			'Мебель корпусная' => 'mebel-korpusnaya',
			'Мебель офисная' => 'mebel-ofisnaya',
			'Мебель мягкая' => 'mebel-myagkaya',
			'Мебель детская' => 'mebel-detskaya',
			'Мебель промышленная' => 'mebel-promyshlennaya',
			'Мебель садово-парковая' => 'mebel-sadovo-parkovaya',
			'Мебель для ванных' => 'mebel-dlya-vannyh',
			'Мебельная фурнитура' => 'mebelnaya-furnitura',

			'Семена' => 'semena',
			'Рассада' => 'rassada',
			'Саженцы деревьев и кустарников' => 'sazhentsy-derevyev-kustarnikov',
			'Грунты и агрохимия' => 'grunty-agrohimiya',
			'Сельскохозяйственное сырье' => 'selskohozyajstvennoe',

			'Оборудование для электроснабжения' => 'oborudovanie-dlya-elektrosnabzheniya',
			'Комплектующие электрооборудования' => 'komplektuyushchie-elektrooborudovaniya',
			'Монтажное оборудование' => 'montazhnoe-oborudovanie',
			'Освещение, электрика' => 'osveshchenie-ehlektrika',
			'Силовые вилки, розетки' => 'silovye-vilki-rozetki',
			'Электродвигатели' => 'elektrodvigateli',
			'Электронные компоненты' => 'ehlektronnye-komponenty',
			'Кабельная продукция' => 'kabelnaya-produkciya',
			'Охрана и безопасность' => 'ohrana-bezopasnost',
			'Элементы питания' => 'ehlementy-pitaniya',
			'Контрольно-измерительные приборы' => 'kontrolno-izmeritelnye-pribory',

			'Общестроительные материалы' => 'obshchestroitelnye-materialy',
			'Цемент и сухие смеси' => 'cement-suhie-smesi',
			'Отделочные материалы' => 'otdelochnye-materialy',
			'Фасадные материалы' => 'fasadnye-materialy',
			'Сантехника' => 'santekhnika',
			'Инструмент' => 'instrument',
			'Строительные растворы' => 'stroitelnye-rastvory',
			'Изоляционные материалы' => 'izolyacionnye-materialy',
			'Пиломатериалы' => 'pilomaterialy',
			'Окна и комплектующие' => 'okna-komplektuyushchie',
			'Двери, ворота' => 'dveri-vorota',
			'Лестницы, ограждения' => 'lestnicy-ograzhdeniya',
			'Разработка проектов' => 'razrabotka-proektov',
			'Строительно-монтажные работы' => 'stroitelno-montazhnye-raboty',
			'Установка бытового оборудования' => 'ustanovka-bytovogo-oborudovaniya',
			'Установка инженерного оборудования' => 'ustanovka-inzhenernogo-oborudovaniya',
			'Услуги по ландшафтным работам' => 'uslugi-po-landshafnym-rabotam',
			'Ремонт объектов недвижимости' => 'remont-obektov-nedvizhimosti',

			'Вендинговое и развлекательное оборудование' => 'vendingovoe-razvlekatelnoe-oborudovanie',
			'Торговое оборудование' => 'torgovoe-oborudovanie',
			'Оборудование для парикмахерских, салонов' => 'oborudovanie-dlya-parikmaherskih-salonov',
			'Оборудование для ресторанов, кафе' => 'oborudovanie-dlya-restoranov-kafe',
			'Банковское оборудование' => 'bankovskoe-oborudovanie',
			'Оборудование для автосервиса' => 'oborudovanie-dlya-avtoservisa',
			'Оборудование для учебных заведений' => 'oborudovanie-dlya-uchebnyh-zavedenij',
			'Оборудование, материалы для типографии' => 'oborudovanie-materialy-dlya-tipografii',
			'Оборудование для клининга' => 'oborudovanie-dlya-klininga',
			'Оборудование ювелирное' => 'oborudovanie-yuvelirnoe',
			'Прачечное оборудование' => 'prachechnoe-oborudovanie',
			'Рекламное и выставочное оборудование' => 'reklamnoe-vystavochnoe-oborudovanie',

			'Средства по уходу за волосами' => 'hair-care-products',
			'Средства по уходу за телом' => 'body-care-products',
			'Средства по уходу за лицом' => 'face-care-products',
			'Средства для маникюра, педикюра' => 'sredstva-dlya-manikyura-pedikyura',
			'Парфюмерия, духи' => 'perfume',
			'Декоративная косметика' => 'decorative-cosmetics',
			'Средства личной гигиены' => 'personal-hygiene-products',
			'Интимные товары' => 'intimate-goods',
			'Лекарственные средства' => 'medicines',
			'Биологические активные добавки' => 'bad',
			'Перевязочные средства' => 'dressings',
			'Предметы ухода за больными' => 'predmety-uhoda-za-bolnymi',
			'Протезные, ортопедические товары' => 'prostheses-orthopedics',
			'Медицинское оборудование, инструмент' => 'medicinskoe-oborudovanie-instrument',
			'Оптика' => 'optika',

			'Велосипеды' => 'bicycles',
			'Мототехника' => 'mototekhnika',
			'Грузовые автомобили, спецтехника' => 'gruzovye-avtomobili-spectekhnika',
			'Запчасти к транспортным средствам' => 'auto-parts',
			'Колеса, шины, диски' => 'kolesa-shiny-diski',
			'Горюче-смазочные материалы' => 'goryuche-smazochnye-materialy',
			'Автоаксессуары и автохимия' => 'avtoaksessuary-avtohimiya',
			'Автомобили' => 'cars',
			'Лодки, катера' => 'boats',

			'Музыкальные товары' => 'musical-goods',
			'Канцтовары' => 'kanctovary',
			'Игры' => 'games',
			'Книги,  печатные изделия' => 'books-printed-editions',
			'Принадлежности для рукоделия' => 'prinadlezhnosti-dlya-rukodeliya',
			'Художественно-декоративные товары' => 'hudozhestvenno-dekorativnye-tovary',
			'Ювелирные изделия, часы' => 'jewelry-watch',
			'Товары для творчества' => 'tovary-dlya-tvorchestva',
			'Товары для праздника' => 'tovary-dlya-prazdnika',
			'Организация праздников' => 'organizaciya-prazdnikov',
			'Цветы, доставка' => 'flowers-delivery',
			'Подарочная упаковка' => 'podarochnaya-upakovka',
			'Товары для бани и сауны' => 'tovary-dlya-bani-i-sauny',
			'Сувениры и подарки' => 'suveniry-podarki',
			'Интернет-кафе' => 'internet-kafe',

			'Аудит' => 'audit',
			'Бухгалтерские и финансовые услуги' => 'buhgalterskie-finansovye-uslugi',
			'Готовый бизнес, франшизы' => 'gotovyj-biznes-franshizy',
			'Инженерно-консультационные услуги' => 'inzhenerno-konsultacionnye-uslugi',
			'Подбор персонала' => 'podbor-personala',
			'Юридические услуги' => 'yuridicheskie-uslugi',
			'Рекламные услуги, маркетинг' => 'reklamnye-uslugi-marketing',
			'Полиграфические услуги' => 'poligraficheskie-uslugi',
			'Риэлтерские услуги' => 'riehlterskie-uslugi',
			'Услуги аренды' => 'uslugi-arendy',
			'Охранные услуги' => 'ohrannye-uslugi',
			'Страховые услуги' => 'strahovye-uslugi',
			'Образовательные услуги' => 'obrazovatelnye-uslugi',
			'Лингвистические услуги' => 'lingvisticheskie-uslugi',
			'Логистические услуги' => 'logisticheskie-uslugi',
			'IT, интернет, телеком' => 'it-internet-telekom',
			'Услуги гостиничного бизнеса' => 'uslugi-gostinichnogo-biznesa',
			'Услуги связи' => 'uslugi-svyazi',
			'Авторемонт' => 'avtoremont',
			'Автостоянки' => 'avtostoyanki',

			'Ремонт и пошив одежды' => 'remont-poshiv-odezhdy',
			'Изготовление ключей' => 'izgotovlenie-keys',
			'Услуги по клинингу' => 'uslugi-po-kliningu',
			'Услуги бань, саун' => 'uslugi-ban-saun',
			'Услуги химчисток, прачечных' => 'uslugi-himchistok-prachechnyh',
			'Ремонт часов' => 'remont-watch',
			'Ремонт ювелирных изделий' => 'remont-yuvelirnyh-izdelij',
			'Ремонт обуви' => 'remont-obuvi',
			'Услуги ресторанов и кафе' => 'uslugi-restoranov-kafe',
			'Доставка еды и воды' => 'water-food-delivery',
			'Ремонт бытовой техники' => 'remont-bytovoj-tekhniki',
			'Ремонт мебели' => 'remont-mebeli',
			'Ремонт сотовых телефонов' => 'remont-sotovyh-telefonov',
			'Услуги фотографов' => 'uslugi-fotografov',
			'Услуги салонов красоты' => 'uslugi-salonov-krasoty',
			'Услуги проката' => 'uslugi-prokata',
			'Ритуальные, обрядовые услуги' => 'bytovye-uslugi/ritualnye-obryadovye-uslugi',

			'Кожгалантерея' => 'kozhgalantereya',
			'Чемоданы, сумки, зонты' => 'chemodany-sumki-zonty',
			'Гребни, расчески, заколки' => 'grebni-rascheski-zakolki',
			'Бижутерия, украшения' => 'bizhuteriya-ukrasheniya',
			'Солнцезащитные очки' => 'solncezashchitnye-ochki',

			'Ткани' => 'tkani',
			'Шторы' => 'shtory',
			'Ковры' => 'kovry',
			'Одеяла и подушки' => 'odeyala-podushki',
			'Покрывала и пледы' => 'pokryvala-pledy',
			'Постельное белье' => 'bed-linen',
			'Полотенца' => 'polotenca',
			'Столовый текстиль' => 'stolovyj-tekstil',
			'Горшки и кашпо' => 'gorshki-kashpo',
			'Фигурки, статуэтки' => 'figurki-statuehtki',
			'Настенные украшения' => 'nastennye-ukrasheniya',
			'Картины и постеры' => 'kartiny-postery',
			'Карнизы' => 'karnizy',
			'Зеркала' => 'zerkala',

			'Крупная бытовая техника' => 'krupnaya-bytovaya-tekhnika',
			'Мелкая бытовая техника' => 'melkaya-bytovaya-tekhnika',
			'Климатическая техника' => 'klimaticheskaya-tekhnika',
			'Компьютеры и комплектующие' => 'kompyutery-komplektuyushchie',
			'Оргтехника' => 'orgtekhnika',
			'Измерительная техника' => 'izmeritelnaya-tekhnika',
			'Аудио, видео, фототовары' => 'audio-video-fototovary',
			'Запчасти для бытовой техники' => 'zapchasti-dlya-bytovoj-tekhniki',

			'Животноводство' => 'zhivotnovodstvo',
			'Оборудование для животноводства' => 'oborudovanie-dlya-zhivotnovodstva',
			'Зоотовары' => 'zootovary',
			'Ветеринарные препараты' => 'veterinarnye-preparaty',
			'Корма' => 'korma',
			'Комбикорм, кормовые добавки' => 'kombikorm-kormovye-dobavki',
			'Одежда, аксессуары' => 'odezhda-aksessuary',

			'Металлообработка' => 'metalloobrabotka',
			'Металлопрокат' => 'metalloprokat',
			'Листовой прокат' => 'listovoj-prokat',
			'Металлоизделия' => 'metalloizdeliya',
			'Сварочные материалы' => 'svarochnye-materialy',

			'Посуда' => 'posuda',
			'Аксессуары для хранения' => 'aksessuary-dlya-hraneniya',
			'Моющие, чистящие средства' => 'moyushchie-chistyashchie-sredstva',
			'Дезинфицирующие средства' => 'dezinficiruyushchie-sredstva',
			'Освежители воздуха, ароматизаторы' => 'osvezhiteli-vozduha-aromatizatory',
			'Инвентарь для уборки' => 'inventar-dlya-uborki',
			'Мешки для мусора' => 'meshki-dlya-musora',
			'Упаковочные материалы' => 'upakovochnye-materialy',
			'Санитарно-гигиенические средства' => 'sanitarno-gigienicheskie-sredstva',

			'Снаряжение для туризма' => 'snaryazhenie-dlya-turizma',
			'Снаряжение для отдыха' => 'snaryazhenie-dlya-otdyha',
			'Товары для рыбалки' => 'tovary-dlya-rybalki',
			'Товары для охоты' => 'tovary-dlya-ohoty',
			'Спортивная одежда и обувь' => 'sportivnaya-odezhda-obuv',
			'Спортивное питание' => 'sportivnoe-pitanie',
			'Спортивно-развлекательное оборудование' => 'sportivno-razvlekatelnoe-oborudovanie',
			'Услуги турагентов' => 'uslugi-turagentov',
			'Услуги гидов' => 'uslugi-gidov',
			'Пиротехника' => 'pirotekhnika',

			'Аварийно-спасательное оборудование' => 'avarijno-spasatelnoe-oborudovanie',
			'Вентиляционные системы' => 'ventilyacionnye-sistemy',
			'Оборудование для сельского хозяйства' => 'oborudovanie-dlya-selskogo-hozyajstva',
			'Оборудование для автозаправок, нефтебаз' => 'oborudovanie-dlya-avtozapravok-neftebaz',
			'Лесозаготовительное оборудование' => 'lesozagotovitelnoe-oborudovanie',
			'Складское оборудование' => 'skladskoe-oborudovanie',
			'Станки' => 'stanki',
			'Строительное оборудование' => 'stroitelnoe-oborudovanie',
			'Технологическое оборудование' => 'tekhnologicheskoe-oborudovanie',
			'Холодильное оборудование' => 'holodilnoe-oborudovanie',
			'Швейное оборудование' => 'shvejnoe-oborudovanie',
			'Пищевое оборудование' => 'pishchevoe-oborudovanie',
			'Промышленная химия' => 'promyshlennaya-himiya',
			'Производственная тара' => 'proizvodstvennaya-tara',

			'Зажигалки, мундштуки, трубки' => 'zazhigalki-mudshtuki-trubki',
			'Кальяны и комплектующие' => 'kalyany-komplektuyushchiye',
			'Сигареты и сигары' => 'cigarette-cigar',
			'Электронные сигареты' => 'elektronnyye-sigarety',





		];


        foreach ($slugs as $catName => $slug) {
            Category::where(['name' => $catName])->get()->map(function ($category) use ($slug) {
                $category->slug = $slug;
                if ($category->parent) {
                    $category->parent_slug = $category->parent->slug;
                }
                $category->save();
            });
        }
    }
}
