jQuery(document).ready(function($){           
    $window =  $(window);
	var fix_menu = function() { 
		if($(window).width() > 991 && !$('body').is('.big_slider')){
		    var $menu = $('#access');
			var $menu_top_pos = parseInt($('#wrapper').css("padding-top"));
	
			$menu.prevAll().each(function() {
			   $menu_top_pos += $(this).height();
			});
			var $admin_bar_height = $('#wpadminbar').length? $('#wpadminbar').height(): 0;
		    var $offset = $window.scrollTop();
            $logo_wrap = $menu.find('.header-logo');
		    
		    if($offset  > $menu_top_pos && 
		    	(($(window).height() + $menu.height() + $menu_top_pos + 25) < $('body').height())) {
		        $menu.addClass('fix-menu');
		        $menu.css('top', $admin_bar_height + 'px');
                $widget_height = 0;
                $menu_height = $menu.find('.sf-menu').outerHeight();
                
		        $menu.next().css('margin-top', $menu.height() + 'px');
                if( $menu.hasClass( 'bottom' ) ) {
                    if($menu.find('.jma-header-right').length) {
                        $widget_height = $menu.find('.jma-header-right').outerHeight(true) + parseInt($menu.find('.jma-header-right').css( 'top' ), 10);
                    } 
                    if(!$menu.hasClass( 'slide-menu' )){
                        $menu.find('.sf-menu').css( 'margin-top', $widget_height + 'px' );
                    }else{
                        $menu.find('.sf-menu').css( 'margin-top', '' );
                    }
                }
                $logo_vert_padding = $logo_wrap.outerHeight() - $logo_wrap.height();
                $logo_wrap.find('img').css({ 'height': ($widget_height + $menu_height - $logo_vert_padding) + 'px', 'width': 'auto' });
		   }else{
		    	$menu.removeClass('fix-menu');
		        $menu.css('top', '');
		        $menu.next().css('margin-top', '');
                $menu.find('.sf-menu').css( 'margin-top', '' );
                $logo_wrap.find('img').css({ 'height': '', 'width': '' });
		    }
	    }
	};
	
	var header_adjust = function(){ 
	    var $menu = $('.header-nav');
		var header_width = $('#branding').width();		
		var $logo_height = $('.logo.header-nav .header-logo').outerHeight();
		var logo_width = $('.logo.header-nav .header-logo').outerWidth();
		var menu_width = $('.logo.header-nav ul.sf-menu').width();
		if((logo_width + menu_width) > header_width){
	    	$menu.addClass('slide-menu');
		}else{
	    	$menu.removeClass('slide-menu');
		};	
	};
	
	
	if($('#access').data('usechildsticky')){
		$window.scroll(fix_menu);
		$window.scroll(header_adjust);
		$window.load(fix_menu);
	}
	$window.load(header_adjust);
	$window.resize(header_adjust);
	
});
