// Custom JS

document.addEventListener("DOMContentLoaded", function() {

  // lazy load images and fade in elements

  var lazyloadImages;
  var fadeinElements;

  if ("IntersectionObserver" in window) {

    lazyloadImages = document.querySelectorAll(".lazy");
    fadeinElements = document.querySelectorAll(".fade-in");

    var observerCallback = function(entries, observer) {
      entries.forEach(function(entry) {
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

    lazyloadImages.forEach(function(image) {
      imageObserver.observe(image);
    });

    fadeinElements.forEach(function(element) {
      fadeInObserver.observe(element);
    });

  } else {  

    var lazyloadThrottleTimeout;
    lazyloadImages = document.querySelectorAll(".lazy");
    fadeinElements = document.querySelectorAll(".fade-in");
    
    function lazyload () {
      if(lazyloadThrottleTimeout) {
        clearTimeout(lazyloadThrottleTimeout);
      }    

      lazyloadThrottleTimeout = setTimeout(function() {
        var scrollTop = window.pageYOffset;
        lazyloadImages.forEach(function(img) {
            if(img.offsetTop < (window.innerHeight + scrollTop)) {
              img.src = img.dataset.src;
              img.classList.remove('lazy');
            }
        });
        fadeinElements.forEach(function(element) {
            if(element.offsetTop < (window.innerHeight + scrollTop)) {
              element.classList.add('fade-in-active');
            }
        });
        if(lazyloadImages.length == 0 && fadeinElements.length == 0) { 
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