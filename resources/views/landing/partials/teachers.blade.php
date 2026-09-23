<section class="teachers-section" id="teachers">
    <div class="container">
        <div class="section-center">
            <span class="section-label">{{ $settings->teachers_label }}</span>
            <h2 class="section-title">{{ $settings->teachers_title }}</h2>
            <div class="section-sub">{!! $settings->teachers_subtitle !!}</div>
        </div>

        <div class="teachers-carousel" id="teachersCarousel">
            <div class="teachers-viewport">
                <div class="teachers-grid" id="teachersGrid">
            @foreach ($teachers as $teacher)
                <div class="teacher-card">
                    <div class="teacher-photo">
                        @if ($teacher->photo_url)
                            <img src="{{ $teacher->photo_url }}" alt="{{ $teacher->name }}">
                        @else
                            <div class="teacher-avatar">{{ $teacher->emoji }}</div>
                        @endif
                        @if ($teacher->is_featured)
                            <span class="teacher-featured">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2l2.6 7.1L22 9.3l-5.9 4.6 1.9 7.4L12 16.9 6 21.3l1.9-7.4L2 9.3l7.4-.2L12 2z"/></svg>
                                {{ $teacher->featured_label ?: __('Membre distingué') }}
                            </span>
                        @endif
                    </div>
                    <div class="teacher-body">
                        <div class="teacher-name">{{ $teacher->name }}</div>
                        <div class="teacher-specialty">{{ $teacher->specialty }}</div>
                        <div class="teacher-badges">
                            @foreach ($teacher->badges ?? [] as $badge)
                                <span class="badge {{ in_array($badge, ['Ijazah', 'Al-Azhar']) ? 'gold' : '' }}">{{ $badge }}</span>
                            @endforeach
                        </div>
                        <button class="teacher-cta" data-scroll-to-form>
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            Réserver avec lui / elle
                        </button>
                    </div>
                </div>
                @endforeach
                </div>
            </div>
            <div class="teachers-pagination" aria-label="Navigation des professeurs"></div>
        </div>

        <div class="trust-cta-wrap">
            <button class="btn-primary" data-scroll-to-form>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                {{ $settings->teachers_cta_title }}
            </button>
        </div>
    </div>
</section>
