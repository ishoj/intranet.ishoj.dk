
// GLOBALE VARIABLER
var countEmployees = 0;
var countContent = 0;

(function($) { 
  
  /***************************************/
  /****  D O C U M E N T   R E A D Y  ****/
  /***************************************/
  
  $(document).ready(function() {
  
    /*********************/
    /*** SET STRUCTURE ***/
    /*********************/
    function setStructure(i) {

      var windowWidth = $(window).width();

      if(windowWidth < 960) { 
        // SØGNING
        if(!i) {
          findLatestShownUgleResult("mobile");
         // console.log("Funktionen findLatestShownUgleResult(mobile) kaldt responsivt");
        }
      }
        
      if(windowWidth >= 960) { 
        if(menuStatus) {
          // MENUKNAP
          $(".header-menu").removeClass("hide-me");
          $(".header-kryds").addClass("hide-me");
          $("[data-role='mobilenav']").removeClass("animate");
          $(".arrow").removeClass("left");
          menuStatus = false;
          // SØGEBAR
          $(".arrow").removeClass("action");
        }

        
        // SØGNING
        if(!i) {
          findLatestShownUgleResult("desktop");
//          console.log("Funktionen findLatestShownUgleResult(desktop) kaldt responsivt");
          

        }
      }
    }

   /*************/
    /*** INITS ***/
    /*************/
    setStructure(1); // i = 1

    /********************/
    /*** SMART RESIZE ***/
    /********************/
    $(window).smartresize(function() {
      setStructure(0);
    });
    
    
    /************************/
    /*** KLIK PÅ MENUKNAP ***/
    /************************/
    var menuStatus = false;

    // Når der klikkes på mobilmenu-knappen
    $(".header-menu").click(function() {
      if(!menuStatus) { 
        // Hvis søgebaren er aktiv, vent med at vise mobilmenuen, indtil søgebaren er skjult
        if(searchBarStatus) {
          setTimeout(function() {      
            $(".header-menu").addClass("hide-me");
            $(".header-kryds").removeClass("hide-me");
            $("[data-role='mobilenav']").addClass("animate");
            $(".arrow").addClass("left");
            menuStatus = true;            
          }, 300);
        }
        else {
          $(".header-menu").addClass("hide-me");
          $(".header-kryds").removeClass("hide-me");
          $("[data-role='mobilenav']").addClass("animate");
          $(".arrow").addClass("left");
          menuStatus = true;
        }
        
        // SØGEBAR 
        $(".soegebar").removeClass("animate");
        $(".arrow").addClass("action");
        setTimeout(function(){
          $( ".soegebar form > div > input" ).val("");
        },300);
        searchBarStatus = false;
      }
    });	
    // Når der klikkes på skjul-mobilmenu-knappen
    $(".header-kryds").click(function() {
      if(menuStatus) {
        $(".header-menu").removeClass("hide-me");
        $(this).addClass("hide-me");
        $("[data-role='mobilenav']").removeClass("animate");
        $(".arrow").removeClass("left");
        menuStatus = false;

        // SØGEBAR
        $(".arrow").removeClass("action");
        setTimeout(function(){
          $( ".soegebar form > div > input" ).val("");
        },300);
      }
    });
      

    /************************/
    /*** KLIK PÅ SØGEKNAP ***/
    /************************/    
    var searchBarStatus = false;
    
    if($("body").hasClass("front")) { // Tilføj drupals page-klasser for de tre forsider (.front er en af dem)
       setTimeout(function(){
          $(".soegebar form input").focus();
        },300);
        searchBarStatus = true;
    }
    
    $(".header-search").click(function() {
      // NÅR DEN SKAL VISES
      if(!searchBarStatus) {
        // Hvis mobilmenuen er aktiv, vent med at vise søgebaren, indtil mobilmenuen er skjult
        if(menuStatus) {
          setTimeout(function() {      
            $(".soegebar").addClass("animate"); 
            $(".arrow").addClass("action");
            setTimeout(function(){
              $(".soegebar form input").focus();
            },300);
            searchBarStatus = true;
          }, 300);
        }
        else {
          $(".soegebar").addClass("animate");
          $(".arrow").addClass("action");
          setTimeout(function(){
            $(".soegebar form input").focus();
          },300);
          searchBarStatus = true;
        }
        
        // MENUKNAP
        $(".header-menu").removeClass("hide-me");
        $(".header-kryds").addClass("hide-me");
        $("[data-role='mobilenav']").removeClass("animate");
        $(".arrow").removeClass("left");
        // FJERN SØGERESULTATER
        $(".soegeresultat").remove();
        $(".soegeresultat").removeClass("show");
		menuStatus = false;
      }
      // NÅR DEN SKAL SKJULES
      else {
        $(".soegebar").removeClass("animate");
        $(".arrow").removeClass("action");
        setTimeout(function(){
          $( ".soegebar form input" ).val("");
        },300);      
        searchBarStatus = false;
      }
    }); 
  
  
  
    /***************************/
  
  
  
  

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

// NEW FUNCTION TO TEST IF USER DONE TYPING
   
var typingTimer;                //timer identifier
var doneTypingInterval = 500;  //time in ms, 5 second for example

//on keyup, start the countdown
$('#soegefelt').keyup(function(){
    clearTimeout(typingTimer);
    if ($('#soegefelt').val) {
        typingTimer = setTimeout(function(){
        var v = $("#soegefelt").val();
      if(searchString == v){
        return false;
      }
      searchString = v;
      getSearchResultsval(v);
      //   $('#soegefelt').blur();
        }, doneTypingInterval);
    }
});

      
$("#sogeformen").submit(function(e){
    $('#soegefelt').blur();
    return false;
});      

   
    // VISER SØGERESULTATER
    function getSearchResultsval(val) {
      if(val.length < 2) { // Min. to tegn, før der foretages en søgning 
      return false;
    }            
  var indholdantal = 0;  
  var searchstartholder = '<div class="container"><div class="row search-results show">';
  var indholdstart = '<h2 class="indhold">Indhold <span title="0 søgeresultater">0</span></h2><ul class="search-content">';
  var indholdslut = '</ul>';
var secstart = '<div class="container"><div class="row"><div class="grid-half medarbejdere">Medarbejdere <span title="7 søgeresultater">7</span></div><div class="grid-half indhold">Indhold <span title="1200 søgeresultater">1200</span></div></div></div>';     
      
     var strindhold = '';
    var jqxhr = $.getJSON( "/search/search.php?query=" + encodeURIComponent(val), function() {
       
      })
        .done(function(dataindhold) {
      var resultLimitindhold = 12;  
  
      indholdantal = dataindhold.hits.total; 
      countContent = dataindhold.hits.total;
    
         
    
         $.each(dataindhold.hits.hits, function( ital, itemdata ) {
	
        strindhold += '<li><a href="' + itemdata._source.url + '" titel="' + itemdata._source.title + '" alt="' + itemdata._source.field_os2web_base_field_summary_value + '" ><span class="navn">' + itemdata._source.title + '</span></a></li>';

	//strindhold += '<li><a href="' + itemdata._source.url + '" titel="' + itemdata._source.title + '"><span class="navn">' + itemdata._source.title + '</span></a><div class="details" style="display:none;"><span class="beskrivelse">' + itemdata._source.field_os2web_base_field_summary_value + '</span><a href="" title=""><span class="kategori"><span>' + itemdata._source.title + '</span></span></a></div></li>';  
          });    
      
// MEDARBEJDERE RENDER
         var medarbejderstartantal = '';
     var medarbejderslutantal = '';
     var medarbejderfundet  = '';
      var medantal = 0; 
      medantal = dataindhold.hits2.total;
      countEmployees = dataindhold.hits2.total;
            //Log search    
           if (countEmployees >= countContent) {
             _paq.push(['trackSiteSearch',val,"users",countEmployees]);
            } else {
             _paq.push(['trackSiteSearch',val,"content",countContent]);     
            }
         
      medarbejderstartantal =   '<h2 class="medarbejdere action">Medarbejdere <span title="' + medantal + ' søgeresultater">' + medantal + '</span></h2><ul class="search-employees show">';
      medarbejderslutantal   = '</ul></div>';       
            
	  var resultLimit = 12;
      var kaldenavnet = '';
      var afdeling = '';
      var stilling  = '';
      var foto = "";
      var telefon = "";
     var email = "";
       
     $.each(dataindhold.hits2.hits2, function( i, item ) {
           
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
        if (item._source.field_fotolink != '') {
              
         foto = '<div class="foto"><a class="foto" href="' + item._source.url  + '" titel="' + kaldenavnet + '"><img src="' + '/sites/default/files/styles/profilfoto_lille/public/pictures/' + item._source.field_fotolink + '" alt="' + kaldenavnet + '"><span class="optaget"></span></a></div>';
        //    foto = '<div class="foto"><a class="foto" href="' + item._source.url  + '" titel="' + kaldenavnet + '"><img src="' + '/sites/default/files/pictures/' + item._source.field_fotolink + '" alt="' + kaldenavnet + '"><span class="optaget"></span></a></div>';
          } else {
foto = '<div class="foto"><a class="foto" href="' + item._source.url  + '" titel="' + kaldenavnet + '"><img src="/sites/all/themes/ishoj/dist/img/sprites-no/nopic.png" alt="' + kaldenavnet + '"><span class="optaget"></span></a></div>';  
          }
          } else {
foto = '<div class="foto"><a class="foto" href="' + item._source.url  + '" titel="' + kaldenavnet + '"><img src="/sites/all/themes/ishoj/dist/img/sprites-no/nopic.png" alt="' + kaldenavnet + '"><span class="optaget"></span></a></div>';  
          }
        
          // telefon
          if (item._source.field_direkte_telefon != null) {
            telefon = '<span class="telefon"><a href="tel:' + item._source.field_direkte_telefon + '">' + item._source.field_direkte_telefon + '</a></span><br>';
          
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
      $(".medarbejdere span").html(medantal);
        $(".indhold span").html(indholdantal);
          // Hvis der er flere end 12 søgeresultater
          if(showMoreResults && dataindhold.hits2.hits2.length > 12) {       
            moreResultsWasShown = 1;
     
            $(".search-more .grid-full").append("<p><a class=\"btn btn-large btn-outline flere-resultater\" href=\"\search/"+ $(".soegebar form input").val()+"\">Der er flere resultater</a></p>");
            
            
//            Waypoint.destroyAll();
            
            setTimeout(function(){
              
              initWaypointSearch();
//              // Indlæs flere søgeresultater medarbejdere 
//              if($(".soegebar-faner").hasClass("medarbejdere") && countEmployees > 12) {
//                console.log("Hest: " + countEmployees);
//                var waypoints = $(".search-employees").waypoint({
//                  handler: function(direction) {
//                    if (direction === 'down') {
//                      console.log("BUNDEN ER NÅET - MEDARBEJDER ")
//                    }
//                  },
//                  offset: 'bottom-in-view'
//                });
//              }
//              // Indlæs flere søgeresultater indhold 
//              if($(".soegebar-faner").hasClass("indhold") && countContent > 12) {
//                console.log("Hest indhold: " + countContent);
//                var waypoints = $(".search-content").waypoint({
//                  handler: function(direction) {
//                    if (direction === 'down') {
//                      console.log("BUNDEN ER NÅET - INDHOLD ")
//                    }
//                  },
//                  offset: 'bottom-in-view'
//                });
//              }
            },500);
            
//            Waypoint.refreshAll();
            
          
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
            
     
    }
    
  
    // WAYPOINTS TIL SØGNING
    function initWaypointSearch() {

      Waypoint.destroyAll();

      // Indlæs flere søgeresultater medarbejdere 
      if($(".soegebar-faner").hasClass("medarbejdere") && countEmployees > 12) {

      //  console.log("Hest medarbejder: " + countEmployees);
        var waypoints = $(".search-employees").waypoint({
          handler: function(direction) {
            if (direction === 'down') {
              console.log("BUNDEN ER NÅET - MEDARBEJDER ")
            }
          },
          offset: 'bottom-in-view'
        });

      }

      // Indlæs flere søgeresultater indhold 
      if($(".soegebar-faner").hasClass("indhold") && countContent > 12) {

   //     console.log("Hest indhold: " + countContent);
        var waypoints = $(".search-content").waypoint({
          handler: function(direction) {
            if (direction === 'down') {
              console.log("BUNDEN ER NÅET - INDHOLD ")
            }
          },
          offset: 'bottom-in-view'
        });
      }

      Waypoint.refreshAll();

    }
  
  
  
  
  
  /***********************************/
  
  
      /**** SØGEVARIABLER ****/
    var hasEmployees = 0,
        hasContent   = 0,
        latestShown  = "";
    
    
//    function showUgleResults() {
//      // Hvis resultat i begge søgninger
//      if(hasEmployees && hasContent) {
//        
//        latestShown = "medarbejdere";
//      }
//      // Hvis resultat kun i medarbejder-søgning
//      if(hasEmployees && !hasContent) {
//        
//        latestShown = "medarbejdere";
//      }
//      // Hvis resultat kun i indholds-søgning
//      if(!hasEmployees && hasContent) {
//        
//        latestShown = "indhold";
//      }
//    }
    
    
    // Responsiv funktion der tjekker om hvilken søgning, der sidst er vist. Bruges når der skiftes fra mobil visning til desktop visning
    function findLatestShownUgleResult(s) {
      
      switch (s) {
          
        case "mobile":
          
          if(latestShown == "medarbejdere") {
            $(".search-results h2.medarbejdere").addClass("action");
          }
          if(latestShown == "indhold") {
            $(".search-results h2.indhold").addClass("action");
          }
          break;
          
        case "desktop":
          
          // Medarbejdere
          if(latestShown == "medarbejdere") { 
            // Desktop
            $(".soegebar-faner").removeClass("indhold").addClass("medarbejdere");
            $(".search-content").removeClass("show");
            $(".search-employees").addClass("show");
            $(".search-results h2.indhold").removeClass("action");            
          }
          // Indhold
          if(latestShown == "indhold") { 
            // Desktop
            $(".soegebar-faner").removeClass("medarbejdere").addClass("indhold");
            $(".search-employees").removeClass("show");
            $(".search-content").addClass("show");
            $(".search-results h2.medarbejdere").removeClass("action");   
             
          }
          break;
//        default:
//          default code block
      }
      
    }
    
    
    
    
    // Klik på søgeresultat-header (medarbejdere eller indhold)
        $(".soegebar-resultater").on('click', ".search-results h2", function () {
      $(this).toggleClass("action");
      
      // Medarbejdere
      if($(this).hasClass("medarbejdere")) {
        if($(this).hasClass("action")) {
          if(!$(".search-employees").hasClass("show")) {
            $(".search-employees").addClass("show");
            latestShown = "medarbejdere";
            // Desktop
            $(".soegebar-faner").removeClass("indhold").addClass("medarbejdere");        
          }
        }
        else {
          $(".search-employees").removeClass("show");
          latestShown = "medarbejdere";
        }
      }
      
      // Indhold
      if($(this).hasClass("indhold")) {
        if($(this).hasClass("action")) {
          if(!$(".search-content").hasClass("show")) {
            $(".search-content").addClass("show");
            latestShown = "indhold";
            // Desktop
            $(".soegebar-faner").removeClass("medarbejdere").addClass("indhold");   
          }
        }
        else {
          $(".search-content").removeClass("show");
          latestShown = "indhold";
        }
      }
      
    });    

    // Klik/mouseover på soegebar-faner (medarbejdere eller indhold)
    $(".soegebar-faner").on('click mouseover', ".row div", function () {
      
      // Medarbejdere
      if($(this).hasClass("medarbejdere")) {
           
       // console.log("uglen.js: " + countEmployees);
        if(!$(".soegebar-faner").hasClass("medarbejdere")) {
          // Desktop
          $(".soegebar-faner").removeClass("indhold").addClass("medarbejdere");
          $(".search-content").removeClass("show");
          $(".search-employees").addClass("show");
          // Mobil
          $(".search-results h2.medarbejdere").addClass("action");
          $(".search-results h2.indhold").removeClass("action");
          
          latestShown = "medarbejdere";
            _paq.push(['trackEvent', 'SearchTabs', 'Vis', 'Medarbejdere']);
        }
      }
      
      // Indhold
      if($(this).hasClass("indhold")) {
        if(!$(".soegebar-faner").hasClass("indhold")) {
          // Desktop
          $(".soegebar-faner").removeClass("medarbejdere").addClass("indhold");
          $(".search-employees").removeClass("show");
          $(".search-content").addClass("show");
          // Mobil
          $(".search-results h2.medarbejdere").removeClass("action");
          $(".search-results h2.indhold").addClass("action");
          
          latestShown = "indhold";
             _paq.push(['trackEvent', 'SearchTabs', 'Vis', 'Indhold']);
        }
      }
      
    });    
    
    // Scroll til toppen, når der fokus på søgefeltet, eller når der tastes i søgefeltet
    // Bruger scrollTo-plugin'et
    var soegefeltFokus = 0;
    var soegefeltIsTop = 0;
    $('#soegefelt').on({
      'focus': function() {
        if (soegefeltFokus) {
          $.scrollTo( ($(this).offset().top - 50), 300);
          soegefeltFokus = 1;
          soegefeltIsTop = 1;
        }
      },
      'blur': function() {
        if (!soegefeltFokus) {
          soegefeltFokus = 1;
          soegefeltIsTop = 0;
        }
      },
      'keyup': function() {
          $.scrollTo( ($(this).offset().top - 50), 300);
          soegefeltIsTop = 1;
      },
    });
    
    
   
  
  
  
  // MIKRO ARTIKLER
      
      $(".microArticle h3.mArticle").click(function(){
       if($(this).parent().hasClass("active")){
          _paq.push(['trackEvent', 'MicroArticle', 'Show', $(this).text()]);
          }
          else {
              _paq.push(['trackEvent', 'MicroArticle', 'Hide', $(this).text()]);
          }
      });	
  
  
    
  });
  
  
})(jQuery);  
  
  