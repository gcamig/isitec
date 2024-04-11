document.addEventListener("DOMContentLoaded", function () {
    function openVideoPopup(element) {
        const videoPopup = document.getElementById('videoPopup');
        const videoCompleto = document.querySelector('.videoCompleto');

        videoCompleto.controls = true;
        element.style.display = 'none';
        videoCompleto.style.display = 'block';
        videoPopup.style.display = 'flex';
    }

    function closeVideoPopup() {
        const videoPopup = document.getElementById('videoPopup');
        const videoCompleto = document.querySelector('.videoCompleto');
        const videoMiniatura = document.querySelector('.videoMiniatura');

        videoCompleto.pause();
        videoCompleto.currentTime = 0;
        videoCompleto.controls = false;
        videoCompleto.style.display = 'none';
        videoMiniatura.style.display = 'block';
        videoPopup.style.display = 'none';
    }

    const lessons = document.getElementsByClassName('lesson-card');
    console.log(lessons);
    for (let lesson of lessons) {
        lesson.addEventListener('click', () => {
            const dialog = lesson.querySelector('dialog');
            dialog.showModal();            
        })
    }
});
