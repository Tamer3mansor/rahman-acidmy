@php
    $levels = [
        \App\Enums\StudentLevel::Debutant->value => 'Débutant — مبتدئ',
        \App\Enums\StudentLevel::Intermediaire->value => 'Intermédiaire — متوسط',
        \App\Enums\StudentLevel::Avance->value => 'Avancé — متقدم',
        \App\Enums\StudentLevel::JeNeSaisPas->value => 'Je ne sais pas — لا أعرف',
    ];

    $scheduleDays = [
        'الإثنين',
        'الثلاثاء',
        'الأربعاء',
        'الخميس',
        'الجمعة',
        'السبت',
        'الأحد',
        'أي وقت',
    ];
@endphp

<section class="form-section" id="trial-form">
    <div class="container">
        <div class="form-inner">
            <!-- Left info -->
            <div>
                <span class="section-label" style="background:rgba(201,150,58,0.2);color:var(--gold-light);border-color:rgba(201,150,58,0.3);">{{ $settings->form_label }}</span>
                <h2 class="form-side-title">
                    {{ $settings->form_title }}<br>
                    <span class="accent">{{ $settings->form_title_accent }}</span>
                </h2>
                <p class="form-side-sub">{!! $settings->form_subtitle !!}</p>
                <div class="form-info-list">
                    @foreach ($formInfos as $info)
                        <div class="form-info-item">
                            <div class="form-info-icon">
                                <i class="{{ $info->icon }}"></i>
                            </div>
                            <div class="form-info-text">
                                <div class="label">{{ $info->label }}</div>
                                <div class="val">{{ $info->value }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Form card -->
            <div class="form-card">
                <h3 class="form-card-title">{{ $settings->form_card_title }}</h3>
                <p class="form-card-sub">{!! $settings->form_card_subtitle !!}</p>

                <form id="trialForm"
                      data-url="{{ route('contact.submission') }}"
                      data-google-url="{{ config('services.google_sheets.form_url', '') }}">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="studentName">اسم الطالب *</label>
                            <input type="text" id="studentName" name="student_name" placeholder="أدخل اسم الطالب" required>
                        </div>
                        <div class="form-group">
                            <label for="parentName">اسم ولي الأمر *</label>
                            <input type="text" id="parentName" name="parent_name" placeholder="أدخل اسمك" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="studentAge">عمر الطالب *</label>
                            <input type="number" id="studentAge" name="student_age" placeholder="مثال: 8" min="3" max="80" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">رقم الهاتف *</label>
                            <input type="tel" id="phone" name="phone" placeholder="+33 6 00 00 00 00" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">البريد الإلكتروني *</label>
                        <input type="email" id="email" name="email" placeholder="example@email.com" required>
                    </div>

                    <div class="form-group">
                        <label>المستوى الحالي (Niveau de l'élève) *</label>
                        <div class="level-options">
                            @foreach ($levels as $value => $label)
                                <div class="level-option">
                                    <input type="radio" name="level" id="lvl{{ $loop->index + 1 }}" value="{{ $value }}" required>
                                    <label for="lvl{{ $loop->index + 1 }}"><span class="radio-dot"></span>{{ $label }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="form-group">
                        <label>المواعيد المتاحة خلال الأسبوع</label>
                        <div class="schedule-grid">
                            @foreach ($scheduleDays as $index => $day)
                                <div class="sched-option">
                                    <input type="checkbox" id="sched{{ $index + 1 }}" value="{{ $day }}">
                                    <label for="sched{{ $index + 1 }}">{{ $day }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="message">رسالة إضافية (اختياري)</label>
                        <textarea id="message" name="message" placeholder="هل لديك أي استفسار أو طلب خاص؟"></textarea>
                    </div>

                    <button type="submit" class="form-submit" id="submitBtn">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        أرسل طلبي وسأنتظر التواصل
                    </button>
                    <p class="form-note">{{ $settings->form_privacy_note }}</p>
                </form>
            </div>
        </div>
    </div>
</section>