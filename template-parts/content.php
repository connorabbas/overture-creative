<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Overture_Creative
 */

?>
<div class="col-md-4">
	<div class="card shadow" style="margin-bottom: 30px;">
		<img
		src="<?php echo get_the_post_thumbnail_url();?>"
		class="card-img-top"
		alt="..."
		/>
		<div class="card-body">

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> style="margin: 0 !important;">
				<header class="entry-header">
					<?php
					if ( is_singular() ) :
						the_title( '<h1 class="entry-title">', '</h1>' );
					else :
						the_title( '<h5 class="entry-title card-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h5>' );
					endif;

					if ( 'post' === get_post_type() ) :
						?>
						<div class="entry-meta">
							<p class="card-text">
							<?php
							overture_creative_posted_on();
							//overture_creative_posted_by();
							?>
							</p>
						</div><!-- .entry-meta -->
					<?php endif; ?>
				</header><!-- .entry-header -->
			</article><!-- #post-<?php the_ID(); ?> -->
		</div>
	</div>
</div>
