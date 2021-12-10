<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Overture_Creative
 */

get_header();
// multiple preformatted images
/* $id = get_the_ID();
$banner_img = get_post_meta($id, 'post_banner_img', true);	
$banner_img = explode(',', $banner_img);
if(!empty($banner_img)) {
	foreach ($banner_img as $attachment_id) {
		$imgURL = wp_get_attachment_url( $attachment_id );
		echo $imgURL;
	} 
} */
/* Start the Loop */
while ( have_posts() ) :
	the_post();
	get_template_part( 'template-parts/content/content-single' );
	?>
	<div class="container full-height-page" style="margin-top: 30px;">
		<main id="primary" class="site-main">
			<h2><?php the_title(); ?></h2>
			<br><br>
			<?php
			the_content();

			// If comments are open or there is at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}

			// Prev Next Post Nav
			the_post_navigation(
				array(
					/* translators: %s: Parent post link. */
					'prev_text' => 'Previous Post',
					'next_text' => 'Next Post',
				)
			);

			?>
		</main><!-- #main -->
	</div>
	<?php
endwhile; // End of the loop.
get_sidebar();
get_footer();
