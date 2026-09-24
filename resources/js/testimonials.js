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

    const setPlaying = (playing) => {
        player.classList.toggle('is-playing', playing);
        show(icoPlay, !playing);
        show(icoPause, playing);
        toggleBtn.setAttribute('aria-label', playing ? 'إيقاف مؤقت' : 'تشغيل');
    };

    const setMuted = (muted) => {
        show(icoVolOn, !muted);
        show(icoVolOff, muted);
        muteBtn.setAttribute('aria-label', muted ? 'تشغيل الصوت' : 'كتم الصوت');
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
        video.muted = false;
        setMuted(false);
        const attempt = video.play();
        if (attempt !== undefined && typeof attempt.catch === 'function') {
            attempt.catch(() => { /* autoplay with sound blocked until user interaction */ });
        }
    }
}