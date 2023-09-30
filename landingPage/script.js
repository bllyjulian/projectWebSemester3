// let scrollCount = 0;
// let isNavbarHidden = false;

// window.addEventListener('scroll', function() {
//   let currentScrollPos = window.pageYOffset;

//   if (currentScrollPos > scrollCount) {
//     scrollCount = currentScrollPos;
//     if (scrollCount > 670) {
//       if (!isNavbarHidden) {
//         document.getElementById("navbar").style.top = "-65px";
//         isNavbarHidden = true;
//       }
//     }
//   } else {
//     scrollCount = currentScrollPos;
//     if (scrollCount) {
//       if (isNavbarHidden) {
//         document.getElementById("navbar").style.top = "0";
//         isNavbarHidden = false;
//       }
//     }
//   }
//   if (currentScrollPos >= 670 && currentScrollPos <= 1000) {
//     document.getElementById("navbar").style.backgroundColor = "white";
//   } else {
//     document.getElementById("navbar").style.backgroundColor = ""; // Reset to default
//   }
// });

let scrollCount = 0;
let isNavbarHidden = false;
let navLinks = document.querySelectorAll('.nav-kanan li a');

window.addEventListener('scroll', function() {
  let currentScrollPos = window.pageYOffset;

  if (currentScrollPos > scrollCount) {
    scrollCount = currentScrollPos;
    if (scrollCount > 670) {
      if (!isNavbarHidden) {
        document.getElementById("navbar").style.top = "-65px";
        isNavbarHidden = true;
      }
    }
  } else {
    scrollCount = currentScrollPos;
    if (scrollCount) {
      if (isNavbarHidden) {
        document.getElementById("navbar").style.top = "0";
        isNavbarHidden = false;
      }
    }
  }

  // Ubah warna teks tautan navigasi
  if (currentScrollPos >= 620 && currentScrollPos <= 1270) {
    navLinks.forEach(link => {
      link.style.color = "white";
    });
  } else {
    navLinks.forEach(link => {
      link.style.color = ""; // Reset ke warna default
    });
  }
});
