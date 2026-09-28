<?php

namespace App\Filament\Resources\LandingSettings\Schemas;

use App\Enums\MediaType;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class LandingSettingsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make()
                    ->columnSpanFull()
                    ->tabs([

                        Tab::make('الترويسة')
                            ->schema([
                                Section::make('الشعار والاسم')
                                    ->schema([
                                        FileUpload::make('header_logo_path')
                                            ->label('شعار الهيدر')
                                            ->image()
                                            ->disk('public')
                                            ->directory('landing/header')
                                            ->helperText('يظهر في شريط التنقل أعلى الصفحة. اتركه فارغاً لاستخدام الأيقونة الافتراضية')
                                            ->columnSpanFull(),
                                        TextInput::make('header_brand_name')
                                            ->label('اسم العلامة التجارية')
                                            ->maxLength(255),
                                        TextInput::make('header_brand_sub')
                                            ->label('الشعار الفرعي')
                                            ->helperText('مثال: ACADEMY')
                                            ->maxLength(255),
                                    ])
                                    ->columns(2),

                                Section::make('الأزرار')
                                    ->schema([
                                        TextInput::make('header_btn1_title')
                                            ->label('نص الزر الأول')
                                            ->maxLength(255),
                                        TextInput::make('header_btn1_url')
                                            ->label('رابط الزر الأول')
                                            ->maxLength(255),
                                        TextInput::make('header_btn2_title')
                                            ->label('نص الزر الثاني')
                                            ->maxLength(255),
                                        TextInput::make('header_btn2_url')
                                            ->label('رابط الزر الثاني')
                                            ->maxLength(255),
                                    ])
                                    ->columns(2),
                            ]),

                        Tab::make('الهيرو')
                            ->schema([
                                Section::make('نص الهيرو')
                                    ->schema([
                                        TextInput::make('hero_badge')
                                            ->label('الشارة')
                                            ->maxLength(255),
                                        TextInput::make('hero_title')
                                            ->label('العنوان الرئيسي')
                                            ->columnSpan(2)
                                            ->maxLength(255),
                                        TextInput::make('hero_title_accent')
                                            ->label('العنوان المميز (بالذهب)')
                                            ->maxLength(255),
                                        RichEditor::make('hero_subtitle')
                                            ->label('العنوان الفرعي')
                                            ->extraAttributes(['style' => 'direction: rtl; text-align: right;'])
                                            ->columnSpan(2),
                                    ])
                                    ->columns(2),

                                Section::make('الأزرار')
                                    ->schema([
                                        TextInput::make('hero_btn1_title')
                                            ->label('نص الزر الأساسي')
                                            ->maxLength(255),
                                        TextInput::make('hero_btn1_url')
                                            ->label('رابط الزر الأساسي')
                                            ->maxLength(255),
                                        TextInput::make('hero_btn2_title')
                                            ->label('نص الزر الثانوي')
                                            ->maxLength(255),
                                        TextInput::make('hero_btn2_url')
                                            ->label('رابط الزر الثانوي')
                                            ->url()
                                            ->maxLength(255),
                                    ])
                                    ->columns(2),

                                Section::make('وسائط الهيرو')
                                    ->schema([
                                        Select::make('hero_media_type')
                                            ->label('نوع الوسائط')
                                            ->options(MediaType::class)
                                            ->enum(MediaType::class)
                                            ->default(MediaType::Video->value)
                                            ->live(),
                                        FileUpload::make('hero_video_path')
                                            ->label('ملف الوسائط (فيديو أو صورة)')
                                            ->acceptedFileTypes(['video/mp4', 'video/quicktime', 'video/webm', 'image/jpeg', 'image/png', 'image/webp', 'image/gif'])
                                            ->directory('hero-media')
                                            ->disk('public')
                                            ->helperText('ارفع صورة أو فيديو — منطبقاً على نوع الوسائط. فيديو (mp4/mov/webm) أو صورة (jpg/png/webp).')
                                            ->columnSpan(2),
                                        Toggle::make('hero_video_autoplay')
                                            ->label('تشغيل تلقائي')
                                            ->hidden(fn (Get $get): bool => $get('hero_media_type') !== MediaType::Video),
                                        Toggle::make('hero_video_loop')
                                            ->label('تكرار الفيديو')
                                            ->hidden(fn (Get $get): bool => $get('hero_media_type') !== MediaType::Video),
                                    ])
                                    ->columns(2),
                            ]),

                        Tab::make('شهادات العملاء')
                            ->schema([
                                TextInput::make('trust_label')
                                    ->label('التسمية')
                                    ->maxLength(255),
                                TextInput::make('trust_title')
                                    ->label('العنوان')
                                    ->columnSpan(2)
                                    ->maxLength(255),
                                RichEditor::make('trust_subtitle')
                                    ->label('العنوان الفرعي')
                                    ->extraAttributes(['style' => 'direction: rtl; text-align: right;'])
                                    ->columnSpan(2),
                                TextInput::make('trust_cta_title')
                                    ->label('نص زر الدعوة')
                                    ->columnSpan(2)
                                    ->maxLength(255),
                            ]),

                        Tab::make('الخطوات')
                            ->schema([
                                TextInput::make('journey_label')
                                    ->label('التسمية')
                                    ->maxLength(255),
                                TextInput::make('journey_title')
                                    ->label('العنوان')
                                    ->columnSpan(2)
                                    ->maxLength(255),
                                RichEditor::make('journey_subtitle')
                                    ->label('العنوان الفرعي')
                                    ->extraAttributes(['style' => 'direction: rtl; text-align: right;'])
                                    ->columnSpan(2),
                                TextInput::make('journey_cta_title')
                                    ->label('نص زر الدعوة')
                                    ->columnSpan(2)
                                    ->maxLength(255),
                            ]),

                        Tab::make('المقارنة')
                            ->schema([
                                TextInput::make('compare_label')
                                    ->label('التسمية')
                                    ->maxLength(255),
                                TextInput::make('compare_title')
                                    ->label('العنوان')
                                    ->columnSpan(2)
                                    ->maxLength(255),
                                RichEditor::make('compare_subtitle')
                                    ->label('العنوان الفرعي')
                                    ->extraAttributes(['style' => 'direction: rtl; text-align: right;'])
                                    ->columnSpan(2),
                                TextInput::make('compare_problems_title')
                                    ->label('عنوان عمود المشكلات')
                                    ->maxLength(255),
                                TextInput::make('compare_solutions_title')
                                    ->label('عنوان عمود الحلول')
                                    ->maxLength(255),
                                TextInput::make('compare_cta_title')
                                    ->label('نص زر الدعوة')
                                    ->columnSpan(2)
                                    ->maxLength(255),
                            ])
                            ->columns(2),

                        Tab::make('المعلمون')
                            ->schema([
                                TextInput::make('teachers_label')
                                    ->label('التسمية')
                                    ->maxLength(255),
                                TextInput::make('teachers_title')
                                    ->label('العنوان')
                                    ->columnSpan(2)
                                    ->maxLength(255),
                                RichEditor::make('teachers_subtitle')
                                    ->label('العنوان الفرعي')
                                    ->extraAttributes(['style' => 'direction: rtl; text-align: right;'])
                                    ->columnSpan(2),
                                TextInput::make('teachers_cta_title')
                                    ->label('نص زر الدعوة')
                                    ->columnSpan(2)
                                    ->maxLength(255),
                            ]),

                        Tab::make('الأسئلة الشائعة')
                            ->schema([
                                TextInput::make('faq_label')
                                    ->label('التسمية')
                                    ->maxLength(255),
                                TextInput::make('faq_title')
                                    ->label('العنوان')
                                    ->columnSpan(2)
                                    ->maxLength(255),
                                RichEditor::make('faq_subtitle')
                                    ->label('العنوان الفرعي')
                                    ->extraAttributes(['style' => 'direction: rtl; text-align: right;'])
                                    ->columnSpan(2),
                            ]),

                        Tab::make('نموذج التواصل')
                            ->schema([
                                TextInput::make('form_label')
                                    ->label('التسمية')
                                    ->maxLength(255),
                                TextInput::make('form_title')
                                    ->label('العنوان')
                                    ->maxLength(255),
                                TextInput::make('form_title_accent')
                                    ->label('العنوان المميز (بالذهب)')
                                    ->maxLength(255),
                                RichEditor::make('form_subtitle')
                                    ->label('النص الجانبي')
                                    ->extraAttributes(['style' => 'direction: rtl; text-align: right;'])
                                    ->columnSpan(2),
                                TextInput::make('form_card_title')
                                    ->label('عنوان البطاقة')
                                    ->maxLength(255),
                                RichEditor::make('form_card_subtitle')
                                    ->label('العنوان الفرعي للبطاقة')
                                    ->extraAttributes(['style' => 'direction: rtl; text-align: right;'])
                                    ->columnSpan(2),
                                RichEditor::make('form_note')
                                    ->label('ملاحظة إضافية')
                                    ->extraAttributes(['style' => 'direction: rtl; text-align: right;'])
                                    ->columnSpan(2),
                                TextInput::make('form_privacy_note')
                                    ->label('ملاحظة الخصوصية')
                                    ->columnSpan(2)
                                    ->maxLength(255),
                            ])
                            ->columns(2),

                        Tab::make('الفوتر')
                            ->schema([
                                TextInput::make('footer_brand_name')
                                    ->label('اسم العلامة التجارية')
                                    ->maxLength(255),
                                TextInput::make('footer_brand_sub')
                                    ->label('الشعار الفرعي')
                                    ->maxLength(255),
                                RichEditor::make('footer_description')
                                    ->label('الوصف')
                                    ->extraAttributes(['style' => 'direction: rtl; text-align: right;'])
                                    ->columnSpan(2),
                                TextInput::make('footer_copyright')
                                    ->label('نص الحقوق')
                                    ->columnSpan(2)
                                    ->maxLength(255),
                            ]),

                        Tab::make('النصوص المشتركة (ناف/فوتر/فورم)')
                            ->schema([
                                Section::make('القائمة العلوية')
                                    ->description('نصوص مشتركة في كل صفحات الموقع. أي حقل فاضي يستخدم النص الافتراضي.')
                                    ->schema(self::textInputs([
                                        'nav_courses_label' => 'رابط «دوراتنا»',
                                        'nav_kids_label' => 'رابط «دورات الأطفال»',
                                        'nav_adults_label' => 'رابط «دورات الكبار»',
                                        'nav_teachers_label' => 'رابط «المعلمون»',
                                        'nav_testimonials_label' => 'رابط «آراء العملاء»',
                                        'nav_pricing_label' => 'رابط «الأسعار»',
                                        'nav_resources_label' => 'رابط «الموارد»',
                                        'nav_blog_label' => 'رابط «المدونة»',
                                        'nav_lessons_label' => 'رابط «دروس مجانية»',
                                        'nav_faq_label' => 'رابط «الأسئلة الشائعة»',
                                        'nav_menu_label' => 'اسم زر القائمة (موبايل)',
                                        'nav_theme_label' => 'اسم زر المظهر (موبايل)',
                                        'nav_theme_toggle_label' => 'aria-label زر المظهر',
                                    ]))
                                    ->columns(3),

                                Section::make('الفوتر والتذييل')
                                    ->schema(self::textInputs([
                                        'footer_quicklinks_title' => 'عنوان عمود «روابط سريعة»',
                                        'footer_contact_title' => 'عنوان عمود «تواصل معنا»',
                                        'footer_link_home' => 'رابط «الرئيسية»',
                                        'footer_link_courses' => 'رابط «دوراتنا»',
                                        'footer_link_journey' => 'رابط «مسارنا»',
                                        'footer_link_teachers' => 'رابط «معلمونا»',
                                        'footer_link_faq' => 'رابط «الأسئلة الشائعة»',
                                        'footer_link_whatsapp' => 'رابط «واتساب»',
                                        'footer_link_trial' => 'رابط «احجز تجربة»',
                                        'footer_link_email' => 'رابط «البريد»',
                                        'footer_made_with' => 'نص «صُنع بحب»',
                                        'floating_whatsapp_title' => 'tooltip زر واتساب العائم',
                                        'floating_scroll_top_label' => 'aria-label زر «العودة للأعلى»',
                                    ]))
                                    ->columns(3),

                                Section::make('نصوص بطاقة التواصل')
                                    ->description('العناوين و placeholder حقول نموذجtrial. التنسيقات-supported: {name} و {phone} و {email} داخل الـ placeholder لو أردت مثالاً.')
                                    ->schema(self::textInputs([
                                        'field_student_name_label' => 'حقل «اسم الطالب» — التسمية',
                                        'field_student_name_placeholder' => 'حقل «اسم الطالب» — مثال',
                                        'field_parent_name_label' => 'حقل «اسم ولي الأمر» — التسمية',
                                        'field_parent_name_placeholder' => 'حقل «اسم ولي الأمر» — مثال',
                                        'field_student_age_label' => 'حقل «سن الطالب» — التسمية',
                                        'field_student_age_placeholder' => 'حقل «سن الطالب» — مثال',
                                        'field_phone_label' => 'حقل «رقم واتساب» — التسمية',
                                        'field_phone_placeholder' => 'حقل «رقم واتساب» — مثال',
                                        'field_email_label' => 'حقل «البريد الإلكتروني» — التسمية',
                                        'field_email_placeholder' => 'حقل «البريد الإلكتروني» — مثال',
                                        'field_level_label' => 'حقل «المستوى» — التسمية',
                                        'field_level_placeholder' => 'حقل «المستوى» — مثال',
                                        'field_schedule_label' => 'حقل «المواعيد المفضلة» — التسمية',
                                        'field_schedule_placeholder' => 'حقل «المواعيد المفضلة» — مثال',
                                        'field_message_label' => 'حقل «رسالة إضافية» — التسمية',
                                        'field_message_placeholder' => 'حقل «رسالة إضافية» — مثال',
                                        'form_optional_suffix' => 'لاحقة «(اختياري)»',
                                        'form_required_suffix' => 'رمز الحقل المطلوب',
                                        'form_submit_text' => 'نص زر الإرسال',
                                    ]))
                                    ->columns(2),

                                Section::make('رسائل النظام وشهادات العملاء')
                                    ->description('تُستخدم في toast و shahidat بعد الإرسال.')
                                    ->schema(self::textInputs([
                                        'toast_success_text' => 'رسالة النجاح',
                                        'toast_error_text' => 'رسالة الخطأ',
                                        'toast_received_text' => 'رسالة «تم الاستلام»',
                                        'form_loading_text' => 'نص جاري الإرسال',
                                        'testimonial_tag_whatsapp' => 'وسم شهادة واتساب',
                                        'testimonial_tag_google' => 'وسم شهادة Google',
                                        'testimonial_video_placeholder' => 'نص بديل فيديو شهادة',
                                        'testimonial_play_label' => 'aria-label زر تشغيل الفيديو',
                                        'testimonial_mute_label' => 'aria-label زر كتم الصوت',
                                        'testimonial_unmute_label' => 'aria-label زر تشغيل الصوت',
                                        'testimonial_resume_label' => 'aria-label زر التشغيل (متوقف)',
                                        'testimonial_pause_label' => 'aria-label زر الإيقاف المؤقت',
                                        'testimonial_volume_label' => 'aria-label مفتاح الصوت',
                                    ]))
                                    ->columns(2),
                            ]),

                        Tab::make('تحسين محركات البحث (SEO)')
                            ->schema([
                                Section::make('إعدادات SEO العامة للموقع')
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
            ]);
    }

    /**
     * Build plain text inputs from a field name => Arabic label map.
     *
     * @param  array<string, string>  $labels
     * @return array<int, TextInput>
     */
    private static function textInputs(array $labels): array
    {
        $fields = [];

        foreach ($labels as $name => $label) {
            $fields[] = TextInput::make($name)
                ->label($label)
                ->maxLength(255)
                ->columnSpan(1);
        }

        return $fields;
    }
}
