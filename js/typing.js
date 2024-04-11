let typedHeader = "";
let typedSentence = "";
let title = "";
let sentence = "";
const element = document.querySelector(".typeText");
const header = document.querySelector(".typeHeader");
const url = window.location.href;

if (url.includes("register")) {
  title = "Bienvenido!";
  sentence = "Para unirte registrate con tus datos personales.";
}
else {
  title = "Bienvenido de nuevo!";
  sentence = "Para mantenerte conectado, inicia sesión con tus datos personales.";
}

function typeSentence(sentence, index) {
  if (index < sentence.length) {
    typedSentence += sentence.charAt(index);
    element.innerHTML = typedSentence;
    index++;
    setTimeout(() => {
      typeSentence(sentence, index);
    }, 50);
  } else {
    setTimeout(() => {
      element.classList.add("highlight");
    }, 4000);

    setTimeout(() => {
      element.classList.remove("highlight");
      typedSentence = "";
      element.innerHTML = typedSentence;
      typeSentence(sentence, 0);
    }, 5000);
  }
}

function typeHeader(sentence, index) {
  if (index < sentence.length) {
    typedHeader += sentence.charAt(index);
    header.innerHTML = typedHeader;
    index++;
    setTimeout(() => {
      typeHeader(sentence, index);
    }, 50);
  }
}

typeHeader(title, 0);
typeSentence(sentence, 0);