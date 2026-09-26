<x-filament-panels::page>
    <div class="space-y-6 leading-relaxed text-[var(--brand-text-muted)]">
        <x-filament::section>
            <x-slot name="heading">
                مقدمة في السيو (SEO) للموقع
            </x-slot>
            <p>
                الـ SEO هو اختصار لـ <strong class="font-semibold text-[var(--brand-text)]">Search Engine Optimization</strong>، ويعني تحسين الموقع للظهور في النتائج الأولى على محركات البحث مثل جوجل.
                كـ مدير للموقع، لديك تحكم كامل في نصوص وعناوين وصور الصفحات، وهذا الكتيب سيساعدك على كتابتها بأفضل شكل لزيادة زيارات الموقع.
            </p>
        </x-filament::section>

        <x-filament::section>
            <x-slot name="heading">
                1. عنوان الصفحة (Meta Title)
            </x-slot>
            <p class="mb-2">
                هو العنوان الرئيسي الذي يظهر باللون الأزرق العريض في نتائج بحث جوجل.
            </p>
            <ul class="mb-4 list-inside list-disc space-y-2">
                <li><strong class="font-semibold text-[var(--brand-text)]">الطول المناسب:</strong> يفضل ألا يتجاوز 60 حرفاً حتى لا يتم قصه في جوجل. الحقل في اللوحة يمنع تجاوز 60 حرفاً ويعرض عدّاداً مباشراً.</li>
                <li><strong class="font-semibold text-[var(--brand-text)]">كيف تكتبه:</strong> اكتب اسم الدورة أو الخدمة أولاً، يليه ميزة تنافسية، ثم اسم الأكاديمية (اختياري).</li>
                <li>
                    <strong class="font-semibold text-[var(--brand-text)]">مثال لدورة أطفال (57 حرفاً):</strong>
                    <code class="rounded bg-[var(--brand-chip-bg)] px-1.5 py-0.5 font-semibold text-[var(--brand-chip-text)]">دورة تحفيظ القرآن الكريم للأطفال أونلاين | الرحمن أكاديمي</code>
                </li>
            </ul>
        </x-filament::section>

        <x-filament::section>
            <x-slot name="heading">
                2. وصف الصفحة (Meta Description)
            </x-slot>
            <p class="mb-2">
                هو النص الوصفي الذي يظهر تحت العنوان الأزرق في جوجل. هدفه الأساسي هو إقناع الباحث بالضغط على الرابط الخاص بك.
            </p>
            <ul class="mb-4 list-inside list-disc space-y-2">
                <li><strong class="font-semibold text-[var(--brand-text)]">الطول المناسب:</strong> بين 150 إلى 160 حرفاً. الحقل في اللوحة يمنع تجاوز 160 حرفاً ويعرض عدّاداً مباشراً.</li>
                <li><strong class="font-semibold text-[var(--brand-text)]">كيف تكتبه:</strong> اشرح محتوى الصفحة باختصار وأضف "دعوة لاتخاذ إجراء (Call to Action)" في النهاية.</li>
                <li>
                    <strong class="font-semibold text-[var(--brand-text)]">مثال (152 حرفاً):</strong>
                    <code class="rounded bg-[var(--brand-chip-bg)] px-1.5 py-0.5 font-semibold text-[var(--brand-chip-text)]">سجّل الآن في دورة التجويد للكبار مع نخبة من شيوخ الأزهر الشريف أونلاين. جرّب حصة تجريبية مجانية، واحصل على متابعة فردية وشهادة إتمام معتمدة. احجز مقعدك!</code>
                </li>
            </ul>
        </x-filament::section>

        <x-filament::section>
            <x-slot name="heading">
                3. صورة المشاركة (OG Image)
            </x-slot>
            <p class="mb-2">
                هي الصورة التي تظهر عندما يقوم شخص بمشاركة رابط الصفحة (الدورة أو الرئيسية) على الواتساب، فيسبوك، أو منصات التواصل.
            </p>
            <ul class="list-inside list-disc space-y-2">
                <li>يفضل أن تكون أبعاد الصورة <strong class="font-semibold text-[var(--brand-text)]">1200x630 بكسل</strong>، واللوحة تضبط الأبعاد تلقائياً إلى 1200x630 عند الرفع.</li>
                <li>يجب أن تكون جذابة وتعبر بوضوح عن موضوع الدورة أو الصفحة لجذب انتباه المتصفحين في منصات التواصل.</li>
            </ul>
        </x-filament::section>

        <x-filament::section>
            <x-slot name="heading">
                السماح لفهارس البحث (Allow Indexing)
            </x-slot>
            <p class="mb-2">
                مفتاح <code class="rounded bg-[var(--brand-chip-bg)] px-1.5 py-0.5 font-semibold text-[var(--brand-chip-text)]">is_indexed</code> موجود في كل إعدادات السيو بالموقع، وهو يتحكم مباشرة في وسم <code class="rounded bg-[var(--brand-chip-bg)] px-1.5 py-0.5 font-semibold text-[var(--brand-chip-text)]">robots</code> في صفحة الموقع.
            </p>
            <ul class="list-inside list-disc space-y-2">
                <li>في حالة <strong class="font-semibold text-[var(--brand-text)]">السماح</strong> (الافتراضي): تضيف الصفحة الوسم <code class="rounded bg-[var(--brand-chip-bg)] px-1.5 py-0.5 font-semibold text-[var(--brand-chip-text)]">index,follow</code>، أي أنها تظهر في نتائج البحث.</li>
                <li>في حالة <strong class="font-semibold text-[var(--brand-text)]">المنع</strong>: تضيف الصفحة الوسم <code class="rounded bg-[var(--brand-chip-bg)] px-1.5 py-0.5 font-semibold text-[var(--brand-chip-text)]">noindex,nofollow</code>، أي أن جوجل يتوقف عن عرضها نهائياً في النتائج.</li>
                <li>استخدم المنع فقط للصفحات المؤقتة أو التجريبية. لا تُنعِل الفهرسة على صفحة نهائية ثم تنساها، لأن إصلاح ذلك بعد ذلك يحتاج وقتاً طويلاً لإعادة الفهرسة.</li>
            </ul>
        </x-filament::section>

        <x-filament::section>
            <x-slot name="heading">
                أنواع Schema المتاحة
            </x-slot>
            <p class="mb-2">
                حقل "نوع Schema" متاح في نموذج <strong class="font-semibold text-[var(--brand-text)]">الدورة</strong> فقط، وله أربع قيم:
            </p>
            <ul class="list-inside list-disc space-y-2">
                <li><code class="rounded bg-[var(--brand-chip-bg)] px-1.5 py-0.5 font-semibold text-[var(--brand-chip-text)]">Course</code> — القيمة الافتراضية، استخدمها لكل دورة حتى يعرض جوجل السعر والتقييم مباشرة في النتائج.</li>
                <li><code class="rounded bg-[var(--brand-chip-bg)] px-1.5 py-0.5 font-semibold text-[var(--brand-chip-text)]">EducationalOrganization</code> — استخدمها للصفحات التعريفية بالأكاديمية نفسها.</li>
                <li><code class="rounded bg-[var(--brand-chip-bg)] px-1.5 py-0.5 font-semibold text-[var(--brand-chip-text)]">FAQPage</code> — للصفحات التي تحتوي على أسئلة وأجوبة.</li>
                <li><code class="rounded bg-[var(--brand-chip-bg)] px-1.5 py-0.5 font-semibold text-[var(--brand-chip-text)]">Article</code> — للمقالات والأخبار الطويلة.</li>
            </ul>
        </x-filament::section>

        <x-filament::section>
            <x-slot name="heading">
                أين تجد حقول السيو في اللوحة
            </x-slot>
            <p class="mb-2">
                حقول السيو (<code class="rounded bg-[var(--brand-chip-bg)] px-1.5 py-0.5 font-semibold text-[var(--brand-chip-text)]">Meta Title</code> و <code class="rounded bg-[var(--brand-chip-bg)] px-1.5 py-0.5 font-semibold text-[var(--brand-chip-text)]">Meta Description</code> و <code class="rounded bg-[var(--brand-chip-bg)] px-1.5 py-0.5 font-semibold text-[var(--brand-chip-text)]">OG Image</code> و <code class="rounded bg-[var(--brand-chip-bg)] px-1.5 py-0.5 font-semibold text-[var(--brand-chip-text)]">is_indexed</code>) موجودة في أربعة أماكن:
            </p>
            <ul class="list-inside list-disc space-y-2">
                <li><strong class="font-semibold text-[var(--brand-text)]">الدورات:</strong> من صفحة تعديل الدورة، في تاب "تحسين محركات البحث (SEO)".</li>
                <li><strong class="font-semibold text-[var(--brand-text)]">صفحة الدورات:</strong> من "صفحات الدورات" في تاب "تحسين محركات البحث (SEO)"، وفيه ثلاثة أقسام: إعدادات صفحة الأطفال، وإعدادات صفحة الكبار، وإعدادات SEO العامة (احتياطي).</li>
                <li><strong class="font-semibold text-[var(--brand-text)]">الصفحة الرئيسية:</strong> من "إعدادات الصفحة الرئيسية" في تاب "تحسين محركات البحث (SEO)".</li>
                <li><strong class="font-semibold text-[var(--brand-text)]">الأسعار:</strong> من "الأسعار" في قسم "تحسين محركات البحث (SEO)".</li>
            </ul>
        </x-filament::section>

        <x-filament::section>
            <x-slot name="heading">
                نصائح عامة
            </x-slot>
            <ul class="list-inside list-disc space-y-2">
                <li>استخدم الكلمات المفتاحية التي يبحث عنها الناس بشكل طبيعي دون تكرار مبالغ فيه. (مثال: حفظ القرآن, تجويد, لغة عربية لغير الناطقين بها).</li>
                <li>لا تترك حقلي <code class="rounded bg-[var(--brand-chip-bg)] px-1.5 py-0.5 font-semibold text-[var(--brand-chip-text)]">Meta Title</code> و <code class="rounded bg-[var(--brand-chip-bg)] px-1.5 py-0.5 font-semibold text-[var(--brand-chip-text)]">Meta Description</code> فارغين. وفي حال تم تركهما فارغين، سيحاول الموقع أخذ نصوص افتراضية، لكن الأفضل دائماً كتابتها خصيصاً لكل صفحة.</li>
                <li>اكتب وصفاً مختلفاً لكل صفحة. تكرار نفس الوصف على عدة صفحات يخلط جوجل بينها ويضر بالترتيب.</li>
                <li>العنوان والوصف لكل صفحة يجب أن يطابقا محتوى الصفحة فعلاً، لأن جوجل يعاقب المحتوى الذي يوعد بشيء غير موجود في الصفحة.</li>
            </ul>
        </x-filament::section>
    </div>
</x-filament-panels::page>
