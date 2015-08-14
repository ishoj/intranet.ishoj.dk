/****************************/
/****  AF THOMAS MIKKEL  ****/
/****    tho@ishoj.dk    ****/
/****************************/

(function($) {
  
  /***************************************/
  /****  D O C U M E N T   R E A D Y  ****/
  /***************************************/
  
  $(document).ready(function() {


      
      var sStart = '<div class="view view-aktiviteter view-id-aktiviteter"><div class="view-filters"><p></p></div><div class="view-content">';
      var sEnd   = '</div></div>';
      var s      = '';

      
      

//    <div class="swiper-slide fix-width">
//      <div class="date">30. jun</div>
//      <div class="circle"><div></div></div>
//      <div class="description">
//        <ul>
//          <li><h3><a href="/moede-i-ishoej-byraad?d=0" title="Møde i Ishøj Byråd">Møde i Ishøj Byråd</a></h3>Kl. 09.15, Ishøj Rådhus (Byrådssalen)</li>      
//          <li><h3><a href="/25-aars-jubilaeum?d=0" title="25 års jubilæum">25 års jubilæum</a></h3>Kl. 12.00, Kantinen på rådhuset</li>  
//        </ul>
//      </div>
//    </div>


      
      
      
      
      // http://api.jquery.com/jQuery.getJSON/
      // Assign handlers immediately after making the request, and remember the jqxhr object for this request
      // JSON-parser: http://jsonviewer.stack.hu/
      var json_url = "/sites/all/themes/ishoj/templates/hent_aktivitetskalender_json.php";
      var jqxhr = $.getJSON( json_url, function() {
        console.log( "success" );
      })
        .done(function(data) {
          console.log( "second success\n\n" );

          var datoArr = [];
          
          function checkDato(item) {
            for (var i = 0; i < datoArr.length; i++) {
              if (item == datoArr[i]) {
                return false;
              }
            }
            datoArr.push(item);
            return true;
          }

          var aktiveDato = "";
          
          $.each(data, function( i, item ) {
            if (checkDato(item.displaydato)) {

              s += '<div class="swiper-slide fix-width">';
                s += '<div class="date">' + item.displaydato + '</div>';
                s += '<div class="circle"><div></div></div>';
                s += '<div class="description">';
                  s += '<ul>';
//                    s += '<li><h3><a href="' + item.url + '" title="' + item.title + '">' + item.title + '</a></h3>Kl. ' + item.klokkeslaet + ', ' + item.aktivitetssted + '</li>';
                    aktiveDato = item.displaydato;
                    $.each(data, function( j, item ) {
//                      if(j > 0) {
                        if(item.displaydato == aktiveDato) {
                          s += '<li><h3><a href="' + item.url + '" title="' + item.title + '">' + item.title + '</a></h3>Kl. ' + item.klokkeslaet + ', ' + item.aktivitetssted + '</li>';
                        } 
//                      }
                        
  //                    s += "<li>" + j + "</li>";
                    });


                  s += '</ul>';
                s += '</div>';
              s += '</div>';
              
            }

          });
          
          $(".aktivitetsside .swiper-wrapper").append(sStart + s + sEnd); 

        })
        .fail(function() {
          console.log( "error" );
        })
        .always(function() {
          console.log( "complete" );
        });


      


  });

  
  /*********************************/
  /****  W I N D O W   L O A D  ****/
  /*********************************/
  
  $(window).load(function() {

 

  });

  
})(jQuery);








