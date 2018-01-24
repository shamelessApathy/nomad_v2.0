<?php

$fwp_options = fwp_get_option( array( 'e404_logo', 'e404_text', 'e404_bg', 'fwp_single_type', 'e404_page_id', 'e404_menu', 'e404_override' ) );

$fwp_do_skip_menu = ( isset( $fwp_options['e404_menu'] ) && $fwp_options['e404_menu'] == 1 ) ? false : true;

fwp_settings::set_var('do_skip_menu', $fwp_do_skip_menu);

get_header();

if(isset($fwp_options['e404_override']) && $fwp_options['e404_override'] == 1 && $fwp_options['e404_page_id'] != ''){
	$page = get_page($fwp_options['e404_page_id']);
	echo (isset($page->post_content)? apply_filters('the_content', $page->post_content) : '');
} else {

?>

<section class="intro">
            <div class="black-overlay"></div>
            <div class="container valign">
                <div class="row">
                    <?php if( !empty( $fwp_options['e404_logo']['url'] ) ) { ?>
                    <div class="col-md-12">
                        <img src="<?php echo esc_url( $fwp_options['e404_logo']['url'] ); ?>" class="img-responsive center-block introLogo" alt="Intro Logo">
                    </div>
                    <?php } ?>
                    <div class="col-md-offset-2 col-md-8 text-center">
                        <h2 class="minimal"><small>OOPS!</small> 404 ERROR!</h2>
                    </div>
                </div>
                <div class="verticallineSeparator center-block"></div>

                <div class="row">
                    <div class="col-md-offset-4 col-md-4 introSmallCaption minimal-style text-center">
                        <?php echo !empty( $fwp_options['e404_text'] )  ? fwp_utils::fwp_escape ( $fwp_options['e404_text'] )  : '<a class="btn btn-default btn-white" href="' . home_url('/') . '">GO BACK</a>'; ?>
                    </div>
                </div>
            </div>
</section>

<?php if( !empty( $fwp_options['e404_bg']['url'] ) ) { ?>

<script>
jQuery(function($){
    $.backstretch("<?php echo esc_url( $fwp_options['e404_bg']['url'] ); ?>");
});
</script>

<?php }

}

get_footer();