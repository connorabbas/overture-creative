<?php
/**
 * Overture Creative functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Overture_Creative
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

if ( ! function_exists( 'overture_creative_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function overture_creative_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Overture Creative, use a find and replace
		 * to change 'overture-creative' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'overture-creative', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'menu-1' => esc_html__( 'Primary', 'overture-creative' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'overture_creative_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);
	}
endif;
add_action( 'after_setup_theme', 'overture_creative_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function overture_creative_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'overture_creative_content_width', 640 );
}
add_action( 'after_setup_theme', 'overture_creative_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function overture_creative_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'overture-creative' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'overture-creative' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'overture_creative_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function overture_creative_scripts() {
	//wp_enqueue_style( 'overture-creative-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_enqueue_style( 'overture-creative-style', get_stylesheet_uri(), array(), '' );
	wp_style_add_data( 'overture-creative-style', 'rtl', 'replace' );

	wp_enqueue_script( 'overture-creative-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'overture_creative_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

// Custom Nav
function wpb_custom_new_menu() {
	register_nav_menus(
		array(
		'overture-creative' => __( 'Custom Primary Menu' ),
		'overture-creative-mobile' => __( 'Custom Mobile Menu' )
		)
	);
}
add_action( 'init', 'wpb_custom_new_menu' );

//register_nav_menus(array('primary'=>__('Primary Navigation', 'overture-creative'), 'secondary'=>__('Secondary Navigation', 'overture-creative')));

function recent_posts_sc($atts, $content = null) {
	
	global $post;
	
	extract(shortcode_atts(array(
		'cat'     => '',
		'num'     => '5',
		'order'   => 'DESC',
		'orderby' => 'post_date',
	), $atts));
	
	$args = array(
		'cat'            => $cat,
		'posts_per_page' => $num,
		'order'          => $order,
		'orderby'        => $orderby,
	);
	
	$output = '';
	
	$posts = get_posts($args);
	
	foreach($posts as $post) {
		
		setup_postdata($post);
		
		$output .= '<li><a href="'. get_the_permalink() .'">'. get_the_title() .'</a></li>';
		
	}

	$themeName = wp_get_theme()->template;
	$output .= $themeName;
	
	wp_reset_postdata();
	
	return '<ul>'. $output .'</ul>';
	
}
add_shortcode('recent_posts', 'recent_posts_sc');

// Add Meta Box to post
add_action( 'add_meta_boxes', 'multi_media_uploader_meta_box' );

function multi_media_uploader_meta_box() {
	add_meta_box( 'my-post-box', 'Preformatted Images', 'multi_media_uploader_meta_box_func', 'post', 'normal', 'high' );
	//add_meta_box( 'my-post-box', 'Preformatted Images', 'multi_media_uploader_meta_box_func', 'employee', 'normal', 'high' );
}

function multi_media_uploader_meta_box_func($post) {
	$banner_img = get_post_meta($post->ID,'post_banner_img',true);
	?>
	<style type="text/css">
		.multi-upload-medias ul li .delete-img { position: absolute; right: 3px; top: 2px; background: aliceblue; border-radius: 50%; cursor: pointer; font-size: 14px; line-height: 20px; color: red; }
		.multi-upload-medias ul li { width: 120px; display: inline-block; vertical-align: middle; margin: 5px; position: relative; }
		.multi-upload-medias ul li img { width: 100%; }
	</style>

	<table cellspacing="10" cellpadding="10">
		<tr>
			<td>Images:</td>
			<td>
				<?php echo multi_media_uploader_field( 'post_banner_img', $banner_img ); ?>
			</td>
		</tr>
	</table>

	<script type="text/javascript">
		jQuery(function($) {

			$('body').on('click', '.wc_multi_upload_image_button', function(e) {
				e.preventDefault();

				var button = $(this),
				custom_uploader = wp.media({
					title: 'Insert image',
					button: { text: 'Use this image' },
					multiple: 'add' 
				}).on('select', function() {
					var attech_ids = '';
					attachments
					var attachments = custom_uploader.state().get('selection'),
					attachment_ids = new Array(),
					i = 0;
					attachments.each(function(attachment) {
						attachment_ids[i] = attachment['id'];
						attech_ids += ',' + attachment['id'];
						if (attachment.attributes.type == 'image') {
							$(button).siblings('ul').append('<li data-attechment-id="' + attachment['id'] + '"><a href="' + attachment.attributes.url + '" target="_blank"><img class="true_pre_image" src="' + attachment.attributes.url + '" /></a><i class=" dashicons dashicons-no delete-img"></i></li>');
						} else {
							$(button).siblings('ul').append('<li data-attechment-id="' + attachment['id'] + '"><a href="' + attachment.attributes.url + '" target="_blank"><img class="true_pre_image" src="' + attachment.attributes.icon + '" /></a><i class=" dashicons dashicons-no delete-img"></i></li>');
						}

						i++;
					});

					var ids = $(button).siblings('.attechments-ids').attr('value');
					if (ids) {
						var ids = ids + attech_ids;
						$(button).siblings('.attechments-ids').attr('value', ids);
					} else {
						$(button).siblings('.attechments-ids').attr('value', attachment_ids);
					}
					$(button).siblings('.wc_multi_remove_image_button').show();
				})
				.open();
			});

			$('body').on('click', '.wc_multi_remove_image_button', function() {
				$(this).hide().prev().val('').prev().addClass('button').html('Add Images');
				$(this).parent().find('ul').empty();
				return false;
			});

		});

		jQuery(document).ready(function() {
			jQuery(document).on('click', '.multi-upload-medias ul li i.delete-img', function() {
				var ids = [];
				var this_c = jQuery(this);
				jQuery(this).parent().remove();
				jQuery('.multi-upload-medias ul li').each(function() {
					ids.push(jQuery(this).attr('data-attechment-id'));
				});
				jQuery('.multi-upload-medias').find('input[type="hidden"]').attr('value', ids);
			});
		})
	</script>

	<?php
}


function multi_media_uploader_field($name, $value = '') {
	$image = '">Add Media';
	$image_str = '';
	$image_size = 'full';
	$display = 'none';
	$value = explode(',', $value);

	if (!empty($value)) {
		foreach ($value as $values) {
			if ($image_attributes = wp_get_attachment_image_src($values, $image_size)) {
				$image_str .= '<li data-attechment-id=' . $values . '><a href="' . $image_attributes[0] . '" target="_blank"><img src="' . $image_attributes[0] . '" /></a><i class="dashicons dashicons-no delete-img"></i></li>';
			}
		}

	}

	if($image_str){
		$display = 'inline-block';
	}

	return '<div class="multi-upload-medias"><ul>' . $image_str . '</ul><a href="#" class="wc_multi_upload_image_button button' . $image . '</a><input type="hidden" class="attechments-ids ' . $name . '" name="' . $name . '" id="' . $name . '" value="' . esc_attr(implode(',', $value)) . '" />&nbsp;<a href="#" class="wc_multi_remove_image_button button" style="display:inline-block;display:' . $display . '">Remove All Images</a></div>';
}

// Save Meta Box values.
add_action( 'save_post', 'wc_meta_box_save' );

function wc_meta_box_save( $post_id ) {
	if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;	
	}

	if( !current_user_can( 'edit_post' ) ){
		return;	
	}
	
	if( isset( $_POST['post_banner_img'] ) ){
		update_post_meta( $post_id, 'post_banner_img', $_POST['post_banner_img'] );
	}
}

/* Include custom Elementor widgets */
require_once('overture-widgets.php');
function add_elementor_widget_categories( $elements_manager ) {
	$elements_manager->add_category(
		'overture-creative',
		[
			'title' => __( 'Overture Creative', 'elementor' ),
			'icon' => 'fa fa-plug',
		]
	);
}
add_action( 'elementor/elements/categories_registered', 'add_elementor_widget_categories' );
