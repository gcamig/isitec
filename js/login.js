const signUpButton = document.getElementById('signUp');
const signInButton = document.getElementById('signIn');
const goBackButton = document.getElementById('goBack');
const container = document.getElementById('container');

signUpButton.addEventListener('click', () => {
	container.classList.add("right-panel-active");
});

signInButton.addEventListener('click', () => {
	document.getElementById("sign-in-container").style.display = "block";
	container.classList.remove("right-panel-active");
});