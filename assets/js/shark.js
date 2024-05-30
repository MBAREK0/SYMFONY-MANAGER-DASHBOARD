window.onload = function() {
    document.getElementById('passwordInput').focus();
};
document.addEventListener("DOMContentLoaded", function() {
    const canvas = document.getElementById('canvas');
    const context = canvas.getContext('2d', { willReadFrequently: true });
    const videoContainer = document.getElementById('video-container');
    let video;
    let videoLoaded = false;

    function loadVideo(src, callback) {
        video = document.createElement('video');
        video.src = src;
        video.crossOrigin = "anonymous";
        video.muted = true;  // Mute the video to comply with autoplay policies
        video.addEventListener('loadeddata', function() {
            console.log("Video loaded");
            videoLoaded = true;
            callback();
        });
        video.load();
    }

    function startVideo() {
        if (!videoLoaded) return;
        console.log("Starting video");
        video.play();
        requestAnimationFrame(drawFrame);
    }

    function drawFrame() {
        if (videoLoaded) {
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            context.drawImage(video, 0, 0, canvas.width, canvas.height);
            applyChromaKey();
        }
        requestAnimationFrame(drawFrame);
    }

    function applyChromaKey() {
        const frame = context.getImageData(0, 0, canvas.width, canvas.height);
        const length = frame.data.length / 4;

        for (let i = 0; i < length; i++) {
            const r = frame.data[i * 4 + 0];
            const g = frame.data[i * 4 + 1];
            const b = frame.data[i * 4 + 2];

            // Simple chroma key condition for green screen
            if (g > 100 && r < 100 && b < 100) {
                frame.data[i * 4 + 3] = 0; // Set alpha to 0 (transparent)
            }
        }

        context.putImageData(frame, 0, 0);
    }

    videoContainer.style.display = 'none';
    setTimeout(() => {
        videoContainer.style.display = 'block';
        loadVideo('videos/shark.mp4', () => {
            console.log("Video is ready for playback");
            startVideo();
        });
    }, 10);
    setTimeout(() => {
        videoContainer.style.display = 'none';
    }, 50000);

});
