/**
 * audio-player.js — Pachamala Temple Theme
 * Devotional music player with autoplay attempt + user toggle
 */

(function () {
    'use strict';

    var audio  = document.getElementById('devotional-audio');
    var btn    = document.getElementById('audio-toggle');
    var player = document.getElementById('audio-player');

    if (!audio || !btn || !player) return;

    // Restore previous state from sessionStorage
    var savedState = sessionStorage.getItem('pkt_audio');

    function setPlaying(playing) {
        btn.classList.toggle('playing', playing);
        btn.setAttribute('aria-pressed', playing ? 'true' : 'false');
        btn.setAttribute('aria-label', playing ? 'Pause Devotional Music' : 'Play Devotional Music');
    }

    // Attempt autoplay (only if user hasn't manually paused)
    if (savedState !== 'paused') {
        var playPromise = audio.play();

        if (playPromise !== undefined) {
            playPromise
                .then(function () {
                    // Autoplay succeeded
                    setPlaying(true);
                    player.classList.add('autoplay-success');
                })
                .catch(function () {
                    // Autoplay blocked by browser — show player prominently
                    setPlaying(false);
                    player.classList.add('autoplay-blocked');
                    // Pulse the button to draw attention
                    setTimeout(function () {
                        player.style.transform = 'scale(1.05)';
                        setTimeout(function () {
                            player.style.transform = '';
                        }, 300);
                    }, 1000);
                });
        }
    } else {
        // User previously paused — don't autoplay
        setPlaying(false);
    }

    // Toggle on button click
    btn.addEventListener('click', function () {
        if (audio.paused) {
            audio.play().then(function () {
                setPlaying(true);
                sessionStorage.setItem('pkt_audio', 'playing');
            }).catch(function () {
                console.warn('Audio play failed');
            });
        } else {
            audio.pause();
            setPlaying(false);
            sessionStorage.setItem('pkt_audio', 'paused');
        }
    });

    // Keyboard shortcut: M to mute/unmute
    document.addEventListener('keydown', function (e) {
        if (e.key === 'm' && e.altKey) {
            btn.click();
        }
    });

    // Auto-play when user interacts with page (handles strict autoplay policies)
    var interacted = false;
    function handleFirstInteraction() {
        if (interacted || savedState === 'paused') return;
        interacted = true;
        if (audio.paused) {
            audio.play().then(function () {
                setPlaying(true);
            }).catch(function () {});
        }
        document.removeEventListener('click', handleFirstInteraction);
        document.removeEventListener('scroll', handleFirstInteraction);
    }

    document.addEventListener('click',  handleFirstInteraction, { once: true });
    document.addEventListener('scroll', handleFirstInteraction, { once: true });

})();
