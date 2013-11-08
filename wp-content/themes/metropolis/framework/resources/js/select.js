/**
 *
 * Style Select
 *
 * Replace Select text
 * Dependencies: jQuery
 *
 */
(function ($) {
  styleSelect = {
    init: function () {
      $( '.select-wrapper').each(function () {
        $(this).prepend( '<span>' + $(this).find( '.thb-input option:selected').text() + '</span>' );
      });
      $( 'select.thb-input').live( 'change', function () {
        $(this).prev( 'span').replaceWith( '<span>' + $(this).find( 'option:selected').text() + '</span>' );
      });
      $( 'select.thb-input').bind($.browser.msie ? 'click' : 'change', function(event) {
        $(this).prev( 'span').replaceWith( '<span>' + $(this).find( 'option:selected').text() + '</span>' );
      }); 
    }
  };
})(jQuery);

jQuery(document).ready(function() { 
  styleSelect.init();
});