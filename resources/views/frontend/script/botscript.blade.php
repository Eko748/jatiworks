<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.counterup/2.0.0/jquery.counterup.min.js"></script>
<script src="{{ asset('assets/js/home.js') }}"></script>
<script src="{{ asset('assets/js/navbar.js') }}"></script>
<script src="{{ asset('assets/js/owlcarousel.js') }}"></script>
<script>
  $(document).ready(function() {
      $('#beranda-carousel').owlCarousel({
          loop: true,
          margin: 10,
          responsiveClass: true,
          dots: false,
          autoplay: true,
          autoplayTimeout: 2500,
          autoplayHoverPause: true,
          responsive: {
              0: {
                  items: 1,
                  nav: false
              },
              600: {
                  items: 1,
                  nav: false
              },
              1000: {
                  items: 1,
                  nav: false,
                  loop: true
              }
          }
      });
  });
</script>
