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
        $('#login-panel a').on('click', function(e) {
            e.preventDefault();
            
            var $log = $("#login"), 
                $reg = $("#registerFormular"), 
                $pwf = $("#forgotPassword");
            
            console.log(this.id);

            if (this.id == 'reg') { $reg.show(); $log.hide(); $pwf.hide();	}
            else if (this.id == 'pwf') { $pwf.show(); $reg.hide(); $log.hide(); }
            else if (this.id == 'log') { $log.show(); $pwf.hide(); $reg.hide(); }
        });
    };
    
    p.updateSizes = function() {  
        
    };

    p._onScroll = function(event) {
        
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
    
    app = new runalyze.App();

});