<?php

namespace Database\Seeders;

use App\Enums\MediaType;
use App\Models\LandingSettings;
use Illuminate\Database\Seeder;

class LandingSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LandingSettings::query()->updateOrCreate(
            ['id' => 1],
            [
                'header_brand_name' => 'Ar-Rahman',
                'header_brand_sub' => 'ACADEMY',
                'header_logo_path' => null,
                'header_btn1_title' => 'واتساب',
                'header_btn1_url' => 'https://wa.me/0000000000',
                'header_btn2_title' => 'احجز حصتك التجريبية',
                'header_btn2_url' => '#trial-form',

                'hero_badge' => 'تعليم إسلامي أونلاين · 7 أيام × 7',
                'hero_title' => 'تعلّم القرآن والعربية',
                'hero_title_accent' => 'مخصّص لك',
                'hero_subtitle' => 'حصص فردية أون لاين للأطفال والكبار، مع معلمين متخصصين من خريجي الأزهر الشريف وحاملي الإجازات. برنامج مُصمَّم على مستواك وجدولك.',
                'hero_btn1_title' => 'احجز حصتك التجريبية',
                'hero_btn1_url' => '#trial-form',
                'hero_btn2_title' => 'تحدّث معنا',
                'hero_btn2_url' => 'https://wa.me/0000000000',
                'hero_video_path' => null,
                'hero_media_type' => MediaType::Video->value,
                'hero_video_autoplay' => true,
                'hero_video_loop' => true,

                'trust_label' => 'ماذا يقولون عنّا',
                'trust_title' => 'آلاف الأسر تثق بأكاديمية الرحمن',
                'trust_subtitle' => 'شهادات حقيقية من طلابنا وأولياء الأمور في أوروبا وكندا والعالم العربي',
                'trust_cta_title' => 'احجز حصتك التجريبية المجانية',

                'journey_label' => 'كيف تسير رحلتك معنا',
                'journey_title' => '5 خطوات بسيطة نحو التميّز',
                'journey_subtitle' => 'من أول تواصل حتى تحقيق أهدافك — الطريق واضح والدعم متواصل',
                'journey_cta_title' => 'ابدأ رحلتك اليوم',

                'compare_label' => 'لماذا أكاديمية الرحمن؟',
                'compare_title' => 'الفرق واضح من البداية',
                'compare_subtitle' => 'قارن بنفسك بين التعليم التقليدي وما نقدمه',
                'compare_problems_title' => 'مشكلات التعليم التقليدي',
                'compare_solutions_title' => 'حل أكاديمية الرحمن',
                'compare_cta_title' => 'جرّب الفرق مجاناً',

                'teachers_label' => 'معلمونا',
                'teachers_title' => 'نخبة من أفضل المعلمين',
                'teachers_subtitle' => 'معلمون متخصصون، كل واحد منهم اجتاز عملية اختيار صارمة لضمان جودة التعليم',
                'teachers_cta_title' => 'احجز حصتك مع أحد معلمينا',

                'faq_label' => 'أسئلة شائعة',
                'faq_title' => 'كل ما تريد معرفته',
                'faq_subtitle' => 'لم تجد إجابتك؟ تواصل معنا مباشرة',

                'form_label' => 'حصة تجريبية مجانية',
                'form_title' => 'ابدأ رحلتك مع',
                'form_title_accent' => 'أكاديمية الرحمن',
                'form_subtitle' => 'املأ هذا النموذج وسيتواصل معك فريقنا خلال 24 ساعة لترتيب حصة مجانية بدون أي التزام.',
                'form_card_title' => 'سجّل معلوماتك',
                'form_card_subtitle' => 'سيتواصل معك فريقنا خلال 24 ساعة لترتيب الحصة المجانية',
                'form_note' => 'الرجاء إدخال بيانات صحيحة لسهولة التواصل',
                'form_privacy_note' => '🔒 بياناتك محفوظة ولن تُشارك مع أي طرف ثالث',

                'footer_brand_name' => 'Ar-Rahman Academy',
                'footer_brand_sub' => 'أكاديمية الرحمن للتعليم الإسلامي',
                'footer_description' => 'تعليم القرآن الكريم واللغة العربية أون لاين للأطفال والكبار، مع معلمين متخصصين من خريجي الأزهر الشريف.',
                'footer_copyright' => '© 2025 Ar-Rahman Academy. جميع الحقوق محفوظة.',
            ]
        );
    }
}
