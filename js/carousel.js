let currentIndex = 0;

const nextButton = document.querySelector('.next');
const prevButton = document.querySelector('.prev');

nextButton.addEventListener('click', () => changeSlide(1));
prevButton.addEventListener('click', () => changeSlide(-1));

function changeSlide(direction) {
  const images = document.querySelectorAll('.slider img');
  currentIndex += direction;

  if (currentIndex >= images.length) {
    currentIndex = 0;
  } else if (currentIndex < 0) {
    currentIndex = images.length - 1;
  }

  // Oculta todas las imágenes y muestra la actual con animación
  images.forEach((img, index) => {
    img.style.display = index === currentIndex ? 'block' : 'none';
    img.style.opacity = index === currentIndex ? '1' : '0';
  });
}
