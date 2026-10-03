/* ============================================================
   Ar-Rahman Academy — testimonial video player
   Custom play/pause + volume controls (no native controls).
   First video attempts autoplay with sound; browsers may block
   it until the visitor interacts, so the big play button stays
   as a fallback.
   ============================================================ */

/* Clips are recorded on phones, so they arrive in both orientations. The card
   frame is sized from the real video dimensions once they are known: a
   landscape clip keeps the 16/9 frame, a portrait clip gets a portrait frame.
   The frame then matches the footage exactly, so the clip is neither cropped
   nor letterboxed. Portrait ratios are clamped so an extreme recording cannot
   turn a card into a sliver or a wall. */
const FRAME_PORTRAIT_MIN_RATIO = 0.45;
const FRAME_PORTRAIT_MAX_RATIO = 0.9;
const METADATA_ROOT_MARGIN = '200px';

document.addEventListener('DOMContentLoaded', () => {
    const players = document.querySelectorAll('[data-tv-player]');

    players.forEach((player, index) => initTvPlayer(player, index === 0));
});

function initTvPlayer(player, autoplay) {
    const video = player.querySelector('[data-tv-video]');
    const playBtn = player.querySelector('[data-tv-play]');
    const toggleBtn = player.querySelector('[data-tv-toggle]');
    const muteBtn = player.querySelector('[data-tv-mute]');
    const volume = player.querySelector('[data-tv-volume]');

    if (!video || !toggleBtn || !muteBtn || !volume) return;

    fitFrameToVideo(video);
    loadMetadataWhenNear(video);

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

    video.addEventListener('play', () => setPlaying(true));
    video.addEventListener('pause', () => setPlaying(false));

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

    setPlaying(false);
    setMuted(video.muted);

    if (autoplay) {
        /* Phones only allow muted autoplay, so start muted and upgrade to sound
           on the first interaction. Trying with sound first leaves the card as a
           black frame because the rejected promise is never retried. */
        video.muted = true;
        setMuted(true);

        const attempt = video.play();
        if (attempt !== undefined && typeof attempt.catch === 'function') {
            attempt.catch(() => { /* play button stays as the fallback */ });
        }

        const unmute = () => {
            video.muted = false;
            setMuted(false);
            if (video.paused) video.play();
        };

        ['pointerdown', 'touchstart', 'keydown', 'wheel'].forEach((evt) => {
            window.addEventListener(evt, unmute, { once: true, passive: true });
        });
    }
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
        frame.style.setProperty('height', 'auto');
    };

    if (video.readyState >= 1) {
        applyRatio();
        return;
    }

    video.addEventListener('loadedmetadata', applyRatio);
}

/* Later cards ship with preload="none" so the landing page does not fetch every
   clip up front, which would leave their orientation unknown and the frame at
   the 16/9 default. Nudging those to metadata as they approach the viewport
   resolves the dimensions without pulling the clip itself. */
function loadMetadataWhenNear(video) {
    if (video.preload !== 'none' || typeof IntersectionObserver === 'undefined') return;

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (!entry.isIntersecting) return;

            observer.disconnect();
            video.setAttribute('preload', 'metadata');
            video.load();
        });
    }, { rootMargin: METADATA_ROOT_MARGIN });

    observer.observe(video);
}