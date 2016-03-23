/****************************/
/****  AF THOMAS MIKKEL  ****/
/****    tho@ishoj.dk    ****/
/****************************/


// Debouncing ensures that exactly one signal is sent for an event that may be happening several times 
// http://paulirish.com/2009/throttled-smartresize-jquery-event-handler/
(function ($, sr) {
 
  // debouncing function from John Hann
  // http://unscriptable.com/index.php/2009/03/20/debouncing-javascript-methods/
  var debounce = function (func, threshold, execAsap) {
      var timeout;
 
      return function debounced() {
          var obj = this, args = arguments;
          function delayed () {
              if (!execAsap)
                  func.apply(obj, args);
              timeout = null; 
          };
 
          if (timeout)
              clearTimeout(timeout);
          else if (execAsap)
              func.apply(obj, args);
 
          timeout = setTimeout(delayed, threshold || 100); 
      };
  }
	// smartresize 
	jQuery.fn[sr] = function(fn){  return fn ? this.bind('resize', debounce(fn)) : this.trigger(sr); };
 
})(jQuery,'smartresize');



(function($) {
  
  /***************************************/
  /****  D O C U M E N T   R E A D Y  ****/
  /***************************************/
  
  $(document).ready(function() {

    
    


//var waypoints = $("#waypoints-trigger-medarbejder").waypoint({
//  handler: function(direction) {
//    console.log("BUNDEN ER NÅET!!!!");
//  }
////  offset: 'bottom-in-view'
//});
    
    
    /*********************/
    /*** SET STRUCTURE ***/
    /*********************/
    function setStructure(i) {

      var windowWidth = $(window).width();


      if(windowWidth >= 768) {
        // DEL PÅ SOCIALE MEDIER
        if($(".delsiden")[0]) {
          $(".delsiden").appendTo(".social-desktop");
        }
      }
      else {
        // DEL PÅ SOCIALE MEDIER
        if($(".delsiden")[0]) {            
          $(".delsiden").appendTo(".social-mobile");
        }
      }

//      if(windowWidth < 960) { 
//        // SØGNING
//        if(!i) {
//          findLatestShownUgleResult("mobile");
//          console.log("Funktionen findLatestShownUgleResult(mobile) kaldt responsivt");
//        }
//      }
//        
      if(windowWidth >= 960) { 
//        if(menuStatus) {
//          // MENUKNAP
//          $(".header-menu").removeClass("hide-me");
//          $(".header-kryds").addClass("hide-me");
//          $("[data-role='mobilenav']").removeClass("animate");
//          $(".arrow").removeClass("left");
//          menuStatus = false;
//          // SØGEBAR
//          $(".arrow").removeClass("action");
//        }

        // DEL PÅ SOCIALE MEDIER
        if($(".delsiden")[0] && !$(".sprite-printer")[0]) {
          $(".delsiden").prepend("<a class=\"sprite sprite-printer\" href=\"#\" title=\"Print siden\"><span><span class=\"screen-reader\">Print siden</span></span></a>");
        }
        
        // SØGNING
//        if(!i) {
//          findLatestShownUgleResult("desktop");
////          console.log("Funktionen findLatestShownUgleResult(desktop) kaldt responsivt");
//          
//
//        }
      }
      else {

        // DEL PÅ SOCIALE MEDIER
        if($(".sprite-printer")[0]) {
          $(".sprite-printer").remove();
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

    
    /****************/
    /*** BREAKING ***/
    /****************/
    if($(".breaking")[0]) {
      setTimeout(function (){ 
        $(".breaking").addClass("show");
      }, 200);   
    }
    $(".breaking-close").click(function(event){
      event.preventDefault();
      $(".breaking").removeClass("show");      
    });


//    /************************/
//    /*** KLIK PÅ MENUKNAP ***/
//    /************************/
//    var menuStatus = false;
//
//    // Når der klikkes på mobilmenu-knappen
//    $(".header-menu").click(function() {
//      if(!menuStatus) { 
//        // Hvis søgebaren er aktiv, vent med at vise mobilmenuen, indtil søgebaren er skjult
//        if(searchBarStatus) {
//          setTimeout(function() {      
//            $(".header-menu").addClass("hide-me");
//            $(".header-kryds").removeClass("hide-me");
//            $("[data-role='mobilenav']").addClass("animate");
//            $(".arrow").addClass("left");
//            menuStatus = true;            
//          }, 300);
//        }
//        else {
//          $(".header-menu").addClass("hide-me");
//          $(".header-kryds").removeClass("hide-me");
//          $("[data-role='mobilenav']").addClass("animate");
//          $(".arrow").addClass("left");
//          menuStatus = true;
//        }
//        
//        // SØGEBAR 
//        $(".soegebar").removeClass("animate");
//        $(".arrow").addClass("action");
////        removeSearchResults(2);  // Midlertidig deaktivering. Funktionen ligger i test.js
//        setTimeout(function(){
//          $( ".soegebar form > div > input" ).val("");
//        },300);
//        searchBarStatus = false;
//      }
//    });	
//    // Når der klikkes på skjul-mobilmenu-knappen
//    $(".header-kryds").click(function() {
//      if(menuStatus) {
//        $(".header-menu").removeClass("hide-me");
//        $(this).addClass("hide-me");
//        $("[data-role='mobilenav']").removeClass("animate");
//        $(".arrow").removeClass("left");
//        menuStatus = false;
//
//        // SØGEBAR
//        $(".arrow").removeClass("action");
////        removeSearchResults(2);  // Midlertidig deaktivering. Funktionen ligger i test.js
//        setTimeout(function(){
//          $( ".soegebar form > div > input" ).val("");
//        },300);
//      }
//    });
//      
//
//    /************************/
//    /*** KLIK PÅ SØGEKNAP ***/
//    /************************/    
//    var searchBarStatus = false;
//    
//    if($("body").hasClass("front")) { // Tilføj drupals page-klasser for de tre forsider (.front er en af dem)
////        $(".soegebar input[type=submit]").removeAttr("disabled");
//        setTimeout(function(){
//          $(".soegebar form input").focus();
//        },300);
//        searchBarStatus = true;
//    }
//    
//    $(".header-search").click(function() {
//      // NÅR DEN SKAL VISES
//      if(!searchBarStatus) {
//        // Hvis mobilmenuen er aktiv, vent med at vise søgebaren, indtil mobilmenuen er skjult
//        if(menuStatus) {
//          setTimeout(function() {      
//            $(".soegebar").addClass("animate"); 
//            $(".arrow").addClass("action");
////            $(".soegebar input[type=submit]").removeAttr("disabled");
//            setTimeout(function(){
//              $(".soegebar form input").focus();
//            },300);
//            searchBarStatus = true;
//          }, 300);
//        }
//        else {
//          $(".soegebar").addClass("animate");
//          $(".arrow").addClass("action");
////          $(".soegebar input[type=submit]").removeAttr("disabled");
//          setTimeout(function(){
//            $(".soegebar form input").focus();
//          },300);
//          searchBarStatus = true;
//        }
//        
//        // MENUKNAP
//        $(".header-menu").removeClass("hide-me");
//        $(".header-kryds").addClass("hide-me");
//        $("[data-role='mobilenav']").removeClass("animate");
//        $(".arrow").removeClass("left");
//        // FJERN SØGERESULTATER
//        $(".soegeresultat").remove();
//        $(".soegeresultat").removeClass("show");
//		menuStatus = false;
//      }
//      // NÅR DEN SKAL SKJULES
//      else {
//        $(".soegebar").removeClass("animate");
////        removeSearchResults(2);  // Midlertidig deaktivering. Funktionen ligger i test.js
//        $(".arrow").removeClass("action");
////        $(".soegebar input[type=submit]").attr("disabled","disabled");
//        setTimeout(function(){
////          $( ".soegebar form > div > input" ).val("");
//          $( ".soegebar form input" ).val("");
//        },300);      
//        searchBarStatus = false;
//      }
//    });    
    
    //////////////////////////////////////
    // VIS SØGERESULTATER INDSÆTTES HER //
    //////////////////////////////////////
      
    // Se http://stackoverflow.com/questions/15620303/trouble-animating-div-height-using-css-animation
    // og http://css3.bradshawenterprises.com/animating_height/
//    function searchBoxHeight() {
//      console.log( "soegeresultat højde: " + $(".soegeresultat").height() );
//    }
    
    
    /**********************/
    /****  SØGEFILTER  ****/
    /**********************/
//    var searchFilterString = "";
//    var newFilterOnTheWay = 0;
//    
//    var searchFilterArr = new Array('medarbejder=1', 'indholdssider=1', 'bilag=1', 'afdeling=1', 'ansvarsområder=1', 'stilling=1');
//    var searchFilterArrBool = new Array(0, 0, 0, 0, 0, 0);
//    
//    
//    // Klik på knappen 'Tilføj søgefilter'
//    $(".add-search-filter").click(function(){
//      if(!newFilterOnTheWay) {
//        newFilterOnTheWay = 1;
//        $(".add-search-filter").addClass("hide-me");
//        $(".addFilterForm").removeClass("hide-me");
//      }
//    });
//    
//    // Tilføj søgefilter til søgestreng
//    $(function() {
//      // bind change event to select
//      $("#addFilter").bind("change", function() {
//        if($(this).val() != "0") {
//          selIndex = $(this).val();
//          
//          switch (selIndex) { 
//              
//            case 'medarbejder': 
////              console.log(selIndex);
//              searchFilterArrBool[0] = 1;
//              break;
//              
//            case 'indholdssider': 
////              console.log(selIndex);
//              searchFilterArrBool[1] = 1;
//              break;
//              
//            case 'bilag': 
////              console.log(selIndex);
//              searchFilterArrBool[2] = 1;
//              break;      
//              
//            case 'afdeling': 
////              console.log(selIndex);
//              searchFilterArrBool[3] = 1;
//              break;      
//              
//            case 'ansvarsområder': 
////              console.log(selIndex);
//              searchFilterArrBool[4] = 1;
//              break;      
//              
//            case 'stilling': 
////              console.log(selIndex);
//              searchFilterArrBool[5] = 1;
//              break;
//          }
//          
//          
//          // Tilføjer "slet filter"
//          var newFilter = '<span class="remove-search-filter" data-index="' + selIndex + '"><i class="search-filter-minus" title="Slet søgefilter: ' + $(this).find(":selected").text() + '" ></i><span>' + $(this).find(":selected").text() + '</span></span>';
//          $(".filter-lines").append(newFilter);
//          
//          // Skjuler den valgte option
//          $(this).find(":selected").addClass("hide-me");
//          
//          // Viser "Tilføj filter" og skjuler select-boksen
//          $(".add-search-filter").removeClass("hide-me");
//          $(".addFilterForm").addClass("hide-me");
//          
//          // "Selecter" første option, så den er klar til næste omgang "tilføj søgefiter"
//          $("#addFilter option:first-child").attr("selected", true);
//          
//          updateSearchString();
//          newFilterOnTheWay = 0;
//          
//        }
//        return false;
//      }); 
//    });
//
//    
//    // Klik på knappen 'Slet søgefilter'
//    $(document).on('click', ".remove-search-filter", function() {
//      var selIndex = $(this).attr("data-index");
////      console.log(selIndex);
//      $(this).remove();
//      $('.addFilterForm select option[value="' + selIndex + '"]').removeClass("hide-me");
//      
//          
//      switch (selIndex) { 
//
//        case 'medarbejder': 
//          searchFilterArrBool[0] = 0;
//          break;
//
//        case 'indholdssider': 
//          searchFilterArrBool[1] = 0;
//          break;
//
//        case 'bilag': 
//          searchFilterArrBool[2] = 0;
//          break;      
//
//        case 'afdeling': 
//          searchFilterArrBool[3] = 0;
//          break;      
//
//        case 'ansvarsområder': 
//          searchFilterArrBool[4] = 0;
//          break;      
//
//        case 'stilling': 
//          searchFilterArrBool[5] = 0;
//          break;
//      }
//      
//      updateSearchString();
//    
//    });
//    
//    
//    function updateSearchString() {
//      
//      searchFilterString = "";
//      var mereEndEn = 0;
//      
//      for(i = 0; i < searchFilterArrBool.length; i++) {
//        if(searchFilterArrBool[i] == 1) {
//          if(mereEndEn > 0) {
//            searchFilterString += "&" + searchFilterArr[i];
//          }
//          else {
//            searchFilterString += searchFilterArr[i];
//          }
//          mereEndEn++;
//        }
//      }
//      
//      console.log( searchFilterString );
//    
//    }
    

//    /**** SØGEVARIABLER ****/
//    var hasEmployees = 0,
//        hasContent   = 0,
//        latestShown  = "";
//    
//    
////    function showUgleResults() {
////      // Hvis resultat i begge søgninger
////      if(hasEmployees && hasContent) {
////        
////        latestShown = "medarbejdere";
////      }
////      // Hvis resultat kun i medarbejder-søgning
////      if(hasEmployees && !hasContent) {
////        
////        latestShown = "medarbejdere";
////      }
////      // Hvis resultat kun i indholds-søgning
////      if(!hasEmployees && hasContent) {
////        
////        latestShown = "indhold";
////      }
////    }
//    
//    
//    // Responsiv funktion der tjekker om hvilken søgning, der sidst er vist. Bruges når der skiftes fra mobil visning til desktop visning
//    function findLatestShownUgleResult(s) {
//      
//      switch (s) {
//          
//        case "mobile":
//          
//          if(latestShown == "medarbejdere") {
//            $(".search-results h2.medarbejdere").addClass("action");
//          }
//          if(latestShown == "indhold") {
//            $(".search-results h2.indhold").addClass("action");
//          }
//          break;
//          
//        case "desktop":
//          
//          // Medarbejdere
//          if(latestShown == "medarbejdere") { 
//            // Desktop
//            $(".soegebar-faner").removeClass("indhold").addClass("medarbejdere");
//            $(".search-content").removeClass("show");
//            $(".search-employees").addClass("show");
//            $(".search-results h2.indhold").removeClass("action");            
//          }
//          // Indhold
//          if(latestShown == "indhold") { 
//            // Desktop
//            $(".soegebar-faner").removeClass("medarbejdere").addClass("indhold");
//            $(".search-employees").removeClass("show");
//            $(".search-content").addClass("show");
//            $(".search-results h2.medarbejdere").removeClass("action");            
//          }
//          break;
////        default:
////          default code block
//      }
//      
//    }
//    
//    
//    
//    
//    // Klik på søgeresultat-header (medarbejdere eller indhold)
//        $(".soegebar-resultater").on('click', ".search-results h2", function () {
//      $(this).toggleClass("action");
//      
//      // Medarbejdere
//      if($(this).hasClass("medarbejdere")) {
//        if($(this).hasClass("action")) {
//          if(!$(".search-employees").hasClass("show")) {
//            $(".search-employees").addClass("show");
//            latestShown = "medarbejdere";
//            // Desktop
//            $(".soegebar-faner").removeClass("indhold").addClass("medarbejdere");        
//          }
//        }
//        else {
//          $(".search-employees").removeClass("show");
//          latestShown = "medarbejdere";
//        }
//      }
//      
//      // Indhold
//      if($(this).hasClass("indhold")) {
//        if($(this).hasClass("action")) {
//          if(!$(".search-content").hasClass("show")) {
//            $(".search-content").addClass("show");
//            latestShown = "indhold";
//            // Desktop
//            $(".soegebar-faner").removeClass("medarbejdere").addClass("indhold");   
//          }
//        }
//        else {
//          $(".search-content").removeClass("show");
//          latestShown = "indhold";
//        }
//      }
//      
//    });    
//
//    // Klik/mouseover på soegebar-faner (medarbejdere eller indhold)
//    $(".soegebar-faner").on('click mouseover', ".row div", function () {
//      
//      // Medarbejdere
//      if($(this).hasClass("medarbejdere")) {
//        console.log("uglen.js: " + countEmployees);
//        if(!$(".soegebar-faner").hasClass("medarbejdere")) {
//          // Desktop
//          $(".soegebar-faner").removeClass("indhold").addClass("medarbejdere");
//          $(".search-content").removeClass("show");
//          $(".search-employees").addClass("show");
//          // Mobil
//          $(".search-results h2.medarbejdere").addClass("action");
//          $(".search-results h2.indhold").removeClass("action");
//          
//          latestShown = "medarbejdere";
//        }
//      }
//      
//      // Indhold
//      if($(this).hasClass("indhold")) {
//        if(!$(".soegebar-faner").hasClass("indhold")) {
//          // Desktop
//          $(".soegebar-faner").removeClass("medarbejdere").addClass("indhold");
//          $(".search-employees").removeClass("show");
//          $(".search-content").addClass("show");
//          // Mobil
//          $(".search-results h2.medarbejdere").removeClass("action");
//          $(".search-results h2.indhold").addClass("action");
//          
//          latestShown = "indhold";
//        }
//      }
//      
//    });    
//    
//    // Scroll til toppen, når der fokus på søgefeltet, eller når der tastes i søgefeltet
//    // Bruger scrollTo-plugin'et
//    var soegefeltFokus = 0;
//    var soegefeltIsTop = 0;
//    $('#soegefelt').on({
//      'focus': function() {
//        if (soegefeltFokus) {
//          $.scrollTo( ($(this).offset().top - 50), 300);
//          soegefeltFokus = 1;
//          soegefeltIsTop = 1;
//        }
//      },
//      'blur': function() {
//        if (!soegefeltFokus) {
//          soegefeltFokus = 1;
//          soegefeltIsTop = 0;
//        }
//      },
//      'keyup': function() {
//        console.log("\nKeyup triggered");
//          $.scrollTo( ($(this).offset().top - 50), 300);
//          soegefeltIsTop = 1;
//      },
//    });
//    
//    
//   
    
    
    
    /*************************************/
    /**** MIKROARTIKLER FRA BORGER.DK ****/
    /*************************************/
    if($(".microArticleContainer")[0]) { 
      $(".microArticle div.mArticle").hide();
      $(".microArticle > h3").prepend("<span class=\"sprites-sprite sprite-plus mikroartikel\"></span>");
      
      $(".microArticle h3.mArticle").click(function(){
          $(this).parent().find("div.mArticle").slideToggle('fast');
          if($(this).parent().hasClass("active")){
              $(this).parent().removeClass("active");
              $(this).removeClass("active");
              $(this).find("span").removeClass("sprite-minus");
          }
          else {
              $(this).parent().addClass("active");
              $(this).addClass("active");
              $(this).find("span").addClass("sprite-minus");
          }
      });		
    }
    
      
    /********************/
    /**** GOOGLE MAP ****/
    /********************/
    $(".map-btn").click(function(){
        if($("#map-canvas").hasClass("active")){
            $("#map-canvas").removeClass("active");
    $(this).text("Vis kort");
        }
        else {
            $("#map-canvas").addClass("active");
    $(this).text("Skjul kort");
        }
    });
    
    
    /********************/
    /**** DEL SIDEN ****/
    /********************/
    var popupCenter = function(url, title, w, h) {
      // Fixes dual-screen position                         Most browsers      Firefox
      var dualScreenLeft = window.screenLeft !== undefined ? window.screenLeft : screen.left;
      var dualScreenTop = window.screenTop !== undefined ? window.screenTop : screen.top;
      var width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
      var height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;
      var left = ((width / 2) - (w / 2)) + dualScreenLeft;
      var top = ((height / 3) - (h / 3)) + dualScreenTop;
      var newWindow = window.open(url, title, 'scrollbars=yes, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);
      // Puts focus on the newWindow
      if (window.focus) {
        newWindow.focus();
      }
    };
//    $(".delsiden a:not(.sprite-share, .sprite-printer)").click(function(e){
    $(".dimmer-delsiden a:not(.sprite-link, .breaking-close)").click(function(e){
      e.stopPropagation();
      popupCenter($(this).attr("href"), $(this).attr("title"), 580, 470);
      e.preventDefault();
    });  
//    $(".dimmer-delsiden a:not(.dimmer-delsiden)").click(function(e){
//      e.stopPropagation();
//      popupCenter($(this).attr("href"), $(this).attr("title"), 580, 470);
//      e.preventDefault();
//    });  
    // DEL-KNAPPEN
    $(".sprite-share").click(function(e){
      $(".dimmer-delsiden").removeClass("hidden");
      $(".dimmer-delsiden ul").addClass("show");
      e.preventDefault();
    });  
    // LINK URL-KNAPPEN
    $(".sprite-link").click(function(e){
      e.stopPropagation();
      $(".link-url").addClass("show");
      e.preventDefault();
    });  
    // URL TEKST
    $(".link-url textarea").click(function(e){
      e.stopPropagation();
      e.preventDefault();
      $(this).focus().select().toggleClass("show-bg");
    });  
    // LUK-KNAP
    $(".dimmer-delsiden .breaking-close").click(function(e){
      e.stopPropagation();
      e.preventDefault();
      $(".dimmer-delsiden").addClass("hidden").children("> ul").removeClass(".show");
      $(".dimmer-delsiden ul").removeClass("show");
      $(".link-url textarea").removeClass("show-bg");
      $(".link-url").removeClass("show");
      $(".link-url span").removeClass("show-bg");
    });  
    
    
    // DIMMER-DELSIDEN
    $(".dimmer-delsiden").click(function(e){
      $(this).addClass("hidden").children("> ul").removeClass(".show");
      $(".dimmer-delsiden ul").removeClass("show");
      $(".link-url textarea").removeClass("show-bg");
      $(".link-url").removeClass("show");
      $(".link-url span").removeClass("show-bg");
    });  
      
    /*********************/
    /**** PRINT SIDEN ****/
    /*********************/
    $(document).on('click', '.sprite-printer', function(e) { 
      window.print();
      e.preventDefault();
    });
      

    /*************************************/
    /**** ANDRE KOMMUNALE HJEMMESIDER ****/
    /*************************************/
    if ($("#hjemmesider")[0]) {
      $(function() {
        // bind change event to select
        $("#hjemmesider").bind("change", function() {
          if($(this).val() != "0") {
            selIndex = $(this).val();
            if(selIndex.substr(0,7) != 'http://'){
              selIndex = 'http://' + selIndex;
            }
            $("#hjemmesider option:first-child").attr("selected", true);
            window.location = selIndex;
          }
          return false;
        });
      });
    }

    /*******************************/
    /**** SWIPER SOCIAL-CONTENT ****/
    /*******************************/
    function findSlidesPerView(maxCol) {
      var ww = $(window).width();
      if (ww>=960) { 
        if(maxCol == 4) 
          return 4;
        if(maxCol == 3) 
          return 3;
      }
      if (ww>=640 && ww<960) {
        return 2;
      }
      if (ww<640) { 
        return 1;
      }
    } 
    function findSpaceBetween() {
      var ww = $(window).width();
      if (ww>=960) { 
          return 42;
      }
      if (ww>=640 && ww<960) {
        return 24;
      }
      if (ww<640) { 
        return 12;
      }
    }
    function initSwiper() {
      // Init swipers
      // Social content
      if ($(".swiper-container-social-content")[0]) {
        var socialContentSwiper = new Swiper ('.swiper-container-social-content', {
          direction: 'horizontal',
          loop: false,
          spaceBetween: 1,
          slidesPerView: findSlidesPerView(4),
          nextButton: '.swiper-button-next',
          prevButton: '.swiper-button-prev'
        });
        $(window).resize(function() { 
          socialContentSwiper.params.slidesPerView = findSlidesPerView(4);
        });
      }
      // Nyhedsliste
      if ($(".swiper-container-news")[0]) {
        var newsSwiper = new Swiper ('.swiper-container-news', {
          direction: 'horizontal',
          loop: false,
          spaceBetween: findSpaceBetween(),
          slidesPerView: findSlidesPerView(3),
          nextButton: '.news-swiper-button-next',
          prevButton: '.news-swiper-button-prev'
        });
        $(window).resize(function() { 
          newsSwiper.params.slidesPerView = findSlidesPerView(3);
          newsSwiper.params.spaceBetween  = findSpaceBetween();
        });
      }
      // TV-Ishøj Youtube 
      if ($(".swiper-container-news_tvi")[0]) {
        var news_tviSwiper = new Swiper ('.swiper-container-news_tvi', {
          direction: 'horizontal',
          loop: false,
          spaceBetween: findSpaceBetween(),
          slidesPerView: findSlidesPerView(3),
          nextButton: '.news_tvi-swiper-button-next',
          prevButton: '.news_tvi-swiper-button-prev'
        });
        $(window).resize(function() { 
          news_tviSwiper.params.slidesPerView = findSlidesPerView(3);
          news_tviSwiper.params.spaceBetween  = findSpaceBetween();
        });
      }
      // Aktiviteter
      if ($(".swiper-container-activities")[0]) {
        var activitiesSwiper = new Swiper ('.swiper-container-activities', {
          direction: 'horizontal',
          loop: false,
          spaceBetween: findSpaceBetween(),
          slidesPerView: findSlidesPerView(3),
          nextButton: '.activities-swiper-button-next',
          prevButton: '.activities-swiper-button-prev'
        });
        $(window).resize(function() { 
          activitiesSwiper.params.slidesPerView = findSlidesPerView(3);
          activitiesSwiper.params.spaceBetween  = findSpaceBetween();
        });
      }

    }
    
    initSwiper();
  
    
    // Tilføj h2 til Aktivitetsidens søgeboks
//    if($(".views-exposed-widgets")[0]) {
//      $(".views-exposed-widgets").prepend("<h2>Søg aktiviteter</h2>");
//    }
    
    // Tilføj h2 til Aktivitetsidens søgeboks
    if($(".nyhedsside")[0]) {
      $(".views-exposed-widgets").prepend("<h2>Søg nyheder</h2>");
    }
    
    // Tilføj måneds-friser til aktivitetslisten på Aktivitetessiden 
    if($(".page-taxonomy-term-3013")[0]) {
      var bgMonths = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
      var bgMonthsNames = ["jan", "feb", "mar", "apr", "maj", "jun", "jul", "aug", "sep", "okt", "nov", "dec"];
      var bgMonthsNamesFull = ["Januar", "Februar", "Marts", "April", "Maj", "Juni", "Juli", "August", "September", "Oktober", "November", "December"];
       
      $(".swiper-slide").each(function(){
        var datoText = $(this).find(".date").html();
        
        for(i = 0; i < bgMonths.length; i++) {
          if(datoText.indexOf(bgMonthsNames[i]) > -1) {
            if(bgMonths[i] == 1) {
              break;
            }
            else {
              bgMonths[i] = 1;
              console.log("Indsæt frise\n");
//              $( '<div class="swiper-slide fix-width"><div id="frise' + i + '" class="maanedsfrise ' + bgMonthsNames[i] + '" data-stellar-background-ratio="0.85"><div><div><div><h2>' + bgMonthsNamesFull[i] + '</h2></div></div></div></div></div>' ).insertBefore( $(this) );
              break; 
            }
          }
        }
        console.log($(this).find(".date").html() + "\n");
         
      });
//      $.stellar({
//        horizontalScrolling: false,
////        verticalOffset: -1400,
//        responsive: true
//      });
    }

    
    /************************/
    /**** TILFØJ INDHOLD ****/
    /************************/
    if($(".tilfoej-indhold")[0]) {
      $(".header-plus").click(function() {
        $(".tilfoej-indhold").toggleClass("show");
      });
    }

    
    
    
    /**********************/
    /**** DRUPAL FIXES ****/
    /**********************/    
  
    /* Fjerner styles-attributten på billeder, der er indsat i brødteksten. Herved kan billeder bliver skaleret responsivt via css */
    $(".artikel img").each(function(){
      if($(this).attr("style")) {
        $(this).removeAttr("style");	
      }
    });
    

    
    
    
  });

  
  /*********************************/
  /****  W I N D O W   L O A D  ****/
  /*********************************/
  
  $(window).load(function() {

    /********************/
    /**** FLEXSLIDER ****/
    /********************/
    // https://github.com/woothemes/FlexSlider/wiki/FlexSlider-Properties
    if ($(".flexslider")[0]) {

      $(".flexslider").flexslider({
  //      startAt: 0,
        animation: "slide",
        slideshowSpeed: 7000,
        prevText: "",
        nextText: ""
      });
      $(".flex-direction-nav a.flex-prev").removeClass("flex-prev").addClass("icon").addClass("flex-prev"); // swapper klasserne
      $(".flex-direction-nav a.flex-next").removeClass("flex-next").addClass("icon").addClass("flex-next");
    }


  });

  
})(jQuery);







