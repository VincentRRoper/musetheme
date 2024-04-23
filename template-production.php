<?php
/**
 * Template Name: Production
 */

get_header();
$productionItems = get_field('production_item');
$itemsCount = is_array($productionItems) ? count($productionItems) : 0;
?>
<div class="prod">
    <div class="prod-bg" <?php if (get_field('background_image')): ?>style="background-image: url('<?php echo esc_url(get_field('background_image')) ?>')"<?php endif ?>></div>
    <div class="prod-inner">
        <h1 class="page-banner-heading headline-header prod-header"><?php esc_html_e('Production', TRANSLATION_DOMAIN) ?></h1>
        <?php if ($itemsCount > 0): ?>
        <div class="prod-list">
            <!--
            <?php foreach ($productionItems as $key => $production_item): ?>
            --><div class="prod-item-box prod-item-box<?php echo $key+1 ?>">
                <div class="prod-item">
                    <div class="prod-item-img-box"><img class="prod-item-img" src="<?php echo esc_url($production_item['logo']) ?>"></div>
                </div>
                <div class="prod-item-bg"></div>
                <div class="prod-item-txt prod-item-txt<?php echo $key+1 ?>"><?php echo $production_item['heading'] ?></div>
            </div><!--
            <?php endforeach; ?>
            -->
        </div>
        <?php endif ?>
    </div>
</div>
<?php if ($itemsCount > 0): ?>
<div class="prod-covers">
    <div class="prod-cover-items owl-carousel">
	    <?php foreach ($productionItems as $key => $production_item):
           $production_item['index'] = $key;
        ?>
	    <?php echo get_template_part('template-parts/template-production/production-cover'.$production_item['template'], null, ['production_item' => $production_item]) ?>
        <?php endforeach; ?>
    </div>
    <div class="sliderscroll sliderscroll-prod" data-carousel-class="prod-cover-items">
        <div class="sliderscroll-inner">
            <?php if ($itemsCount > 1): ?>
            <i class="fa-solid fa-circle current-circle"></i>
            <?php endif ?>
            <div class="sliderscroll-arrows"></div>
            <div class="sliderscroll-points owl-dots">
            <!--
            <?php foreach ($productionItems as $production_item): ?>
            --><div class="sliderscroll-point owl-dot">
                    <i class="fa-regular fa-circle other sliderscroll-point-circle"></i><span class="sliderscroll-line"></span>
                    <div class="sliderscroll-point-tooltip"><?php echo $production_item['heading'] ?></div>
                </div><!--
            <?php endforeach; ?>
                -->
            </div>
        </div>
    </div>
    <div class="prod-cover-close">
		<?php get_template_part('assets/svg/inline', 'menu-close.svg'); ?>
    </div>
</div>
<?php endif ?>
<?php get_footer();