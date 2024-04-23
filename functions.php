<?php
ini_set('error_log', __DIR__.'/error_log');
require get_template_directory() . '/inc/constants.php';

if ( ! function_exists( 'musetheme_setup' ) ) :
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function musetheme_setup()
    {
        register_nav_menus(
            array(
                'primary' => esc_html__('Main menu', TRANSLATION_DOMAIN),
            )
        );

        add_theme_support( 'custom-logo', array(
            'height' => 480,
            'width'  => 720,
        ) );
		add_theme_support( 'post-thumbnails' ); 
        add_theme_support('custom-background');
		add_post_type_support( 'page', ['excerpt', 'thumbnail'] );
// 		add_post_type_support( 'post', ['excerpt', 'thumbnail'] );		
		
		// Check function exists.
        if( function_exists('acf_add_options_page') ) {
            // Register options page.
            $option_page = acf_add_options_page(array(
                'page_title'    => esc_html__('Theme General Settings', TRANSLATION_DOMAIN),
                'menu_title'    => esc_html__('Theme Settings', TRANSLATION_DOMAIN),
                'menu_slug'     => 'theme-general-settings',
                'capability'    => 'edit_posts',
                'redirect'      => false
            ));
        }
	    if (is_admin()) {
		    add_filter('posts_search', 'search_by_title_only', 500, 2);
	    }
    }
endif;
add_action( 'after_setup_theme', 'musetheme_setup' );
/**
 * Enqueue scripts and styles.
 */
function musetheme_scripts() {
	$pageTemplate = basename(get_page_template());
    // Remove embed.min.js script - it's not necessary here because we don't won't to embed posts from another wordpress sites
    wp_dequeue_script( 'wp-embed' );
    wp_deregister_script( 'wp-embed' );
	// Don't load Gutenberg-related stylesheets.
	wp_dequeue_style( 'wp-block-library' ); // Wordpress core
	wp_dequeue_style( 'wp-block-library-theme' ); // Wordpress core
	wp_dequeue_style( 'wc-block-style' ); // WooCommerce
	wp_dequeue_style( 'global-styles' ); // REMOVE THEME.JSON

	/* Enqueue scripts and styles for inner pages */
	wp_enqueue_style('musetheme-owl', get_template_directory_uri() . '/assets/css/owl.carousel.min.css');
	wp_enqueue_style('musetheme-animate', get_template_directory_uri() . '/assets/css/animate.css');
	wp_enqueue_style('musetheme-lightbox', get_template_directory_uri() . '/assets/css/lightbox.min.css');
	// Add the main style.css file
	wp_enqueue_style('musetheme-style', get_stylesheet_uri(), array(), filemtime(get_stylesheet_directory().'/style.css'));

	wp_enqueue_script('font-awesome', 'https://kit.fontawesome.com/c9ec18d5e9.js', [], false, true);
	wp_enqueue_script('musetheme-jquery-mousewheel', get_template_directory_uri() . '/assets/js/jquery.mousewheel.min.js', ['jquery'], false, true);
	wp_enqueue_script('musetheme-owl', get_template_directory_uri() . '/assets/js/owl.carousel.min.js', ['jquery'], false, true);
	wp_enqueue_script('musetheme-js', get_template_directory_uri() . '/assets/js/index.js', ['musetheme-owl'], filemtime(get_stylesheet_directory() . '/assets/js/index.js'), true);
	wp_enqueue_script('musetheme-lightbox', get_template_directory_uri() . '/assets/js/lightbox.min.js', ['jquery'], false, true);
//	wp_enqueue_script('musetheme-masonry-grid', get_template_directory_uri() . '/assets/js/masonry.pkgd.min.js', ['jquery'], false, true);
}
add_action( 'wp_enqueue_scripts', 'musetheme_scripts' );

/**
 * @param $search
 * @param $wp_query
 *
 * @return string
 */
function search_by_title_only( $search, $wp_query ) {
	if (!is_admin() || empty($search)) {
		return $search;
	}
	// $wp_query was a reference
	global $wpdb;
	$q = $wp_query->query_vars;
	$n = !empty($q['exact']) ? '' : '%';
	$search = $searchand = '';
	foreach ((array) $q['search_terms'] as $term) {
		$term = esc_sql($wpdb->esc_like($term));
		$search .= "{$searchand}($wpdb->posts.post_title LIKE '{$n}{$term}{$n}')";
		$searchand = ' AND ';
	}
	$search = " AND ({$search}) ";
	if (!is_user_logged_in()) {
		$search .= " AND ($wpdb->posts.post_password = '') ";
	}
	return $search;
}

// Remove WP Emoji
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );

// Add support for Property Hive custom query_vars
add_filter( 'query_vars', 'muse_add_query_vars' );
function muse_add_query_vars( $query_vars )
{
	$query_vars[] = 'distribution_title';
	$query_vars[] = 'distribution_filter_by';
	$query_vars[] = 'distribution_filter_by_value';
	$query_vars[] = 'distribution_sort';
	$query_vars[] = 'distribution_id';
	return $query_vars;
}

add_filter( 'posts_where', 'muse_post_title_like', 10, 2 );
function muse_post_title_like( $where, $wp_query )
{
	global $wpdb;
	if ( $title = $wp_query->get( 'post_title_like' ) ) {
		$where .= " AND " . $wpdb->posts . ".post_title LIKE '%" . esc_sql( $wpdb->esc_like( $title ) ) . "%'";
	}
	return $where;
}

function muse_get_distribution_sort_params($sort = '') {
	switch ($sort) {
		case 'z-a':
			$sortBy = 'title';
			$sortOrder = 'DESC';
			break;
		case 'a-z':
		default:
			$sortBy = 'title';
			$sortOrder = 'ASC';
			break;
	}
	return ['sort_by' => $sortBy, 'sort_order' => $sortOrder];
}

/**
 * @param int    $perPage
 * @param int    $page
 * @param string $search
 * @param array  $excludeIds
 * @param string $sort
 * @param string $filterBy
 * @param string $filterVal
 * @param array $includeIds Priority list
 *
 * @return array Ids
 */
function muse_get_distributions($perPage = 10, $page = 1, $search = '', $excludeIds = [], $sort = '', $filterBy = '', $filterVal = null, $includeIds = []) {
    // Sorting is applied => ignore priority list of $includeIds
	if ($sort && $includeIds) {
		return [];
	}
	list('sort_by' => $sortBy, 'sort_order' => $sortOrder) = muse_get_distribution_sort_params($sort);
	$args = [
		'post_type' => 'type-distribution',
		'posts_per_page' => $perPage,
//		'post_title_like' => $search,
		's' => $search,
		'fields' => 'ids',
		'paged' => $page
	];
	// Don't apply sorting for $includeIds by default
	if (!$includeIds || $sort) {
		$args['orderby'] = $sortBy;
		$args['order'] = $sortOrder;
	}
	if ($excludeIds && is_array($excludeIds)) {
		$args['post__not_in'] = $excludeIds;
	}
	if ($includeIds && is_array($includeIds)) {
		// Combine post__not_in and post__in
		if (!empty($args['post__not_in'])) {
			$includeIds = array_diff($includeIds, $excludeIds);
			// If include array became empty - set invalid ID value to return empty results
			if (empty($includeIds))
				$includeIds = [-1];
		}
		$args['post__in'] = $includeIds;
	}
	if ($filterBy && $filterVal) {
		$args['meta_key'] = $filterBy;
		$args['meta_value'] = $filterVal;
	}

	$postsQuery = new WP_Query($args);
	$postIds = ($postsQuery->have_posts()) ? $postsQuery->posts : [];
	if ($includeIds && $postIds && !$sort) {
		// Save initial sorting for prioritized distributions
		foreach ($includeIds as $key => $include_id) {
			// Skip filtered values
			if (!in_array($include_id, $postIds)) {
				unset($includeIds[$key]);
			}
		}
		// Save previous order
		$postIds = $includeIds;

	}
	return $postIds;
}

function muse_get_distributions_ajax() {
	$perPage = (int) ($_POST['perPage'] ?? 0);
	$page = (int) ($_POST['page'] ?? 0);
	$search = $_POST['search'] ?? '';
	$sort = $_POST['sort'] ?? '';
	$filter = $_POST['filter'] ?? '';
	$filterVal = $_POST['filterVal'] ?? null;
	$excludeIds = $_POST['excludeIds'] ?? [];
	$includeIds = $_POST['includeIds'] ?? [];
	$ids = muse_get_distributions($perPage,$page, $search, $excludeIds, $sort, $filter, $filterVal, $includeIds);
	$distributions = [];
	foreach ($ids as $id) {
		$distributions[] = muse_get_distribution_data($id);
	}
	echo json_encode($distributions);
	exit;
}
add_action("wp_ajax_muse_get_distributions_ajax", "muse_get_distributions_ajax");
add_action("wp_ajax_nopriv_muse_get_distributions_ajax", "muse_get_distributions_ajax");

function muse_get_distribution_data($id) {
	$post = get_post($id);
	if (!$post) {
		return false;
	}
	$awards = get_field('awards', $id);
	$img = esc_url(get_field('image', $id));
	$length = get_field('length', $id);
	$genre = get_field('genre', $id);
	$content = $post->post_content;
	$content = apply_filters('the_content', $content);
	$content = str_replace(']]>', ']]&gt;', $content);
	$title = wp_kses_post(get_the_title($post));
	// Movies/Seasons in this series
	$series = [];
	$seriesDropdownLabel = '';
	if (have_rows('seasons', $id)) {
		$series = get_field('seasons', $id);
		$seriesDropdownLabel = 'Other titles in this Series';
	} elseif (have_rows('movies', $id)) {
		$series = get_field('movies', $id);
		$seriesDropdownLabel = 'Movies in this Series';
	}
	// Escape description and title
	foreach ($series as &$serie) {
		$serieDesc = apply_filters('the_content', $serie['description']);
		$serie['description'] = str_replace(']]>', ']]&gt;', $serieDesc);
		$serie['title'] = wp_kses_post($serie['title']);
	}

	return [
		'id' => $id,
		'img' => $img,
		'film_length' => $length,
		'genre' => $genre,
		'awards' => $awards,
		'post_content' => $content,
		'post_title' => $title,
		'series' => $series,
		'series_dropdown_label' => $seriesDropdownLabel,
	];
}

function muse_get_random_hero_image() {
	$images = get_field('hero_images');
	if (!$images)
		return null;
	$cnt = count($images);
	$randomVal = rand(0, $cnt - 1);
	return esc_url($images[$randomVal]['image']);
}

function muse_get_link_prefix() {
	$currentLang = apply_filters('wpml_current_language', null);
	switch ($currentLang) {
		case 'fr':
			return '/fr';
		default:
			return '';
	}
}

function muse_pop_about($atts ){
   
    ob_start();
      $atts = shortcode_atts( array(
		'title' => 'something',
	), $atts );
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
<div class="logo-section"><img style="mix-blend-mode: multiply;" class=" wp-image-1479 aligncenter" src="https://muse.rankmediadev.com/wp-content/uploads/2022/10/Muse-favicon-512x512-1.png" alt="" width="49" height="49" /></div>
</div>
<?php endwhile; ?>

    <?php wp_reset_postdata(); ?>
     
    <?php endif; ?>
   
  <!-- more HTML code here -->
  <?php   // back to PHP
   
     
    return ob_get_clean();
   
}

// register shortcode
add_shortcode('show-bio', 'muse_pop_about');