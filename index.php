<!DOCTYPE html>
<html lang="es">

<head>
  <title>Login | Isitec</title>
  <meta charset="utf-8">
  <meta name="author" content="author">
  <meta name="keywords" content="keywords">
  <meta name="description" content="description">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="./img/logo.png">
  <link rel="stylesheet" href="./css/style.css">
</head>

<body>
<section class="container" id="container">
    <div class="form-container sign-up-container">
      <form class="sign-up-form">
        <h2>Sign up</h2>
        <div class="sign-up-grid">
          <div class="input-group">
            <input class="data-input" name="email" type="text" placeholder="" />
            <label class="data-label" for="Email">Email</label>
          </div>
          <div class="input-group">
            <input class="data-input" name="user" type="text" placeholder="" />
            <label class="data-label" for="user">Username</label>
          </div>
          <div class="input-group">
            <input class="data-input" name="firstname" type="text" placeholder="" />
            <label class="data-label" for="firstname">First Name</label>
          </div>
          <div class="input-group">
            <input class="data-input" name="lastname" type="text" placeholder="" />
            <label class="data-label" for="lastname">Last Name</label>
          </div>
          <div class="input-group">
            <input class="data-input" name="pass" type="text" placeholder="" />
            <label class="data-label" for="pass">Password</label>
          </div>
          <div class="input-group">
            <input class="data-input" name="verifpass" type="text" placeholder="" />
            <label class="data-label" for="verifpass">Verify Password</label>
          </div>
        </div>
        <button class="form-button">Sign Up</button>
      </form>
    </div>
    <div class="form-container sign-in-container" id="sign-in-container">
      <form class="login-form">
        <h2>Login</h2>
        <div class="input-group">
          <input class="data-input" name="user" type="text" placeholder="" />
          <label class="data-label" for="user">User / email</label>
        </div>
        <div class="input-group">
          <input class="data-input" name="pass" type="text" placeholder="" />
          <label class="data-label" for="pass">Password</label>
        </div>
        <button class="form-button">Sign In</button>
      </form>
    </div>
    <div class="overlay-container">
      <div class="overlay">
        <div class="overlay-panel overlay-left">
          <h1>Welcome Back!</h1>
          <p>To keep connected with us please login with your personal info</p>
          <button class="ghost" id="signIn">Sign In</button>
        </div>
        <div class="overlay-panel overlay-right">
          <h1>Don't have an account yet?</h1>
          <p>Enter your personal details and start journey with us</p>
          <button class="ghost" id="signUp">Sign Up</button>
        </div>
      </div>
    </div>
  </section>
  <script type="module" src="./js/login.js"></script>
</body>

</html>