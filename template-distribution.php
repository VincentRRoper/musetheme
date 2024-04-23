<?php
/**
 * Template Name: Distribution
 */

get_header();

$search = get_query_var('distribution_title');
$filter = get_query_var('distribution_filter_by');
$filterVal = get_query_var('distribution_filter_by_value');
$sort = get_query_var('distribution_sort');
$distributionId = (int)get_query_var('distribution_id');
// Param for "data" attribute of ajax request
$distributionIdParam = [];
if ($distributionId > 0) {
	$fullPriorityList = [$distributionId];
	$distributionIdParam = [$distributionId];
} else {
	$fullPriorityList = (array)get_field('signature_and_featured_films');
}


$perPage = 10;
$page = 1;
// Apply sort and filter
$priorityList = muse_get_distributions(-1, 1, $search, [], $sort, $filter, $filterVal, $fullPriorityList);
$regularList = muse_get_distributions($perPage, $page, $search, $priorityList, $sort, $filter, $filterVal, $distributionIdParam);
// The whole list
$list = array_merge($priorityList, $regularList);
// Get the list of genres
$firstDistribution = $list[0] ?? null;
$genres = [];
if (!$firstDistribution) {
    // There is no distribution that matches the filters => simply get the first distribution without filtering to get ACF value
    $distributionsForGenres = muse_get_distributions(1);
	$firstDistribution = $distributionsForGenres[0] ?? null;
}
if ($firstDistribution) {
	$genresAcf = get_field_object('genre', $firstDistribution);
	$genres = $genresAcf['choices'] ?? [];
}
$heroImage = muse_get_random_hero_image();
?>
<script>
    document.getElementsByTagName('body')[0].onload = initDocumentSmoothScroll();
</script>
    <div class="distrib-banner page-banner">
        <img class="page-banner-img" src="<?php echo $heroImage ?>">
        <div class="page-banner-text">
            <h1 class="page-banner-heading headline-header"><?php the_field('banner_heading') ?></h1>
            <div class="page-banner-txt">
                <?php the_field('banner_sub_heading') ?>
            </div>
        </div>
    </div>
    <div class="distrib-inner clearfix">
        <?php if ( get_field( 'enable_email' ) == 1 ) : ?>
 <div class="email-bar"><a href="mailto:<?php the_field('email'); ?>"><i class="fa fa-envelope" aria-hidden="true"></i> sales@muse.ca</a>
</div> 
<?php else : ?>
 
<?php endif; ?>
        
        <div class="distrib-searchbar clearfix">
            <form>
                <div class="distrib-search">
                    <div class="distrib-search-input">
                        <input type="text" placeholder="<?php esc_attr_e('Search titles', TRANSLATION_DOMAIN) ?>" title="<?php esc_attr_e('Search titles', TRANSLATION_DOMAIN) ?>" name="distribution_title" value="<?php echo $search ?>">
                        <i class="fa-solid fa-search distrib-search-ico"></i>
                    </div>
                </div>
                <div class="distrib-filtersort">
                    <div class="distrib-filter">
                        <div class="distrib-filtersort-label"><?php esc_html_e('Filter by', TRANSLATION_DOMAIN) ?></div>
                        <label class="select"><select name="distribution_filter_by">
                                <option value=""><?php esc_html_e('Default', TRANSLATION_DOMAIN) ?></option>
                                <option value="genre" data-radios-class="distrib-filter-radios--genre" <?php if ($filter == 'genre') echo 'selected="selected"'; ?>>Genre</option>
                            </select>
                        </label>
                    </div>
                    <div class="distrib-sort">
                        <div class="distrib-filtersort-label"><?php esc_html_e('Sort by', TRANSLATION_DOMAIN) ?></div>
                        <label class="select">
                            <select name="distribution_sort">
                                <option value=""><?php esc_html_e('Default', TRANSLATION_DOMAIN) ?></option>
                                <option value="a-z" <?php if ($sort == 'a-z') echo 'selected="selected"' ?>>A-Z</option>
                                <option value="z-a" <?php if ($sort == 'z-a') echo 'selected="selected"' ?>>Z-A</option>
                            </select>
                        </label>
                    </div>
                </div>
                <?php if ($genres): ?>
                <div class="distrib-filter-radios distrib-filter-radios--genre">
                    <?php foreach ($genres as $genre):
                        $genreId = 'distrib_filter_by_genre_'.preg_replace("/[^a-zA-Z]+/", "", $genre);
                        ?>
                    <div class="distrib-filter-radio"><input type="radio" id="<?php echo $genreId ?>" name="distribution_filter_by_value" value="<?php echo $genre ?>" <?php if ($filterVal==$genre) echo 'checked="checked"'; ?> disabled><label for="<?php echo $genreId ?>"><?php echo $genre ?></label></div>
                    <?php endforeach; ?>
                </div>
                <?php endif ?>
            </form>
        </div>
        <div class="distrib-list">
            <?php if ($list): foreach($list as $itemId):
                $distribData = muse_get_distribution_data($itemId);
                if (!$distribData) continue;
                $itemGenre = $distribData['genre'];
                $itemAwards = $distribData['awards'];
                $series = $distribData['series'];
                $hasSeries = count($series) > 0;
                $itemHeadingClass = '';
                if (!$hasSeries)
                    $itemHeadingClass = 'no-series'
            ?>
                <div class="distrib-item" data-id="<?php echo $distribData['id'] ?>">
                    <div class="distrib-item-inner">
                        <img class="distrib-item-img" src="<?php echo $distribData['img'] ?>">
                        <div class="distrib-item-hover">
                            <div class="distrib-item-bg">
                                <?php if ($itemAwards): ?>
                                <div class="distrib-item-awards">
                                    <?php foreach ($itemAwards as $award): ?>
                                        <img class="distrib-item-award-ico" src="<?php echo $award['icon'] ?>">
                                    <?php endforeach; ?>
                                </div>
                                <?php endif ?>
                                <div class="distrib-item-desc">
                                    <div><?php echo $distribData['film_length'] ?></div>
                                    <div><?php echo $itemGenre ?></div>
                                </div>
                            </div>
                            <div class="distrib-item-border"></div>
                        </div>
                        <div class="distrib-item-arrow"></div>
                    </div>
                </div>
                <div class="distrib-item-details <?php echo $itemHeadingClass ?>">
                    <div class="distrib-item-details-inner">
                        <i class="distrib-items-details-close fa-solid fa-xmark"></i>
                        <?php if ($hasSeries): ?>
                            <div class="distrib-item-detail-dropdown custom-select" data-scrollbar>
                                <select class="distrib-item-detail-dropdown-select">
                                    <option value="0"
                                        data-title="<?php echo $distribData['post_title'] ?>"
                                        data-description="<?php echo $distribData['post_content'] ?>"
                                        data-image="<?php echo $distribData['img'] ?>"
                                        data-length="<?php echo $distribData['film_length'] ?>"
                                    >
                                        <?php echo $distribData['series_dropdown_label'] ?>
                                    </option>
                                    <?php foreach ($series as $key => $serie): ?>
                                        <option value="<?php echo $key + 1 ?>"
                                            data-title="<?php echo $serie['title'] ?>"
                                            data-description="<?php echo $serie['description'] ?>"
                                            data-image="<?php echo $serie['image'] ?>"
                                            data-length="<?php echo $serie['length'] ?>"
                                        >
                                            <?php echo $serie['title'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        <?php endif ?>
                        <img class="distrib-item-detail-img" src="<?php echo $distribData['img'] ?>">
                        <div class="distrib-item-detail-txt">
                            <div class="distrib-item-detail-heading"><?php echo $distribData['post_title'] ?></div>
                            <?php if ($itemAwards): ?>
                            <div class="distrib-item-detail-awards">
                                <?php foreach ($itemAwards as $key => $award): ?>
                                    <div class="distrib-item-detail-award">
                                        <img class="distrib-item-award-ico" src="<?php echo $award['icon'] ?>">
                                        <span class="distrib-item-detail-award-info"><?php echo $award['text'] ?></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <?php endif ?>
                            <div class="distrib-item-detail-info">
                                <span class="distrib-item-detail-info-length"><?php echo $distribData['film_length'] ?></span>
                                *
                                <?php echo $itemGenre ?>
                            </div>
                            <div class="distrib-item-detail-desc">
                                <?php echo $distribData['post_content'] ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; else: ?>
                <div class="distrib-list--no-results"><?php esc_html_e('No results found', TRANSLATION_DOMAIN) ?></div>
            <?php endif; ?>
        </div>
    </div>
<script>
    var isLoading = false;
    var isFullList = false;
    var pageToLoad = <?php echo $page + 1; ?>;
    jQuery(document).ready(function($) {
        // Lazy load items
        $(window).scroll(function() {
            if(Math.ceil($(window).scrollTop()) >= Math.ceil(($(document).height() - $(window).height()) - 100)
                && !isLoading && !isFullList
            ) {
                isLoading = true;

                var distribLoadingHtml = [
                    '<div class="distrib-item distrib-item--loading">',
                    '<div class="distrib-item-load"><?php esc_html_e('Loading...', TRANSLATION_DOMAIN) ?></div>',
                    '</div>'
                ].join('');
                $('.distrib-list').append(distribLoadingHtml);
                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo admin_url('admin-ajax.php'); ?>',
                    dataType: "json",
                    data: {
                        action: 'muse_get_distributions_ajax',
                        page: pageToLoad,
                        perPage: '<?php echo $perPage ?>',
                        search: '<?php echo $search ?>',
                        sort: '<?php echo $sort ?>',
                        filter: '<?php echo $filter ?>',
                        filterVal: '<?php echo $filterVal ?>',
                        excludeIds: <?php echo json_encode($priorityList) ?>,
                        includeIds: <?php echo json_encode($distributionIdParam) ?>
                    },
                    success: function(data) {
                        if (!data.length) {
                            // the full list is loaded - 0 items left
                            isFullList = true;
                            return;
                        }
                        for (var i in data) {
                            var distrib = data[i];
                            var awards = distrib.awards;
                            var awardsHtml = '',
                                awardsDetailHtml = '';
                            if (awards.length > 0) {
                                awardsHtml += '<div class="distrib-item-awards">';
                                awardsDetailHtml += '<div class="distrib-item-detail-awards">';
                                for (var j in awards) {
                                    var award = awards[j];
                                    awardsHtml += [
                                        '<img class="distrib-item-award-ico" src="',
                                        award.icon,
                                        '">'
                                    ].join('');
                                    awardsDetailHtml += [
                                        '<div class="distrib-item-detail-award">',
                                        '<img class="distrib-item-award-ico" src="',
                                        award.icon,
                                        '">',
                                        '<span class="distrib-item-detail-award-info">',
                                        award.text,
                                        '</span>',
                                        '</div>'
                                    ].join('');
                                }
                                awardsHtml += '</div>';
                                awardsDetailHtml += '</div>';
                            }
                            var series = distrib.series;
                            var seriesOptions = '',
                                itemHeadingClass = '';
                            if (series.length > 0) {
                                for (var k in series) {
                                    var serie = series[k];
                                    seriesOptions += [
                                        '<option value="', k, '" ',
                                        'data-title="',
                                        serie.title, '" ',
                                        'data-description="',
                                        serie.description, '" ',
                                        'data-image="',
                                        serie.image, '" ',                                        
                                        'data-length="',
                                        serie.length, '" ',
                                        '>',
                                        serie.title,
                                        '</option>'
                                    ].join('');
                                }
                            } else {
                                itemHeadingClass = 'no-series';
                            }
                            var distribHtmlArr = [
                                '<div class="distrib-item" data-id="',
                                distrib.id,
                                '">',
                                '<div class="distrib-item-inner">',
                                '<img class="distrib-item-img" src="',
                                distrib.img,
                                '">',
                                '<div class="distrib-item-hover">',
                                '<div class="distrib-item-bg">',
                                '<div class="distrib-item-awards">',
                                awardsHtml,
                                '</div>',
                                '<div class="distrib-item-desc">',                                
                                '<div>',
                                distrib.film_length,
                                '</div>',
                                '<div>',
                                distrib.genre,
                                '</div>',
                                '</div>',
                                '</div>',
                                '<div class="distrib-item-border"></div>',
                                '</div>',
                                '<div class="distrib-item-arrow"></div>',
                                '</div>',
                                '</div>',
                                '<div class="distrib-item-details ' + itemHeadingClass + '">',
                                '<div class="distrib-item-details-inner">',
                                '<i class="distrib-items-details-close fa-solid fa-xmark"></i>',
                            ];
                            if (seriesOptions.length > 0) {
                                distribHtmlArr.push(
                                    '<div class="distrib-item-detail-dropdown custom-select" data-scrollbar>',
                                    '<select class="distrib-item-detail-dropdown-select">',
                                    '<option value="0"',
                                    'data-title="',
                                    distrib.post_title, '"',
                                    'data-title="',
                                    distrib.post_content, '"',
                                    'data-image="',
                                    distrib.img, '"',                                    
                                    'data-length="',
                                    distrib.film_length, '"',
                                    '>',
                                    distrib.series_dropdown_label,
                                    '</option>',
                                    seriesOptions,
                                    '</select>',
                                    '</div>',
                                );
                            }
                            distribHtmlArr.push(
                                '<img class="distrib-item-detail-img" src="',
                                distrib.img,
                                '">',
                                '<div class="distrib-item-detail-txt">',
                                '<div class="distrib-item-detail-heading">',
                                distrib.post_title,
                                '</div>',
                                awardsDetailHtml,
                                '<div class="distrib-item-detail-info">',                                
                                '<span class="distrib-item-detail-info-length">',
                                distrib.film_length,
                                '</span>',
                                ' * ',
                                distrib.genre,
                                '</div>',
                                '<div class="distrib-item-detail-desc">',
                                distrib.post_content,
                                '</div>',
                                '</div>',
                                '</div>',
                                '</div>'
                            );
                            var distribHtml = distribHtmlArr.join('');
                            $('.distrib-list').append(distribHtml);
                        }
                        initializeCustomSelect();
                        initSmoothScroll();
                    },
                    complete: function() {
                        $('.distrib-list').find('.distrib-item--loading').remove();
                        pageToLoad++;
                        isLoading = false;
                    }
                });
            }
        });
        $('[name=distribution_filter_by]').on('change', function() {
            $('.distrib-filter-radios').slideUp().find(':input').prop('disabled', true);
            var radios = $('.'+ $(this).find('option:selected').data('radios-class'));
            if (radios.length) {
                radios.find(':input').prop('disabled', false);
                radios.slideDown();
            }
        }).trigger('change');
        $('.distrib-search-ico').on('click', function() {
            $(this).closest('form').submit();
        });
        $('[name=distribution_sort], [name=distribution_filter_by], [name=distribution_filter_by_value]').on('change', function() {
            // Filter only if "Filter by" is getting disabled
            if ($(this).attr('name') == 'distribution_filter_by' && this.value) return;
            $(this).closest('form').submit();
        });
        $('.distrib-list').on('change', '.distrib-item-detail-dropdown-select', function() {
            var dropdown = $(this);
            var selectedOption = dropdown.find('option:selected');
            var container = dropdown.closest('.distrib-item-details');
            container.find('.distrib-item-detail-img').attr('src', selectedOption.data('image'));
            container.find('.distrib-item-detail-heading').html(selectedOption.data('title'));
            container.find('.distrib-item-detail-desc').html(selectedOption.data('description'));
            container.find('.distrib-item-detail-info-length').html(selectedOption.data('length'));
        });

        <?php if ($search || $filter || $filterVal || $sort): ?>
        // Scroll to search/filter tab to see results
        if (($(document).height() - $(window).height()) > 0) {
            setTimeout(function() {
                $('body').addClass('scrolled');
                var scrollVal = $('.distrib-inner').offset().top - $('.logo-container').height() + 1;
                $('html, body').animate({
                    scrollTop: scrollVal
                }, 700);
                }, 0
            );
        }
        <?php endif ?>

        var distributionId = parseInt('<?php echo $distributionId ?>') || 0;
        if (distributionId > 0) {
            setTimeout(function() {
                $('.distrib-item[data-id='+distributionId+']').trigger('click');
            }, 0);
        }
    });
</script>
<?php get_footer();