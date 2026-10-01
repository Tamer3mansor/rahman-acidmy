<?php

namespace App\Filament\Resources\CoursePageSettings\Schemas;

use App\Rules\CtaUrl;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

/**
 * Four tabs, one per page, so nothing is edited twice:
 *
 *   1. صفحة الأطفال الرئيسية   — copy unique to /enfants
 *   2. صفحة الكبار الرئيسية     — copy unique to /adultes
 *   3. المحتوى المشترك (أطفال) — copy for every kids course detail page,
 *                                plus the override tier of the content chain
 *   4. المحتوى المشترك (كبار)  — the same for adults
 *
 * Course detail sections resolve in this order:
 * course record → shared tab → main page tab → section hidden.
 */
class CoursePageSettingsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make()
                    ->columnSpanFull()
                    ->tabs([
                        Tab::make('صفحة الأطفال الرئيسية')
                            ->schema(self::mainPageSections('kids')),
                        Tab::make('صفحة الكبار الرئيسية')
                            ->schema(self::mainPageSections('adults')),
                        Tab::make('المحتوى المشترك — الأطفال')
                            ->schema(self::sharedSections('kids')),
                        Tab::make('المحتوى المشترك — الكبار')
                            ->schema(self::sharedSections('adults')),
                        Tab::make('تحسين محركات البحث (SEO)')
                            ->schema(self::seoSections()),
                    ]),

                Section::make('الحالة')
                    ->description('إيقاف الصفحة الرئيسية هنا يخفي صفحتي الأطفال والكبار وصفحات تفاصيل دوراتها بالكامل (404).')
                    ->schema([
                        Toggle::make('is_active')
                            ->label('نشط')
                            ->helperText('عند الإيقاف ترجع الصفحات للخطأ 404 حتى لو كانت الدورات نشطة.')
                            ->default(true),
                    ])
                    ->columns(1),
            ]);
    }

    /**
     * Tab 1 and 2: hero, catalog grid, contact card and final band. The
     * repeatable sections are also the last fallback tier for the course
     * detail pages, which is why they live here rather than in the shared tab.
     *
     * @return array<int, Section>
     */
    private static function mainPageSections(string $audience): array
    {
        return [
            Section::make('الهيرو')
                ->description('الجزء العلوي من الصفحة الرئيسية.')
                ->schema([
                    TextInput::make($audience.'_badge')
                        ->label('الشارة')
                        ->helperText('يظهر في هيرو الصفحة الرئيسية — مثال: 🌱 رحلة إيمانية ممتعة لسن 5 - 15 سنة')
                        ->columnSpan(3),
                    TextInput::make($audience.'_label')->label('التسمية')->columnSpan(3),
                    TextInput::make($audience.'_title')->label('العنوان')->columnSpan(2),
                    TextInput::make($audience.'_title_accent')->label('الجزء المميز من العنوان')->columnSpan(1),
                    Textarea::make($audience.'_subtitle')->label('الوصف')->rows(2)->columnSpanFull(),
                    TextInput::make($audience.'_cta_title')->label('نص زر الحث')->columnSpan(2),
                    TextInput::make($audience.'_cta_url')
                        ->label('رابط زر الحث')
                        ->helperText('مثال: #catalog للانتقال لشبكة الدورات، أو رابط كامل.')
                        ->columnSpan(2),
                    TextInput::make($audience.'_wa_title')->label('نص زر واتساب')->columnSpan(2),
                    TextInput::make($audience.'_wa_url')->label('رابط واتساب')->url()->columnSpan(2),
                ])
                ->columns(6),

            Section::make('بطاقة العرض الرئيسية')
                ->schema([
                    FileUpload::make($audience.'_showcase_image')
                        ->label('صورة البطاقة')
                        ->image()
                        ->disk('public')
                        ->directory('images/course-hero')
                        ->columnSpan(2),
                    TextInput::make($audience.'_showcase_emoji')
                        ->label('إيموجي احتياطي (اختياري)')
                        ->helperText('يُعرض فقط عندما لا تكون هناك صورة مرفوعة.')
                        ->columnSpan(2),
                    TextInput::make($audience.'_showcase_title')->label('عنوان البطاقة')->columnSpan(2),
                    Textarea::make($audience.'_showcase_subtitle')->label('وصف البطاقة')->rows(2)->columnSpanFull(),
                ])
                ->columns(4),

            Section::make('شبكة الدورات')
                ->description('رأس القسم الذي يعرض بطاقات الدورات، والنصوص الظاهرة على كل بطاقة.')
                ->schema([
                    TextInput::make($audience.'_catalog_title')->label('عنوان القسم')->columnSpan(2),
                    Textarea::make($audience.'_catalog_subtitle')->label('وصف القسم')->rows(2)->columnSpan(2),
                    TextInput::make($audience.'_catalog_empty_text')
                        ->label('نص حالة «لا توجد دورات»')
                        ->helperText('يظهر مكان شبكة الدورات لو مفيش دورات نشطة في هذه الفئة.')
                        ->columnSpan(2),
                    TextInput::make($audience.'_card_cta_text')->label('نص زر البطاقة')->columnSpan(2),
                    TextInput::make($audience.'_card_age_template')
                        ->label('قالب عمر الطالب')
                        ->helperText('استخدم {age} كعنصر نائب للسن — مثال: Âge : {age} (تتحول لـ Âge : Dès 5 ans)')
                        ->placeholder('Âge : {age}')
                        ->columnSpan(2),
                    TextInput::make($audience.'_card_level_prefix')
                        ->label('بادئة المستوى على البطاقة')
                        ->helperText('مثال: Niveau : — اتركه فاضي لو مش عايز بادئة.')
                        ->columnSpan(2),
                ])
                ->columns(4),

            Section::make('قسم «مناسب لـ»')
                ->description('يظهر أسفل شبكة الدورات في الصفحة الرئيسية، وهو آخر مصدر لمحتوى قسم «مناسب لـ» في صفحات تفاصيل الدورات.')
                ->schema([
                    TextInput::make($audience.'_about_label')->label('التسمية')->columnSpan(2),
                    TextInput::make($audience.'_about_title')->label('العنوان')->columnSpan(2),
                    Textarea::make($audience.'_about_subtitle')->label('الوصف')->rows(2)->columnSpan(2),
                    Repeater::make($audience.'_about_items')
                        ->label('العناصر')
                        ->schema([
                            TextInput::make('icon')
                                ->label('الأيقونة (إيموجي)')
                                ->helperText('إيموجي واحد فقط، مثال 📖 — لو سايبها فاضية هتظهر علامة صح.')
                                ->default('📚')
                                ->maxLength(8)
                                ->columnSpan(1),
                            TextInput::make('title')->label('العنوان')->columnSpan(1),
                            Textarea::make('description')->label('الوصف')->rows(2)->columnSpanFull(),
                        ])
                        ->columns(2)
                        ->defaultItems(0)
                        ->addActionLabel('إضافة عنصر')
                        ->reorderableWithButtons()
                        ->collapsible(),
                ])
                ->columns(3),

            Section::make('قسم «البرنامج»')
                ->description('محتوى ما سيتعلمه الطالب، ويصل لصفحات التفاصيل كآخر مصدر بعد المحتوى المشترك.')
                ->schema([
                    TextInput::make($audience.'_curriculum_label')->label('التسمية')->columnSpan(2),
                    TextInput::make($audience.'_curriculum_title')->label('العنوان')->columnSpan(2),
                    Textarea::make($audience.'_curriculum_subtitle')->label('الوصف')->rows(2)->columnSpan(2),
                    Repeater::make($audience.'_curriculum_items')
                        ->label('المواضيع')
                        ->schema(self::topicSchema())
                        ->columns(2)
                        ->defaultItems(0)
                        ->addActionLabel('إضافة موضوع')
                        ->reorderableWithButtons()
                        ->collapsible(),
                ])
                ->columns(3),

            Section::make('قسم «كيف تكون الحصة»')
                ->description('اتركه فاضي لو مش عايز القسم يظهر في الصفحة الرئيسية — صفحات التفاصيل هتأخذ محتواه من المحتوى المشترك أو من هنا.')
                ->schema([
                    TextInput::make($audience.'_session_label')->label('التسمية')->columnSpan(2),
                    TextInput::make($audience.'_session_title')->label('العنوان')->columnSpan(2),
                    Textarea::make($audience.'_session_subtitle')->label('الوصف')->rows(2)->columnSpan(2),
                    Repeater::make($audience.'_session_items')
                        ->label('المميزات')
                        ->schema(self::titleDescriptionSchema())
                        ->columns(2)
                        ->defaultItems(0)
                        ->addActionLabel('إضافة ميزة')
                        ->reorderableWithButtons()
                        ->collapsible(),
                ])
                ->columns(3),

            Section::make('قسم «المسار»')
                ->schema([
                    TextInput::make($audience.'_journey_label')->label('التسمية')->columnSpan(2),
                    TextInput::make($audience.'_journey_title')->label('العنوان')->columnSpan(2),
                    Textarea::make($audience.'_journey_subtitle')->label('الوصف')->rows(2)->columnSpan(2),
                    Repeater::make($audience.'_journey_items')
                        ->label('الخطوات')
                        ->schema(self::titleDescriptionSchema())
                        ->columns(2)
                        ->defaultItems(0)
                        ->addActionLabel('إضافة خطوة')
                        ->reorderableWithButtons()
                        ->collapsible(),
                ])
                ->columns(3),

            Section::make('قسم «الشهادات»')
                ->description('الشهادات نفسها بتتحكم فيها من صفحة «آراء العملاء»، والقسم ده بيحدد عنوانه وعدد اللي بيظهروا في الصفحة.')
                ->schema([
                    TextInput::make($audience.'_testimonials_label')->label('التسمية')->columnSpan(3),
                    TextInput::make($audience.'_testimonials_title')->label('العنوان')->columnSpan(3),
                    Textarea::make($audience.'_testimonials_subtitle')->label('الوصف')->rows(2)->columnSpan(3),
                    TextInput::make($audience.'_testimonials_per_page')
                        ->label('عدد الشهادات في الصفحة')
                        ->helperText('كل الشهادات المختارة بتظهر، مقسمة على صفحات بهذا العدد. بيأثر على صفحة الجمهور دي وعلى صفحات الكورسات بتاعته.')
                        ->numeric()
                        ->minValue(1)
                        ->maxValue(24)
                        ->default(6)
                        ->columnSpan(3),
                ])
                ->columns(3),

            Section::make('قسم «الأسئلة الشائعة»')
                ->schema([
                    TextInput::make($audience.'_faq_label')->label('التسمية')->columnSpan(3),
                    TextInput::make($audience.'_faq_title')->label('العنوان')->columnSpan(3),
                    Textarea::make($audience.'_faq_subtitle')->label('الوصف')->rows(2)->columnSpan(2),
                    Repeater::make($audience.'_faq_items')
                        ->label('الأسئلة')
                        ->helperText('لكل سؤال سطرا CTA يظهران أسفل الإجابة — نص ورابط لكل زر.')
                        ->schema(self::faqSchema())
                        ->columns(2)
                        ->defaultItems(0)
                        ->addActionLabel('إضافة سؤال')
                        ->reorderableWithButtons()
                        ->collapsible(),
                    TextInput::make($audience.'_faq_cta1_text')->label('نص زر CTA 1')->columnSpan(1),
                    TextInput::make($audience.'_faq_cta1_url')->label('رابط زر CTA 1')->rules([new CtaUrl])->columnSpan(1),
                    TextInput::make($audience.'_faq_cta2_text')->label('نص زر CTA 2')->columnSpan(1),
                    TextInput::make($audience.'_faq_cta2_url')->label('رابط زر CTA 2')->rules([new CtaUrl])->columnSpan(1),
                ])
                ->columns(3),

            Section::make('نموذج التواصل والCTA الأخير')
                ->description('نموذج التواصل بيظهر في الصفحة الرئيسية بس، والـ CTA الأخير بيقفل الصفحة.')
                ->schema([
                    TextInput::make($audience.'_form_title')->label('عنوان نموذج التواصل')->columnSpan(1),
                    Textarea::make($audience.'_form_subtitle')->label('وصف نموذج التواصل')->rows(2)->columnSpan(2),
                    TextInput::make($audience.'_final_title')->label('عنوان الـ CTA الأخير')->columnSpan(2),
                    Textarea::make($audience.'_final_subtitle')->label('وصف الـ CTA الأخير')->rows(2)->columnSpan(2),
                    TextInput::make($audience.'_final_cta_text')->label('نص زر الـ CTA الأخير')->columnSpan(2),
                ])
                ->columns(3),
        ];
    }

    /**
     * Tabs 3 and 4: copy for every course detail page of that audience, plus
     * the override tier of the content chain.
     *
     * @return array<int, Section>
     */
    private static function sharedSections(string $audience): array
    {
        $is = fn (string $key): string => 'details_'.$audience.'_'.$key;

        return [
            Section::make('هيرو صفحة التفاصيل')
                ->description('يظهر في أعلى كل صفحة تفاصيل دورة من هذه الفئة.')
                ->schema([
                    TextInput::make($is('hero_label'))
                        ->label('الشارة أعلى العنوان')
                        ->helperText('مثال: Programme dédié aux enfants et aux jeunes')
                        ->columnSpan(3),
                    TextInput::make($is('back_label'))
                        ->label('اسم الفئة في مسار التنقل (Breadcrumb)')
                        ->helperText('مثال: Cours des enfants')
                        ->columnSpan(3),
                    TextInput::make($is('trial_btn_text'))->label('نص زر الحجز')->columnSpan(2),
                    TextInput::make($is('trial_url'))
                        ->label('رابط زر الحجز')
                        ->helperText('مثال: /#trial-form')
                        ->columnSpan(2),
                    TextInput::make($is('whatsapp_btn_text'))->label('نص زر واتساب')->columnSpan(2),
                ])
                ->columns(6),

            Section::make('عناوين أقسام صفحة التفاصيل')
                ->description('العناوين اللي كانت ثابتة في الكود — دلوقتي بتتحكم فيها بالكامل. لو سيبتها فاضية القسم هيتعرض من غير عنوان.')
                ->schema([
                    TextInput::make($is('suitability_label'))->label('«مناسب لـ» — التسمية')->columnSpan(2),
                    TextInput::make($is('suitability_title'))->label('«مناسب لـ» — العنوان')->columnSpan(2),
                    TextInput::make($is('curriculum_label'))->label('«البرنامج» — التسمية')->columnSpan(2),
                    TextInput::make($is('curriculum_title'))->label('«البرنامج» — العنوان')->columnSpan(2),
                    TextInput::make($is('session_label'))->label('«كيف تكون الحصة» — التسمية')->columnSpan(2),
                    TextInput::make($is('session_title'))->label('«كيف تكون الحصة» — العنوان')->columnSpan(2),
                    Textarea::make($is('session_subtitle'))->label('«كيف تكون الحصة» — الوصف')->rows(2)->columnSpan(2),
                    TextInput::make($is('testimonials_label'))->label('«الشهادات» — التسمية')->columnSpan(2),
                    TextInput::make($is('testimonials_title'))->label('«الشهادات» — العنوان')->columnSpan(2),
                    TextInput::make($is('journey_label'))->label('«المسار» — التسمية')->columnSpan(2),
                    TextInput::make($is('journey_title'))->label('«المسار» — العنوان')->columnSpan(2),
                    TextInput::make($is('why_label'))->label('«لماذا مدرسة الرحمن» — التسمية')->columnSpan(2),
                    TextInput::make($is('why_title'))->label('«لماذا مدرسة الرحمن» — العنوان')->columnSpan(2),
                    TextInput::make($is('faq_label'))->label('«الأسئلة الشائعة» — التسمية')->columnSpan(2),
                    TextInput::make($is('faq_title'))->label('«الأسئلة الشائعة» — العنوان')->columnSpan(2),
                ])
                ->columns(4),

            Section::make('الحجز والبطاقة الجانبية')
                ->schema([
                    TextInput::make($is('booking_title'))->label('عنوان قسم الحجز')->columnSpan(2),
                    Textarea::make($is('booking_subtitle'))->label('وصف قسم الحجز')->rows(2)->columnSpan(2),
                    TextInput::make($is('booking_note'))->label('ملاحظة الحجز')->columnSpan(2),
                    TextInput::make($is('sidebar_title'))->label('عنوان البطاقة الجانبية')->columnSpan(2),
                    TextInput::make($is('related_title'))->label('عنوان «دورات مشابهة»')->columnSpan(2),
                    TextInput::make($is('related_cta_text'))->label('نص زر بطاقة «دورات مشابهة»')->columnSpan(2),
                ])
                ->columns(3),

            Section::make('قسم «لماذا مدرسة الرحمن»')
                ->description('قسم كروت موجود في صفحة التفاصيل بعد «المسار». سيب الكروت فاضية في الاتنين والقسم مش هيظهر خالص.')
                ->schema([
                    Repeater::make($audience.'_why_items')
                        ->label('كروت «لماذا مدرسة الرحمن» — المحتوى الأساسي')
                        ->schema(self::topicSchema())
                        ->columns(2)
                        ->defaultItems(0)
                        ->addActionLabel('إضافة ميزة')
                        ->reorderableWithButtons()
                        ->collapsible(),
                    Repeater::make($audience.'_shared_why_items')
                        ->label('override: كروت «لماذا مدرسة الرحمن»')
                        ->helperText('اتركها فاضية لتستخدم الكروت الأساسية. املأها بس لو عايز الكروت تختلف حسب الفئة.')
                        ->schema(self::topicSchema())
                        ->columns(2)
                        ->defaultItems(0)
                        ->addActionLabel('إضافة ميزة')
                        ->reorderableWithButtons()
                        ->collapsible(),
                ])
                ->columns(1),

            Section::make('محتوى مشترك — تجاوز المحتوى')
                ->description('اترك أي قسم فاضي هنا ليرجع تلقائياً لمحتوى الصفحة الرئيسية. املأه بس لو عايز صفحة التفاصيل تختلف عن الصفحة الرئيسية.')
                ->schema([
                    Repeater::make($audience.'_shared_curriculum_items')
                        ->label('override: «البرنامج»')
                        ->schema(self::topicSchema())
                        ->columns(2)
                        ->defaultItems(0)
                        ->addActionLabel('إضافة موضوع')
                        ->reorderableWithButtons()
                        ->collapsible(),
                    Repeater::make($audience.'_shared_about_items')
                        ->label('override: «مناسب لـ»')
                        ->helperText('العناصر بتتحول لنقاط نصية في صفحة التفاصيل.')
                        ->schema(self::topicSchema())
                        ->columns(2)
                        ->defaultItems(0)
                        ->addActionLabel('إضافة عنصر')
                        ->reorderableWithButtons()
                        ->collapsible(),
                    Repeater::make($audience.'_shared_session_items')
                        ->label('override: «كيف تكون الحصة»')
                        ->helperText('مهم: لو القسم فاضي في كل المستويات، مش هيظهر في صفحة التفاصيل خالص.')
                        ->schema(self::titleDescriptionSchema())
                        ->columns(2)
                        ->defaultItems(0)
                        ->addActionLabel('إضافة ميزة')
                        ->reorderableWithButtons()
                        ->collapsible(),
                    Repeater::make($audience.'_shared_journey_items')
                        ->label('override: «المسار»')
                        ->schema(self::titleDescriptionSchema())
                        ->columns(2)
                        ->defaultItems(0)
                        ->addActionLabel('إضافة خطوة')
                        ->reorderableWithButtons()
                        ->collapsible(),
                    Repeater::make($audience.'_shared_faq_items')
                        ->label('override: «الأسئلة الشائعة»')
                        ->schema(self::faqSchema())
                        ->columns(2)
                        ->defaultItems(0)
                        ->addActionLabel('إضافة سؤال')
                        ->reorderableWithButtons()
                        ->collapsible(),
                ])
                ->columns(1),
        ];
    }

    /** @return array<int, Section> */
    private static function seoSections(): array
    {
        return [
            Section::make('إعدادات SEO صفحة الأطفال')
                ->description('العنوان والوصف الخاصين بصفحة /enfants فقط.')
                ->schema([
                    TextInput::make('kids_meta_title')
                        ->label('عنوان الميتا (Meta Title)')
                        ->helperText('يُوصى بألا يتجاوز 60 حرفاً')
                        ->maxLength(60)
                        ->live()
                        ->hint(fn (?string $state): string => mb_strlen((string) $state).'/60')
                        ->columnSpan(1),
                    Textarea::make('kids_meta_description')
                        ->label('وصف الميتا (Meta Description)')
                        ->helperText('يُوصى بألا يتجاوز 160 حرفاً')
                        ->maxLength(160)
                        ->rows(3)
                        ->live()
                        ->hint(fn (?string $state): string => mb_strlen((string) $state).'/160')
                        ->columnSpan(1),
                    FileUpload::make('kids_og_image')
                        ->label('صورة المشاركة (Open Graph)')
                        ->image()
                        ->disk('public')
                        ->directory('images/og')
                        ->imageResizeMode('contain')
                        ->imageResizeTargetWidth('1200')
                        ->imageResizeTargetHeight('630')
                        ->columnSpan(2),
                ])
                ->columns(2),
            Section::make('إعدادات SEO صفحة الكبار')
                ->description('العنوان والوصف الخاصين بصفحة /adultes فقط.')
                ->schema([
                    TextInput::make('adults_meta_title')
                        ->label('عنوان الميتا (Meta Title)')
                        ->helperText('يُوصى بألا يتجاوز 60 حرفاً')
                        ->maxLength(60)
                        ->live()
                        ->hint(fn (?string $state): string => mb_strlen((string) $state).'/60')
                        ->columnSpan(1),
                    Textarea::make('adults_meta_description')
                        ->label('وصف الميتا (Meta Description)')
                        ->helperText('يُوصى بألا يتجاوز 160 حرفاً')
                        ->maxLength(160)
                        ->rows(3)
                        ->live()
                        ->hint(fn (?string $state): string => mb_strlen((string) $state).'/160')
                        ->columnSpan(1),
                    FileUpload::make('adults_og_image')
                        ->label('صورة المشاركة (Open Graph)')
                        ->image()
                        ->disk('public')
                        ->directory('images/og')
                        ->imageResizeMode('contain')
                        ->imageResizeTargetWidth('1200')
                        ->imageResizeTargetHeight('630')
                        ->columnSpan(2),
                ])
                ->columns(2),
            Section::make('إعدادات SEO العامة (احتياطي)')
                ->description('تُستخدم هذه القيم كاحتياطي إذا تُركت حقول الصفحة المخصصة فارغة.')
                ->schema([
                    TextInput::make('meta_title')
                        ->label('عنوان الميتا (Meta Title)')
                        ->helperText('يُوصى بألا يتجاوز 60 حرفاً')
                        ->maxLength(60)
                        ->live()
                        ->hint(fn (?string $state): string => mb_strlen((string) $state).'/60')
                        ->columnSpan(1),
                    Textarea::make('meta_description')
                        ->label('وصف الميتا (Meta Description)')
                        ->helperText('يُوصى بألا يتجاوز 160 حرفاً')
                        ->maxLength(160)
                        ->rows(3)
                        ->live()
                        ->hint(fn (?string $state): string => mb_strlen((string) $state).'/160')
                        ->columnSpan(1),
                    FileUpload::make('og_image')
                        ->label('صورة المشاركة (Open Graph)')
                        ->image()
                        ->disk('public')
                        ->directory('images/og')
                        ->imageResizeMode('contain')
                        ->imageResizeTargetWidth('1200')
                        ->imageResizeTargetHeight('630')
                        ->columnSpan(1),
                    Toggle::make('is_indexed')
                        ->label('السماح لفهارس البحث (Allow search engine indexing)')
                        ->default(true),
                ])
                ->columns(2),
        ];
    }

    /**
     * Repeater item for icon + title + description blocks.
     *
     * @return array<int, Component>
     */
    private static function topicSchema(): array
    {
        return [
            TextInput::make('icon')
                ->label('الأيقونة (إيموجي)')
                ->helperText('إيموجي واحد فقط، مثال 📖 — لو سايبها فاضية هتظهر أيقونة افتراضية.')
                ->default('📚')
                ->maxLength(8)
                ->columnSpan(1),
            TextInput::make('title')->label('العنوان')->columnSpan(1),
            Textarea::make('description')->label('الوصف')->rows(2)->columnSpanFull(),
        ];
    }

    /**
     * Repeater item for title + description blocks.
     *
     * @return array<int, Component>
     */
    private static function titleDescriptionSchema(): array
    {
        return [
            TextInput::make('title')->label('العنوان')->columnSpan(1),
            Textarea::make('description')->label('الوصف')->rows(2)->columnSpan(1),
        ];
    }

    /**
     * Repeater item for a question with two optional CTA rows under the answer.
     *
     * @return array<int, Component>
     */
    private static function faqSchema(): array
    {
        return [
            TextInput::make('question')->label('السؤال')->columnSpanFull(),
            RichEditor::make('answer')->label('الإجابة')->columnSpanFull(),
            TextInput::make('cta1_text')->label('نص الزر الأول')->placeholder('مثال: احجز جلسة تجريبية')->columnSpan(1),
            TextInput::make('cta1_url')->label('رابط الزر الأول')->rules([new CtaUrl])->placeholder('# أو https://...')->columnSpan(1),
            TextInput::make('cta2_text')->label('نص الزر الثاني')->placeholder('مثال: تواصل عبر واتساب')->columnSpan(1),
            TextInput::make('cta2_url')->label('رابط الزر الثاني')->rules([new CtaUrl])->placeholder('# أو https://...')->columnSpan(1),
        ];
    }
}
