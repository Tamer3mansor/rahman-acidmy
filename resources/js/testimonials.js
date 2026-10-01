/* ============================================================
   Ar-Rahman Academy — testimonial video player
   Custom play/pause + volume controls (no native controls).
   First video attempts autoplay with sound; browsers may block
   it until the visitor interacts, so the big play button stays
   as a fallback.
   ============================================================ */

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

    const icoPlay = toggleBtn.querySelector('[data-ico-play]');
    const icoPause = toggleBtn.querySelector('[data-ico-pause]');
    const icoVolOn = muteBtn.querySelector('[data-ico-vol-on]');
    const icoVolOff = muteBtn.querySelector('[data-ico-vol-off]');

    const show = (node, visible) => { if (node) node.style.display = visible ? '' : 'none'; };

    /* Labels come from "إعدادات الصفحة الرئيسية" so an admin can change the
       player copy without touching this file. */
    const copy = {
        play: player.dataset.playLabel || 'تشغيل الفيديو',
        resume: player.dataset.resumeLabel || 'تشغيل',
        pause: player.dataset.pauseLabel || 'إيقاف مؤقت',
        mute: player.dataset.muteLabel || 'كتم الصوت',
        unmute: player.dataset.unmuteLabel || 'تشغيل الصوت',
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