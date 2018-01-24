<?php

/**
 * The sidebar containing the main widget area
*/

$fwp_sidebar_class = fwp_settings::get_var('fwp_sidebar_class');

if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
	<div class="fwp-sidebar" role="complementary">
		<div class="fwp-sidebar__inner <?php echo $fwp_sidebar_class; ?>">
			<?php dynamic_sidebar( 'sidebar-1'); ?>
		</div>
	</div>
<?php endif; ?>