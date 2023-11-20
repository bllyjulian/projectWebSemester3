<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/logo.png">
  <title>
    Daftar Akun
  </title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link id="pagestyle" href="../assets/css/soft-ui-dashboard.css?v=1.0.7" rel="stylesheet" />
  <!-- Nepcha Analytics (nepcha.com) -->
  <!-- Nepcha is a easy-to-use web analytics. No cookies and fully compliant with GDPR, CCPA and PECR. -->
  <script defer data-site="YOUR_DOMAIN_HERE" src="https://api.nepcha.com/js/nepcha-analytics.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <style>
    body {
      font-family: 'Open Sans', serif;
    }
    .form-control {
      font-family: 'Open Sans', serif;
  height:48px;
}
#loginFrame {
  max-width : 420px;
  width:100%;
  margin:0 auto;
}
#login {
  cursor:pointer;
}
.levelUp {z-index : 9;transform : translateX(32px) translateY(32px);transition:all 300ms linear;}
.levelDown {z-index : 8;transform : translateX(-32px) translateY(-32px);transition:all 300ms linear;}
 
#signup {
  width:100%;
  position:absolute;
}
 
.levelDown:after {
  position:absolute;
  content:" ";
  width:100%;
  height:100%;
  left:0;
  top:0;
  background : rgba(0,0,0,0.7);
  border-radius:4px;
  backdrop-filter: blur(3px);
}
 
.levelDown:hover:after{
  cursor:pointer;
  background : rgba(0,0,0,0.1);
}
  </style>
</head>
<body>
<div class="vh-100 d-flex align-items-center">
  <div class="container">
    <div class="row">
      <div class="col-lg-5 col-md-6 col-sm-8 col-xs-10 mx-auto">
        <div id="loginFrame" class="position-relative">
          <div id="signup" class="levelDown shadow bg-white card p-3">
            <h3 class="my-2">Lupa Password</h3>
            <form action="" method="" onsubmit="" class='mx-3 my-3'>
              <div class="mb-3">
                <label class="text-lg font-weight-bold" for="fullname">Email/Username</label>
                <input type="text" class="mt-1 form-control" id="fullname" name="fullname">
              </div>
              <div class="mb-3">
                <label class="text-lg font-weight-bold" for="email">Password</label>
                <input type="email" class="mt-1 form-control" id="email" name="email">
              </div>
              <div class="mb-4">
                <label class="text-lg font-weight-bold" for="password">Ulangi Password</label>
                <input type="password" class="mt-1 form-control" id="password" name="password">
              </div>
              <div class="mb-2">
                <button class="btn btn-lg btn-primary w-100">Simpan</button>
              </div>
            </form>
          </div>
          <div id="login" class="levelUp shadow bg-white card p-3">
            <h3 class="my-2">Login</h3>
            <form action="" method="" onsubmit="" class='mx-3 my-3'>
              <div class="mb-3">
                <label class="text-lg font-weight-bold" for="email">Username</label>
                <input type="email" class="mt-2 form-control" id="email" name="email">
              </div>
              <div class="mb-3">
                <label class="text-lg font-weight-bold" for="password">Password</label>
                <input type="password" class="mt-2 form-control" id="password" name="password">
              </div>

              <div class="mb-2">
                <button class="btn btn-lg bg-gradient-primary w-100">Login</button>
              </div>
              <div class="mt-4 text-center">
                <a href="">Forgot Password?</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
$koneksi = null;
?>
<script>
 var signup = document.getElementById('signup')
var login = document.getElementById('login')
 
signup.onclick = function(e){
  e.target.className = e.target.className.replace('levelDown','levelUp')
  login.className = login.className.replace('levelUp','levelDown')
}
 
login.onclick = function(e){
  e.target.className = e.target.className.replace('levelDown','levelUp')
  signup.className = signup.className.replace('levelUp','levelDown')
}
</script>
</body>
</html>