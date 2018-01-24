<?php

global $fwp_custom_shortcode_css;

$fwp_options = fwp_get_option( array( 'copyright', 'social-media', 'fwp_footer_social_media_background_hover', 'fwp_single_type' ) );

do_action('fwp_before_footer'); ?>

<section id="footer" class="dark group">

        <?php do_action('attach_footer_info_page'); ?>

        <div class="bottomLine text-center clearfix">
        <div class="container">
        <div class="row">

        <div class="col-sm-6 text-left">
        <?php if(isset($fwp_options['copyright'])){
            echo apply_filters('the_content', $fwp_options['copyright']);
        } ?>
        </div>
        <div class="col-sm-6 text-right">
        <?php if(isset($fwp_options['social-media']) && is_array($fwp_options['social-media']) && count($fwp_options['social-media']) > 0) { ?>
        <div class="allIconsSocialWrapper center-block">
        <?php
            foreach($fwp_options['social-media'] as $social_media_item){
                if($social_media_item == '') continue;
                list($icon, $url) = explode('|', $social_media_item);
                $social_wrapper = '<div class="socialWrapper center-block black-icon">
                                    <div class="socialIcon-wrap socialIcon-effect-1 socialIcon-effect-1a">
                                        <div class="socialIcon">%s
                                        </div>
                                    </div>
                                    </div>';
                $social_icon = sprintf ('<a href="%s"><i class="fa %s"></i></a>', esc_url(trim($url)), esc_attr(trim($icon)));
                echo sprintf($social_wrapper, $social_icon);
            }
        ?>
        </div>
        <?php }
            $social_icon_shadow = (isset($fwp_options['fwp_footer_social_media_background_hover'])) ? ($fwp_options['fwp_footer_social_media_background_hover']) : '';
            $fwp_custom_shortcode_css .= (sprintf('#footer .socialIcon:after{box-shadow: 0 0 0 2px %s;}',$social_icon_shadow));
        ?>
        </div>

    </div>
    </div>
    </div>
</section>

<?php wp_footer(); ?>

</body>
</html>