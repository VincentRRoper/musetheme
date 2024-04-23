<?php
/**
 * Template Name: Home page
 */

get_header();
$currentSlides = get_field('current_slides');
$currentSlidesCount = $currentSlides ? count($currentSlides) : 0;
?>
    <div class="video-container">
        <div class="video-bg" style="background: url('<?php echo esc_url(get_field('background_image')) ?>') no-repeat top center;background-size: cover;"></div>
        <div class="video-bg video-bg--blur" style="background: url('<?php echo esc_url(get_field('background_image_blurred')) ?>') no-repeat top center;background-size: cover;"></div>
        <div class="video-cover" style=""></div>
        <video id="video-homepage" class="lazy" autoplay="autoplay" loop playsinline muted>
            <source data-src="<?php echo esc_url(get_field('video')) ?>" type="video/mp4">
        </video>
    </div>
    <div class="home-sections full-container owl-carousel" id="home-sections">
        <section class="container home-section video-section">
            <div class="content">
                <div class="home-rotate-m">
                    <img src="<?php echo esc_url(get_field('rotate_mobile_icon')) ?>">
                    <div class="home-rotate-m-txt"><?php the_field('rotate_mobile_text') ?></div>
                </div>
            </div>
            <div class="headline">
                <div class="headline-container">
                    <h1 class="headline-header"><?php the_field('sizzle_heading') ?></h1>
	                <?php if (get_field('sizzle_sub_heading')): ?>
                    <h3 class="headline-sub-header"><?php the_field('sizzle_sub_heading') ?></h3>
                    <?php endif ?>
                </div>
            </div>
        </section>

        <section class="container home-section current-section" >
                  <div class="content">
                <?php if ($currentSlides): ?>
                <div class="current-slides"><div class="current-slides-inner owl-carousel">
                    <?php foreach ($currentSlides as $key => $slide):
                        $slideImg = $slide['image'];
                        ?>
                    <div class="current-slide">
                        <div class="current-slide-inner" data-slide="<?php echo $key ?>" data-img="<?php echo esc_url($slideImg) ?>" style="background-image: -moz-linear-gradient(180deg, #00000000 0%, #0000002E 63%, #000000b4 90%, #000000e2 100%), url('<?php echo esc_url($slideImg) ?>'); background-image: -webkit-linear-gradient(180deg, #00000000 0%, #0000002E 63%, #000000b4 90%, #000000e2 100%), url('<?php echo esc_url($slideImg) ?>'); background-image: -o-linear-gradient(180deg, #00000000 0%, #0000002E 63%, #000000b4 90%, #000000e2 100%), url('<?php echo esc_url($slideImg) ?>'); background-image: -ms-linear-gradient(180deg, #00000000 0%, #0000002E 63%, #000000b4 90%, #000000e2 100%), url('<?php echo esc_url($slideImg) ?>'); background-image: linear-gradient(180deg, #00000000 0%, #0000002E 63%, #000000b4 90%, #000000e2 100%), url('<?php echo esc_url($slideImg) ?>');">
                        </div>
                        <div class="current-slide-title">
                            <?php if (!empty($slide['small_title'])): ?>
                                <div class="current-slide-title--small"><?php echo $slide['small_title']?></div>
                            <?php endif ?>
                            <?php echo $slide['title']?>
                        </div>
                        <div class="current-slide-content" data-scrollbar>
                            <?php echo $slide['hover_text'] ?>
                        </div>
                        <div class="current-slide-arrow current-slide-arrow--prev"></div>
                        <div class="current-slide-arrow current-slide-arrow--next"></div>

                    </div>
                    <?php endforeach; ?>
                </div></div>
                <?php endif ?>
	            <?php if ($currentSlidesCount > 0): ?>
                    <div class="sliderscroll sliderscroll-current" data-carousel-class="current-slides-inner">
                        <div class="sliderscroll-inner">
				            <?php if ($currentSlidesCount > 1): ?>
                                <i class="fa-solid fa-circle current-circle"></i>
				            <?php endif ?>
                            <div class="sliderscroll-arrows"></div>
                            <div class="sliderscroll-points owl-dots">
                                <!--
                            <?php for ($i = 0; $i < $currentSlidesCount; $i++): ?>
                            --><div class="sliderscroll-point owl-dot">
                                    <i class="fa-regular fa-circle other sliderscroll-point-circle"></i><span class="sliderscroll-line"></span>
                                </div><!--
                            <?php endfor; ?>
                            -->
                            </div>
                        </div>
                    </div>
	            <?php endif ?>
            </div>
            <div class="content">
                <?php if ($currentSlides): ?>
                <div class="current-slides"><div class="current-slides-inner owl-carousel">
                    <?php foreach ($currentSlides as $key => $slide):
                        $slideImg = $slide['image'];
                        ?>
                    <div class="current-slide">
                        <div class="current-slide-inner" data-slide="<?php echo $key ?>" data-img="<?php echo esc_url($slideImg) ?>" style="background-image: -moz-linear-gradient(180deg, #00000000 0%, #0000002E 63%, #000000b4 90%, #000000e2 100%), url('<?php echo esc_url($slideImg) ?>'); background-image: -webkit-linear-gradient(180deg, #00000000 0%, #0000002E 63%, #000000b4 90%, #000000e2 100%), url('<?php echo esc_url($slideImg) ?>'); background-image: -o-linear-gradient(180deg, #00000000 0%, #0000002E 63%, #000000b4 90%, #000000e2 100%), url('<?php echo esc_url($slideImg) ?>'); background-image: -ms-linear-gradient(180deg, #00000000 0%, #0000002E 63%, #000000b4 90%, #000000e2 100%), url('<?php echo esc_url($slideImg) ?>'); background-image: linear-gradient(180deg, #00000000 0%, #0000002E 63%, #000000b4 90%, #000000e2 100%), url('<?php echo esc_url($slideImg) ?>');">
                        </div>
                        <div class="current-slide-title">
                            <?php if (!empty($slide['small_title'])): ?>
                                <div class="current-slide-title--small"><?php echo $slide['small_title']?></div>
                            <?php endif ?>
                            <?php echo $slide['title']?>
                        </div>
                        <div class="current-slide-content" data-scrollbar>
                            <?php echo $slide['hover_text'] ?>
                        </div>
                        <div class="current-slide-arrow current-slide-arrow--prev"></div>
                        <div class="current-slide-arrow current-slide-arrow--next"></div>

                    </div>
                    <?php endforeach; ?>
                </div></div>
                <?php endif ?>
	            <?php if ($currentSlidesCount > 0): ?>
                    <div class="sliderscroll sliderscroll-current" data-carousel-class="current-slides-inner">
                        <div class="sliderscroll-inner">
				            <?php if ($currentSlidesCount > 1): ?>
                                <i class="fa-solid fa-circle current-circle"></i>
				            <?php endif ?>
                            <div class="sliderscroll-arrows"></div>
                            <div class="sliderscroll-points owl-dots">
                                <!--
                            <?php for ($i = 0; $i < $currentSlidesCount; $i++): ?>
                            --><div class="sliderscroll-point owl-dot">
                                    <i class="fa-regular fa-circle other sliderscroll-point-circle"></i><span class="sliderscroll-line"></span>
                                </div><!--
                            <?php endfor; ?>
                            -->
                            </div>
                        </div>
                    </div>
	            <?php endif ?>
            </div>
            <div class="headline">
                <div class="headline-container">
                    <h1 class="headline-header"><?php the_field('current_heading') ?></h1>
	                <?php if (get_field('current_sub_heading')): ?>
                    <h3 class="headline-sub-header"><?php the_field('current_sub_heading') ?></h3>
                    <?php endif ?>
                </div>
            </div>
        </section>

        <section class="container home-section news-section">
            <div class="content">
                <div class="news-items" data-scrollbar>
                <?php while(have_rows('news_item')): the_row(); ?>
                <div class="news-item">
                    <div class="news-item-date"><?php echo the_sub_field('date') ?></div>
                    <div class="news-item-content">
                        <div class="news-item-headline"><h3><?php echo the_sub_field('heading') ?></h3></div>
                        <div id="item<?php echo get_row_index() ?>" class="news-item-body"><?php echo the_sub_field('content') ?></div>
                    </div>
                    <div class="news-item-opener">
                        <a href="javascript:void(0)">
                            <span class="expand"><span class="hide-m"><i><?php esc_html_e('Read article', TRANSLATION_DOMAIN) ?> &gt;</i></span><span class="hide show-m"><?php esc_html_e('more', TRANSLATION_DOMAIN) ?> &gt;&gt;</span></span>
                            <span class="collapse"><span class="hide-m"><i><?php esc_html_e('Close', TRANSLATION_DOMAIN) ?></i><i class="close-ico fa fa-angle-up"></i></span><span class="hide show-m">&lt;&lt; <?php esc_html_e('collapse', TRANSLATION_DOMAIN) ?></span></span>
                        </a>
                    </div>
                </div>
                <?php endwhile; ?>
                </div>
            </div>
            <div class="headline">
                <div class="headline-container">
                    <h1 class="headline-header"><?php the_field('news_heading') ?></h1>
	                <?php if (get_field('news_sub_heading')): ?>
                    <h3 class="headline-sub-header"><?php the_field('news_sub_heading') ?></h3>
                    <?php endif ?>
                </div>
            </div>
        </section>
    </div>
    <div class="sliderscroll sliderscroll-home" data-carousel-class="home-sections">
        <div class="sliderscroll-inner">
            <i class="fa-solid fa-circle current-circle"></i>
            <div class="sliderscroll-arrows"></div>
            <div class="sliderscroll-points owl-dots">
                <div class="sliderscroll-point owl-dot">
                    <i class="fa-regular fa-circle other sliderscroll-point-circle"></i><span class="sliderscroll-line"></span>
                </div><!--
                --><div class="sliderscroll-point owl-dot">
                    <i class="fa-regular fa-circle other sliderscroll-point-circle"></i><span class="sliderscroll-line"></span>
                </div><!--
                --><div class="sliderscroll-point owl-dot">
                    <i class="fa-regular fa-circle other sliderscroll-point-circle"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="soundswitch soundswitch-home off"><i class="fa-solid fa-volume-xmark off-icon"></i><i class="fa-solid fa-volume-up on-icon"></i></div>
<script>
    var owlHomeInitialized = false,
        owlCurrentInitialized = false
    ;
    jQuery('.home-sections').first().on('initialized.owl.carousel',function() {
        if (!owlHomeInitialized) {
            initSmoothScrollH();
        }
        owlHomeInitialized = true;
    })
    jQuery('.current-slides-inner').first().on('initialized.owl.carousel',function() {
        if (!owlCurrentInitialized) {
            initSmoothScrollHCurrent();
        }
        owlCurrentInitialized = true;
    })
//    initSmoothScrollHCurrent
</script>
<?php get_footer();