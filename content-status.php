<?php
/**
 * @package Memberlite
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-content">
		<?php 
			$content_archives = get_theme_mod('content_archives'); 
			if($content_archives == 'excerpt')
				the_excerpt();
			else
				the_content( __( 'Continue Reading', 'memberlite' ) ); 
		?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'memberlite' ),
				'after'  => '</div>',
			) );
		?>
		<p><a href="<?php the_permalink(); ?>" rel="bookmark"><i class="fa fa-link"></i></a></p>
		<div class="clear"></div>
	</div><!-- .entry-content -->
	<footer class="entry-footer">
		<?php if ( 'post' == get_post_type() ) : // Hide meta text for pages on Search ?>
			<?php echo memberlite_get_entry_meta($post, 'after'); ?>
		<?php endif; // End if 'post' == get_post_type() ?>

		<?php edit_post_link( __( 'Edit', 'memberlite' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->