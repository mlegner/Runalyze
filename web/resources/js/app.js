this.runalyze = this.runalyze || {};

(function() {

    var App = function() {
        this.init();
    },

    p = App.prototype;

    p.init = function() {
        this.addEvents();
        this.languageSelector();
        this.loginBoxView();
        this.updateSizes();
        this.toggleUserHelper();
        this.toggleLanguage();
    };

    p.addEvents = function() {
        $(window).on('scroll', $.proxy(this._onScroll, this));
        $(window).on('resize', $.proxy(this._onResize, this));
        $(document).on('keyup', $.proxy(this._onKeyUp, this));
    };

    p.languageSelector = function() {
        $('#openLanguageSelector').on('click', function(e) {
            e.preventDefault();
            $('#languageSelector').fadeIn(400);
        });
        $('#closeLanguageSelector').on('click', function(e) {
            e.preventDefault();
            $('#languageSelector').fadeOut(400);
        });
    };

    p.loginBoxView = function () {
        $('a.loginBoxChange').on('click', function(e) {
            e.preventDefault();

            var $log = $("#login"),
                $reg = $("#registerFormular"),
                $pwf = $("#forgotPassword");


//            var activeElement = $(".boxWrapper.active").attr('id');
//            console.log($(".boxWrapper.active").attr('id'));

//            $(".boxWrapper").removeClass("inactive");
            $(".boxWrapper").removeClass("active");
//            $('#' + activeElement).addClass("inactive");


            if ($(this).hasClass('reg')) {
                $reg.addClass('active');
            }
            else if ($(this).hasClass('pwf')) {
                $pwf.addClass('active');
            }
            else if ($(this).hasClass('log')) {
                $log.addClass('active');
            }
        });
    };

    p.updateSizes = function() {

    };

    p.toggleLanguage = function() {
      $('.toggleLanguage').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();

        $(this).parent().toggleClass('active');
      });
    };

    p.toggleUserHelper = function() {
      $('#userHelper a').on('click', function(e) {
          e.preventDefault();
          e.stopPropagation();

          console.log("Hello");

          var log = $("#loginWidget"),
              reg = $("#registerWidget"),
              fpw = $("#passwordWidget");

          $(".widget").removeClass("active");
          $("#userHelper a").removeClass("active");

          if ($(this).hasClass('register')) {
            if($(this).hasClass('active')){
              $(this).removeClass('active');
              reg.removeClass('active');
            }
            else{
              reg.addClass('active');
              $(this).addClass('active');
            }
          }
          else if ($(this).hasClass('pwf')) {
              pwf.addClass('active');
          }
          else if ($(this).hasClass('login')) {
            if($(this).hasClass('active')){
              $(this).removeClass('active');
              log.removeClass('active');
            }
            else{
              log.addClass('active');
              $(this).addClass('active');
            }
          }
      });
    };

    p._onScroll = function(event) {
      var scrollPosition = $(window).scrollTop();
      if( scrollPosition > 20 )
        $('.headerContent').addClass('small');
      else if( scrollPosition <= 20 )
        $('.headerContent').removeClass('small');
    };

    p._onResize = function(event) {
        this.updateSizes();
    };

    p._onKeyUp = function(event) {
        if (event.keyCode == 27){
            $('#nav').fadeOut(400);
            this.hideSearch();
        }
    };

    runalyze.App = App;

})();


$(document).ready(function() {

    /*INIT FOUNDATION SCRIPTS*/
    $(document).foundation();

    Runalyze.init();

    var app = new runalyze.App();

});
