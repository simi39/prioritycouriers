var App = function () {
	
    function handleIEFixes() {
        //fix html5 placeholder attribute for ie7 & ie8
       /* console.log("IE:"+navigator.userAgent.toUpperCase().indexOf('MSIE'));
        var ua = window.navigator.userAgent;
        var msie = ua.indexOf("MSIE ");
    
        if (msie > 0) // If Internet Explorer, return version number
        {
            alert(parseInt(ua.substring(msie + 5, ua.indexOf(".", msie))));
        }
        else  // If another browser, return 0
        {
            alert('otherbrowser');
        }*/
        /*
        Below code is commented by smita because it was affecting when existing 
        dropdown list of addresses were appearing in address page */
        /*
        if (jQuery.browser.msie && jQuery.browser.version.substr(0, 1) < 9) { // ie7&ie8
            jQuery('input[placeholder], textarea[placeholder]').each(function () {
                var input = jQuery(this);

                jQuery(input).val(input.attr('placeholder'));

                jQuery(input).focus(function () {
                    if (input.val() == input.attr('placeholder')) {
                        input.val('');
                    }
                });

                jQuery(input).blur(function () {
                    if (input.val() == '' || input.val() == input.attr('placeholder')) {
                        input.val(input.attr('placeholder'));
                    }
                });
            });
        }*/
    }

    function handleBootstrap() {
        $('.carousel').carousel({
            interval: 15000,
            pause: 'hover'
        });
        $('.tooltips').tooltip();
        $('.popovers').popover();
    }

    function handleMisc() {
        jQuery('.top').click(function () {
            jQuery('html,body').animate({
                scrollTop: jQuery('body').offset().top
            }, 'slow');
        }); //move to top navigator
    }

    function handleSearch() {    
        jQuery('.search').click(function () {
			//jQuery('.search-open').fadeIn(500);
			
		   if(jQuery('.search-btn').hasClass('t_n_t')){
                jQuery('.search-open').fadeIn(500);
                jQuery('.search-btn').removeClass('t_n_t');
                
            } else {
                jQuery('.search-open').fadeOut(500);
                jQuery('.search-btn').addClass('t_n_t');
               
            } 
		
        }); 
    }

    function handleSwitcher() {    
        var panel = $('.style-switcher');

        $('.style-switcher-btn').click(function () {
            $('.style-switcher').show();
        });

        $('.theme-close').click(function () {
            $('.style-switcher').hide();
        });
        
        $('li', panel).click(function () {
            var color = $(this).attr("data-style");
            var data_header = $(this).attr("data-header");
            setColor(color, data_header);
            $('.unstyled li', panel).removeClass("theme-active");
            $(this).addClass("theme-active");
        });

        var setColor = function (color, data_header) {
            $('#style_color').attr("href", "assets/css/themes/" + color + ".css");
            if(data_header == 'light'){
                $('#style_color-header-1').attr("href", "assets/css/themes/headers/header1-" + color + ".css");
                $('#logo-header').attr("src", "assets/img/logo1-" + color + ".png");
                $('#logo-footer').attr("src", "assets/img/logo2-" + color + ".png");
            } else if(data_header == 'dark'){
                $('#style_color-header-2').attr("href", "assets/css/themes/headers/header2-" + color + ".css");
                $('#logo-header').attr("src", "assets/img/logo2-" + color + ".png");
                $('#logo-footer').attr("src", "assets/img/logo2-" + color + ".png");
            }
        }
    }

    return {
        init: function () {
            handleBootstrap();
            handleIEFixes();
            handleMisc();
            handleSearch();
            handleSwitcher();
        },

        initSliders: function () {
            $('#clients-flexslider').flexslider({
                animation: "slide",
                easing: "swing",
                animationLoop: true,
                itemWidth: 1,
                itemMargin: 1,
                minItems: 1,
                maxItems: 1,
                controlNav: false,
                directionNav: false,
                move: 2
            });
            
            $('#photo-flexslider').flexslider({
                animation: "slide",
                controlNav: false,
                animationLoop: false,
                itemWidth: 80,
                itemMargin: 0
            }); 
            
            $('#testimonal_carousel').collapse({
                toggle: false
            });
        },

        initFancybox: function () {
            jQuery(".fancybox-button").fancybox({
            groupAttr: 'data-rel',
            prevEffect: 'none',
            nextEffect: 'none',
            closeBtn: true,
            helpers: {
                title: {
                    type: 'inside'
                    }
                }
            });
        },

        initBxSlider: function () {
            $('.bxslider').bxSlider({
                minSlides: 3,
                maxSlides: 3,
                slideWidth: 360,
                slideMargin: 10
            });            
        },

        initBxSlider1: function () {
            $('.bxslider').bxSlider({
                minSlides: 4,
                maxSlides: 4,
                slideWidth: 360,
                slideMargin: 10
            });            
        }

    };
}();