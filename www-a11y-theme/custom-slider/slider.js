jQuery(document).ready(function ($) {
  var slideIndex = 0;
  showSlides(slideIndex);

  function showSlides(n) {
      var slides = $('.slide');
      var bullets = $('.slider-bullet');

      if (n >= slides.length) {
          slideIndex = 0;
      } else if (n < 0) {
          slideIndex = slides.length - 1;
      } else {
          slideIndex = n;
      }

      slides.hide().removeClass('active');
      slides.eq(slideIndex).fadeIn().addClass('active');

      bullets.removeClass('active');
      bullets.filter('[data-index="' + slideIndex + '"]').addClass('active');
  }

  $('.slider-bullet').click(function () {
      var bulletIndex = $(this).data('index'); // Pega o índice do bullet pelo atributo data-index
      showSlides(bulletIndex);
  });

  setInterval(function () {
      slideIndex++;
      showSlides(slideIndex);
  }, 5000);
});
