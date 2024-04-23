<?php
/**
 * The main template file
 */

get_header(); ?>

<?php if ( is_home() && ! is_front_page() && ! empty( single_post_title( '', false ) ) ) : ?>
    <header class="page-header alignwide">
        <h1 class="page-title"><?php single_post_title(); ?></h1>
    </header><!-- .page-header -->
<?php endif; ?>
<?php
if ( have_posts() ) {
	// Load posts loop.
	while ( have_posts() ) {
		the_post();
	}
} else {
	// If no content, include the "No posts found" template.
    ?>
    <p><?php esc_html_e( 'Nothing found', TRANSLATION_DOMAIN ); ?></p>
<?php
}

get_footer();