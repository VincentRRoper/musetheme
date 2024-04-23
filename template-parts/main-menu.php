<?php $linkPrefix = muse_get_link_prefix(); ?>
<div class="main-menu">
      
	<ul class="main-menu-items">
	     <li class="lang">
       <?php echo do_shortcode( ' [wpml_language_selector_widget]'); ?>
    </li> 
		<li><a class="main-menu-item-link" href="<?php echo $linkPrefix ?>/"><?php esc_html_e('Home', TRANSLATION_DOMAIN) ?></a></li>
		<li><a class="main-menu-item-link" href="<?php echo $linkPrefix ?>/distribution"><?php esc_html_e('Distribution', TRANSLATION_DOMAIN) ?></a></li>
		<li><a class="main-menu-item-link" href="<?php echo $linkPrefix ?>/production"><?php esc_html_e('Production', TRANSLATION_DOMAIN) ?></a></li>
		<li><a class="main-menu-item-link" href="<?php echo $linkPrefix ?>/about"><?php esc_html_e('About', TRANSLATION_DOMAIN) ?></a></li>
			<li class="lang-m">
           <?php echo do_shortcode( ' [wpml_language_selector_widget]'); ?>
        </li> 
	</ul>
    <div class="main-menu-areas">
        <div class="main-menu-area main-menu-area-top">
            <div class="main-menu-area-name"><?php esc_html_e('Los Angeles', TRANSLATION_DOMAIN) ?></div>
            <div class="main-menu-area-info">
                <div class="main-menu-area-info-txt">
                    <div class="main-menu-area-info-name"><?php esc_html_e('Los Angeles', TRANSLATION_DOMAIN) ?></div>
                    <div class="main-menu-area-info-details">
                        <div class="main-menu-area-info-address">
                            <?php esc_html_e('4450 Lakeside Dr.,', TRANSLATION_DOMAIN) ?><br>
                            <?php esc_html_e('Suite 200', TRANSLATION_DOMAIN) ?><br>
                            <?php esc_html_e('Burbank, CA, 91504', TRANSLATION_DOMAIN) ?>
                        </div>
                        <div class="main-menu-area-info-tel">
                            <?php esc_html_e('Contact', TRANSLATION_DOMAIN) ?>: <a href="mailto:reception@muse.ca">reception@muse.ca</a><br>
                            <?php esc_html_e('Tel', TRANSLATION_DOMAIN) ?>: <a href="tel:8183583615">(818) 358-3615</a><br>
                            <?php esc_html_e('Fax', TRANSLATION_DOMAIN) ?>: <a href="tel:8184747700">(818) 474-7700</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="main-menu-area main-menu-area-top">
            <div class="main-menu-area-name"><?php esc_html_e('Montreal', TRANSLATION_DOMAIN) ?></div>
            <div class="main-menu-area-info">
                <div class="main-menu-area-info-txt">
                    <div class="main-menu-area-info-name"><?php esc_html_e('Montreal', TRANSLATION_DOMAIN) ?></div>
                    <div class="main-menu-area-info-details">
                        <div class="main-menu-area-info-address">
                            <?php esc_html_e('Head Office', TRANSLATION_DOMAIN) ?><br>
                            <?php esc_html_e('3451 rue St-Jacques', TRANSLATION_DOMAIN) ?><br>
                            <?php esc_html_e('Montreal, Quebec, H4C 1H1', TRANSLATION_DOMAIN) ?>
                        </div>
                        <div class="main-menu-area-info-tel">
                            <?php esc_html_e('Contact', TRANSLATION_DOMAIN) ?>: <a href="mailto:reception@muse.ca">reception@muse.ca</a><br>
                            <?php esc_html_e('Tel', TRANSLATION_DOMAIN) ?>: <a href="tel:5148666873">(514) 866-6873</a><br>
                            <?php esc_html_e('Fax', TRANSLATION_DOMAIN) ?>: <a href="tel:5148763911">(514) 876-3911</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="main-menu-toggle main-menu-close hide-portrait">
		        <?php get_template_part('assets/svg/inline', 'menu-close.svg'); ?>
            </div>
        </div>
        <div class="main-menu-area">
            <div class="main-menu-area-name"><?php esc_html_e('Toronto', TRANSLATION_DOMAIN) ?></div>
            <div class="main-menu-area-info">
                <div class="main-menu-area-info-txt">
                    <div class="main-menu-area-info-name"><?php esc_html_e('Toronto', TRANSLATION_DOMAIN) ?></div>
                    <div class="main-menu-area-info-details">
                        <div class="main-menu-area-info-address">
                            <?php esc_html_e('530 Richmond St. W, 2nd Floor', TRANSLATION_DOMAIN) ?><br>
                            <?php esc_html_e('Toronto, Ontario', TRANSLATION_DOMAIN) ?><br>
                            <?php esc_html_e('M5V 1Y4', TRANSLATION_DOMAIN) ?>
                        </div>
                        <div class="main-menu-area-info-tel">
                            <?php esc_html_e('Contact', TRANSLATION_DOMAIN) ?>: <a href="mailto:reception@muse.ca">reception@muse.ca</a><br>
                            <?php esc_html_e('Tel', TRANSLATION_DOMAIN) ?>: <a href="tel:4163066473">(416) 306-6473</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="main-menu-area">
            <div class="main-menu-area-name"><?php esc_html_e('Vancouver', TRANSLATION_DOMAIN) ?></div>
            <div class="main-menu-area-info">
                <div class="main-menu-area-info-txt">
                    <div class="main-menu-area-info-name"><?php esc_html_e('Vancouver', TRANSLATION_DOMAIN) ?></div>
                    <div class="main-menu-area-info-details">
                        <div class="main-menu-area-info-address">
                            <?php esc_html_e('MEP Corporate Services LTD', TRANSLATION_DOMAIN) ?><br>
                            <?php esc_html_e('Royal Centre, Suite 1750,', TRANSLATION_DOMAIN) ?> <br>
                            <?php esc_html_e('1055 West Georgia St. Vancouver, V6E 3P3', TRANSLATION_DOMAIN) ?>
                        </div>
                        <div class="main-menu-area-info-tel">
                            <?php esc_html_e('Contact', TRANSLATION_DOMAIN) ?>: <a href="mailto:reception@muse.ca">reception@muse.ca</a><br>
                            <?php esc_html_e('Tel', TRANSLATION_DOMAIN) ?>: <a href="tel:5148666873">(514) 866-6873</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<div class="main-menu-social">
		<a target="_blank" class="main-menu-social-link" href="https://www.facebook.com/museent"><i class="fa-brands fa-facebook-f"></i></a>
		<a target="_blank" class="main-menu-social-link" href="https://www.youtube.com/user/MuseTrailers"><i class="fa-brands fa-youtube"></i></a>
		<a target="_blank" class="main-menu-social-link" href="https://twitter.com/MuseEntertains"><i class="fa-brands fa-twitter"></i></a>
		<a target="_blank" class="main-menu-social-link" href="https://www.instagram.com/muse_entertainment/"><i class="fa-brands fa-instagram"></i></a>
	</div>
    <div class="main-menu-toggle main-menu-close hide show-portrait">
		<?php get_template_part('assets/svg/inline', 'menu-close.svg'); ?>
    </div>
</div>