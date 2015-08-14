/**
 * @file
 * jquery.sbselect.js
 */

if ("undefined" !== typeof($j)) {
  $j(document).ready(function($) {
    $('ul.sb-list').each(function(){

      var list = $(this),
      select = $(document.createElement('select')).addClass('sb-select').insertBefore($(this).hide());

      $('>li a', this).each(function(){
        //var target=$(this).attr('target'),
        var option = $(document.createElement('option'))
        .appendTo(select)
        .val(this.href)
        .addClass('sb-option')
        .html($(this).html());
      });

      list.remove();
    });


    var $select = $('.sb-select');

    if ($.browser.msie) {
      $select.prepend("<option value=''></option>").val('');
    }

    var onClick = function(e) {
      if (e.target.nodeName == "OPTION") {
        window.location.href = $(this).parent().find('option:selected').val();
      }
    };

    var onChange = function () {
      window.location.href = $(this).parent().find('option:selected').val();
    };

    var onKeyDown = function (e) {
      $select.off('change');
      var keyCode = e.keyCode || e.which;

      if(keyCode === 13) {
        $select.on('change', onChange).change();
      }
    };

    $select.on('change', onChange)
    .on('keydown', onKeyDown)
    .on('click', onClick);

    jQuery('.sb-select').yaselect();
    jQuery('#edit-os2web-meetings-tax-committee').yaselect();
  });
}
