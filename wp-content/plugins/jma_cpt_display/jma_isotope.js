jQuery(window).load(function() {

    /* Put any theme-specific JS here...
	 *
	 *
	 * to start with default class
  $container.isotope({ filter: '.first' });
  $('.filters').find("[data-filter='.first']").addClass('is-checked'); */

    var $container = jQuery('#jma-cpt-grid-inner').isotope({
        itemSelector: '.jma-column',
        layoutMode: 'fitRows'
    });
    // bind filter button click
    jQuery('.filters').on('click', '.trigger', function() {
        var filterValue = jQuery(this).attr('data-filter').substring(1);
        $container.isotope({
            filter: '.' + filterValue
        });
    });

    jQuery('.taxonomies').on('click', '.trigger', function() {
        var filterValue = jQuery(this).attr('data-filter');
        $container.isotope({
            filter: '*'
        });
    });

});
jQuery(document).ready(function($) {
    // change is-checked class on buttons
    jQuery('#all-buttons').each(function(i, buttonGroup) {
        var $buttonGroup = jQuery(this);
        $buttonGroup.on('click', '.trigger', function() {
            if ($(this).parents('.taxonomies').length) {
                $buttonGroup.find('.is-checked').removeClass('is-checked');
            } else {
                $buttonGroup.find('.filters').find('.is-checked').removeClass('is-checked');
            }

            jQuery(this).addClass('is-checked');
        });
    });


    jQuery('.taxonomies').each(function(i, parentGroup) {
        var $taxButton = jQuery(this);
        $taxButton.on('click', '.trigger', function() {
            $clicked = jQuery(this);
            if (!$clicked.hasClass('is-checked')) {
                jQuery('.terms').animate({
                    'height': 0,
                    'margin-bottom': 0
                }, 100);
                currentClass = $clicked.data('tax');
                $currentClass = jQuery('.' + currentClass);
                $autoheight = $currentClass.css('height', 'auto').outerHeight();
                $currentClass.animate({
                    'height': $autoheight + 'px',
                    'margin-bottom': '15px'
                }, 300);
            }
        });
    });



});