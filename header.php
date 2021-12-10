<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Overture_Creative
 */

$themeName = wp_get_theme()->template;
$option_exists = get_option('overture-site-settings', array());

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<!-- Global site tag (gtag.js) - Google Analytics -->
	<!-- <script async src="https://www.googletagmanager.com/gtag/js?id=__YOUR_KEY__"></script>
	<script>
	window.dataLayer = window.dataLayer || [];
	function gtag(){dataLayer.push(arguments);}
	gtag('js', new Date());

	gtag('config', '__YOUR_KEY__');
	</script> -->

	<!-- Google reCaptcha -->
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> class="">
	<?php wp_body_open();?>

	<!-- <div id="page-loader-area" class="text-center row align-items-center">
		<div class="col text-center">
			<div class="lds-dual-ring"></div>
		</div>
	</div> -->
	<?php
	// Page Loader
	if($option_exists){
		$loaderType=1;
		$loaderBackground='#262626';
		$loaderColor='#fff';
		if(isset($option_exists['loaderType'])){
			if(isset($option_exists['loaderType'])){$loaderType = $option_exists['loaderType'];}
			if(isset($option_exists['loaderBackground'])){$loaderBackground = $option_exists['loaderBackground'];}
			if(isset($option_exists['loaderColor'])){$loaderColor = $option_exists['loaderColor'];}
        	require_once($_SERVER["DOCUMENT_ROOT"] .'/wp-content/plugins/overture-creative-addons/admin/page-loaders/load-'.$loaderType.'.php');
		} else{
			require_once($_SERVER["DOCUMENT_ROOT"] .'/wp-content/plugins/overture-creative-addons/admin/page-loaders/load-1.php');
		}
    }
	?>

	<div id="site-content">

	<?php
	// Load in saved menu type
    if($option_exists){
		if(isset($option_exists['menuType'])){
			$menuType = $option_exists['menuType'];
        	require_once($_SERVER["DOCUMENT_ROOT"] .'/wp-content/themes/'.$themeName.'/overture-nav-menu/layouts/'.$menuType.'.php');
		} else{
			require_once($_SERVER["DOCUMENT_ROOT"] .'/wp-content/themes/'.$themeName.'/overture-nav-menu/layouts/slidedown.php');
		}
    } else{
        require_once($_SERVER["DOCUMENT_ROOT"] .'/wp-content/themes/'.$themeName.'/overture-nav-menu/layouts/slidedown.php');
    }
    ?>

		
