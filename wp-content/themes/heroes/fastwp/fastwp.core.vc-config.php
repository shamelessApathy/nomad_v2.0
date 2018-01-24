<?php
global $fwp_visual_composer_blocks;

/**
Initialize empty VC Blocks array is if not already set by child theme 
**/
if(!isset($fwp_vc_blocks) || !is_array($fwp_vc_blocks)){
	$fwp_vc_blocks = array();
}
/**
Merge existent VC Blocks array with all plugin-generated blocks 
**/
if(isset($fwp_visual_composer_blocks) && is_array($fwp_visual_composer_blocks)){
	$fwp_visual_composer_blocks = array_merge($fwp_vc_blocks, $fwp_visual_composer_blocks);
}else {
	$fwp_visual_composer_blocks = $fwp_vc_blocks;
}