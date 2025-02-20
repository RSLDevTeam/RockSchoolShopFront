<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package rockschool
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="entry-content">
		<?php
		get_template_part( 'section-templates/section', 'flex-content' );
		get_template_part( 'section-templates/section', 'content-group' );
		get_template_part( 'section-templates/section', 'two-content' );
		the_content();
		?>
	</div><!-- .entry-content -->

	
</article><!-- #post-<?php the_ID(); ?> -->
