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
                            <div class="form-info-icon">{{ $info->icon }}</div>
                            <div class="form-info-text">
                                <div class="label">{{ $info->label }}</div>
                                <div class="val">{{ $info->value }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Form card -->
            @include('landing.partials.contact-card', [
                'title' => $settings->form_card_title,
                'subtitle' => $settings->form_card_subtitle,
                'note' => true,
                'cardClass' => 'form-card',
            ])
        </div>
    </div>
</section>