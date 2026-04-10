//Hamburger Menu
var Menu = {
    el: {
    ham: jQuery('.menu-m'),
    menuTop: jQuery('.menu-top'),
    menuMiddle: jQuery('.menu-middle'),
    menuBottom: jQuery('.menu-bottom')
    },
    init: function() {
    Menu.bindUIactions();
    },
    bindUIactions: function() {
    Menu.el.ham
    .on(
    'click',
    function(event) {
    Menu.activateMenu(event);
    event.preventDefault();
    }
    );
    },
    activateMenu: function() {
    Menu.el.menuTop.toggleClass('menu-top-click');
    Menu.el.menuMiddle.toggleClass('menu-middle-click');
    Menu.el.menuBottom.toggleClass('menu-bottom-click'); 
    }
    };
Menu.init();


// Close navbar when click on link ( used for Landingpages )
// function closeNavbar() {
//   $(".navbar-toggler").attr("aria-expanded", "false");
//   $(".navbar-collapse").removeClass("show");
//   $(".menu-top").removeClass("menu-top-click");
//   $(".menu-middle").removeClass("menu-middle-click");
//   $(".menu-bottom").removeClass("menu-bottom-click");
//   $("body").removeClass("no-scroll");
//   $(".site").removeClass("filter-style");
//   $(".menu-menu-1-container").removeClass("act");
//   toggleScroll();
// }
// $(".navbar-collapse li a").on("click", function() {
//   closeNavbar();
// });


//For all navigation, add menu-open class on body
document.addEventListener('DOMContentLoaded', function () {
  var navbar = document.getElementById('navbarNav');

  navbar.addEventListener('show.bs.collapse', function () {
    document.body.classList.add('menu-open');
  });

  navbar.addEventListener('hide.bs.collapse', function () {
    document.body.classList.remove('menu-open');
  });
});


// var swiper = new Swiper(".mySwiper", {
//   pagination: {
//     el: ".swiper-pagination",
//   },
// });

var swiper = new Swiper(".mySwiper-boxes-section", {
  slidesPerView: 1,
  spaceBetween: 15,
  loop: true,
  autoHeight: true,
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
  breakpoints: {
    640: {
      slidesPerView: 2,
      spaceBetween: 15,
    },
    768: {
      slidesPerView: 3,
      spaceBetween: 16,
    },
    1024: {
      slidesPerView: 4,
      spaceBetween: 16,
    },
  },
});

// Calculate Header Height
jQuery(document).ready(function($) {
    function adjustPageOffset() {
        var headerHeight = $('header').outerHeight(); // Measure <header> height

        // Set the header height as a global CSS variable
        document.documentElement.style.setProperty('--header-height', headerHeight + 'px');
    }

    // Run on load
    adjustPageOffset();

    // Run again on resize (in case header height changes)
    $(window).on('resize', function() {
        adjustPageOffset();
    });
});