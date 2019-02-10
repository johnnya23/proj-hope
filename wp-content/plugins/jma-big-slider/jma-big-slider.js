jQuery(document).ready(function($) {

    var $window = $(window);

    function fix_big_slider() {
        window_width = $window.width();
        if (window_width > 992) {
            $('body').addClass('big_slider_wide');
            $('body').removeClass('big_slider_narrow');
            admin_bar_height = $('#wpadminbar').length ? $('#wpadminbar').outerHeight() : 0;

            $menu = $('#access');
            menu_height = $menu.outerHeight();
            top_height = $menu.hasClass('fix-menu') ? menu_height : $('#top').outerHeight() - $window.scrollTop();
            top_height = $('body').hasClass('constrict-header') ? 0 : top_height + admin_bar_height;
            window_height = $window.height();
            $site_logo = $('.site-logo');
            st_header_height = parseInt($('.site-logo').find('img').attr('height')) + parseInt($site_logo.css('padding-top'), 10) + parseInt($site_logo.css('padding-bottom'), 10);
            var available_height = window_height - st_header_height - admin_bar_height - 130; //to leave 130px at bottom for custom main
            //console.log(top_height);

            image_width = $('.jma-header-image').data('image_width');
            image_height = $('.jma-header-image').data('image_height'); //console.log(image_width);
            image_ratio = image_height / image_width;



            available_ratio = available_height / window_width;


            if ($('body').hasClass('center-vert'))
                $('#custom-main').css({
                    'margin-top': (((window_height - $('#custom-main').outerHeight()) / 2) + $('#top').outerHeight() / 2) + 'px'
                });
            else
                $('#custom-main').css({
                    'margin-top': (available_height) + 'px'
                });


            $('.jma-header-image').css({
                'top': top_height + 'px',
                'height': (available_height) + 'px'
            });
            $('.jma-header-image .nivo-directionNav').css('width', window_width + 'px');
            if (image_ratio < available_ratio) {
                $('.jma-header-image-wrap').css('width', (available_height * (1 / image_ratio)) + 'px');
            } else {
                $('.jma-header-image-wrap').css('width', image_width + 'px');
            }
        } else {
            $('body').removeClass('big_slider_wide');
            $('body').removeClass('tablet-on');
            $('body').addClass('big_slider_narrow');
            $('.image.jma-header-content').css('height', '');
            $('#custom-main').css('margin-top', '');
            $('#top').css('top', '');
            $('.jma-header-image').css({
                'width': '',
                'top': '',
                'height': ''
            });
            $('.jma-header-image .nivo-directionNav').css('width', '');
        }
    };

    // Target links to animate to their hashtags.

    $('.jma-buttons  a').on('click', function() {

        $('html, body').animate({
            scrollTop: $(this.hash).offset().top - 260
        }, 500);

        return false;
    });





    function fix_home_menu() {
        if ($window.width() > 992) {
            var $menu = $('.jma-buttons');
            $window_pos = $window.scrollTop();
            $custom_main_pos = $('#custom-main').offset();
            var admin_bar_height = $('#wpadminbar').length ? $('#wpadminbar').height() : 0;
            var top_height = $('#access').outerHeight(); //console.log($menu_pos.top);console.log($window.scrollTop());
            $li_count = $menu.find('li').size();
            $menu.find('li').css('width', (100 / $li_count) + '%');
            if (($custom_main_pos.top - $window_pos) < (top_height + admin_bar_height) + 2) {
                $menu.addClass('fix-home-menu');
                $menu.css('top', top_height + admin_bar_height);

                $menu.next().css('margin-top', $menu.height() + 'px');
            } else {
                $menu.removeClass('fix-home-menu');
                $menu.next().css('margin-top', '');
                $menu.css('top', '');
            }
        }
    };


    if ($('body').is('.big_slider')) {
        $window.resize(fix_big_slider);
        $(document).on('slide_menu', function() {

            setTimeout(fix_big_slider, 800);
        });
    }
    $window.scroll(function() {

        fix_home_menu();
        if ($('body').is('.big_slider')) {
            fix_big_slider();
        }
    });

    $window.load(function() {

        fix_home_menu();
        if ($('body').is('.big_slider')) {
            fix_big_slider();
        }
    });
});