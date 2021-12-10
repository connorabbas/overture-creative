<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Overture_Creative
 */

?>
		<footer id="pageFooter" class="site-footer">
			<div class="container">
				<div class="row" style="padding-bottom: 30px !important;">
					<div class="col-md-4"></div>
					<div class="col-md-4"></div>
					<div class="col-md-4">
						<div class="bottomMenu">
							<?php 
								wp_nav_menu(
									array(
										'theme_location' => 'secondary',
										'menu_id'        => 'footer-menu',
									)
								);
							?>
						</div>
					</div>
				</div>
			</div>
		</footer>
	</div><!-- #page from header -->
	<button onclick="topFunction()" id="goToTop" title="Go to top" style="display:none"><i class="ion ion-md-arrow-up"></i></button>
</div><!-- #site-content from header -->

<script>
	// fade on load and link click
	jQuery(document).ready(function() {
		jQuery('#primary-menu li.menu-item a').each(function(){
			jQuery(this).addClass('fade-link');
		});
		jQuery('.bottomMenu li.page_item a').each(function(){
			jQuery(this).addClass('fade-link');
		});

		jQuery('#site-content').css('display', 'none');
		jQuery('#site-content').fadeIn(500);
		jQuery('#page-loader-area').fadeOut(500);

		jQuery('.fade-link').click(function(event) {
			/* event.preventDefault();
			newLocation = this.href;
			jQuery('#site-content').fadeOut(350, newpage); */
			//jQuery('#site-content').fadeOut(350);
			jQuery('#page-loader-area').fadeIn(500);
		});
		function newpage() {
			window.location = newLocation;
		}
	});

	jQuery(window).bind("pageshow", function(event) {
		if (event.originalEvent.persisted) {
			jQuery('#page-loader-area').fadeOut(500);
		}
	});


	// Scroll To Top Button
	window.onscroll = function() {scrollFunction()};
	function scrollFunction() {
		if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
			jQuery('#goToTop').fadeIn();
		} else {
			jQuery('#goToTop').fadeOut();
		}
	}
	function topFunction() {
		document.body.scrollTop = 0;
		document.documentElement.scrollTop = 0;
	}
</script>

<?php 

wp_footer(); 

?>

</body>
</html>
