<?php
/**
 * The template used for displaying page content in page.php
 */

$page_class  = 'top'; // Help to force consistency for plugins like bbPress using in non-page context
$page_class .= get_post_meta( $post->ID, '_tb_title', true ) != 'hide' ? ' has-title' : ' no-title';
$page_class .= get_the_content() ? ' has-content' : ' no-content';
$is_cowebop_base = themeblvd_get_base() == 'cowebop-base';
?>
<article id="post-<?php the_ID(); ?>" <?php post_class($page_class); ?>>
<?php if( $is_cowebop_base )jma_content_top(); ?>

	<?php 
    $use_title = true;
    $jma_images_on = false;
    if( $is_cowebop_base ) {
        $jma_spec_options = jma_get_theme_values();
        $jma_images_on = jma_images_on();
        $use_title = $jma_spec_options['title_page_top'] != 1 || $jma_spec_options['body_shape'] == 'dark_modular';
    }
    if ( (! themeblvd_get_att('epic_thumb') && get_post_meta( get_the_ID(), '_tb_title', true ) != 'hide') && $use_title ) : ?>
		<header class="entry-header">
			<h1 class="entry-title"><?php the_title(); ?></h1>
		</header><!-- .entry-header -->
	<?php endif; ?>

	<?php if ( (has_post_thumbnail() && themeblvd_get_att('thumbs') && ! themeblvd_get_att('epic_thumb') ) &&  !$jma_images_on ) : ?>
		<div class="featured-item featured-image standard popout">
			<?php themeblvd_the_post_thumbnail(); ?>
		</div><!-- .featured-item(end) -->
	<?php endif; ?>

	<div class="entry-content clearfix">
		<?php the_content(); ?>
	</div><!-- .entry-content -->

	<?php wp_link_pages( array( 'before' => '<div class="page-link">' . themeblvd_get_local('pages').': ', 'after' => '</div>' ) ); ?>
	<?php edit_post_link( themeblvd_get_local( 'edit_page' ), '<div class="edit-link"><i class="fa fa-edit"></i> ', '</div>' ); ?>
<?php if( $is_cowebop_base )jma_content_bottom(); ?>

</article><!-- #post-<?php the_ID(); ?> -->