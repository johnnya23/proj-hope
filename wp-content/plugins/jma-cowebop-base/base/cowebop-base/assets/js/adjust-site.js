jQuery(document).ready(function($) {
    $window = $(window);

    function fix_menu() {
        //reads @media query in base.css to trigger window size change
        if (($('.copyright').css('margin-bottom') == '5px')) {
            var $menu = $('#branding').find('#access');
            var menu_top_pos = parseInt($('#wrapper').css("padding-top"));
            $logo_wrap = $menu.find('.site-logo');

            $menu.prevAll().each(function() {
                menu_top_pos += $(this).height();
            });
            var admin_bar_height = $('#wpadminbar').length ? $('#wpadminbar').height() : 0;
            var offset = $window.scrollTop();
            var menu_height = $menu.height();
            var $menu_ul = $menu.find('.sf-menu');

            if (offset > menu_top_pos &&
                (($(window).height() + menu_height + menu_top_pos + 25) < $('body').height())) {
                $menu.addClass('fix-menu');
                $menu.css({
                    'top': admin_bar_height + 'px',
                    'height': $menu.find('ul.sf-menu').find('li.level-1').find('a').outerHeight() + 'px'
                });
                widget_height = 0;

                $menu.next().css('margin-top', menu_height + 'px');
                if ($menu.hasClass('bottom')) {
                    if ($menu.find('.jma-header-right').length) {
                        widget_height = $menu.find('.jma-header-right').outerHeight(true) + parseInt($menu.find('.jma-header-right').css('top'), 10);
                    }
                    if (!$menu.hasClass('slide-menu')) {
                        $menu_ul.css('margin-top', widget_height + 'px');
                    } else {
                        $menu_ul.css('margin-top', '');
                    }
                }
                logo_vert_padding = $logo_wrap.outerHeight() - $logo_wrap.height();
                $logo_wrap.find('img').css({
                    'height': (widget_height + $menu_ul.outerHeight() - logo_vert_padding) + 'px'
                });
            } else {
                $menu.removeClass('fix-menu');
                $menu.css({
                    'top': '',
                    'height': ''
                });
                $menu.next().css('margin-top', '');
                $menu_ul.css('margin-top', '');
                $logo_wrap.find('img').css({
                    'height': $logo_wrap.find('img').attr('height') + 'px'
                });
            }
        }
    }

    function header_adjust() {
        var $menu = $('.header-nav');
        var header_width = $('#branding').width();
        var logo_width = $('.logo.header-nav .site-logo').outerWidth();
        var menu_width = $('.logo.header-nav ul.sf-menu').width();
        if ((logo_width + menu_width + 6) > header_width) {
            $menu.addClass('slide-menu');
        } else {
            $menu.removeClass('slide-menu');
        }
    }

    $window.load(function() {
        header_adjust();
        if ($('#access').data('usechildsticky')) {
            fix_menu();
        }
    });
    $window.scroll(function() {
        //do this one immediately
        if ($('#access').data('usechildsticky')) {
            fix_menu();
            header_adjust();
        }
    });

    $window.bind('baseresizeEnd', function() {
        //do something, window hasn't changed size in 500ms
        header_adjust();
    });

    $window.resize(function() {
        if (this.baseresizeTO) clearTimeout(this.baseresizeTO);
        this.baseresizeTO = setTimeout(function() {
            $(this).trigger('baseresizeEnd');
        }, 500);
    });

});