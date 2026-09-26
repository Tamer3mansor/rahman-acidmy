<?php

namespace App\Filament\Resources\CoursePageSettings\Schemas;

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

class CoursePageSettingsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make()
                    ->columnSpanFull()
                    ->tabs([
                        Tab::make('صفحة الأطفال')
                            ->schema([
                                Section::make('نصوص رأس الصفحة')
                                    ->schema([
                                        TextInput::make('kids_label')->label('التسمية')->required()->columnSpan(3),
                                        TextInput::make('kids_badge')->label('الشارة')->required()->columnSpan(3),
                                        TextInput::make('kids_title')->label('العنوان')->required()->columnSpan(3),
                                        TextInput::make('kids_title_accent')->label('الجزء المميز من العنوان')->columnSpan(3),
                                        Textarea::make('kids_subtitle')->label('الوصف')->required()->columnSpanFull()->rows(2),
                                    ])
                                    ->columns(6),
                                Section::make('الأزرار')
                                    ->schema([
                                        TextInput::make('kids_cta_title')->label('نص زر الحث')->required()->columnSpan(2),
                                        TextInput::make('kids_wa_title')->label('نص زر واتساب')->required()->columnSpan(2),
                                        TextInput::make('kids_wa_url')->label('رابط واتساب')->columnSpan(2),
                                    ])
                                    ->columns(2),

                                Section::make('بطاقة العرض الرئيسية')
                                    ->schema([
                                        FileUpload::make('kids_showcase_image')
                                            ->label('صورة البطاقة')
                                            ->image()
                                            ->disk('public')
                                            ->directory('images/course-hero')
                                            ->columnSpan(2),
                                        TextInput::make('kids_showcase_emoji')
                                            ->label('إيموجي احتياطي (اختياري)')
                                            ->helperText('يُعرض فقط عندما لا تكون هناك صورة مرفوعة.')
                                            ->default('📖 ✨')
                                            ->columnSpan(2),
                                        TextInput::make('kids_showcase_title')->label('عنوان البطاقة')->columnSpan(2),
                                        Textarea::make('kids_showcase_subtitle')->label('وصف البطاقة')->rows(2)->columnSpanFull(),
                                    ])
                                    ->columns(4),
                            ]),
                        Tab::make('صفحة الكبار')
                            ->schema([
                                Section::make('نصوص رأس الصفحة')
                                    ->schema([
                                        TextInput::make('adults_label')->label('التسمية')->required()->columnSpan(3),
                                        TextInput::make('adults_badge')->label('الشارة')->required()->columnSpan(3),
                                        TextInput::make('adults_title')->label('العنوان')->required()->columnSpan(3),
                                        TextInput::make('adults_title_accent')->label('الجزء المميز من العنوان')->columnSpan(3),
                                        Textarea::make('adults_subtitle')->label('الوصف')->required()->columnSpanFull()->rows(2),
                                    ])
                                    ->columns(6),
                                Section::make('الأزرار')
                                    ->schema([
                                        TextInput::make('adults_cta_title')->label('نص زر الحث')->required()->columnSpan(2),
                                        TextInput::make('adults_wa_title')->label('نص زر واتساب')->required()->columnSpan(2),
                                        TextInput::make('adults_wa_url')->label('رابط واتساب')->columnSpan(2),
                                    ])
                                    ->columns(2),

                                Section::make('بطاقة العرض الرئيسية')
                                    ->schema([
                                        FileUpload::make('adults_showcase_image')
                                            ->label('صورة البطاقة')
                                            ->image()
                                            ->disk('public')
                                            ->directory('images/course-hero')
                                            ->columnSpan(2),
                                        TextInput::make('adults_showcase_emoji')
                                            ->label('إيموجي احتياطي (اختياري)')
                                            ->helperText('يُعرض فقط عندما لا تكون هناك صورة مرفوعة.')
                                            ->default('📖')
                                            ->columnSpan(2),
                                        TextInput::make('adults_showcase_title')->label('عنوان البطاقة')->columnSpan(2),
                                        Textarea::make('adults_showcase_subtitle')->label('وصف البطاقة')->rows(2)->columnSpanFull(),
                                    ])
                                    ->columns(4),
                            ]),
                        Tab::make('محتوى الأقسام (أطفال)')
                            ->schema(self::audienceContentSections('kids')),
                        Tab::make('محتوى الأقسام (كبار)')
                            ->schema(self::audienceContentSections('adults')),
                        Tab::make('صفحة تفاصيل الدورة')
                            ->schema([
                                Section::make('نصوص الحجز والاستمارة')
                                    ->schema([
                                        TextInput::make('details_cta_title')->label('نص زر الحث')->required()->columnSpan(2),
                                        TextInput::make('details_booking_title')->label('عنوان الحجز')->required()->columnSpan(2),
                                        TextInput::make('details_form_title')->label('عنوان الاستمارة')->required()->columnSpan(2),
                                        Textarea::make('details_booking_subtitle')->label('وصف الحجز')->required()->columnSpanFull()->rows(2),
                                        TextInput::make('details_booking_note')->label('ملاحظة الحجز')->columnSpan(2),
                                    ])
                                    ->columns(3),
                            ]),
                        Tab::make('تحسين محركات البحث (SEO)')
                            ->schema([
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
                            ]),
                    ]),

                Section::make('الحالة')
                    ->schema([
                        Toggle::make('is_active')
                            ->label('نشط')
                            ->default(true),
                    ])
                    ->columns(1),
            ]);
    }

    /**
     * Content sections shared between the kids and adults tabs.
     *
     * @return array<int, Section>
     */
    private static function audienceContentSections(string $audience): array
    {
        return [
            Section::make($audience === 'kids' ? 'قسم منهج التعلم (Que va apprendre mon enfant ?)' : 'قسم ماذا ستتعلم (Que vas-tu apprendre ?)')
                ->description('عنوان القسم وقائمة المواضيع التي سيتعلمها الطالب.')
                ->schema([
                    TextInput::make($audience.'_curriculum_label')->label('التسمية')->columnSpan(2),
                    TextInput::make($audience.'_curriculum_title')->label('العنوان')->columnSpan(2),
                    Textarea::make($audience.'_curriculum_subtitle')->label('الوصف')->rows(2)->columnSpan(2),
                    Repeater::make($audience.'_curriculum_items')
                        ->label('المواضيع')
                        ->schema([
                            TextInput::make('icon')
                                ->label('الأيقونة (إيموجي)')
                                ->helperText('إيموجي واحد فقط، مثال 📖 — لو سايبها فاضية هتظهر أيقونة افتراضية.')
                                ->default('📚')
                                ->maxLength(8)
                                ->columnSpan(1),
                            TextInput::make('title')->label('العنوان')->required()->columnSpan(1),
                            Textarea::make('description')->label('الوصف')->rows(2)->columnSpanFull(),
                        ])
                        ->columns(2)
                        ->defaultItems(0)
                        ->addActionLabel('إضافة موضوع')
                        ->reorderableWithButtons()
                        ->collapsible(),
                ])
                ->columns(3),
            Section::make('قسم حول الدورة (À propos des cours)')
                ->description('نصوص وعناصر القسم الذي يُعرَض أسفل قائمة الدورات.')
                ->schema([
                    TextInput::make($audience.'_about_label')->label('التسمية')->columnSpan(2),
                    TextInput::make($audience.'_about_title')->label('العنوان')->columnSpan(2),
                    Textarea::make($audience.'_about_subtitle')->label('الوصف')->rows(2)->columnSpan(2),
                    Repeater::make($audience.'_about_items')
                        ->label('العناصر')
                        ->schema([
                            TextInput::make('icon')
                                ->label('الأيقونة (إيموجي)')
                                ->helperText('إيموجي واحد فقط، مثال 📖 — لو سايبها فاضية هتظهر أيقونة افتراضية.')
                                ->default('📚')
                                ->maxLength(8)
                                ->columnSpan(1),
                            TextInput::make('title')->label('العنوان')->required()->columnSpan(1),
                            Textarea::make('description')->label('الوصف')->rows(2)->columnSpanFull(),
                        ])
                        ->columns(2)
                        ->defaultItems(0)
                        ->addActionLabel('إضافة عنصر')
                        ->reorderableWithButtons()
                        ->collapsible(),
                ])
                ->columns(3),

            Section::make('قسم المسار (Comment se déroule votre parcours)')
                ->schema([
                    TextInput::make($audience.'_journey_label')->label('التسمية')->columnSpan(2),
                    TextInput::make($audience.'_journey_title')->label('العنوان')->columnSpan(2),
                    Textarea::make($audience.'_journey_subtitle')->label('الوصف')->rows(2)->columnSpan(2),
                    Repeater::make($audience.'_journey_items')
                        ->label('الخطوات')
                        ->schema([
                            TextInput::make('title')->label('العنوان')->required()->columnSpan(1),
                            Textarea::make('description')->label('الوصف')->rows(2)->columnSpan(1),
                        ])
                        ->columns(2)
                        ->defaultItems(0)
                        ->addActionLabel('إضافة خطوة')
                        ->reorderableWithButtons()
                        ->collapsible(),
                ])
                ->columns(3),

            Section::make('قسم الأسئلة الشائعة والنموذج')
                ->schema([
                    TextInput::make($audience.'_faq_label')->label('تسمية الأسئلة')->columnSpan(3),
                    TextInput::make($audience.'_faq_title')->label('عنوان الأسئلة')->columnSpan(3),
                    Textarea::make($audience.'_faq_subtitle')->label('وصف الأسئلة')->rows(2)->columnSpan(2),
                    Repeater::make($audience.'_faq_items')
                        ->label('الأسئلة')
                        ->helperText('لكل سؤال سطرا CTA يظهران أسفل الإجابة — نص ورابط لكل زر.')
                        ->schema([
                            TextInput::make('question')->label('السؤال')->required()->columnSpanFull(),
                            RichEditor::make('answer')->label('الإجابة')->columnSpanFull(),
                            TextInput::make('cta1_text')->label('نص الزر الأول')->placeholder('مثال: احجز جلسة تجريبية')->columnSpan(1),
                            TextInput::make('cta1_url')->label('رابط الزر الأول')->url()->placeholder('# أو https://...')->columnSpan(1),
                            TextInput::make('cta2_text')->label('نص الزر الثاني')->placeholder('مثال: تواصل عبر واتساب')->columnSpan(1),
                            TextInput::make('cta2_url')->label('رابط الزر الثاني')->url()->placeholder('# أو https://...')->columnSpan(1),
                        ])
                        ->columns(2)
                        ->defaultItems(0)
                        ->addActionLabel('إضافة سؤال')
                        ->reorderableWithButtons()
                        ->collapsible(),

                    TextInput::make($audience.'_faq_cta1_text')->label('نص زر CTA 1')->columnSpan(1),
                    TextInput::make($audience.'_faq_cta1_url')->label('رابط زر CTA 1')->url()->columnSpan(1),
                    TextInput::make($audience.'_faq_cta2_text')->label('نص زر CTA 2')->columnSpan(1),
                    TextInput::make($audience.'_faq_cta2_url')->label('رابط زر CTA 2')->url()->columnSpan(1),

                    TextInput::make($audience.'_form_title')->label('عنوان نموذج التواصل')->columnSpan(1),
                    Textarea::make($audience.'_form_subtitle')->label('وصف نموذج التواصل')->rows(2)->columnSpan(1),
                ])
                ->columns(3),

            Section::make('قسم التوصيات (الشهادات)')
                ->description('تظهر الشهادات هنا من صفحة «اراء العملاء» في لوحة التحكم، حسب خانة «ظهور إضافي على صفحات الدورات».')
                ->schema([
                    TextInput::make($audience.'_testimonials_title')->label('عنوان القسم')->columnSpan(3),
                    Textarea::make($audience.'_testimonials_subtitle')->label('وصف القسم')->rows(2)->columnSpan(3),
                ])
                ->columns(3),
        ];
    }
}
