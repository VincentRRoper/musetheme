<?php
$production_item = $args['production_item'] ?? null;
if ($production_item):
?>
    <div class="prod-cover-item-imgs-m owl-carousel">
		<?php for ($i = 0; $i < 10; $i++): ?>
			<?php if (!empty($production_item['image'.$i])): ?>
                <a class="prod-cover-item-img" href="<?php echo esc_url($production_item['image'.$i]['url']) ?>" data-lightbox="prod-cover-item-imgs<?php echo $production_item['index'] ?>" data-title="<?php echo esc_attr($production_item['image'.$i]['alt']) ?>">
                    <img src="<?php echo esc_url($production_item['image'.$i]['url']) ?>" data-slide="<?php echo $i ?>">
                </a>
			<?php endif ?>
		<?php endfor; ?>
    </div>
<?php endif ?>