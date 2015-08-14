(function($) {
  
  /***************************************/
  /****  D O C U M E N T   R E A D Y  ****/
  /***************************************/
  
$(document).ready(function() {

      /****************************/
    /**** VIS SØGERESULTATER ****/
    /****************************/

    var searchString = "";
    var showMoreResults = true;
    var moreResultsWasShown = false;

    function searchChanged(val){
      if(searchString == val){
        return false;
      }
    }

// NEW FUNCTION TO TEST IF USER DONE 
/*      //setup before functions
var typingTimer;                //timer identifier
var doneTypingInterval = 500;  //time in ms, 5 second for example

//on keyup, start the countdown
$('#in').keyup(function(){
    clearTimeout(typingTimer);
    if ($('#in').val) {
        typingTimer = setTimeout(function(){
            //do stuff here e.g ajax call etc....
             var v = $("#in").val();
             $("#out").html(v);
        }, doneTypingInterval);
    }
});
*/
      
    // NÅR DER INDTASTES I SØGEFELTET
//    $( ".soegebar form > div > input" ).keyup(function() {
    $( ".soegebar form input" ).keyup(function() {
      if(searchString == $(this).val()){
        return false;
      }
      searchString = $(this).val();
      getSearchResultsval($(this).val());
    });
      
    // NÅR DER SUBMITTES (KLIK PÅ ENTER-TASTEN ELLER PÅ SUBMIT-KNAPPEN)
    $( ".soegebar form" ).submit(function( event ) {
      event.preventDefault();
 window.location.href = "/search/" + $(".soegebar form input").val();
    });

    // FJERNER SØGERESULTATER
    function removeSearchResults(i) {
 console.log( "removeSearchResults" + i);
      }
        
  
   
    // VISER SØGERESULTATER
    function getSearchResultsval(val) {
      if(val.length < 2) { // Min. to tegn, før der foretages en søgning 
        removeSearchResults(1);
        return false;
    }            
         var indholdantal = 0;  
  var searchstartholder = '<div class="container"><div class="row search-results show">';
  var indholdstart = '<h2 class="indhold">Indhold <span title="0 søgeresultater">0</span></h2><ul class="search-content">';
  var indholdslut = '</ul>';
var secstart = '<div class="container"><div class="row"><div class="grid-half medarbejdere">Medarbejdere <span title="7 søgeresultater">7</span></div><div class="grid-half indhold">Indhold <span title="1200 søgeresultater">1200</span></div></div></div>';     
       
     var strindhold = '';
         var medarbejderstartantal = '';
        var medarbejderslutantal = '';
         var medarbejderfundet  = '';
      
        var jqxhr = $.getJSON( "/search/search.php?query=" + encodeURIComponent(val), function() {
       
      })
        .done(function(dataindhold) {
      var resultLimitindhold = 12;  
  
      indholdantal = dataindhold.hits.total;   
        
    
         $.each(dataindhold.hits.hits, function( ital, itemdata ) {
	   
         strindhold += '<li><a href="' + itemdata._source.url + '" titel="' + itemdata._source.title + '"><span class="navn">' + itemdata._source.title + '</span></a><div class="details"><span class="beskrivelse">' + itemdata._source.field_os2web_base_field_summary_value + '</span><a href="" title=""><span class="kategori"><span>' + itemdata._source.title + '</span></span></a></div></li>';

	  
          });    
            
      
   
        })
        .fail(function() {
        })
        .always(function() {
        });
            
        
        // START SØG MEDARBEJDER        
    
  
     
     
     
      var jqxhr = $.getJSON( "/search/searchmedarbejder.php?query=" + encodeURIComponent(val), function() {
       // console.log( "success" );
      })
        .done(function(data) {
         
var medantal = 0; 
      medantal = data.hits.total;
      medarbejderstartantal =   '<h2 class="medarbejdere action">Medarbejdere <span title="' + medantal + ' søgeresultater">' + medantal + '</span></h2><ul class="search-employees show">';
      medarbejderslutantal   = '</ul></div>';       
            
	  var resultLimit = 12;
      var kaldenavnet = '';
      var afdeling = '';
      var stilling  = '';
      var foto = "";
      var telefon = "";
     var email = "";
       
        $.each(data.hits.hits, function( i, item ) {
           
      if (i < resultLimit) {
            if (item._source.field_kaldenavn != null) {
            kaldenavnet =  item._source.field_kaldenavn;
            } else {
            kaldenavnet = item._source.field_fornavn + ' ' + item._source.field_efternavn;
            }
        //  console.log(kaldenavnet);
          if (item._source.field_titel_stilling_name != null) {
            stilling = '<a href="' + item._source.url  + '" titel="' + item._source.field_titel_stilling_name + '"><span class="titel">' + item._source.field_titel_stilling_name + '</span></a><br>';
          } else {
          stilling  = '<span class="titel">Stilling ikke angivet</span><br>';
          }
          if (item._source.field_afdeling_name != null) {
            afdeling = '<a href="" titel="' + item._source.field_afdeling_name + '"><span class="afdeling">' + item._source.field_afdeling_name + '</span></a><br>';
          } else {
          afdeling = '<span class="afdeling">Afdeling ikke angivet<br></span>';
          }
          if (item._source.field_fotolink != null) {
        
         foto = '<div class="foto"><a class="foto" href="' + item._source.url  + '" titel="' + kaldenavnet + '"><img src="' + '/sites/default/files/pictures/' + item._source.field_fotolink + '" alt="' + kaldenavnet + '"><span class="optaget"></span></a></div>';
          
          } else {
foto = '<div class="foto"><a class="foto" href="' + item._source.url  + '" titel="' + kaldenavnet + '"><img src="http://intranet.ishoj.bellcom.dk/sites/all/themes/ishoj/dist/img/sprites-no/nopic.png" alt="' + kaldenavnet + '"><span class="optaget"></span></a></div>';  
          }
        
          // telefon
          if (item._source.field_direkte_telefon != null) {
            telefon = '<span class="telefon">' + item._source.field_direkte_telefon + '</span><br>';
          } else {
          telefon  = '<span class="telefon">Telefon ikke angivet</span><br>';
          }
          // mail 
          if (item._source.mail != null) {
          email = '<a href="mailto:' + item._source.mail + '" titel="Send en mail til ' + kaldenavnet + '"><span class="email">' + item._source.mail + '</span></a>';
          } else {
          email  = '<a href="#" titel="E-mail ikke angivet"><span class="email">E-mail ikke angivet</span></a>';
          }
          medarbejderfundet += '<li><a href="' + item._source.url  + '" titel="' + kaldenavnet + '"><span class="navn">' + kaldenavnet + '</span></a>'  + foto + '<div class="details">' + stilling + afdeling + telefon + email + '</div></li>';
	    }
        });

         
             
           $(".soegebar-faner").html(secstart);
            
             $(".soegebar-resultater").html(searchstartholder + indholdstart + strindhold + indholdslut + medarbejderstartantal + medarbejderfundet + medarbejderslutantal);  
     
         //  $(".soegebar-resultater").html(searchstartholder + indholdstart + strindhold + indholdslut + sStart + s + sEnd);  
     
            $(".medarbejdere span").html(medantal);
        $(".indhold span").html(indholdantal);
          // Hvis der er flere end 12 søgeresultater
          if(showMoreResults && data.hits.hits.length > 12) {       
            moreResultsWasShown = 1;
     
            $(".search-more .grid-full").append("<p><a class=\"btn btn-large btn-outline flere-resultater\" href=\"\search/"+ $(".soegebar form input").val()+"\">Der er flere resultater</a></p>");
          
          }
     
  setTimeout(function(){
            $(".search-results").addClass("show");
            if(showMoreResults) {
              $(".search-more").addClass("show");
            }
          },10);  

        })
        .fail(function() {
       
        })
        .always(function() {
       
        });
// SLUT SØG MEDARBEJDER
        
        
    }
    
    
  });
  
  
})(jQuery);  
  
  