/* Load jQuery.
--------------------------*/
(function(jQuery){
  Drupal.behaviors.awesome = {
    attach: function (context, settings) {
      // Your custom JavaScript goes inside this function...
      jQuery('.mobile-menu', context).click(function () {
        jQuery(this).next('.primary-menu-wrapper').toggleClass('active-menu');
      });
      jQuery('.close-mobile-menu', context).click(function () {
        jQuery(this).closest('.primary-menu-wrapper').toggleClass('active-menu');
      });
      // Full page search.
      jQuery('.search-icon').on('click', function() {
        jQuery('.search-box').addClass('open');
        return false;
      });
    
      jQuery('.search-box-close').on('click', function() {
        jQuery('.search-box').removeClass('open');
        return false;
      });
    
      // Scroll To Top.
      jQuery(window).scroll(function () {
        if (jQuery(this).scrollTop() > 80) {
          jQuery('.scrolltop').fadeIn('slow');
        } else {
          jQuery('.scrolltop').fadeOut('slow');
        }
      });
      jQuery('.scrolltop').click(function () {
        jQuery('html, body').animate( { scrollTop: 0 }, 'slow');
      });
    }
  };
})(jQuery);
