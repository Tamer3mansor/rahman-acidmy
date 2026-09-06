<section class="compare-section" id="courses">
    <div class="container">
        <div class="section-center">
            <span class="section-label">{{ $settings->compare_label }}</span>
            <h2 class="section-title">{{ $settings->compare_title }}</h2>
            <p class="section-sub">{!! $settings->compare_subtitle !!}</p>
        </div>

        <div class="compare-grid">
            <div class="compare-card problems">
                <h3 class="compare-card-title">{{ $settings->compare_problems_title }}</h3>
                <ul class="compare-list">
                    @foreach ($compareProblems as $item)
                        <li class="compare-item">
                            <span class="compare-icon x">✕</span>
                            <span>{{ $item->text }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="compare-card solutions">
                <h3 class="compare-card-title">{{ $settings->compare_solutions_title }}</h3>
                <ul class="compare-list">
                    @foreach ($compareSolutions as $item)
                        <li class="compare-item">
                            <span class="compare-icon check">✓</span>
                            <span>{{ $item->text }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="compare-cta">
            <button class="btn-primary" data-scroll-to-form>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                {{ $settings->compare_cta_title }}
            </button>
        </div>
    </div>
</section>