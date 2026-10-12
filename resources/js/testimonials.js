/* ============================================================
   Ar-Rahman Academy — testimonial video player
   Custom play/pause, seek, volume and fullscreen controls
   (no native controls). Videos never autoplay; the big play button
   starts playback on demand so several clips cannot play over each
   other.
   ============================================================ */

/* Clips are recorded on phones, so they arrive in both orientations. The card
   frame is sized from the real video dimensions once they are known: a
   landscape clip keeps the 16/9 frame, a portrait clip gets a portrait frame.
   The frame then matches the footage exactly, so the clip is neither cropped
   nor letterboxed. Portrait ratios are clamped so an extreme recording cannot
   turn a card into a sliver or a wall. */
const FRAME_PORTRAIT_MIN_RATIO = 0.45;
const FRAME_PORTRAIT_MAX_RATIO = 0.9;

/* The hero video keeps playing once the visitor starts it (see landing.js).
   Playing a testimonial clip is a deliberate, visible choice, so the hero is
   paused to avoid the two audios overlapping once the visitor unmutes. */
const getHeroVideo = () => document.querySelector('[data-hero-video]');

document.addEventListener('DOMContentLoaded', () => {
    initTvPlayers(document);
    initTestimonialsPagination();
});

function initTvPlayers(root) {
    root.querySelectorAll('[data-tv-player]').forEach((player) => initTvPlayer(player));
}

/* Pagination of the audience/course testimonial sections swaps only that
   section instead of reloading the whole page. The links keep their real hrefs
   (so they still work without JS); clicks are intercepted, the freshly rendered
   section is fetched and dropped in place, and the URL is updated silently. */
function initTestimonialsPagination() {
    document.querySelectorAll('[data-testimonials-section]').forEach((section) => {
        if (section.dataset.paginationBound === 'true') return;

        section.dataset.paginationBound = 'true';
        section.addEventListener('click', (event) => {
            const link = event.target.closest('a.testimonials-page');
            if (!link) return;

            event.preventDefault();
            loadTestimonialsPage(section, link.href);
        });
    });
}

async function loadTestimonialsPage(section, url) {
    section.classList.add('is-loading');

    try {
        const response = await fetch(url, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            credentials: 'same-origin',
        });

        if (!response.ok) throw new Error(String(response.status));

        const template = document.createElement('template');
        template.innerHTML = (await response.text()).trim();

        const fresh = template.content.firstElementChild;
        if (!fresh) throw new Error('empty response');

        section.replaceWith(fresh);
        initTvPlayers(fresh);
        initTestimonialsPagination();

        window.history.replaceState(window.history.state, '', url);
    } catch {
        section.classList.remove('is-loading');
        window.location.href = url;
    }
}

function initTvPlayer(player) {
    const video = player.querySelector('[data-tv-video]');
    const playBtn = player.querySelector('[data-tv-play]');
    const toggleBtn = player.querySelector('[data-tv-toggle]');
    const muteBtn = player.querySelector('[data-tv-mute]');
    const volume = player.querySelector('[data-tv-volume]');
    const seek = player.querySelector('[data-tv-seek]');
    const fullscreenBtn = player.querySelector('[data-tv-fullscreen]');

    if (!video || !toggleBtn || !muteBtn || !volume) return;

    fitFrameToVideo(video);
    trackLoadingState(player, video);
    initFirstFrame(player, video);

    const icoPlay = toggleBtn.querySelector('[data-ico-play]');
    const icoPause = toggleBtn.querySelector('[data-ico-pause]');
    const icoVolOn = muteBtn.querySelector('[data-ico-vol-on]');
    const icoVolOff = muteBtn.querySelector('[data-ico-vol-off]');

    const show = (node, visible) => { if (node) node.style.display = visible ? '' : 'none'; };

    /* Labels come from "إعدادات الصفحة الرئيسية" so an admin can change the
       player copy without touching this file. */
    const copy = {
        play: player.dataset.playLabel || 'Lire la vidéo',
        resume: player.dataset.resumeLabel || 'Lire',
        pause: player.dataset.pauseLabel || 'Pause',
        mute: player.dataset.muteLabel || 'Couper le son',
        unmute: player.dataset.unmuteLabel || 'Activer le son',
    };

    const setPlaying = (playing) => {
        player.classList.toggle('is-playing', playing);
        show(icoPlay, !playing);
        show(icoPause, playing);
        toggleBtn.setAttribute('aria-label', playing ? copy.pause : copy.resume);
    };

    const setMuted = (muted) => {
        show(icoVolOn, !muted);
        show(icoVolOff, muted);
        muteBtn.setAttribute('aria-label', muted ? copy.unmute : copy.mute);
        volume.value = String(muted ? 0 : (video.volume || 1));
    };

    const marquee = player.closest('[data-video-marquee]');

    video.addEventListener('play', () => {
        setPlaying(true);
        marquee?.classList.add('is-paused');
        getHeroVideo()?.pause();
    });
    video.addEventListener('pause', () => {
        setPlaying(false);
        marquee?.classList.remove('is-paused');
    });

    playBtn?.addEventListener('click', () => {
        video.muted = false;
        setMuted(false);
        video.play();
    });

    toggleBtn.addEventListener('click', () => {
        if (video.paused) video.play(); else video.pause();
    });

    muteBtn.addEventListener('click', () => {
        video.muted = !video.muted;
        setMuted(video.muted);
    });

    volume.addEventListener('input', () => {
        video.volume = parseFloat(volume.value) || 0;
        video.muted = video.volume === 0;
        setMuted(video.muted);
    });

    /* The progress bar mirrors playback and seeks on drag. It is normalised to
       0–1000 so the value stays meaningful before the duration is known. */
    if (seek) {
        const syncSeek = () => {
            if (!video.duration) return;
            seek.value = String(Math.round((video.currentTime / video.duration) * 1000));
        };

        video.addEventListener('timeupdate', syncSeek);
        video.addEventListener('loadedmetadata', syncSeek);
        video.addEventListener('seeked', syncSeek);

        seek.addEventListener('input', () => {
            if (!video.duration) return;
            video.currentTime = (parseFloat(seek.value) / 1000) * video.duration;
        });
    }

    initFullscreen(player, video, fullscreenBtn);

    setPlaying(false);
    setMuted(video.muted);
}

/* Fullscreen is requested on the player (not the raw <video>) so the custom
   controls stay visible. Safari only exposes element fullscreen on newer
   versions, so older iPhones fall back to the native video fullscreen. */
function initFullscreen(player, video, button) {
    const requestElement = player.requestFullscreen || player.webkitRequestFullscreen;
    const enterNative = video.webkitEnterFullscreen;
    const supported = Boolean(requestElement || enterNative);

    if (!button || !supported) return;

    button.hidden = false;

    const icoEnter = button.querySelector('[data-ico-fs-enter]');
    const icoExit = button.querySelector('[data-ico-fs-exit]');
    const show = (node, visible) => { if (node) node.style.display = visible ? '' : 'none'; };

    const currentFullscreenElement = () =>
        document.fullscreenElement || document.webkitFullscreenElement || null;

    const syncIcon = () => {
        const active = currentFullscreenElement() === player;
        show(icoEnter, !active);
        show(icoExit, active);
    };

    button.addEventListener('click', () => {
        if (currentFullscreenElement()) {
            const exit = document.exitFullscreen || document.webkitExitFullscreen;
            exit?.call(document);
            return;
        }

        if (requestElement) {
            try {
                const attempt = requestElement.call(player);
                attempt?.catch?.(() => {});
            } catch {
                enterNative?.call(video);
            }
            return;
        }

        enterNative?.call(video);
    });

    ['fullscreenchange', 'webkitfullscreenchange'].forEach((event) => {
        document.addEventListener(event, syncIcon);
    });

    syncIcon();
}

function fitFrameToVideo(video) {
    const frame = video.closest('.trust-video-card');

    if (!frame) return;

    const applyRatio = () => {
        const width = video.videoWidth;
        const height = video.videoHeight;

        if (!width || !height) return;

        if (width >= height) {
            frame.classList.remove('is-portrait');
            frame.style.removeProperty('aspect-ratio');
            frame.style.removeProperty('height');
            return;
        }

        const ratio = Math.min(
            Math.max(width / height, FRAME_PORTRAIT_MIN_RATIO),
            FRAME_PORTRAIT_MAX_RATIO
        );

        frame.classList.add('is-portrait');
        frame.style.setProperty('aspect-ratio', String(ratio));

        /* The homepage marquee sizes portrait cards from CSS (a fixed viewport
           height), so leave inline height/width alone there. Screenshot-style
           grids derive the height from the card width instead. */
        if (frame.closest('.trust-video-marquee')) {
            frame.style.removeProperty('height');
            frame.style.removeProperty('width');
        } else {
            frame.style.setProperty('height', 'auto');
            frame.style.removeProperty('width');
        }
    };

    if (video.readyState >= 1) {
        applyRatio();
        return;
    }

    video.addEventListener('loadedmetadata', applyRatio);
}

/* The branded cover stays over a clip until the browser has a frame to paint,
   so the card never shows an empty (or uninitialised green) area. Once a frame
   exists it only comes back if playback genuinely runs out of data. */
function trackLoadingState(player, video) {
    const setReady = (ready) => player.classList.toggle('is-ready', ready);

    video.addEventListener('loadeddata', () => setReady(true));
    video.addEventListener('canplay', () => setReady(true));
    video.addEventListener('playing', () => setReady(true));
    video.addEventListener('waiting', () => { if (video.readyState < 2) setReady(false); });

    if (video.readyState >= 2) setReady(true);
}

/* Waiting for a clip to load before the visitor asks for it would download data
   nobody is watching, so the first frame is only seeded for cards that scroll
   into view. Seeding means nudging the playhead a hair past zero: the browser
   then decodes a real frame, which replaces the cover and also avoids the
   uninitialised green GPU frame some browsers paint otherwise. If the clip
   cannot be decoded (stalled network, unsupported codec) the branded cover
   simply stays put, so the card never flickers to a raw frame. */
function initFirstFrame(player, video) {
    if (player.dataset.firstFrame === 'done') return;

    player.dataset.firstFrame = 'done';

    const setReady = () => player.classList.add('is-ready');

    /* An admin-uploaded poster is already a real image, so show it straight
       away and skip seeding a frame from the clip. */
    if (video.getAttribute('poster')) {
        setReady();
        return;
    }

    if (video.readyState >= 2) {
        setReady();
        return;
    }

    whenVisible(player, async () => {
        try {
            if (video.readyState < 1) {
                if (video.preload === 'none') {
                    video.preload = 'metadata';
                    video.load();
                }

                await once(video, ['loadedmetadata'], 8000);
            }

            if (video.readyState >= 2) {
                setReady();
                return;
            }

            const duration = Number.isFinite(video.duration) ? video.duration : 1;
            video.currentTime = Math.min(0.1, duration * 0.5);

            await once(video, ['seeked', 'loadeddata', 'canplay'], 8000);
            setReady();
        } catch {
            /* Leave the branded cover in place. */
        }
    });
}

/* Runs the callback the first time the element scrolls within (or near) the
   viewport, then stops observing. Falls back to running immediately when
   IntersectionObserver is unavailable. */
function whenVisible(element, callback) {
    if (!('IntersectionObserver' in window)) {
        callback();
        return;
    }

    const observer = new IntersectionObserver((entries) => {
        if (entries.some((entry) => entry.isIntersecting)) {
            observer.disconnect();
            callback();
        }
    }, { rootMargin: '150px 0px' });

    observer.observe(element);
}

/* Resolves on the first of the given events, or rejects after the timeout so a
   stalled clip cannot leave the caller waiting forever. */
function once(target, events, timeout) {
    return new Promise((resolve, reject) => {
        let done = false;

        const cleanup = () => {
            events.forEach((name) => target.removeEventListener(name, handler));
            clearTimeout(timer);
        };

        const handler = () => {
            if (done) return;
            done = true;
            cleanup();
            resolve();
        };

        const timer = setTimeout(() => {
            if (done) return;
            done = true;
            cleanup();
            reject(new Error('timeout'));
        }, timeout);

        events.forEach((name) => target.addEventListener(name, handler));
    });
}