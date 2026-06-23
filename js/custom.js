// Custom JS

document.addEventListener("DOMContentLoaded", function () {

  // lazy load images and fade in elements

  var lazyloadImages;
  var fadeinElements;

  if ("IntersectionObserver" in window) {

    lazyloadImages = document.querySelectorAll(".lazy");
    fadeinElements = document.querySelectorAll(".fade-in");

    var observerCallback = function (entries, observer) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          var element = entry.target;
          if (element.classList.contains("lazy")) {
            element.src = element.dataset.src;
            element.classList.remove("lazy");
          } else if (element.classList.contains("fade-in")) {
            element.classList.add("fade-in-active");
          }
          observer.unobserve(element);
        }
      });
    };

    var imageObserver = new IntersectionObserver(observerCallback);
    var fadeInObserver = new IntersectionObserver(observerCallback);

    lazyloadImages.forEach(function (image) {
      imageObserver.observe(image);
    });

    fadeinElements.forEach(function (element) {
      fadeInObserver.observe(element);
    });

  } else {

    var lazyloadThrottleTimeout;
    lazyloadImages = document.querySelectorAll(".lazy");
    fadeinElements = document.querySelectorAll(".fade-in");

    function lazyload() {
      if (lazyloadThrottleTimeout) {
        clearTimeout(lazyloadThrottleTimeout);
      }

      lazyloadThrottleTimeout = setTimeout(function () {
        var scrollTop = window.pageYOffset;
        lazyloadImages.forEach(function (img) {
          if (img.offsetTop < (window.innerHeight + scrollTop)) {
            img.src = img.dataset.src;
            img.classList.remove('lazy');
          }
        });
        fadeinElements.forEach(function (element) {
          if (element.offsetTop < (window.innerHeight + scrollTop)) {
            element.classList.add('fade-in-active');
          }
        });
        if (lazyloadImages.length == 0 && fadeinElements.length == 0) {
          document.removeEventListener("scroll", lazyload);
          document.removeEventListener("facetwp-loaded", lazyload);
          window.removeEventListener("resize", lazyload);
          window.removeEventListener("orientationChange", lazyload);
        }
      }, 20);
    }

    document.addEventListener("scroll", lazyload);
    document.addEventListener("facetwp-loaded", lazyload);
    window.addEventListener("resize", lazyload);
    window.addEventListener("orientationChange", lazyload);

  }
})

// lazy load video
document.addEventListener('DOMContentLoaded', function () {
  const lazyVideos = document.querySelectorAll('.lazy-video');

  const config = {
    root: null,
    rootMargin: '100px 0px',
    threshold: 0.25
  };

  const loadVideo = (video) => {
    if (video.dataset.src) {
      const source = document.createElement('source');
      source.src = video.dataset.src;
      source.type = 'video/mp4'; // You can make this dynamic if needed
      video.appendChild(source);
      video.load();
      video.play();
    }
  };

  const observer = new IntersectionObserver((entries, observer) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        const video = entry.target;
        loadVideo(video);
        observer.unobserve(video);
      }
    });
  }, config);

  lazyVideos.forEach(video => {
    observer.observe(video);
  });
});

// add scrolled class
window.addEventListener('scroll', function () {
  if (window.scrollY > 50) {
    document.body.classList.add('scrolled');
  } else {
    document.body.classList.remove('scrolled');
  }
});

// mobile nav toggle & pane
document.addEventListener('DOMContentLoaded', function () {
  const navIcon = document.getElementById('nav-icon');

  if (navIcon) {
    navIcon.addEventListener('click', function () {
      navIcon.classList.toggle('open');
      document.body.classList.toggle('nav-open');
    });
  }
});

function setMobileMenuHeight() {
  const menu = document.getElementById('mobile-menu');
  if (!menu) return;

  const rect = menu.getBoundingClientRect();
  const remainingHeight = window.innerHeight - rect.top;

  menu.style.height = `${remainingHeight}px`;
}

// Run on load and resize
window.addEventListener('DOMContentLoaded', setMobileMenuHeight);
window.addEventListener('resize', setMobileMenuHeight);