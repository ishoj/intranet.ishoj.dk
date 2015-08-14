/**
 * @file
 * jquery.tabindex.js
 */

(function($)  {
  $(function(){
    var tabindex = 1;
    $('a,select').each(function() {
      if (this.type != "hidden") {
        var $input = $(this);
        $input.attr("tabindex", tabindex);
        tabindex++;
      }
    });
  });
})(jQuery);
