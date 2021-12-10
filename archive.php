<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Overture_Creative
 */

get_header();
?>
	<div class="full-height-page">
		<div class="container">
			<main id="primary" class="site-main">

				<?php if ( have_posts() ) : ?>

					<header class="page-header">
						<div class="row">
							<div class="col-md-12">
								<h1><?php echo str_replace(array('Category: ', 'Archives: '),array('', ''),get_the_archive_title()); ?></h1>
								<?php
								the_archive_description( '<div class="archive-description">', '</div>' );
								?>
							</div>
						</div>
					</header><!-- .page-header -->
					<div class="row">
						<?php
						$postCount = 0;
						/* Start the Loop */
						while ( have_posts() ) :
							the_post();
							$postCount++;
							/*
							* Include the Post-Type-specific template for the content.
							* If you want to override this in a child theme, then include a file
							* called content-___.php (where ___ is the Post Type name) and that will be used instead.
							*/
							get_template_part( 'template-parts/content', get_post_type() );
							if($postCount % 3 === 0 ){
							?>
							</div><div class="row">
							<?php
							}
						endwhile;
						?>
					</div>
					<?php

					the_posts_navigation();

				else :

					get_template_part( 'template-parts/content', 'none' );

				endif;
				?>

			</main><!-- #main -->
		</div>
	</div>

<?php
get_sidebar();
get_footer();
