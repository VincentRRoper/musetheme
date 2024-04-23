<?php
/**
 * The header.
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<?php wp_head(); ?>
	<?php require('header-scripts.php'); ?>
	
</head>
<body <?php body_class(); ?>>
<?php require('body-scripts.php'); ?>
<?php wp_body_open(); ?>
<?php echo get_template_part('template-parts/main-menu') ?>
<div class="logo-container">
    <div class="logo">
        <div class="logo-bg">
            <a class="logo-imgs" href="/">
                <?php get_template_part('assets/svg/inline', 'logo-star.svg'); ?>
                <?php get_template_part('assets/svg/inline', 'logo.svg'); ?>
            </a>
        </div>
    </div>
</div>
    <div class="main-menu-toggle menu-toggler">
	    <?php get_template_part('assets/svg/inline', 'menu-hamburger.svg'); ?>
    </div>
