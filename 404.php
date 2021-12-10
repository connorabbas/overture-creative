<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Overture_Creative
 */

get_header();
?>

	<main id="primary" class="site-main container">
		<br>
		<br>
		<div class="row">
			<div class="col-md-12 text-center">
				<h1 style="font-weight: bold; font-size: 200px; margin: 0;">404</h1>
				<p>Nothing to see here!</p>
				<a href="/"><button class="btn btn-primary">Home Page</button></a>
			</div>
		</div>
		<br><br><br>

		<!-- <section class="error-404 not-found">
			<header class="page-header">
				<h1 class="page-title"><?php //esc_html_e( 'Oops! That page can&rsquo;t be found.', 'overture-creative' ); ?></h1>
			</header>

			<div class="page-content">
				<p><?php //esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'overture-creative' ); ?></p>

					<?php
					/* get_search_form();

					the_widget( 'WP_Widget_Recent_Posts' ); */
					?>

					<div class="widget widget_categories">
						<h2 class="widget-title"><?php //esc_html_e( 'Most Used Categories', 'overture-creative' ); ?></h2>
						<ul>
							<?php
							/* wp_list_categories(
								array(
									'orderby'    => 'count',
									'order'      => 'DESC',
									'show_count' => 1,
									'title_li'   => '',
									'number'     => 10,
								)
							); */
							?>
						</ul>
					</div>

					<?php
					/* $overture_creative_archive_content = '<p>' . sprintf( esc_html__( 'Try looking in the monthly archives. %1$s', 'overture-creative' ), convert_smilies( ':)' ) ) . '</p>';
					the_widget( 'WP_Widget_Archives', 'dropdown=1', "after_title=</h2>$overture_creative_archive_content" );

					the_widget( 'WP_Widget_Tag_Cloud' ); */
					?>

			</div>
		</section> -->

	</main>

<?php
get_footer();
