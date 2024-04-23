<?php 


?>

<?php
$args = array(
    'post_type' => 'popup',
    'title' => $atts['title'],
    'posts_per_page'=>'-1'
     
);


$the_query = new WP_Query( $args ); ?>


<?php if ( $the_query->have_posts() ) : ?>
<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

<div class="bio-section">

<div class="bio-content">
     
<div class="bio-title"><?php the_field( 'bio'); ?></div>
<div class="bio-position"><?php the_field( 'bio_position' ); ?></div>
 <hr class="line">
<div class="desc"><?php the_field( 'bio_description' ); ?></div>
</div>
<div class="bio-image">
    <?php $bio_image = get_field( 'bio_image' ); ?>
<?php if ( $bio_image ) : ?>
	<img class="circular_image" src="<?php echo esc_url( $bio_image['url'] ); ?>" alt="<?php echo esc_attr( $bio_image['alt'] ); ?>" />
<?php endif; ?>
</div>
 <hr class="line-m">
<div class="desc-m"><?php the_field( 'bio_description' ); ?></div>
<div class="logo-section"><img class=" wp-image-1479 aligncenter" src="https://muse.rankmediadev.com/wp-content/uploads/2022/10/Muse-favicon-512x512-1.png" alt="" width="29" height="44" /></div>
</div>
<?php endwhile; ?>

    <?php wp_reset_postdata(); ?>
     
    <?php endif; ?>
   

