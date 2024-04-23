<?php
$production_item = $args['production_item'] ?? null;
if ($production_item):
	?>
    <div class="prod-cover-item prod-cover-item5">
        <div class="prod-cover-item-bg-img" style="background-image: url('<?php echo esc_url($production_item['background_image']) ?>');"></div>
        <div class="prod-cover-item-bg">
            <div class="prod-cover-padding-m"></div>
            <div class="prod-cover-item-content">
                <div class="prod-cover-item-grid prod-cover-item-grid5">
                        <div class="prod-cover-heading-col v-align-bottom"><div class="prod-cover-heading"><?php echo $production_item['heading'] ?></div></div>
                        <div class="prod-cover-txt-col v-align-bottom"><div class="prod-cover-txt"><?php echo $production_item['description'] ?></div>
                        </div>
                        <a class="v-align-bottom prod-cover-img2-col hide-m" href="<?php echo esc_url($production_item['image1']['url']) ?>" data-lightbox="prod-cover-imgs5" data-title="<?php echo esc_attr($production_item['image1']['alt']) ?>"><?php if (!empty($production_item['image1'])): ?><img data-animation="fadeInDown" class="" src="<?php echo esc_url($production_item['image1']['url']) ?>" alt="<?php echo esc_attr($production_item['image1']['alt']) ?>" title="<?php echo esc_attr($production_item['image1']['alt']) ?>"><?php endif ?></a>
                        <a class="v-align-bottom prod-cover-img1-col hide-m" href="<?php echo esc_url($production_item['image2']['url']) ?>" data-lightbox="prod-cover-imgs5" data-title="<?php echo esc_attr($production_item['image2']['alt']) ?>"><?php if (!empty($production_item['image2'])): ?><img data-animation="fadeInRight" class="" src="<?php echo esc_url($production_item['image2']['url']) ?>" alt="<?php echo esc_attr($production_item['image2']['alt']) ?>" title="<?php echo esc_attr($production_item['image2']['alt']) ?>"><?php endif ?></a>
                        <a class="v-align-bottom prod-cover-img4-col hide-m" href="<?php echo esc_url($production_item['image3']['url']) ?>" data-lightbox="prod-cover-imgs5" data-title="<?php echo esc_attr($production_item['image3']['alt']) ?>"><?php if (!empty($production_item['image3'])): ?><img style="--animate-duration: 0.85s; object-position: center 16%;" data-animation="fadeInLeft" class="" src="<?php echo esc_url($production_item['image3']['url']) ?>" alt="<?php echo esc_attr($production_item['image3']['alt']) ?>" title="<?php echo esc_attr($production_item['image3']['alt']) ?>"><?php endif ?></a>
                        <a class="v-align-bottom prod-cover-img4-col hide-m" href="<?php echo esc_url($production_item['image4']['url']) ?>" data-lightbox="prod-cover-imgs5" data-title="<?php echo esc_attr($production_item['image4']['alt']) ?>"><?php if (!empty($production_item['image4'])): ?><img style="object-position: center top;" data-animation="fadeInDown" class="" src="<?php echo esc_url($production_item['image4']['url']) ?>" alt="<?php echo esc_attr($production_item['image4']['alt']) ?>" title="<?php echo esc_attr($production_item['image4']['alt']) ?>"><?php endif ?></a>
                        <a class="v-align-bottom prod-cover-img2-col hide-m" href="<?php echo esc_url($production_item['image5']['url']) ?>" data-lightbox="prod-cover-imgs5" data-title="<?php echo esc_attr($production_item['image5']['alt']) ?>"><?php if (!empty($production_item['image5'])): ?><img data-animation="fadeInUp" class="" src="<?php echo esc_url($production_item['image5']['url']) ?>" alt="<?php echo esc_attr($production_item['image5']['alt']) ?>" title="<?php echo esc_attr($production_item['image5']['alt']) ?>"><?php endif ?></a>
                        <a class="v-align-bottom prod-cover-img4-col hide-m" href="<?php echo esc_url($production_item['image6']['url']) ?>" data-lightbox="prod-cover-imgs5" data-title="<?php echo esc_attr($production_item['image6']['alt']) ?>"><?php if (!empty($production_item['image6'])): ?><img style="--animate-duration: 1s; object-position: center 18%;"  data-animation="fadeInLeft" class="" src="<?php echo esc_url($production_item['image6']['url']) ?>" alt="<?php echo esc_attr($production_item['image6']['alt']) ?>" title="<?php echo esc_attr($production_item['image6']['alt']) ?>"><?php endif ?></a>
                        <a class="v-align-bottom prod-cover-img4-col hide-m" href="<?php echo esc_url($production_item['image7']['url']) ?>" data-lightbox="prod-cover-imgs5" data-title="<?php echo esc_attr($production_item['image7']['alt']) ?>"><?php if (!empty($production_item['image7'])): ?><img style="object-position: center 19%;" data-animation="fadeInUp" class="" src="<?php echo esc_url($production_item['image7']['url']) ?>" alt="<?php echo esc_attr($production_item['image7']['alt']) ?>" title="<?php echo esc_attr($production_item['image7']['alt']) ?>"><?php endif ?></a>
                        <?php echo get_template_part('template-parts/template-production/production-cover-mobile-arrow-top') ?>
                </div>
				<?php echo get_template_part('template-parts/template-production/production-cover-mobile-slider', null, ['production_item' => $production_item]) ?>
            </div>
        </div>

    </div>
<?php endif ?>