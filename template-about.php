<?php
/**
 * Template Name: About
 */

get_header();

$content = '';
while(have_posts()):
	$content = apply_filters('the_content', get_the_content());
    break;
endwhile;
$heroImage = muse_get_random_hero_image();
?>
<script>
    document.getElementsByTagName('body')[0].onload = initDocumentSmoothScroll();
</script>
<div class="about-container">
    <div class="page-banner about-banner">
        <img class="page-banner-img" src="<?php echo $heroImage ?>">
        <div class="page-banner-text">
            <h1 class="page-banner-heading headline-header"><?php the_field('banner_heading') ?></h1>
            <div class="page-banner-txt">
                <?php the_field('banner_sub_heading') ?>
            </div>
        </div>
    </div>
    <div class="about-inner clearfix">
        <div class="about-inner-col about-content">
            <?php echo $content ?>
        </div>
        <?php if (have_rows('team')): ?>
        <div class="about-inner-col about-sidebar">
            <div class="about-persons">
                <!--
                <?php while(have_rows('team')): the_row(); ?>
                --><div class="about-person-box"><div class="about-person">
				 <img class="<?php echo esc_attr(the_sub_field('popup')) ?>" src="<?php echo esc_url(the_sub_field('image')) ?>">
                    <div class="about-person-tooltip">
                        <div class="about-person-name"><?php the_sub_field('name') ?></div>
                        <div class="about-person-position"><?php the_sub_field('position') ?></div>
                    </div>
                </div></div><!--
                <?php endwhile; ?>
                -->
            </div>
        </div>
        <?php endif ?>
    </div>
</div>

<?php get_footer();