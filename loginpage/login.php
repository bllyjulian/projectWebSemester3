<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" href="../admin/assets/img/logo.png">
  <title>
    Login
  </title>
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <link id="pagestyle" href="../admin/assets/css/soft-ui-dashboard.css?v=1.0.7" rel="stylesheet" />
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
<script src="js/particles.js"></script>

<script src="js/app.js"></script>
</head>
<style>
    .input-group1 {
    position: relative;
  }
  .bb {
    position: absolute;
    right: 10px;
    top: 12px;
  }
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
 
#lupapw {
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
  border-radius: 10px;
  backdrop-filter: blur(1px);
}
 
.levelDown:hover:after{
  cursor:pointer;
  background : rgba(0,0,0,0.1);
}
#particles-js{
  position: absolute;
      top: 0;
      left: 0;
  width: 100%;
  height: 100%;
  background-color: #F8F9FA;
}
  </style>
<body>
  <div class="vh-100 d-flex align-items-center">
  <div id="particles-js"></div>
  
  <div class="container">
    <div class="row">
      <div class="col-lg-5 col-md-6 col-sm-8 col-xs-10 mx-auto">
        <div id="loginFrame" class="position-relative">

          <div id="lupapw" class="levelDown shadow bg-white card p-3">
            <h3 class="my-2">Lupa Password?</h3>
            <form action="" method="" onsubmit="" class='mx-3 my-3'>
              <div class="mb-3">
                <label class="text-lg font-weight-bold" for="email-username">Email/Username</label>
                <input type="text" class="mt-1 form-control" id="email-username" name="email-username" autocomplete="off">
              </div>
              <div class="mb-3">
                <label class="text-lg font-weight-bold" for="lpPassword">Password</label>
                <input type="email" class="mt-1 form-control" id="lpPassword" name="lpPassword" autocomplete="off">
              </div>
              <div class="mb-4">
                <label class="text-lg font-weight-bold" for="ulPassword">Ulangi Password</label>
                <input type="password" class="mt-1 form-control" id="ulPassword" name="ulPassword" autocomplete="off">
              </div>
              <div class="mb-2">
                <button class="btn btn-lg btn-primary w-100">Simpan</button>
              </div>
            </form>
          </div>
          <div id="login" class="levelUp shadow bg-white card p-3">
            <h3 class="my-2">Login</h3>
            <form method="post" action="../admin/crudphp/proses.php?aksi=login" id="formlogin" class='mx-3 my-3'>
              <div class="mb-3">
                <label class="text-lg font-weight-bold" for="user">Username</label>
                <input type="text" class="mt-2 form-control" id="user" name="user" autocomplete="off">
              </div>
              <div class="form-group">
    <label class="text-lg font-weight-bold" for="pass">Password</label>
    <div class="input-group1">
    <input type="password" class="form-control" name="pass" id="password" placeholder="" autocomplete="off">             
    <span class="bb" style="cursor: pointer;">
        <i class="fas fa-eye" id="togglePassword"></i>
    </span>
</div>


</div>

              <div class="mb-2">
                <button type="submit" class="btn btn-lg bg-gradient-primary w-100">Login</button>
              </div>

            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#formlogin').submit(function(event) {
            event.preventDefault();

            var user = $('[name="user"]').val();
            var pass = $('[name="pass"]').val();

            $.ajax({
                type: 'POST',
                url: '../admin/crudphp/proses.php?aksi=login',
                data: { user: user, pass: pass },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        Swal.fire(
                            'Login Berhasil',
                            'Selamat datang',
                            'success'
                        ).then(() => {
                            window.location.href = '../admin/pages/dashboard';
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Login Gagal',
                            text: '' + response.message,
                            footer: '<a href="">Perlu bantuan?</a>'
                        });
                    }
                },
                error: function() {

                }
            });
        });
    });
</script>

<script>
      document.getElementById("togglePassword").addEventListener("click", function() {
        const passwordInput = document.getElementById("password");
        const type = passwordInput.getAttribute("type") === "password" ? "text" : "password";
        passwordInput.setAttribute("type", type);
        this.classList.toggle("fa-eye-slash");
    });
var lupapw = document.getElementById('lupapw');
var login = document.getElementById('login');


lupapw.onclick = function(e) {
  e.target.className = e.target.className.replace('levelDown', 'levelUp');
  login.className = login.className.replace('levelUp', 'levelDown');
};

login.onclick = function(e) {
  e.target.className = e.target.className.replace('levelDown', 'levelUp');
  lupapw.className = lupapw.className.replace('levelUp', 'levelDown');
};


  /* ---- particles.js config ---- */

  particlesJS("particles-js", {

"particles": {

  "number": {

    "value": 190,

    "density": {

      "enable": true,

      "value_area": 800

    }

  },

  "color": {

    "value": "#9E1DB5"

  },

  "shape": {

    "type": "circle",

    "stroke": {

      "width": 2,

      "color": "#9E1DB5"

    },

    "polygon": {

      "nb_sides": 5

    },

    "image": {

      "src": "img/github.svg",

      "width": 100,

      "height": 100

    }

  },

  "opacity": {

    "value": 1,

    "random": false,

    "anim": {

      "enable": false,

      "speed": 1,

      "opacity_min": 0.1,

      "sync": false

    }

  },

  "size": {

    "value": 2,

    "random": true,

    "anim": {

      "enable": false,

      "speed": 40,

      "size_min": 0.1,

      "sync": false

    }

  },

  "line_linked": {

    "enable": true,

    "distance": 150,

    "color": "#F10488",

    "opacity": 1,

    "width": 1

  },

  "move": {

    "enable": true,

    "speed": 6,

    "direction": "none",

    "random": false,

    "straight": false,

    "out_mode": "out",

    "bounce": false,

    "attract": {

      "enable": false,

      "rotateX": 600,

      "rotateY": 1200

    }

  }

},

"interactivity": {

  "detect_on": "canvas",

  "events": {

    "onhover": {

      "enable": true,

      "mode": "repulse"

    },

    "onclick": {

      "enable": true,

      "mode": "push"

    },

    "resize": true

  },

  "modes": {

    "grab": {

      "distance": 440,

      "line_linked": {

        "opacity": 1

      }

    },

    "bubble": {

      "distance": 400,

      "size": 40,

      "duration": 2,

      "opacity": 8,

      "speed": 3

    },

    "repulse": {

      "distance": 150,

      "duration": 0.4

    },

    "push": {

      "particles_nb": 4

    },

    "remove": {

      "particles_nb": 2

    }

  }

},

"retina_detect": true

});

</script>
</body>
</html>