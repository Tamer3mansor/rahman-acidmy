@php
    $type = $testimonial->type?->value;
    $author = trim(($testimonial->author_name ?? '').($testimonial->author_location ? ' · '.$testimonial->author_location : ''));
@endphp

@if ($type === 'whatsapp' || $type === 'google')
    <article class="screenshot-card">
        <div class="screenshot-tag">
            @if ($type === 'whatsapp')
                <svg width="16" height="16" viewBox="0 0 24 24" fill="#25D366"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                Messages WhatsApp
            @else
                <svg width="16" height="16" viewBox="0 0 24 24" fill="#4285F4"><path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/><path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/><path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/></svg>
                Avis Google
            @endif
        </div>

        @if ($type === 'whatsapp')
            <div class="wa-mock">
                <div class="wa-bubble">
                    {!! $testimonial->content !!}
                    @if ($author)
                        <div class="time">{{ $author }}</div>
                    @endif
                </div>
            </div>
        @else
            <div class="review-mock">
                @if ($testimonial->rating)
                    <div class="review-stars">{{ str_repeat('★', min($testimonial->rating, 5)) }}{{ str_repeat('☆', max(5 - min($testimonial->rating, 5), 0)) }}</div>
                @endif
                <div class="review-text">{!! $testimonial->content !!}</div>
                @if ($author)
                    <div class="review-author">{{ $author }}</div>
                @endif
            </div>
        @endif
    </article>
@elseif ($type === 'video')
    <div class="trust-video-card">
        @if (filled($testimonial->media_path))
            @php
                $videoExtension = strtolower(pathinfo($testimonial->media_path, PATHINFO_EXTENSION));
                $videoUrl = \Illuminate\Support\Str::startsWith($testimonial->media_path, ['http://', 'https://'])
                    ? $testimonial->media_path
                    : asset('storage/'.$testimonial->media_path);
            @endphp
            <div class="tv-player" data-tv-player>
                <video class="tv-video" data-tv-video playsinline loop preload="{{ $videoPreload ?? 'metadata' }}">
                    <source src="{{ $videoUrl }}" type="{{ $videoExtension === 'webm' ? 'video/webm' : 'video/mp4' }}">
                </video>
                <button class="tv-play" data-tv-play type="button" aria-label="تشغيل الفيديو">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="#C9963A"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                </button>
                <div class="tv-controls" data-tv-controls>
                    <button class="tv-btn" data-tv-toggle type="button" aria-label="تشغيل">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" data-ico-pause hidden><rect x="6" y="5" width="4" height="14" rx="1"/><rect x="14" y="5" width="4" height="14" rx="1"/></svg>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" data-ico-play><polygon points="6 4 20 12 6 20 6 4"/></svg>
                    </button>
                    <button class="tv-btn" data-tv-mute type="button" aria-label="كتم الصوت">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" data-ico-vol-on><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3a4.5 4.5 0 0 0-2.5-4.03v8.05A4.5 4.5 0 0 0 16.5 12zM14 3.23v2.06a7 7 0 0 1 0 13.42v2.06a9 9 0 0 0 0-17.54z"/></svg>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" data-ico-vol-off hidden><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3a4.5 4.5 0 0 0-2.5-4.03v8.05A4.5 4.5 0 0 0 16.5 12zM14 3.23v2.06a7 7 0 0 1 0 13.42v2.06a9 9 0 0 0 0-17.54z"/><path d="M18.5 4.68 23 9.18 21.4 10.8 17.22 6.6 18.5 4.68zm0 0L23 14.82 21.4 13.2l-4.18-4.2L18.5 4.68z" transform="rotate(0)"/></svg>
                    </button>
                    <input class="tv-volume" data-tv-volume type="range" min="0" max="1" step="0.05" value="1" aria-label="مستوى الصوت">
                </div>
            </div>
        @else
            <div class="trust-video-placeholder">
                <div class="play-sm">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="#C9963A"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                </div>
                <span>Test vidéo · Parents</span>
            </div>
        @endif
    </div>
@endif