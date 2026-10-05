@php
    $cardClass = $cardClass ?? 'contact-card';
@endphp
<div class="{{ $cardClass }}">
    <h3 class="form-card-title">{{ $title }}</h3>
    @if (! empty($subtitle))
        <div class="form-card-sub">{!! $subtitle !!}</div>
    @endif
    @if (! empty($note) && filled($settings->form_note))
        <div class="form-note form-note--top">{!! $settings->form_note !!}</div>
    @endif

    <form id="trialForm"
          data-url="{{ route('contact.submission') }}"
          data-google-url="{{ config('services.google_sheets.form_url', '') }}"
          data-success-text="{{ $settings->toast_success_text }}"
          data-error-text="{{ $settings->toast_error_text }}"
          data-received-text="{{ $settings->toast_received_text }}"
          data-loading-text="{{ $settings->form_loading_text }}">
        <div class="form-row">
            <div class="form-group">
                <label for="studentName">{{ $settings->field_student_name_label }} {{ $settings->form_required_suffix }}</label>
                <input type="text" id="studentName" name="student_name" placeholder="{{ $settings->field_student_name_placeholder }}" required>
            </div>
            <div class="form-group">
                <label for="parentName">{{ $settings->field_parent_name_label }} {{ $settings->form_required_suffix }}</label>
                <input type="text" id="parentName" name="parent_name" placeholder="{{ $settings->field_parent_name_placeholder }}" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="studentAge">{{ $settings->field_student_age_label }} {{ $settings->form_required_suffix }}</label>
                <input type="number" id="studentAge" name="student_age" placeholder="{{ $settings->field_student_age_placeholder }}" min="3" max="80" required>
            </div>
            <div class="form-group">
                <label for="phone">{{ $settings->field_phone_label }} {{ $settings->form_required_suffix }}</label>
                <input type="tel" id="phone" name="phone" placeholder="{{ $settings->field_phone_placeholder }}" required>
            </div>
        </div>
        <div class="form-group">
            <label for="email">{{ $settings->field_email_label }}</label>
            <input type="email" id="email" name="email" placeholder="{{ $settings->field_email_placeholder }}">
        </div>
        <div class="form-group">
            <label for="level">{{ $settings->field_level_label }} ({{ $settings->form_optional_suffix }})</label>
            <input type="text" id="level" name="level" placeholder="{{ $settings->field_level_placeholder }}">
        </div>
        <div class="form-group">
            <label for="schedule">{{ $settings->field_schedule_label }} ({{ $settings->form_optional_suffix }})</label>
            <input type="text" id="schedule" name="schedule" placeholder="{{ $settings->field_schedule_placeholder }}">
        </div>
        <div class="form-group">
            <label for="message">{{ $settings->field_message_label }} ({{ $settings->form_optional_suffix }})</label>
            <textarea id="message" name="message" placeholder="{{ $settings->field_message_placeholder }}"></textarea>
        </div>

        <button type="submit" class="form-submit" id="submitBtn">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            {{ $settings->form_submit_text }}
        </button>
        @if (! empty($note) && filled($settings->form_privacy_note))
            <p class="form-note">{{ $settings->form_privacy_note }}</p>
        @endif
    </form>
</div>
