const screen = document.querySelector('#screen');
const maxShapes = 5;
const colors = ["#9893DA", "#E91E63", "#D6FFF6", "#4DCCBD"];
let currentShapes = 0;

function getRandomColor() {
  return colors[Math.floor(Math.random() * colors.length)];
}

function generateShape() {
  if (currentShapes >= maxShapes) return;

  const shape = document.createElement("div");
  shape.style.backgroundColor = getRandomColor();
  /* const size = Math.floor(1 + 5 * Math.random()) + "vh";
  shape.style.borderRadius = "50%"; */
  const size = Math.floor(5 + 10 * Math.random()) + "vh";
  shape.style.borderRadius = "10px";
  shape.style.width = size;
  shape.style.height = size;
  shape.style.position = "fixed";
  shape.style.zIndex = "-1";
  shape.style.boxShadow = "rgba(50, 50, 93, 0.25) 0px 30px 60px -12px inset, rgba(0, 0, 0, 0.3) 0px 18px 36px -18px inset";
  const edge = Math.floor(Math.random() * 4);
  let x, y;

  switch (edge) {
    case 0:
      x = Math.random() * screen.clientWidth;
      y = -parseFloat(size);
      break;
    case 1:
      x = screen.clientWidth;
      y = Math.random() * screen.clientHeight;
      break;
    case 2:
      x = Math.random() * screen.clientWidth;
      y = screen.clientHeight;
      break;
    case 3:
      x = -parseFloat(size);
      y = Math.random() * screen.clientHeight;
      break;
  }

  shape.style.left = x + "px";
  shape.style.top = y + "px";

  screen.appendChild(shape);
  currentShapes++;
  moveShape(shape);
}

function moveShape(shape) {
  const speed = 1 + Math.random() * 2;
  const rotationSpeed = 0.5 + Math.random() * 2;
  const angle = (Math.random() - 0.5) * 2 * Math.PI;
  let rotation = 0;
  const dx = Math.cos(angle) * speed;
  const dy = Math.sin(angle) * speed;

  function move() {
    let x = parseFloat(shape.style.left) + dx;
    let y = parseFloat(shape.style.top) + dy;
    const shapeWidth = parseFloat(shape.style.width);
    const shapeHeight = parseFloat(shape.style.height);

    // Comprobar si la forma está completamente fuera de la pantalla
    if (
      x < -shapeWidth ||
      x > screen.clientWidth ||
      y < -shapeHeight ||
      y > screen.clientHeight
    ) {
      screen.removeChild(shape);
      currentShapes--;
      return;
    }

    shape.style.left = x + "px";
    shape.style.top = y + "px";

    rotation += rotationSpeed;
    shape.style.transform = `rotate(${rotation}deg)`;

    window.requestAnimationFrame(move);
  }

  move();
}

function generateShapes(amountShapes) {
  for (let i = 0; i < amountShapes; i++) {
    generateShape();
  }
}

generateShapes(maxShapes);

screen.addEventListener('DOMNodeRemoved', generateShape);
