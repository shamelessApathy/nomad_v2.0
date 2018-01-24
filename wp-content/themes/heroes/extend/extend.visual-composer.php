<?php

	function getPostIdAndTitle($post_type = 'page', $value_first = false){
		global $wpdb;
		$sql = $wpdb->prepare("SELECT post_title, ID from $wpdb->posts WHERE `post_type` = '%s' AND `post_status`='publish' ORDER BY `post_title` ASC;",
			$post_type);
		$result = $wpdb->get_results( $sql, ARRAY_A );
		$output = array();
		if(isset($result) && is_array($result)){
			foreach($result as $item){
				if($value_first == true){
					$key = $item['post_title'];
					$value=$item['ID'];
				}else {
					$key = $item['ID'];
					$value=$item['post_title'];
				}
				$output[$key] = $value;
			}
		}
		return $output;
	}


$fwp_visual_composer_param_blocks = array(

    'vc_row' => array(
        array(
	        "type"      => "dropdown",
            "group"     => "Hero Options",
	        "class"     => "",
	        "heading"   => esc_html__('Container width', 'heroes'),
	        "param_name"=> "container_width",
	        "value"     => array(
		    "Default"   => "",
		    "Boxed"     => "boxed")
        ),
        array(
	        "type"      => "dropdown",
            "group"     => "Hero Options",
	        "class"     => "",
	        "heading"   => esc_html__('Overlay', 'heroes'),
	        "param_name"=> "overlay_after_row",
	        "value"     => array(
            "No"   => 0,
            "Yes"     => 1)
        ),
        array(
	        "type"      => "dropdown",
            "group"     => "Hero Options",
	        "class"     => "",
	        "heading"   => esc_html__('Padding top', 'heroes'),
	        "param_name"=> "padding_top",
	        "value"     => array(
            "No padding"=> 'none',
            "Normal"    => 'normal',
            "Large"     => 'large')
        ),
        array(
	        "type"      => "dropdown",
            "group"     => "Hero Options",
	        "class"     => "",
	        "heading"   => esc_html__('Padding bottom', 'heroes'),
	        "param_name"=> "padding_bottom",
	        "value"     => array(
            "No padding"=> 'none',
            "Normal"    => 'normal',
            "Large"     => 'large')
        )
    )

);

global $fwp_visual_composer_blocks;

$fwp_visual_composer_blocks = array(

/** 
A
**/

		array(
			"name" => esc_html__("About Box",'heroes'),
			"base" => "fwp-hero-about-box",
			"icon" => get_template_directory_uri() . "/assets/img/phx_vc_icon.jpg",
			"category" => esc_html__('Theme Elements','heroes'),
			"params" => array( 
				array(
					"type" 			=> "dropdown",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> esc_html__("About Box title tag",'heroes'),
					"param_name" 	=> "title_tag",
					"value" 		=> array('H4' => 'h4','H1' => 'h1', 'H2' => 'h2', 'H3' => 'h3','H5' => 'h5', 'H6' => 'h6'),
					"description" 	=> esc_html__("You can select the AboutBox title tag - From H1 to H6",'heroes'),
					"save_always"	=> true,
					"default"		=> "h4",
					"admin_label"	=> true,
				),
                array(
        	        "type"      => "dropdown",
        	        "class"     => "",
        	        "heading"   => esc_html__('Tag style', 'heroes'),
        	        "param_name"=> "type",
        	        "value"     => array(
                    "Default/Serif" => '',
                    "Minimal/Small" => 'minimal')
                ),
				array(
					"save_always"	=> true,
					"type" 			=> "colorpicker",
					"class"			=> "",
					"heading"		=> esc_html__( "AboutBox title color", "heroes" ),
					"param_name" => "title_color",
					"value" => '#000', //Default Black color
					"description" => esc_html__( "Choose AboutBox title color", "heroes" )
				),
				array(
					"save_always"	=> true,
					"type" 			=> "colorpicker",
					"class"			=> "",
					"heading"		=> esc_html__( "Icon color", "heroes" ),
					"param_name" => "icon_color",
					"value" => '#000', //Default Black color
					"description" => esc_html__( "Choose the icon color", "heroes" )
				),
				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,					
					"heading" => esc_html__("Icon class",'heroes'),
					"param_name" => "icon_class",
					"value" => '',
					"admin_label"=>false,
					"description" => esc_html__("Enter font-awesome icon class here. Ex: fa-facebook",'heroes')
				),
				array(
					"save_always" => true,
					"type" => "textarea",
					"holder" => false,					
					"heading" => esc_html__("Title",'heroes'),
					"param_name" => "title",
					"value" => '',
					"admin_label"=>false,
					"description" => esc_html__("Enter the title here.",'heroes')
				),
				array(
					"save_always" => true,
					"type" => "textarea",
					"holder" => false,
					"heading" => esc_html__("Title serif/small",'heroes'),
					"param_name" => "title_serif",
					"value" => '',
					"admin_label"=>false,
					"description" => esc_html__("Enter the serif span style title here.",'heroes')
				),
				array(
					"save_always" => true,
					"type" => "textarea",
					"holder" => false,
					"heading" => esc_html__("Paragraph content",'heroes'),
					"param_name" => "content",
					"value" => '',
					"admin_label"=>false,
					"description" => esc_html__("Enter your content here.",'heroes')
				),
				array(
					"save_always"   => true,
					"type" 			=> "dropdown",
					"holder"        => false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Animated",'heroes'),
					"param_name" 	=> "animated",
					"value" 		=> array('No' => 'false', 'Yes'=>'true' ),
					"description" 	=> esc_html__("Enable or disable element animation.",'heroes'),
					"admin_label	"=>true,
				),
				array(
					"save_always"   => true,
					"type" 			=> "textfield",
					"holder"        => false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Animation type",'heroes'),
					"param_name" 	=> "animation",
					"value" 		=> "enter left move 10px over 1s after 0.2s",
					"description" 	=> esc_html__("Select the type of animation for more info check documentation",'heroes'),
					"admin_label	"=>true,
				),
				array(
					"save_always" => true,
					"type" 			=> "textfield",
					"holder"        => false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Icon offset",'heroes'),
					"param_name" 	=> "icon_offset",
					"value" 		=> "300",
					"description" 	=> esc_html__("Select the offset of the icon.",'heroes'),
					"admin_label	"=>true,
				),
				array(
					"save_always" => true,
					"type" 			=> "textfield",
					"holder" 		=> false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Parallax speed",'heroes'),
					"param_name" 	=> "stellar_speed",
					"value" 		=> "",
					"description" 	=> esc_html__("Select animation speed relative to scrolling speed.",'heroes'),
					"admin_label	"=>true,
				),
			),
		),

	array(
			"name" => esc_html__("Animated text",'heroes'),
			"base" => "fwp-hero-animatedtext",
			"icon" => get_template_directory_uri() . "/assets/img/phx_vc_icon.jpg",
			"category" => esc_html__('Theme Elements','heroes'),
			"params" => array(

				array(
					"type" 			=> "dropdown",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Animate text",'heroes'),
					"param_name" 	=> "animated",
					"value" 		=> array('Yes'=>'true', 'No' => 'false'),
					"description" 	=> esc_html__("Animate element on scroll",'heroes'),
					"admin_label	"=>true,
				 ),
				array(
					"type" 			=> "textfield",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Animation settings",'heroes'),
					"param_name" 	=> "animation",
					"value" 		=> 'enter right move 10px over 1s after',
					"admin_label"	=>false,
					"description" 	=> esc_html__("Set settings classes (See theme documentation)",'heroes')
				 ),
				array(
					"save_always" => true,
					"type" => "textarea_html",
					"holder" => false,
					"heading" => esc_html__("Content",'heroes'),
					"param_name" => "content",
					"value" => '',
					"admin_label"=>true,
					"description" => esc_html__("Enter content",'heroes')
				 ),
				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,

					"heading" => esc_html__("Extra class",'heroes'),
					"param_name" => "extra_class",
					"value" => '',
					"admin_label"=>true,
					"description" => esc_html__("Extra class name",'heroes')
				 ),
			)
	   ),

/** 
B
**/

		array(
			"name" => esc_html__("Button",'heroes'),
			"base" => "fwp-hero-button",
			"icon" => get_template_directory_uri() . "/assets/img/phx_vc_icon.jpg",   
			"category" => esc_html__('Theme Elements','heroes'),
			"params" => array( 
				array(
					"type" 			=> "dropdown",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Button type",'heroes'),
					"param_name" 	=> "type",
					"value" 		=> array('Default' => 'default', 'White' => 'white', 'Primary' => 'primary', 'Success' => 'success', 'Info' => 'info' , 'Warning' => 'warning', 'Danger' => 'danger', 'Link' => 'link'),
					"description" 	=> esc_html__("Select the type of button you want to display.",'heroes'),
					"save_always"	=> true,
					"default"		=> "default",
					"admin_label"	=> true,
				),
				array(
					"type" 			=> "vc_link",
					"holder"		 => false,
					"class" 		=> "",
					"heading" 		=> esc_html__("New Link",'heroes'),
					"param_name" 	=> "link",
					"value" 		=> '',
					"admin_label"	=>true,
					"description" 	=> esc_html__("The URL link of the button.",'heroes')
				 ),
				array(
					"type" 			=> "textfield",
					"holder"		 => false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Action",'heroes'),
					"param_name" 	=> "action",
					"value" 		=> '',
					"admin_label"	=>true,
					"description" 	=> esc_html__("Javascript action to execute on click",'heroes')
				 ),
				array(
					"type" 			=> "dropdown",
					"holder" 		=> false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Shortcode tag",'heroes'),
					"param_name" 	=> "tag",
					"value" 		=> array('button', 'a'),
					"description" 	=> esc_html__("Button element type. A elements supports open in new window and url, buttons supports just action",'heroes'),
					"admin_label	"=>true,
				 ),
				 array(
					"type" 			=> "dropdown",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Align",'heroes'),
					"param_name" 	=> "align",
					"value" 		=> array('Default (no align)'=>'', 'Center'=>'center', 'Right'=>'right'),
					"description" 	=> esc_html__("Align button relative to parent width",'heroes'),
					"admin_label	"=>true,
				 ),
				 array(
					"type" 			=> "dropdown",
					"holder" 		=> false,
					"class" 		=> "",
                    "save_always"	=> true,    
					"heading" 		=> esc_html__("Animate",'heroes'),
					"param_name" 	=> "animate",
					"value" 		=> array('Yes'=>'true', 'No'=>'false'),
					"description" 	=> esc_html__("Link target is available just for 'a' tag.",'heroes'),
					"default"		=> 'false',
				), 	 
			),
		),  

/** 
C
**/

		array(
			"name" => esc_html__("Counter Box",'heroes'),
			"base" => "fwp-hero-counter-box",
			"icon" => get_template_directory_uri() . "/assets/img/phx_vc_icon.jpg",   
			"category" => esc_html__('Theme Elements','heroes'),
			"params" => array( 
				array(
					"save_always"	=> true,
					"type" 			=> "colorpicker",
					"class"			=> "",
					"heading"		=> esc_html__( "Values color", "heroes" ),
					"param_name" => "value_color",
					"value" => '#FFF',
					"description" => esc_html__( "Choose the color of the values", "heroes" )
				),
				array(
					"save_always"	=> true,
					"type" 			=> "colorpicker",
					"class"			=> "",
					"heading"		=> esc_html__( "Text color", "heroes" ),
					"param_name" => "text_color",
					"value" => '#F1F1F1',
					"description" => esc_html__( "Choose the text color", "heroes" )
				),
								array(
					"save_always"	=> true,
					"type" 			=> "colorpicker",
					"class"			=> "",
					"heading"		=> esc_html__( "Icon color", "heroes" ),
					"param_name" => "icon_color",
					"value" => '#393535',
					"description" => esc_html__( "Choose the icon color. Default : #393535", "heroes" )
				),
				array(
					"save_always" => true,
					"type" 			=> "dropdown",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Animated",'heroes'),
					"param_name" 	=> "animated",
					"value" 		=> array('No' => 'false', 'Yes'=>'true' ),
					"description" 	=> esc_html__("Enable or disable element animation.",'heroes'),
					"admin_label	"=>true,
				),
				array(
					"save_always" => true,
					"type" 			=> "textfield",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Animation type",'heroes'),
					"param_name" 	=> "animation",
					"value" 		=> "enter left move 10px over 1s after 0.2s",
					"description" 	=> esc_html__("Select the type of animation for more info check documentation",'heroes'),
					"admin_label	"=>true,
				),
				array(
					"save_always" => true,
					"type" 			=> "textfield",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Text",'heroes'),
					"param_name" 	=> "text",
					"value" 		=> "",
					"description" 	=> esc_html__("Fill in the text you want.",'heroes'),
					"admin_label	"=>true,
				),
				array(
					"save_always" => true,
					"type" 			=> "textfield",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Icon class",'heroes'),
					"param_name" 	=> "icon_class",
					"value" 		=> "",
					"description" 	=> esc_html__("Select the class of the font-awesome icon. (Here are all the font-awesome icons: https://fortawesome.github.io/Font-Awesome/icons/) // Use for example: fa-facebook",'heroes'),
					"admin_label	"=>true,
				),
				array(
					"type" 			=> "textfield",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Start at",'heroes'),
					"param_name" 	=> "start",
					"value" 		=> '0',
					"admin_label"	=>true,
					"description" 	=> esc_html__("Counter start value",'heroes')
				),
				array(
					"type" 			=> "textfield",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> esc_html__("End at",'heroes'),
					"param_name" 	=> "end",
					"value" 		=> '100',
					"admin_label"	=>true,
					"description" 	=> esc_html__("Count up to",'heroes')
				 ),
				array(
					"type" 			=> "textfield",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Speed",'heroes'),
					"param_name" 	=> "speed",
					"value" 		=> '2000',
					"admin_label"	=>true,
				 ),
				array(
					"type" 			=> "textfield",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Refresh interval",'heroes'),
					"param_name" 	=> "interval",
					"value" 		=> '10',
					"admin_label"	=>true,
				 ),
				array(
					"save_always" => true,
					"type" 			=> "textfield",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Data Stellar Ratio",'heroes'),
					"param_name" 	=> "stellarratio",
					"value" 		=> '1.4',
					"admin_label"	=>true,
					"description" 	=> esc_html__("The position of each icon",'heroes')
				 ),
				array(
					"save_always" => true,
					"type" 			=> "textfield",
					"holder"		 => false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Value sufix",'heroes'),
					"param_name" 	=> "value_sufix",
					"value" 		=> "",
					"description" 	=> esc_html__("Select the sufix of your value.",'heroes'),
					"admin_label	"=>true,
				),
				array(
					"save_always" => true,
					"type" 			=> "textfield",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Icon offset",'heroes'),
					"param_name" 	=> "icon_offset",
					"value" 		=> "300",
					"description" 	=> esc_html__("Select the offset of the icon.",'heroes'),
					"admin_label	"=>true,
				),
			),
		),

        array(
			"name" => esc_html__("Countdown",'heroes'),
			"base" => "fwp-hero-countdown",
			"icon" => get_template_directory_uri() . "/assets/img/phx_vc_icon.jpg",
			"category" => esc_html__('Theme Elements','heroes'),
			"params" => array(
                array(
					"save_always"   => true,
					"type" 			=> "textfield",
					"holder"        => false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Title",'heroes'),
					"param_name" 	=> "title",
					"value" 		=> "Countdown Timers",
					"admin_label"	=> true
				 ),
				array(
					"save_always" 	=> true,
					"type" 			=> "attach_image",
					"holder" 		=> false,
					"heading" 		=> esc_html__("Logo",'heroes'),
					"param_name" 	=> "logo",
					"value" 		=> '',
					"admin_label"	=>false,
					"description" 	=> esc_html__("Logo image",'heroes')
				),
				array(
					"save_always" 	=> true,
					"type" 			=> "attach_image",
					"holder" 		=> false,
					"heading" 		=> esc_html__("Background",'heroes'),
					"param_name" 	=> "background",
					"value" 		=> '',
					"admin_label"	=>false,
					"description" 	=> esc_html__("Background image",'heroes')
				),
				array(
                    "group" => "Options",
					"save_always"   => true,
					"type"          => "textfield",
					"holder"        => false,
					"heading"       => esc_html__("Stop Year",'heroes'),
					"param_name"    => "stop_year",
					"value"         => date( 'Y' ),
					"admin_label"   => true,
					"description"   => esc_html__("The year when countdount will stop",'heroes')
				),
				array(
                    "group" => "Options",
					"save_always"   => true,
					"type" 			=> "dropdown",
					"holder"        => false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Stop Month",'heroes'),
					"param_name" 	=> "stop_month",
					"value" 		=> array( 'January' => 'January', 'February' => 'February', 'March' => 'March', 'April' => 'April', 'May' => 'May', 'June' => 'June', 'July' => 'July', 'August' => 'August', 'September' => 'September', 'October' => 'October', 'November' => 'November', 'December' => 'December' ),
					"description" 	=> esc_html__("The year when countdount will stop.",'heroes'),
					"default"		=> "default",
					"admin_label"	=> true,
				),
				array(
                    "group" => "Options",
					"save_always"   => true,
					"type" 			=> "dropdown",
					"holder"        => false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Stop Day",'heroes'),
					"param_name" 	=> "stop_day",
					"value" 		=> range( 1, 31 ),
					"default"		=> "default",
					"admin_label"	=> true,
				),
				array(
                    "group" => "Options",
					"save_always"   => true,
					"type" 			=> "dropdown",
					"holder"        => false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Stop Hour",'heroes'),
					"param_name" 	=> "stop_hour",
					"value" 		=> range( 0, 23 ),
					"default"		=> "default",
					"admin_label"	=> true,
				),
				array(
                    "group" => "Options",
					"save_always"   => true,
					"type" 			=> "dropdown",
					"holder"        => false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Stop Minute",'heroes'),
					"param_name" 	=> "stop_minute",
					"value" 		=> range( 0, 59 ),
					"default"		=> "default",
					"admin_label"	=> true,
				),
			),
		),

		array(
			"name" => esc_html__("Clients",'heroes'),
			"base" => "fwp-hero-clients",
			"icon" => get_template_directory_uri() . "/assets/img/phx_vc_icon.jpg",   
			"category" => esc_html__('Theme Elements','heroes'),
			"params" => array(
				array(
					"save_always" => true,
					"type" => "textarea",
					"holder" => false,
					
					"heading" => esc_html__("Clients Links",'heroes'),
					"param_name" => "content",
					"value" => '',
					"admin_label"=>false,
					"description" => esc_html__("Each client on new line. Pipe sepparated image and url",'heroes')
				),
				array(
					"save_always" => true,
					"type" 			=> "dropdown",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Autoplay",'heroes'),
					"param_name" 	=> "autoplay",
					"value" 		=> array('Yes' => 'true', 'No'=>'false' ),
					"description" 	=> esc_html__("Enable or disable autoplay.",'heroes'),
					"admin_label	"=>true,
				),
				array(
					"save_always" => true,
					"type" 			=> "dropdown",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Target URL",'heroes'),
					"param_name" 	=> "target",
					"value" 		=> array('Same Window' => '_self', 'New Window'=>'_blank' ),
					"description" 	=> esc_html__("Choose the way the URL will open.",'heroes'),
					"admin_label	"=>true,
				),
				array(
					"save_always" => true,
					"type" 			=> "dropdown",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Show controls",'heroes'),
					"param_name" 	=> "show_controls",
					"value" 		=> array('Yes' => 'true', 'No'=>'false' ),
					"description" 	=> esc_html__("Display controls.",'heroes'),
					"admin_label	"=>true,
				),  
				array(
					"save_always" => true,
					"type" 			=> "dropdown",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Animated",'heroes'),
					"param_name" 	=> "animated",
					"value" 		=> array('No' => 'false', 'Yes'=>'true' ),
					"description" 	=> esc_html__("Enable or disable element animation.",'heroes'),
					"admin_label	"=>true,
				),
				array(
					"save_always" => true,
					"type" 			=> "textfield",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Animation type",'heroes'),
					"param_name" 	=> "animation",
					"value" 		=> "enter left move 10px over 1s after 0.2s",
					"description" 	=> esc_html__("Select the type of animation for more info check documentation",'heroes'),
					"admin_label	"=>true,
				),
				array(
					"save_always" => true,
					"type" 			=> "textfield",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Animation start delay",'heroes'),
					"param_name" 	=> "animation_delay_start",
					"value" 		=> "0.6",
					"description" 	=> esc_html__("Select the delay when the animation starts.",'heroes'),
					"admin_label	"=>true,
				),
				array(
					"save_always" => true,
					"type" 			=> "textfield",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Animation steps delay",'heroes'),
					"param_name" 	=> "animation_delay_step",
					"value" 		=> "0.2",
					"description" 	=> esc_html__("Select the delay of the animation steps.",'heroes'),
					"admin_label	"=>true,
				),

			),
		),


        	array(
			"name" => esc_html__("Contact info",'heroes'),
			"base" => "fwp-hero-contact-info",
			"icon" => get_template_directory_uri() . "/assets/img/phx_vc_icon.jpg",
			"category" => esc_html__('Theme Elements','heroes'),
			"params" => array(

 				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,
					"heading" => esc_html__("Icon class",'heroes'),
					"param_name" => "icon",
					"value" => '',
					"admin_label"=>true,
					"description" => esc_html__("Icon class",'heroes')
				 ),
				array(
					"save_always" => true,
					"type" => "textarea_html",
					"holder" => false,
					"heading" => esc_html__("Contact info",'heroes'),
					"param_name" => "content",
					"value" => '',
					"admin_label"=>false,
					"description" => esc_html__("Enter here your informations",'heroes')
				 ),
                array(
					"save_always" => true,
					"type" => "vc_link",
					"holder" => false,
					"heading" => esc_html__("Element Link",'heroes'),
					"param_name" => "url",
					"value" => '',
					"admin_label"=>false,
					"description" => esc_html__("Insert link for ",'heroes')
				 ),
                array(
					"save_always" => true,
                    "group"         => "Styling",
					"type" => "colorpicker",
					"holder" => false,
					"heading" => esc_html__("Icon Color",'heroes'),
					"param_name" => "icon_color",
					"value" => '',
					"admin_label"=>false,
					"description" => esc_html__("Change icon color",'heroes')
				),
                array(
					"save_always" => true,
                    "group"      => "Styling",
					"type" => "textfield",
					"holder" => false,
					"heading" => esc_html__("Icon size",'heroes'),
					"param_name" => "icon_size",
					"value" => '',
					"admin_label"=>true,
					"description" => esc_html__("Icon size in px",'heroes')
				 ),
				array(
					"type" 			=> "dropdown",
                    "group"         => "Extras",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Animate",'heroes'),
					"param_name" 	=> "animated",
					"value" 		=> array('Yes'=>'true', 'No' => 'false'),
					"description" 	=> esc_html__("Animate element on scroll",'heroes'),
					"admin_label	"=>true,
				 ),
				array(
					"type" 			=> "textfield",
                    "group"         => "Extras",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Animation settings",'heroes'),
					"param_name" 	=> "animation",
					"value" 		=> 'enter left move 10px over 1s after 0.2s',
					"admin_label"	=>false,
					"description" 	=> esc_html__("Set settings classes (See theme documentation)",'heroes')
				 ),
                array(
					"save_always" => true,
                    "group"         => "Extras",
					"type" => "textfield",
					"holder" => false,
					"heading" => esc_html__("Extra class",'heroes'),
					"param_name" => "extra_class",
					"value" => '',
					"admin_label"=>true,
					"description" => esc_html__("Extra class name",'heroes')
				 ),
                array(
					"save_always" => true,
                    "group"         => "Extras",
					"type" => "textfield",
					"holder" => false,
					"heading" => esc_html__("Extra id",'heroes'),
					"param_name" => "extra_id",
					"value" => '',
					"admin_label"=>true,
					"description" => esc_html__("Extra id name, note that you need a unique id across theme",'heroes')
				 ),
			),
	   ),

	
		array(
			"name" => esc_html__("Contact Box",'heroes'),
			"base" => "fwp-hero-contact-box",
			"icon" => get_template_directory_uri() . "/assets/img/phx_vc_icon.jpg",   
			"category" => esc_html__('Theme Elements','heroes'),
			"params" => array(
				array(
					"type" 			=> "textfield",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Icon class",'heroes'),
					"param_name" 	=> "icon",
					"value" 		=> '',
					"admin_label"	=>false,
					"description" 	=> esc_html__("See documentation for valid icons",'heroes')
				 ),
				array(
					"save_always" => true,
					"type" => "colorpicker",
					"holder" => false,
					"heading" => esc_html__("Icon Color",'heroes'),
					"param_name" => "icon_color",
					"value" => '',
					"admin_label"=>false,
					"description" => esc_html__("Change icon color",'heroes')
				),
				array(
					"type" 			=> "dropdown",
					"holder" 		=> false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Icon Position",'heroes'),
					"param_name" 	=> "is_last",
					"value" 		=> array('Other'=>'','Last' => 'true'),
					"description" 	=> esc_html__("Use this in order to remove border on last element",'heroes'),
					"admin_label	"=>true,
					"save_always" => true,
				),
				array(
					"save_always" => true,
					"type" => "textarea_html",
					"holder" => false,					
					"heading" => esc_html__("Content",'heroes'),
					"param_name" => "content",
					"value" => '',
					"admin_label"=>false,
					"description" => esc_html__("Enter your content here.",'heroes')
				),
				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,
					"heading" => esc_html__("Extra class",'heroes'),
					"param_name" => "extra_class",
					"value" => '',
					"admin_label"=>true,
					"description" => esc_html__("Extra class name",'heroes')
				 ),
			),
		),  


/** 
D
**/

/** 
E
**/


/** 
F
**/

		array(
			"name" => esc_html__("Font Awesome Icon",'heroes'),
			"base" => "fa-icon",
			"icon" => get_template_directory_uri() . "/assets/img/phx_vc_icon.jpg",	
			"category" => esc_html__('Theme Elements','heroes'),
			"params" => array( 
				array(
					"type" 			=> "textfield",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Icon class",'heroes'),
					"param_name" 	=> "icon",
					"value" 		=> '',
					"admin_label"	=>false,
					"description" 	=> esc_html__("See documentation for valid icons",'heroes')
				 ),
				array(
					"type" 			=> "dropdown",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Icon size",'heroes'),
					"param_name" 	=> "size",
					"value" 		=> array('1X'=>'1', '2X' => '2', '3X'=>'3', '4X' => '4'),
					"description" 	=> esc_html__("Icon size relative to original",'heroes'),
					"admin_label	"=>true,
				 ),
			),
		),  
/** 
G
**/

/** 
H
**/

/** 
I
**/

/** 
J
**/

/** 
K
**/

/** 
L
**/

	array(
			"name" => esc_html__("Latest Projects Slider",'heroes'),
			"base" => "fwp-hero-latest-projects",
			"icon" => get_template_directory_uri() . "/assets/img/phx_vc_icon.jpg",
			"category" => esc_html__('Theme Elements','heroes'),
			"params" => array(

 				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,
					"heading" => esc_html__("Number of projects to show",'heroes'),
					"param_name" => "count",
					"value" => '3',
					"admin_label"=>true,
				),
				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,
					"heading" => esc_html__("Include just those projects",'heroes'),
					"param_name" => "include",
					"value" => '',
					"admin_label"=>true,
					"description" => esc_html__("Enter here IDs of projects to show",'heroes')
				),
				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,
					"heading" => esc_html__("Exclude those projects",'heroes'),
					"param_name" => "exclude",
					"value" => '',
					"admin_label"=>true,
					"description" => esc_html__("Enter here IDs of projects to ignore",'heroes')
				),
				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,
					"heading" => esc_html__("Include just those categories",'heroes'),
					"param_name" => "include_cats",
					"value" => '',
					"admin_label"=>true,
					"description" => esc_html__("Enter here IDs of categories to show",'heroes')
				),
				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,
					"heading" => esc_html__("Exclude those categories",'heroes'),
					"param_name" => "exclude_cats",
					"value" => '',
					"admin_label"=>true,
					"description" => esc_html__("Enter here IDs of categories to ignore",'heroes')
				),
				array(
					"type" 			=> "dropdown",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Animate",'heroes'),
					"param_name" 	=> "animated",
					"value" 		=> array('Yes'=>'true', 'No' => 'false'),
					"description" 	=> esc_html__("Animate element on scroll",'heroes'),
					"admin_label	"=>true,
				),
				array(
					"type" 			=> "textfield",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Animation settings",'heroes'),
					"param_name" 	=> "animation",
					"value" 		=> 'enter right move 10px over 1s after 0.2s',
					"admin_label"	=>false,
					"description" 	=> esc_html__("Set settings classes (See theme documentation)",'heroes')
				 ),
 				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,

					"heading" => esc_html__("Extra class",'heroes'),
					"param_name" => "extra_class",
					"value" => '',
					"admin_label"=>true,
				),
			),
		),

/** 
M
**/

array(
			"name" => esc_html__("Mesage box",'heroes'),
			"base" => "fwp-hero-message",
			"icon" => get_template_directory_uri() . "/assets/img/phx_vc_icon.jpg",   
			"category" => esc_html__('Theme Elements','heroes'),
			"params" => array( 
				array(
					"type" 			=> "dropdown",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Message type",'heroes'),
					"param_name" 	=> "type",
					"value" 		=> array('Success' => 'success', 'Info' => 'info', 'Warning' => 'warning', 'Danger' => 'danger' ),
					"description" 	=> esc_html__("Select message box type",'heroes'),
					"admin_label	"=>true,
				),
				array(
					"type" 			=> "dropdown",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Dismissible message",'heroes'),
					"param_name" 	=> "dismissible",
					"value" 		=> array('No' => 'false', 'Yes'=>'true' ),
					"description" 	=> esc_html__("Dismissible message",'heroes'),
					"admin_label	"=>true,
				),
				array(
					"save_always" => true,
					"type" => "textarea_html",
					"holder" => false,
					
					"heading" => esc_html__("Message",'heroes'),
					"param_name" => "content",
					"value" => '',
					"admin_label"=>false,
					"description" => esc_html__("Enter your message here",'heroes')
				),
			),
		),

	array(
			"name" => esc_html__("Google map",'heroes'),
			"base" => "fwp-hero-map",
			"icon" => get_template_directory_uri() . "/assets/img/phx_vc_icon.jpg",	
			"category" => esc_html__('Theme Elements','heroes'),
			"params" => array(
				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,
					
					"heading" => esc_html__("Center of map",'heroes'),
					"param_name" => "center",
					"value" => '44.434596, 26.080533',
					"admin_label"=>true,
				),
				array(
					"type" 			=> "dropdown",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Map style",'heroes'),
					"param_name" 	=> "map_style",
					"value" 		=> array('FastWP Style (dark)'=>'fastwp-hero', 'Default Google style' => 'default'),
					"description" 	=> esc_html__("Choose map style",'heroes'),
					"admin_label	"=>true,
				 ),
				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,
					
					"heading" => esc_html__("Default zoom",'heroes'),
					"param_name" => "map_zoom",
					"value" => '8',
					"admin_label"=>true,
				),
				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,
					
					"heading" => esc_html__("Zoom of map when click on a marker",'heroes'),
					"param_name" => "map_izoom",
					"value" => '12',
					"admin_label"=>true,
				),

				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,
					
					"heading" => esc_html__("Marker coordinates",'heroes'),
					"param_name" => "marker_addr",
					"value" => '44.434596, 26.080533',
					"admin_label"=>false,
					"description" => esc_html__("Pipe separated address, latitude and longitude separted by comma",'heroes')
				),

				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,
					
					"heading" => esc_html__("Marker titles",'heroes'),
					"param_name" => "marker_titles",
					"value" => 'We are Hero',
					"admin_label"=>false,
					"description" => esc_html__("Pipe separated titles",'heroes')
				),

				array(
					"save_always" => true,
					"type" => "textarea_html",
					"holder" => false,
					
					"heading" => esc_html__("Marker content",'heroes'),
					"param_name" => "content",
					"value" => '',
					"admin_label"=>false,
					"description" => esc_html__("Pipe separated content of markers",'heroes')
				 ),


 				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,
					
					"heading" => esc_html__("Extra class",'heroes'),
					"param_name" => "extra_class",
					"value" => '',
					"admin_label"=>true,
				),
				
			),
	   ),



/** 
N
**/

/** 
O
**/

/** 
P
**/

		array(
			"name" => esc_html__("Price Table",'heroes'),
			"base" => "fwp-hero-pricetable",
			"icon" => get_template_directory_uri() . "/assets/img/phx_vc_icon.jpg",   
			"category" => esc_html__('Theme Elements','heroes'),
			"params" => array(
				array(
					"save_always" => true,
					"type" 			=> "textfield",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Price",'heroes'),
					"param_name" 	=> "price",
					"value" 		=> "0",
					"description" 	=> esc_html__("Set the price here.",'heroes'),
					"admin_label	"=>true,
				), 
				array(
					"type" 			=> "dropdown",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Currency",'heroes'),
					"param_name" 	=> "currency",
					"value" 		=> array('Dollars' => '$', 'Euros' => '€'),
					"description" 	=> esc_html__("Select the currency you want.",'heroes'),
					"save_always"	=> true,
					"admin_label"	=> true,
				),
				array(
					"save_always" => true,
					"type" 			=> "textfield",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Suffix",'heroes'),
					"param_name" 	=> "suffix",
					"value" 		=> "/month",
					"description" 	=> esc_html__("Choose the billing cycle.",'heroes'),
					"admin_label	"=>true,
				),
				array(
					"type" 			=> "dropdown",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Suffix First",'heroes'),
					"param_name" 	=> "suffix_first",
					"value" 		=> array('No' => 'false', 'Yes' => 'true'),
					"description" 	=> esc_html__("Choose how the suffix will be displayed.",'heroes'),
					"save_always"	=> true,
					"admin_label"	=> true,
				),
				array(
					"save_always" => true,
					"type" 			=> "textfield",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Title",'heroes'),
					"param_name" 	=> "title",
					"value" 		=> "",
					"description" 	=> esc_html__("Set the title of your table.",'heroes'),
					"admin_label	"=>true,
				),
				array(
					"save_always" => true,
					"type" => "textarea",
					"class"	=> "",
					"holder" => false,					
					"heading" => esc_html__("Content",'heroes'),
					"param_name" => "content",
					"value" => '',
					"admin_label"=>false,
					"description" => esc_html__("Fill in the content.",'heroes')
				),
				array(
					"type" 			=> "dropdown",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Stars",'heroes'),
					"param_name" 	=> "stars",
					"value" 		=> array('1 Star' => '1', '2 Stars' => '2', '3 Stars' => '3', '4 Stars' => '4', '5 Stars' => '5'),
					"description" 	=> esc_html__("Rate the service which will be displayed.",'heroes'),
					"save_always"	=> true,
					"admin_label"	=> true,
				),
				array(
					"save_always" => true,
					"type" 			=> "textfield",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Submit Label",'heroes'),
					"param_name" 	=> "submit_label",
					"value" 		=> "SUBSCRIBE!",
					"description" 	=> esc_html__("Type the name of the submission label, the name of the button. (For example: Buy now!)",'heroes'),
					"admin_label	"=>true,
				),
				array(
					"save_always" => true,
					"type" 			=> "textfield",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Submit URL",'heroes'),
					"param_name" 	=> "submit_url",
					"value" 		=> "",
					"description" 	=> esc_html__("Fill in the URL of the submit button.",'heroes'),
					"admin_label	"=>true,
				),
				array(
					"type" 			=> "dropdown",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Submit Target",'heroes'),
					"param_name" 	=> "submit_target",
					"value" 		=> array('New Window' => '_blank', 'Same Window' => '_self'),
					"description" 	=> esc_html__("Choose the way the URL will open.",'heroes'),
					"save_always"	=> true,
					"admin_label"	=> true,
				),
				array(
					"type" 			=> "dropdown",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Remove button",'heroes'),
					"param_name" 	=> "remove_button",
					"value" 		=> array('No' => 'false', 'Yes' => 'true'),
					"description" 	=> esc_html__("Remove the button from your table.",'heroes'),
					"save_always"	=> true,
					"admin_label"	=> true,
				),
				array(
					"save_always" => true,
					"type" 			=> "dropdown",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Animated",'heroes'),
					"param_name" 	=> "animated",
					"value" 		=> array('No' => 'false', 'Yes'=>'true' ),
					"description" 	=> esc_html__("Enable or disable element animation.",'heroes'),
					"admin_label	"=>true,
				),
				array(
					"save_always" => true,
					"type" 			=> "textfield",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Animation type",'heroes'),
					"param_name" 	=> "animation",
					"value" 		=> "enter bottom move 10px over 1s after 0.2s",
					"description" 	=> esc_html__("Select the type of animation for more info check documentation",'heroes'),
					"admin_label	"=>true,
				),
			),
		),

		array(
			"name" => esc_html__("Portfolio",'heroes'),
			"base" => "fwp-hero-portfolio",
			"icon" => get_template_directory_uri() . "/assets/img/phx_vc_icon.jpg",	
			"category" => esc_html__('Theme Elements','heroes'),
			"params" => array( 
				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,
					
					"heading" => esc_html__("Include just those projects",'heroes'),
					"param_name" => "include",
					"value" => '',
					"admin_label"=>true,
					"description" => esc_html__("Enter here IDs of projects to show",'heroes')
				),
				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,
					
					"heading" => esc_html__("Exclude those projects",'heroes'),
					"param_name" => "exclude",
					"value" => '',
					"admin_label"=>true,
					"description" => esc_html__("Enter here IDs of projects to ignore",'heroes')
				),
				array(
					"save_always"   => true,
					"type"          => "textfield",
					"holder"        => false,
					"heading"       => esc_html__("Include those categories",'heroes'),
					"param_name"    => "include_cats",
					"value"         => '',
					"admin_label"   => true,
					"description"   => esc_html__("Enter here IDs of categories to show",'heroes')
				),
				array(
					"save_always"   => true,
					"type"          => "textfield",
					"holder"        => false,
					"heading"       => esc_html__("Exclude those categories",'heroes'),
					"param_name"    => "exclude_cats",
					"value"         => '',
					"admin_label"   => true,
					"description"   => esc_html__("Enter here IDs of categories to ignore",'heroes')
				),
				array(
					"type" 			=> "dropdown",
					"holder" 		=> false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Overlay visible on mobile",'heroes'),
					"param_name" 	=> "show_overlay",
					"value" 		=> array('No' => 'No', 'Yes'=>'yes'),
					"description" 	=> esc_html__("Show overlay active by default on touch devices like project is hovered",'heroes'),
					"admin_label	"=> true,
				 ),
				array(
					"type" 			=> "dropdown",
					"holder" 		=> false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Boxed style",'heroes'),
					"param_name" 	=> "boxed",
					"value" 		=> array('No' => 'No', 'Yes'=>'yes'),
					"description" 	=> esc_html__("Show portfolio items in container",'heroes'),
					"admin_label	"=>true,
				 ),
				array(
					"type" 			=> "dropdown",
					"holder" 		=> false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Portfolio grid style",'heroes'),
					"param_name" 	=> "styleid",
					"value" 		=> array('3 Columns(default)' => '0', '2 Columns'=>'1', '4 Columns'=>'2', 'Detalied items'=>'3'),
					"description" 	=> esc_html__("Show portfolio items in container",'heroes'),
					"admin_label	"=>true,
				 ),
				array(
					"type" 			=> "dropdown",
					"holder" 		=> false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Display filters",'heroes'),
					"param_name" 	=> "show_filters",
					"value" 		=> array('Yes'=>'yes','No' => 'No'),
					"description" 	=> esc_html__("Display or not the project filters",'heroes'),
					"admin_label	"=>true,
				 ),
				 array(
					"save_always" => true,
					"type" => "colorpicker",
					"holder" => false,
					"heading" => esc_html__("Filter background color",'heroes'),
					"param_name" => "filter_bg",
					"value" => '',
					"admin_label"=>false,
					"description" => esc_html__("Color for background on portfolio filters",'heroes')
				),
				 array(
					"save_always" => true,
					"type" => "colorpicker",
					"holder" => false,
					"heading" => esc_html__("Filter buttons color",'heroes'),
					"param_name" => "filter_col",
					"value" => '',
					"admin_label"=>false,
					"description" => esc_html__("Color for filter and border on portfolio filter buttons",'heroes')
				),
				 array(
					"save_always" => true,
					"type" => "colorpicker",
					"holder" => false,
					"heading" => esc_html__("Filter hover color",'heroes'),
					"param_name" => "filter_col_hov",
					"value" => '',
					"admin_label"=>false,
					"description" => esc_html__("Color for filter when hover",'heroes')
				),
				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,		
					"heading" => esc_html__("Label for All projects",'heroes'),
					"param_name" => "all_label",
					"value" => '',
					"admin_label"=>false,
					"description" => esc_html__('Default: "Show all"','heroes')
				 ),
					array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,   
					"heading" => esc_html__("Label for portfolio button",'heroes'),
					"param_name" => "button_label",
					"value" => 'More',
					"admin_label"=>false,
					"description" => esc_html__('Default: "More"','heroes')
				 ),
				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,
					
					"heading" => esc_html__("Extra class",'heroes'),
					"param_name" => "extra_class",
					"value" => '',
					"admin_label"=>true,
					"description" => esc_html__("Extra class name",'heroes')
				 ),
				array(
					"type" 			=> "dropdown",
					"holder" 		=> false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Animate text",'heroes'),
					"param_name" 	=> "animated",
					"value" 		=> array('Yes'=>'true', 'No' => 'false'),
					"description" 	=> esc_html__("Animate element on scroll",'heroes'),
					"admin_label	"=>true,
				 ),
				array(
					"type" 			=> "textfield",
					"holder" 		=> false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Animation settings",'heroes'),
					"param_name" 	=> "animation",
					"value" 		=> 'enter bottom move 10px over 1s after 0.2s',
					"admin_label"	=>false,
					"description" 	=> esc_html__("Set settings classes (See theme documentation)",'heroes')
				 ),
				array(
					"type" 			=> "textfield",
					"holder" 		=> false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Animation delay increase",'heroes'),
					"param_name" 	=> "anim_delay",
					"value" 		=> '0.1',
					"admin_label"	=>false,
					"description" 	=> esc_html__("Animation delay for grouped items (in seconds)",'heroes')
				 ),
			)
		),


/** 
S
**/


array(
		"name" => esc_html__("Slider background section",'heroes'),
		"base" => "fwp-hero-sliderbg",
		"icon" => get_template_directory_uri() . "/assets/img/phx_vc_icon.jpg",	  
		"category" => esc_html__('Home sections','heroes'),
		"params" => array(
				array(
					"save_always" 	=> true,
					"type" 			=> "attach_images",
					"holder" 		=> false,
					"heading" 		=> esc_html__("Images",'heroes'),
					"param_name" 	=> "images",
					"value" 		=> '',
					"admin_label"	=>false,
					"description" 	=> esc_html__("Items to run into background slider",'heroes')
				),
				array(
					"type" 			=> "dropdown",
					"save_always" 	=> true,
					"holder" 		=> false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Overlay content page",'heroes'),
					"param_name" 	=> "pageid",
					"value" 		=> getPostIdAndTitle('page', true),
					"description" 	=> esc_html__("Animate element on scroll",'heroes'),
					"admin_label	"=>true,
				),
				array(
					"type" 			=> "dropdown",
					"save_always" 	=> true,
					"holder" 		=> false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Black overlay",'heroes'),
					"param_name" 	=> "overlay",
					"value" 		=> array('Yes'=>'true', 'No' => 'false'),
					"description" 	=> esc_html__("Add transparent overlay over content",'heroes'),
					"admin_label	"=>true,
				),
				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,
					
					"heading" => esc_html__("Duration",'heroes'),
					"param_name" => "duration",
					"value" => '2000',
					"admin_label"=>true,
				),
				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,
					
					"heading" => esc_html__("Fade",'heroes'),
					"param_name" => "fade",
					"value" => '750',
					"admin_label"=>true,
				),
				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,
					
					"heading" => esc_html__("Extra class",'heroes'),
					"param_name" => "extra_class",
					"value" => '',
					"admin_label"=>true,
					"description" => esc_html__("Extra class name",'heroes')
				 ),
			
		)
	),


		array(
			"name" => esc_html__("Services",'heroes'),
			"base" => "fwp-hero-services",
			"icon" => get_template_directory_uri() . "/assets/img/phx_vc_icon.jpg",   
			"category" => esc_html__('Theme Elements','heroes'),
			"params" => array(
				array(
					"save_always" => true,
					"type" 			=> "dropdown",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Order",'heroes'),
					"param_name" 	=> "order",
					"value" 		=> array('Descending' => 'DESC', 'Ascending'=>'ASC' ),
					"description" 	=> esc_html__("Order posts.",'heroes'),
					"admin_label	"=>true,
				),
					array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,
					
					"heading" => esc_html__("Include just those projects",'heroes'),
					"param_name" => "include",
					"value" => '',
					"admin_label"=>true,
					"description" => esc_html__("Enter here IDs of projects to show",'heroes')
				),
				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,
					
					"heading" => esc_html__("Exclude those projects",'heroes'),
					"param_name" => "exclude",
					"value" => '',
					"admin_label"=>true,
					"description" => esc_html__("Enter here IDs of projects to ignore",'heroes')
				), 
			),
		),
		array(
			"name" => esc_html__("Social Icons Holder",'heroes'),
			"base" => "fwp_hero_socialicons_container",
			'as_parent' => array('only' => 'fwp_hero_socialicons_item' ),
			"icon" => get_template_directory_uri() . "/assets/img/phx_vc_icon.jpg",   
			"category" => esc_html__('Theme Elements','heroes'),
			'content_element' => true,
			'show_settings_on_create' => true,
			"params" => array(
				 array(
					"save_always" => true,
					"type" => "dropdown",
					"holder" => false,
					"heading" => esc_html__("Image align",'heroes'),
					"param_name" => "alignment",
					"value" => array('Center'=>'', 'Left' => 'text-left', 'Right' => 'text-right'),
					"admin_label"=>true,
				 ),
				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,
					"heading" => esc_html__("Extra class",'heroes'),
					"param_name" => "extra_class",
					"value" => '',
					"admin_label"=>false,
				),
			),
			'js_view' => 'VcColumnView' 
		),
		array(
			"name" => esc_html__("Social Icons",'heroes'),
			"base" => "fwp_hero_socialicons_item",
			'as_child' => array('only' => 'fwp_hero_socialicons_container' ),
			"icon" => get_template_directory_uri() . "/assets/img/phx_vc_icon.jpg",   
			"category" => esc_html__('Theme Elements','heroes'),
			'content_element' => true,
			"params" => array(
				array(
					"save_always" => true,
					"type" 			=> "iconpicker",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Icon class",'heroes'),
					"param_name" 	=> "icon_class",
					"value" 		=> "",
					"description" 	=> esc_html__("Select the class of the font-awesome icon. (Here are all the font-awesome icons: https://fortawesome.github.io/Font-Awesome/icons/) // Use for example: facebook",'heroes'),
					"admin_label	"=>true,
				),
				array(
					"group"	=> "Styling",
					"save_always"	=> true,
					"type" 			=> "colorpicker",
					"class"			=> "",
					"heading"		=> esc_html__( "Icon color", "heroes" ),
					"param_name" => "color",
					"value" => '#282828',
					"description" => esc_html__( "Choose the color of the icon.", "heroes" )
				),
				array(
					"save_always"	=> true,
					"group"	=> "Styling",
					"type" 			=> "colorpicker",
					"class"			=> "",
					"heading"		=> esc_html__( "Icon background color", "heroes" ),
					"param_name" => "icon_background",
					"value" => 'rgba(245,245,245,1)',
					"description" => esc_html__( "Choose the background color of the icon.", "heroes" )
				),
				array(
					"save_always"	=> true,
					"group"	=> "Styling",
					"type" 			=> "colorpicker",
					"class"			=> "",
					"heading"		=> esc_html__( "Icon background hover color", "heroes" ),
					"param_name" => "icon_background_hover",
					"value" => 'rgba(0,0,0,1)',
					"description" => esc_html__( "Choose the background color of the icon.", "heroes" )
				),
				array(
					"save_always"	=> true,
					"group"	=> "Styling",
					"type" 			=> "colorpicker",
					"class"			=> "",
					"heading"		=> esc_html__( "Icon color hover", "heroes" ),
					"param_name" => "icon_color_hover",
					"value" => '#fff',
					"description" => esc_html__( "Choose the color of the hover icon.", "heroes" )
				),
				array(
					"save_always"	=> true,
					"group"	=> "Styling",
					"type" 			=> "colorpicker",
					"class"			=> "",
					"heading"		=> esc_html__( "Icon border color", "heroes" ),
					"param_name" => "icon_border",
					"value" => '#282828',
					"description" => esc_html__( "Choose the color of the border.", "heroes" )
				),
				array(
					"save_always" => true,
					"type" 			=> "textfield",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Icon URL",'heroes'),
					"param_name" 	=> "url",
					"value" 		=> "",
					"description" 	=> esc_html__("Fill in the URL of the icon.",'heroes'),
					"admin_label	"=>true,
				),
				array(
					"save_always" => true,
					"type" 			=> "dropdown",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Target URL",'heroes'),
					"param_name" 	=> "target",
					"value" 		=> array('New Window' => '_blank', 'Same Window'=>'_self' ),
					"description" 	=> esc_html__("Select the way you want the URL to open.",'heroes'),
					"admin_label	"=>true,
				),
				array(
					"save_always" => true,
					"type" 			=> "textfield",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Border width",'heroes'),
					"param_name" 	=> "border_width",
					"value" 		=> "",
					"description" 	=> esc_html__("Choose the width of the border.",'heroes'),
					"admin_label	"=>true,
				),
				array(
					"save_always" => true,
					"type" 			=> "dropdown",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Animated",'heroes'),
					"param_name" 	=> "animated",
					"value" 		=> array('No' => 'false', 'Yes'=>'true' ),
					"description" 	=> esc_html__("Enable or disable element animation.",'heroes'),
					"admin_label	"=>true,
				),
				array(
					"save_always" => true,
					"type" 			=> "textfield",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Animation type",'heroes'),
					"param_name" 	=> "animation",
					"value" 		=> "enter top move 10px over 1s after 0.2s",
					"description" 	=> esc_html__("Select the type of animation for more info check documentation",'heroes'),
					"admin_label	"=>true,
				),
			),
		),
	array(
			"name" 		=> esc_html__("Stellar Image (Parallax)",'heroes'),
			"base" 		=> "fwp-hero-stellarimage",
			"class" 		=> "",
			"icon" => get_template_directory_uri() . "/assets/img/phx_vc_icon.jpg",  
			"category" 	=> esc_html__('Theme Elements','heroes'),
			"params" 		=> array( 
				
				array(
					"save_always" => true,
					"type" => "attach_image",
					"holder" => false,		
					"heading" => esc_html__("Select image",'heroes'),
					"param_name" => "image",
					"value" => '',
					"admin_label"=>false,
					"description" => esc_html__("Choose the image to animate",'heroes')
				),

 				array(
					"save_always" => true,
					"type" => "dropdown",
					"holder" => false,
					"heading" => esc_html__("Image align",'heroes'),
					"param_name" => "alignment",
					"value" => array('None (Default)'=>'', 'Left' => 'abs_alignleft', 'Center' => 'abs_aligncenter', 'Right' => 'abs_alignright'),
					"admin_label"=>true,
				 ),
 				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,		
					"heading" => esc_html__("Movement ratio",'heroes'),
					"param_name" => "data_ratio",
					"value" => "0.5",
					"description" => esc_html__("Set movement ratio (Default: 0.5)",'heroes'),
					"admin_label"=>false,
				 ),
				array(
					"group"	=> "Extras",
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,
					"heading" => esc_html__("Extra class",'heroes'),
					"param_name" => "extra_class",
					"value" => '',
					"admin_label"=>false,
				), 
			)
	   ),

		array(
			"name" => esc_html__("Subtitle",'heroes'),
			"base" => "fwp-hero-subtitle",
			"icon" => get_template_directory_uri() . "/assets/img/phx_vc_icon.jpg",   
			"category" => esc_html__('Theme Elements','heroes'),
			"params" => array( 
				array(
					"type" 			=> "dropdown",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Title Tag",'heroes'),
					"param_name" 	=> "tag",
					"value" 		=> array('H1' => 'h1', 'H2' => 'h2', 'H3' => 'h3', 'H4' => 'h4' , 'H5' => 'h5', 'H6' => 'h6'),
					"description" 	=> esc_html__("You can select the Subtitle tag - From H1 to H6",'heroes'),
					"save_always"	=> true,
					"default"		=> "h4",
					"admin_label"	=> true,
				),
				array(
					"type" 			=> "dropdown",
					"holder" 		=> false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Subtitle class",'heroes'),
					"param_name" 	=> "class",
					"value" 		=> array('Default'=>'', 'Serif' => 'serif', 'Minimal' => 'minimal'),
					"description" 	=> esc_html__("Choose from available classes",'heroes'),
					"save_always"	=> true,
					"admin_label"	=> true,
				),
				array(
					"type" 			=> "dropdown",
					"holder" 		=> false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Alignment",'heroes'),
					"param_name" 	=> "align",
					"value" 		=> array('None'=>'', 'Left' => 'left', 'Right' => 'right', 'Center' => 'center'),
					"description" 	=> esc_html__("Choose from available classes",'heroes'),
					"save_always"	=> true,
					"admin_label"	=> true,
				),
				array(
					"save_always" => true,
					"type" => "textfield",
					"class"	=> "",
					"holder" => false,					
					"heading" => esc_html__("Subtitle",'heroes'),
					"param_name" => "text",
					"value" => '',
					"admin_label"=>false,
					"description" => esc_html__("Type in the subtitle.",'heroes')
				),

				array(
					"group"			=> 'Color Properties',
					"save_always"	=> true,
					"type" 			=> "colorpicker",
					"class"			=> "",
					"heading"		=> esc_html__( "Subtitle color", "heroes" ),
					"param_name" => "color",
					"value" => '#777',
					"description" => esc_html__( "Choose the color of the subtitle.", "heroes" )
				),

				array(
					"group"			=> 'Color Properties',
					"save_always"	=> true,
					"type" 			=> "colorpicker",
					"class"			=> "",
					"heading"		=> esc_html__( "Subtitle small class color", "heroes" ),
					"param_name" => "small_color",
					"value" => '#777',
					"description" => esc_html__( "Choose the color of the subtitle small class.", "heroes" )
				),

				array(
					"group"			=> "Animation Settings",
					"save_always" => true,
					"type" 			=> "dropdown",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Animated",'heroes'),
					"param_name" 	=> "animated",
					"value" 		=> array('No' => 'false', 'Yes'=>'true' ),
					"description" 	=> esc_html__("Enable or disable element animation.",'heroes'),
					"admin_label	"=>true,
				),
				array(
					"group"			=> "Animation Settings",
					"save_always" => true,
					"type" 			=> "textfield",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Animation type",'heroes'),
					"param_name" 	=> "animation",
					"value" 		=> "enter top move 10px over 1s after 0.2s",
					"description" 	=> esc_html__("Select the type of animation for more info check documentation",'heroes'),
					"admin_label	"=>true,
				),
			),
		),
		
		array(
			"name" => esc_html__("Separator",'heroes'),
			"base" => "fwp-hero-separator",
			"icon" => get_template_directory_uri() . "/assets/img/phx_vc_icon.jpg",   
			"category" => esc_html__('Theme Elements','heroes'),
			"params" => array( 
				array(
					"save_always" => true,
					"type" 			=> "textfield",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Width",'heroes'),
					"param_name" 	=> "width",
					"value" 		=> "",
					"description" 	=> esc_html__("Choose the width of the separator.",'heroes'),
					"admin_label	"=>true,
				),
				array(
					"save_always" => true,
					"type" 			=> "textfield",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Height",'heroes'),
					"param_name" 	=> "height",
					"value" 		=> "",
					"description" 	=> esc_html__("Choose the height of the separator.",'heroes'),
					"admin_label	"=>true,
				),
				array(
					"type" 			=> "dropdown",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Separator type",'heroes'),
					"param_name" 	=> "type",
					"value" 		=> array('Line Separator' => 'separator', 'Verical Line Separator' => 'vertical', 'Black Image Separator' => 'image', 'White Image Separator' => 'image-white', 'Vertical Image Separator' => 'image-vertical'),
					"description" 	=> esc_html__("Select the type of separator you want to display. Note that only the 'separator' type can change it's color, the other two are simple images.",'heroes'),
					"save_always"	=> true,
					"admin_label"	=> true,
				),
				array(
					"type" 			=> "dropdown",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Separator centered",'heroes'),
					"param_name" 	=> "class",
					"value" 		=> array('No' => '', 'Yes' => 'center-block'),
					"description" 	=> esc_html__("Centered separator?",'heroes'),
					"save_always"	=> true,
					"admin_label"	=> true,
				),
				array(
					"save_always"	=> true,
					"type" 			=> "colorpicker",
					"class"			=> "",
					"heading"		=> esc_html__( "Separator color", "heroes" ),
					"param_name" 	=> "background",
					"value" 		=> '#fff',
					"description" 	=> esc_html__( "This option is available only for the Line Separator type.", "heroes" )
				),
				array(
					"save_always"   => true,
					"type" 			=> "textfield",
					"holder"        => false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Extra Class",'heroes'),
					"param_name" 	=> "extra_class",
					"value" 		=> "",
					"description" 	=> esc_html__("Extra class name",'heroes'),
					"admin_label"   => true,
				),

				// array(
				// 	"save_always" => true,
				// 	"type" 			=> "textfield",
				// 	"holder" => false,
				// 	"class" 		=> "",
				// 	"heading" 		=> esc_html__("Separator class",'heroes'),
				// 	"param_name" 	=> "class",
				// 	"value" 		=> "",
				// 	"description" 	=> esc_html__("Choose the class of the separator. (There are 3 classes you can use for this: 'separator' / 'image' / 'imagevertical'). The 'separator' class is a simple css line, the other two are images. Only the 'separator' class will have the option to change it's color. ",'heroes'),
				// 	"admin_label	"=>true,
				// ),
				// array(
				// 	"save_always" => true,
				// 	"type" => "textarea",
				// 	"class"	=> "minimal",
				// 	"holder" => false,					
				// 	"heading" => esc_html__("Subtitle",'heroes'),
				// 	"param_name" => "content",
				// 	"value" => '',
				// 	"admin_label"=>false,
				// 	"description" => esc_html__("Type in the subtitle.",'heroes')
				// ),
				// array(
				// 	"save_always"	=> true,
				// 	"type" 			=> "colorpicker",
				// 	"class"			=> "",
				// 	"heading"		=> esc_html__( "Line color", "heroes" ),
				// 	"param_name" => "line_color",
				// 	"value" => '#000',
				// 	"description" => esc_html__( "Choose the line color.", "heroes" )
				// ),
				// array(
				// 	"save_always" => true,
				// 	"type" 			=> "dropdown",
				// 	"holder" => false,
				// 	"class" 		=> "",
				// 	"heading" 		=> esc_html__("Animated",'heroes'),
				// 	"param_name" 	=> "animated",
				// 	"value" 		=> array('No' => 'false', 'Yes'=>'true' ),
				// 	"description" 	=> esc_html__("Enable or disable element animation.",'heroes'),
				// 	"admin_label	"=>true,
				// ),
				// array(
				// 	"save_always" => true,
				// 	"type" 			=> "textfield",
				// 	"holder" => false,
				// 	"class" 		=> "",
				// 	"heading" 		=> esc_html__("Animation type",'heroes'),
				// 	"param_name" 	=> "animation",
				// 	"value" 		=> "enter top move 10px over 1s after 0.2s",
				// 	"description" 	=> esc_html__("Select the type of animation for more info check documentation",'heroes'),
				// 	"admin_label	"=>true,
				// ),
			),
		),


/**
T
**/

		array(
			"name" => esc_html__("Testimonials",'heroes'),
			"base" => "fwp-hero-testimonials",
			"icon" => get_template_directory_uri() . "/assets/img/phx_vc_icon.jpg",   
			"category" => esc_html__('Theme Elements','heroes'),
			"params" => array( 
				array(
					"save_always" => true,
					"type" 			=> "dropdown",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Animated",'heroes'),
					"param_name" 	=> "animated",
					"value" 		=> array('No' => 'false', 'Yes'=>'true' ),
					"description" 	=> esc_html__("Enable or disable element animation.",'heroes'),
					"admin_label	"=>true,
				),
				array(
					"save_always" => true,
					"type" 			=> "textfield",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Animation type",'heroes'),
					"param_name" 	=> "animation",
					"value" 		=> "enter left move 10px over 1s after 0.2s",
					"description" 	=> esc_html__("Select the type of animation for more info check documentation",'heroes'),
					"admin_label	"=>true,
				),
				array(
					"save_always" => true,
					"type" 			=> "textfield",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Include Testimonials",'heroes'),
					"param_name" 	=> "include",
					"value" 		=> "",
					"description" 	=> esc_html__("Select the ID's of the testimonials you want to include.",'heroes'),
					"admin_label	"=>true,
				),
				array(
					"save_always" => true,
					"type" 			=> "textfield",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Exclude Testimonials",'heroes'),
					"param_name" 	=> "exclude",
					"value" 		=> "",
					"description" 	=> esc_html__("Select the ID's of the testimonials you want to exclude.",'heroes'),
					"admin_label	"=>true,
				),
			),
		),
		array(
			"name" => esc_html__("Team",'heroes'),
			"base" => "fwp-hero-team",
			"icon" => get_template_directory_uri() . "/assets/img/phx_vc_icon.jpg",   
			"category" => esc_html__('Theme Elements','heroes'),
			"params" => array( 
				array(
					"save_always" => true,
					"type" 			=> "dropdown",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Animated",'heroes'),
					"param_name" 	=> "animated",
					"value" 		=> array('No' => 'false', 'Yes'=>'true' ),
					"description" 	=> esc_html__("Enable or disable element animation.",'heroes'),
					"admin_label	"=>true,
				),
				array(
					"save_always" => true,
					"type" 			=> "textfield",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Animation type",'heroes'),
					"param_name" 	=> "animation",
					"value" 		=> "enter left move 10px over 1s after 0.2s",
					"description" 	=> esc_html__("Select the type of animation for more info check documentation",'heroes'),
					"admin_label	"=>true,
				),
				array(
					"save_always" => true,
					"type" 			=> "textfield",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Initial delay",'heroes'),
					"param_name" 	=> "initial_delay",
					"value" 		=> "0.8",
					"description" 	=> esc_html__("Select the initial delay.",'heroes'),
					"admin_label	"=>true,
				),
				array(
					"save_always" => true,
					"type" 			=> "textfield",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Increment delay",'heroes'),
					"param_name" 	=> "increment_delay",
					"value" 		=> "0.2",
					"description" 	=> esc_html__("Select the incremented delay.",'heroes'),
					"admin_label	"=>true,
				),
			),
		),
		array(
			"name" => esc_html__("Title Serif",'heroes'),
			"base" => "fwp-hero-titlewithserif",
			"icon" => get_template_directory_uri() . "/assets/img/phx_vc_icon.jpg",
			"category" => esc_html__('Theme Elements','heroes'),
			"params" => array(
				array(
					"type" 			=> "dropdown",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Title Tag",'heroes'),
					"param_name" 	=> "tag",
					"value" 		=> array('H1' => 'h1', 'H2' => 'h2', 'H3' => 'h3', 'H4' => 'h4' , 'H5' => 'h5', 'H6' => 'h6'),
					"description" 	=> esc_html__("You can select the Title tag - From H1 to H6",'heroes'),
					"save_always"	=> true,
					"default"		=> "h2",
					"admin_label"	=> true,
				),
				array(
					"save_always" 	=> true,
					"type" 			=> "dropdown",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Title Class",'heroes'),
					"param_name" 	=> "class",
					"value" 		=> array('Default' => '', 'Minimal' => 'minimal'),
					"description" 	=> esc_html__("Choose Title class.",'heroes'),
					"default"		=> "h2",
					"admin_label"	=> true,
				),
				array(
					"save_always" 	=> true,
					"type" 			=> "dropdown",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Show Line",'heroes'),
					"param_name" 	=> "show_line",
					"value" 		=> array('Yes' => 1, 'No' => 0),
					"description" 	=> esc_html__("Choose to show or hide line on title.",'heroes'),
					"default"		=> 1,
					"admin_label"	=> true,
				),
				array(
					"save_always" => true,
					"type" => "textarea",
					"holder" => false,					
					"heading" => esc_html__("Title",'heroes'),
					"param_name" => "content",
					"value" => '',
					"admin_label"=>false,
					"description" => esc_html__("Type in the title., wrap text into span class serif to apply serif",'heroes')
				),
				array(
					"save_always" => true,
					"type" 			=> "dropdown",
					"holder" 		=> false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Align",'heroes'),
					"param_name" 	=> "alignment",
					"value" 		=> array('Center'=>'center','Left' => '', 'Right'=>'right'),
					"description" 	=> esc_html__("Title alignment. Default center",'heroes'),
					"admin_label	"=>true,
				),
				array(
					"save_always"	=> true,
					"type" 			=> "colorpicker",
					"class"			=> "",
					"heading"		=> esc_html__( "Title color", "heroes" ),
					"param_name" => "color",
					"value" => '#000',
					"description" => esc_html__( "Choose the color of the title.", "heroes" )
				),
				array(
					"save_always"	=> true,
					"type" 			=> "colorpicker",
					"class"			=> "",
					"heading"		=> esc_html__( "Serif color", "heroes" ),
					"param_name" => "serif_color",
					"value" => '#000',
					"description" => esc_html__( "Choose the color of the spanclass serif.", "heroes" )
				),
				array(
					"save_always"	=> true,
					"type" 			=> "colorpicker",
					"class"			=> "",
					"heading"		=> esc_html__( "Title small class color", "heroes" ),
					"param_name" 	=> "small_color",
					"value" 		=> '',
					"description" 	=> esc_html__( "Choose the color of the small class for the title.", "heroes" )
				),
				array(
					"save_always" => true,
					"type" 			=> "dropdown",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Animated",'heroes'),
					"param_name" 	=> "animated",
					"value" 		=> array('No' => 'false', 'Yes'=>'true' ),
					"description" 	=> esc_html__("Enable or disable element animation.",'heroes'),
					"admin_label	"=>true,
				),
				array(
					"save_always" => true,
					"type" 			=> "textfield",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Animation type",'heroes'),
					"param_name" 	=> "animation",
					"value" 		=> "enter top move 10px over 1s after 0.2s",
					"description" 	=> esc_html__("Select the type of animation for more info check documentation",'heroes'),
					"admin_label	"=>true,
				),
				array(
					"save_always"   => true,
					"type" 			=> "textfield",
					"holder"        => false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Extra Class",'heroes'),
					"param_name" 	=> "extra_class",
					"value" 		=> "",
					"description" 	=> esc_html__("Extra class name",'heroes'),
					"admin_label"   => true,
				),
			),
		),

		array(
			'name' => 'Hero Tabs',
			'base' => 'fwp_hero_tabs',
			"icon" => get_template_directory_uri() . "/assets/img/phx_vc_icon.jpg",
			'as_parent' => array('only' => 'fwp_hero_tab'),
            'category' => esc_html__('Theme Elements', 'heroes'),
			'description' => esc_html__('Tabs', 'heroes'),
			'content_element' => true,
			'show_settings_on_create' => false,
			"params" => array(
		        array(
		            "type"      => "textfield",
		            "heading"   => esc_html__("Placeholder Parameter", 'heroes'),
		            "param_name"=> "tabs_placeholder_param",
					"value"     => "Tabs Container",
		            "description"=> esc_html__("This is a placeholder parameter of the accordion container. It has no role or effect. Visual Composer does not display shortcodes without parameters.", 'heroes')
		        )
		    ),
			'js_view' => 'VcColumnView'
		),

		array(
			'name' => 'Tab Item',
			'base' => 'fwp_hero_tab',
			"icon" => get_template_directory_uri() . "/assets/img/phx_vc_icon.jpg",
			'as_child' => array('only' => 'fwp_hero_tabs' ),
            'category' => esc_html__('Hero Elements', 'heroes'),
			'description' => esc_html__('Tab Item', 'heroes'),
			'content_element' => true,
			'params' => array(
				array(
					"save_always"   => true,
					'type'          => 'textfield',
					'holder'        => 'div',
					'heading'       => esc_html__('Title', 'heroes'),
					'description'   => '',
					'param_name'    => 'title',
					'value'         => 'Tab Item Title',
				),
				array(
					"save_always" 	=> true,
		            'type' => 'iconpicker',
		            'heading' => esc_html__( 'Icon', 'heroes' ),
		            'param_name' => 'icon_class',
		            'settings' => array(
		                 'emptyIcon' => false,
                         'type' => 'simple_line_icons',
		                 'iconsPerPage' => 200,
		             ),
		             "description" 	=> esc_html__("Choose what icon do you want to use (use font awesome icons).",'heroes')
		        ),
				array(
					"save_always"   => true,
					'type'          => 'textarea_html',
					'holder'        => 'div',
					'heading'       => esc_html__('Content', 'heroes'),
					'param_name'    => 'content',
					'value'         => esc_html__('Content goes here', 'heroes'),
				),
				 array(
					"save_always" 	=> true,
					"type" 			=> 'dropdown',
					"holder" 		=> false,
					"heading" 		=> esc_html__("Active tab ?",'heroes'),
					"param_name" 	=> "is_active",
					'value'			=> array(
							        'No' => false,
						            'Yes' => true,
							    	),
					"default" 		=> 'No',
					"admin_label"	=> true
				 )
			)
		),

		array(
			"name" => esc_html__("Hero Tweeter Feed",'heroes'),
			"base" => "fwp-hero-twitter",
			"icon" => get_template_directory_uri() . "/assets/img/phx_vc_icon.jpg",
			"category" => esc_html__('Theme Elements','heroes'),
			"params" => array(
				array(
					"save_always"   => true,
					"type" 			=> "textfield",
					"holder"        => false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Username",'heroes'),
					"param_name" 	=> "user",
					"value" 		=> "",
					"description" 	=> esc_html__("This username's posts",'heroes'),
					"admin_label"   => true,
				),
				array(
					"save_always"   => true,
					"type" 			=> "textfield",
					"holder"        => false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Tweets Limit",'heroes'),
					"param_name" 	=> "tweets",
					"value" 		=> "2",
					"description" 	=> esc_html__("This username's posts",'heroes'),
					"admin_label"   => true,
				),
				array(
					"save_always"   => true,
					"type" 			=> "textfield",
					"holder"        => false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Date Format",'heroes'),
					"param_name" 	=> "date_format",
					"value" 		=> "M/d/Y",
					"description" 	=> esc_html__("Default: M/d/Y",'heroes'),
					"admin_label"   => true,
				),
				array(
					"save_always"   => true,
					"type" 			=> "textfield",
					"holder"        => false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Extra Class",'heroes'),
					"param_name" 	=> "extra_class",
					"value" 		=> "",
					"description" 	=> esc_html__("Extra class name",'heroes'),
					"admin_label"   => true,
				),
			),
    ),
    array(
		"name" => esc_html__("Video background section",'heroes'),
		"base" => "fwp-hero-videobg",
		"icon" => get_template_directory_uri() . "/assets/img/phx_vc_icon.jpg",	  
		"category" => esc_html__('Home sections','heroes'),
		"params" => array( 
				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,
					"heading" => esc_html__("Video",'heroes'),
					"param_name" => "video",
					"value" => '',
					"admin_label"=>true,
					"description" => esc_html__("Enter Video url",'heroes')
				),
				array(
					"save_always" => true,
					"type" => "attach_image",
					"holder" => false,
					"heading" => esc_html__("Fallback image",'heroes'),
					"param_name" => "image",
					"value" => '',
					"admin_label"=>false,
					"description" => esc_html__("Falback image for devices that don`t support video background",'heroes')
				),
				array(
					"type" 			=> "dropdown",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Overlay content page",'heroes'),
					"param_name" 	=> "pageid",
					"value" 		=> getPostIdAndTitle('page', true),
					"description" 	=> esc_html__("Animate element on scroll",'heroes'),
					"admin_label	"=>true,
				 ),
				array(
					"type" 			=> "dropdown",
					"holder" => false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Black overlay",'heroes'),
					"param_name" 	=> "overlay",
					"value" 		=> array('Yes'=>'true', 'No' => 'false'),
					"description" 	=> esc_html__("Add transparent overlay over content",'heroes'),
					"admin_label	"=>true,
				 ),
				array(
					"type" 			=> "dropdown",
					"holder" 		=> false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Autoplay",'heroes'),
					"param_name" 	=> "autoplay",
					"value" 		=> array('Yes'=>'true', 'No' => 'false'),
					"description" 	=> esc_html__("Automatically play the video",'heroes'),
					"admin_label	"=>true,
				),
				array(
					"type" 			=> "dropdown",
					"holder" 		=> false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Loop",'heroes'),
					"param_name" 	=> "loop",
					"value" 		=> array('Yes'=>'true', 'No' => 'false'),
					"description" 	=> esc_html__("Play continously",'heroes'),
					"admin_label	"=>true,
				),
				array(
					"type" 			=> "dropdown",
					"holder" 		=> false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Highdef",'heroes'),
					"param_name" 	=> "highdef",
					"value" 		=> array('Yes'=>'true', 'No' => 'false'),
					"admin_label	"=>true,
				),
				array(
					"type" 			=> "dropdown",
					"holder" 		=> false,
					"class" 		=> "",
					"heading" 		=> esc_html__("HD",'heroes'),
					"param_name" 	=> "hd",
					"value" 		=> array('Yes'=>'true', 'No' => 'false'),
					"admin_label	"=>true,
				),
				array(
					"type" 			=> "dropdown",
					"holder" 		=> false,
					"class" 		=> "",
					"heading" 		=> esc_html__("Ad Proof",'heroes'),
					"param_name" 	=> "adproof",
					"value" 		=> array('Yes'=>'true', 'No' => 'false'),
					"description" 	=> esc_html__("Remove ads",'heroes'),
					"admin_label	"=>true,
				),
				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,
					"heading" => esc_html__("Volume",'heroes'),
					"param_name" => "volume",
					"value" => '0',
					"default" => '0',
					"admin_label"=>false,
					"description" => esc_html__("Play volume",'heroes')
				),
				array(
					"save_always" => true,
					"type" => "textfield",
					"holder" => false,
					"heading" => esc_html__("Extra class",'heroes'),
					"param_name" => "extra_class",
					"value" => '',
					"admin_label"=>true,
					"description" => esc_html__("Extra class name",'heroes')
				 ),
			
		)
	),

);

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {class WPBakeryShortCode_fwp_hero_socialicons_container extends WPBakeryShortCodesContainer { }}
if ( class_exists( 'WPBakeryShortCode' ) ) {class WPBakeryShortCode_fwp_hero_socialicons_item extends WPBakeryShortCode { }}
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {class WPBakeryShortCode_fwp_hero_tabs extends WPBakeryShortCodesContainer {}}
if ( class_exists( 'WPBakeryShortCode' ) ) {class WPBakeryShortCode_fwp_hero_tab extends WPBakeryShortCode {}}

/**
Add this every single predefined page template
*/
if(function_exists('vc_add_default_templates')){
	$data				 = array();
	$data['name']	   = esc_html__( 'Fastwp Project Page', 'heroes' );
	$data['image_path'] = vc_asset_url( 'vc/templates/product_page.png' );
	$data['content']	= '[vc_row][vc_column width="1/1"][fwp-button label="Live Preview" type="black" link="#" target="_blank" tag="button" align="center"][separator][/vc_column][/vc_row][vc_row el_class="container" gmbt_prlx_bg_type="parallax" gmbt_prlx_video_youtube_loop_trigger="0" gmbt_prlx_video_aspect_ratio="16:9" gmbt_prlx_parallax="none" gmbt_prlx_speed="0.3" gmbt_prlx_break_parents="0"][vc_column width="9/12"][vc_column_text]Maids table how learn drift but purse stand yet set. Music me house could among oh as their. Piqued our sister shy nature almost his wicket. Hand dear so we hour to. He we be hastily offence effects he service.
	Doubtful two bed way pleasure confined followed. Shew up ye away no eyes life or were this. Perfectly did suspicion daughters but his intention. Started on society an brought it explain. Position two saw greatest stronger old. Pianoforte if at simplicity do estimating.[/vc_column_text][/vc_column][vc_column width="3/12"][vc_raw_html]JTNDZGl2JTIwY2xhc3MlM0QlMjJzaW5nbGVQcm9qZWN0SW5mbyUyMiUzRSUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUzQ3VsJTIwY2xhc3MlM0QlMjJsaXN0JTIyJTNFJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTNDbGklM0UlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlM0NpJTIwY2xhc3MlM0QlMjJmYSUyMGZhLWNsb2NrLW8lMjIlM0UlM0MlMkZpJTNFJTI2bmJzcCUzQiUyNm5ic3AlM0IlMjZuYnNwJTNCJTNDcCUyMGNsYXNzJTNEJTIyYm9sZCUyMiUzRTMwJTIwQXVndXN0JTIwMjAxNCUzQyUyRnAlM0UlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlM0MlMkZsaSUzRSUwQSUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUzQ2xpJTNFJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTNDaSUyMGNsYXNzJTNEJTIyZmElMjBmYS1pbmZvLWNpcmNsZSUyMiUzRSUzQyUyRmklM0UlMjZuYnNwJTNCJTI2bmJzcCUzQiUyNm5ic3AlM0JDbGllbnQlM0ElMjAlM0NwJTIwY2xhc3MlM0QlMjJib2xkJTIyJTNFTWljcm9zb2Z0JTNDJTJGcCUzRSUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUzQyUyRmxpJTNFJTBBJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTNDbGklM0UlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlM0NpJTIwY2xhc3MlM0QlMjJmYSUyMGZhLXVzZXIlMjIlM0UlM0MlMkZpJTNFJTI2bmJzcCUzQiUyNm5ic3AlM0IlMjZuYnNwJTNCUG9zdGVkJTIwYnklM0ElMjAlM0NwJTIwY2xhc3MlM0QlMjJib2xkJTIyJTNFSm9obiUyMERvZSUzQyUyRnAlM0UlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlM0MlMkZsaSUzRSUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUzQyUyRnVsJTNFJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTNDJTJGZGl2JTNF[/vc_raw_html][/vc_column][/vc_row][vc_row css=".vc_custom_1417461665429{margin-top: 50px !important;}" gmbt_prlx_bg_type="parallax" gmbt_prlx_video_youtube_loop_trigger="0" gmbt_prlx_video_aspect_ratio="16:9" gmbt_prlx_parallax="none" gmbt_prlx_speed="0.3" gmbt_prlx_break_parents="0"][vc_column width="1/1"][vc_single_image image="506" css_animation="top-to-bottom" alignment="center" border_color="grey" img_link_target="_self" img_size="full"][/vc_column][/vc_row][vc_row][vc_column width="1/2"][vc_single_image image="507" alignment="center" border_color="grey" img_link_target="_self" img_size="full"][/vc_column][vc_column width="1/2"][vc_single_image image="508" alignment="center" border_color="grey" img_link_target="_self" img_size="full"][/vc_column][/vc_row]';
	vc_add_default_templates($data);
}

function vc_iconpicker_type_simple_line_icons( $icons ) {
    // Add custom icons to array
    $icons['Simple Line Icons'] = array(
        array( 'icon-user-female' => esc_html__( 'User', 'heroes' ) ),
        array( 'icon-user-follow' => esc_html__( 'User', 'heroes' ) ),
        array( 'icon-user-following' => esc_html__( 'User', 'heroes' ) ),
        array( 'icon-user-unfollow' => esc_html__( 'User', 'heroes' ) ),
        array( 'icon-trophy' => esc_html__( 'Trophy', 'heroes' ) ),
        array( 'icon-screen-smartphone' => esc_html__( 'Screen', 'heroes' ) ),
        array( 'icon-screen-desktop' => esc_html__( 'Screen', 'heroes' ) ),
        array( 'icon-plane' => esc_html__( 'Plane', 'heroes' ) ),
        array( 'icon-notebook' => esc_html__( 'Notebook', 'heroes' ) ),
        array( 'icon-moustache' => esc_html__( 'Moustache', 'heroes' ) ),
        array( 'icon-mouse' => esc_html__( 'Mouse', 'heroes' ) ),
        array( 'icon-magnet' => esc_html__( 'Magnet', 'heroes' ) ),
        array( 'icon-energy' => esc_html__( 'Energy', 'heroes' ) ),
        array( 'icon-emoticon-smile' => esc_html__( 'Emoticon', 'heroes' ) ),
        array( 'icon-disc' => esc_html__( 'Disc', 'heroes' ) ),
        array( 'icon-cursor-move' => esc_html__( 'Cursor', 'heroes' ) ),
        array( 'icon-crop' => esc_html__( 'Crop', 'heroes' ) ),
        array( 'icon-credit-card' => esc_html__( 'Credit', 'heroes' ) ),
        array( 'icon-chemistry' => esc_html__( 'Chemistry', 'heroes' ) ),
        array( 'icon-user' => esc_html__( 'User', 'heroes' ) ),
        array( 'icon-speedometer' => esc_html__( 'Speedometer', 'heroes' ) ),
        array( 'icon-social-youtube' => esc_html__( 'Social', 'heroes' ) ),
        array( 'icon-social-twitter' => esc_html__( 'Social', 'heroes' ) ),
        array( 'icon-social-tumblr' => esc_html__( 'Social', 'heroes' ) ),
        array( 'icon-social-facebook' => esc_html__( 'Social', 'heroes' ) ),
        array( 'icon-social-dropbox' => esc_html__( 'Social', 'heroes' ) ),
        array( 'icon-social-dribbble' => esc_html__( 'Social', 'heroes' ) ),
        array( 'icon-shield' => esc_html__( 'Shield', 'heroes' ) ),
        array( 'icon-screen-tablet' => esc_html__( 'Screen', 'heroes' ) ),
        array( 'icon-magic-wand' => esc_html__( 'Magic', 'heroes' ) ),
        array( 'icon-hourglass' => esc_html__( 'Hourglass', 'heroes' ) ),
        array( 'icon-graduation' => esc_html__( 'Graduation', 'heroes' ) ),
        array( 'icon-ghost' => esc_html__( 'Ghost', 'heroes' ) ),
        array( 'icon-game-controller' => esc_html__( 'Game', 'heroes' ) ),
        array( 'icon-fire' => esc_html__( 'Fire', 'heroes' ) ),
        array( 'icon-eyeglasses' => esc_html__( 'Eyeglasses', 'heroes' ) ),
        array( 'icon-envelope-open' => esc_html__( 'Envelope', 'heroes' ) ),
        array( 'icon-envelope-letter' => esc_html__( 'Envelope', 'heroes' ) ),
        array( 'icon-bell' => esc_html__( 'Bell', 'heroes' ) ),
        array( 'icon-badge' => esc_html__( 'Badge', 'heroes' ) ),
        array( 'icon-anchor' => esc_html__( 'Anchor', 'heroes' ) ),
        array( 'icon-wallet' => esc_html__( 'Wallet', 'heroes' ) ),
        array( 'icon-vector' => esc_html__( 'Vector', 'heroes' ) ),
        array( 'icon-speech' => esc_html__( 'Speech', 'heroes' ) ),
        array( 'icon-puzzle' => esc_html__( 'Puzzle', 'heroes' ) ),
        array( 'icon-printer' => esc_html__( 'Printer', 'heroes' ) ),
        array( 'icon-present' => esc_html__( 'Present', 'heroes' ) ),
        array( 'icon-playlist' => esc_html__( 'Playlist', 'heroes' ) ),
        array( 'icon-pin' => esc_html__( 'Pin', 'heroes' ) ),
        array( 'icon-picture' => esc_html__( 'Picture', 'heroes' ) ),
        array( 'icon-map' => esc_html__( 'Map', 'heroes' ) ),
        array( 'icon-layers' => esc_html__( 'Layers', 'heroes' ) ),
        array( 'icon-handbag' => esc_html__( 'Handbag', 'heroes' ) ),
        array( 'icon-globe-alt' => esc_html__( 'Globe', 'heroes' ) ),
        array( 'icon-globe' => esc_html__( 'Globe', 'heroes' ) ),
        array( 'icon-frame' => esc_html__( 'Frame', 'heroes' ) ),
        array( 'icon-folder-alt' => esc_html__( 'Folder', 'heroes' ) ),
        array( 'icon-film' => esc_html__( 'Film', 'heroes' ) ),
        array( 'icon-feed' => esc_html__( 'Feed', 'heroes' ) ),
        array( 'icon-earphones-alt' => esc_html__( 'Earphones', 'heroes' ) ),
        array( 'icon-earphones' => esc_html__( 'Earphones', 'heroes' ) ),
        array( 'icon-drop' => esc_html__( 'Drop', 'heroes' ) ),
        array( 'icon-drawer' => esc_html__( 'Drawer', 'heroes' ) ),
        array( 'icon-docs' => esc_html__( 'Docs', 'heroes' ) ),
        array( 'icon-directions' => esc_html__( 'Directions', 'heroes' ) ),
        array( 'icon-direction' => esc_html__( 'Direction', 'heroes' ) ),
        array( 'icon-diamond' => esc_html__( 'Diamond', 'heroes' ) ),
        array( 'icon-cup' => esc_html__( 'Cup', 'heroes' ) ),
        array( 'icon-compass' => esc_html__( 'Compass', 'heroes' ) ),
        array( 'icon-call-out' => esc_html__( 'Call', 'heroes' ) ),
        array( 'icon-call-in' => esc_html__( 'Call', 'heroes' ) ),
        array( 'icon-call-end' => esc_html__( 'Call', 'heroes' ) ),
        array( 'icon-calculator' => esc_html__( 'Calculator', 'heroes' ) ),
        array( 'icon-bubbles' => esc_html__( 'Bubbles', 'heroes' ) ),
        array( 'icon-briefcase' => esc_html__( 'Briefcase', 'heroes' ) ),
        array( 'icon-book-open' => esc_html__( 'Book', 'heroes' ) ),
        array( 'icon-basket-loaded' => esc_html__( 'Basket', 'heroes' ) ),
        array( 'icon-basket' => esc_html__( 'Basket', 'heroes' ) ),
        array( 'icon-bag' => esc_html__( 'Bag', 'heroes' ) ),
        array( 'icon-action-undo' => esc_html__( 'Action', 'heroes' ) ),
        array( 'icon-action-redo' => esc_html__( 'Action', 'heroes' ) ),
        array( 'icon-wrench' => esc_html__( 'Wrench', 'heroes' ) ),
        array( 'icon-umbrella' => esc_html__( 'Umbrella', 'heroes' ) ),
        array( 'icon-trash' => esc_html__( 'Trash', 'heroes' ) ),
        array( 'icon-tag' => esc_html__( 'Tag', 'heroes' ) ),
        array( 'icon-support' => esc_html__( 'Support', 'heroes' ) ),
        array( 'icon-size-fullscreen' => esc_html__( 'Size', 'heroes' ) ),
        array( 'icon-size-actual' => esc_html__( 'Size', 'heroes' ) ),
        array( 'icon-shuffle' => esc_html__( 'Shuffle', 'heroes' ) ),
        array( 'icon-share-alt' => esc_html__( 'Share', 'heroes' ) ),
        array( 'icon-share' => esc_html__( 'Share', 'heroes' ) ),
        array( 'icon-rocket' => esc_html__( 'Rocket', 'heroes' ) ),
        array( 'icon-question' => esc_html__( 'Question', 'heroes' ) ),
        array( 'icon-pie-chart' => esc_html__( 'Pie', 'heroes' ) ),
        array( 'icon-pencil' => esc_html__( 'Pencil', 'heroes' ) ),
        array( 'icon-note' => esc_html__( 'Note', 'heroes' ) ),
        array( 'icon-music-tone-alt' => esc_html__( 'Music', 'heroes' ) ),
        array( 'icon-music-tone' => esc_html__( 'Music', 'heroes' ) ),
        array( 'icon-microphone' => esc_html__( 'Microphone', 'heroes' ) ),
        array( 'icon-loop' => esc_html__( 'Loop', 'heroes' ) ),
        array( 'icon-logout' => esc_html__( 'Logout', 'heroes' ) ),
        array( 'icon-login' => esc_html__( 'Login', 'heroes' ) ),
        array( 'icon-list' => esc_html__( 'List', 'heroes' ) ),
        array( 'icon-like' => esc_html__( 'Like', 'heroes' ) ),
        array( 'icon-home' => esc_html__( 'Home', 'heroes' ) ),
        array( 'icon-grid' => esc_html__( 'Grid', 'heroes' ) ),
        array( 'icon-graph' => esc_html__( 'Graph', 'heroes' ) ),
        array( 'icon-equalizer' => esc_html__( 'Equalizer', 'heroes' ) ),
        array( 'icon-dislike' => esc_html__( 'Dislike', 'heroes' ) ),
        array( 'icon-cursor' => esc_html__( 'Cursor', 'heroes' ) ),
        array( 'icon-control-start' => esc_html__( 'Control', 'heroes' ) ),
        array( 'icon-control-rewind' => esc_html__( 'Control', 'heroes' ) ),
        array( 'icon-control-play' => esc_html__( 'Control', 'heroes' ) ),
        array( 'icon-control-pause' => esc_html__( 'Control', 'heroes' ) ),
        array( 'icon-control-forward' => esc_html__( 'Control', 'heroes' ) ),
        array( 'icon-control-end' => esc_html__( 'Control', 'heroes' ) ),
        array( 'icon-calendar' => esc_html__( 'Calendar', 'heroes' ) ),
        array( 'icon-bulb' => esc_html__( 'Bulb', 'heroes' ) ),
        array( 'icon-bar-chart' => esc_html__( 'Bar', 'heroes' ) ),
        array( 'icon-arrow-up' => esc_html__( 'Arrow', 'heroes' ) ),
        array( 'icon-arrow-right' => esc_html__( 'Arrow', 'heroes' ) ),
        array( 'icon-arrow-left' => esc_html__( 'Arrow', 'heroes' ) ),
        array( 'icon-arrow-down' => esc_html__( 'Arrow', 'heroes' ) ),
        array( 'icon-ban' => esc_html__( 'Ban', 'heroes' ) ),
        array( 'icon-bubble' => esc_html__( 'Bubble', 'heroes' ) ),
        array( 'icon-camcorder' => esc_html__( 'Camcorder', 'heroes' ) ),
        array( 'icon-camera' => esc_html__( 'Camera', 'heroes' ) ),
        array( 'icon-check' => esc_html__( 'Check', 'heroes' ) ),
        array( 'icon-clock' => esc_html__( 'Clock', 'heroes' ) ),
        array( 'icon-close' => esc_html__( 'Close', 'heroes' ) ),
        array( 'icon-cloud-download' => esc_html__( 'Cloud', 'heroes' ) ),
        array( 'icon-cloud-upload' => esc_html__( 'Cloud', 'heroes' ) ),
        array( 'icon-doc' => esc_html__( 'Doc', 'heroes' ) ),
        array( 'icon-envelope' => esc_html__( 'Envelope', 'heroes' ) ),
        array( 'icon-eye' => esc_html__( 'Eye', 'heroes' ) ),
        array( 'icon-flag' => esc_html__( 'Flag', 'heroes' ) ),
        array( 'icon-folder' => esc_html__( 'Folder', 'heroes' ) ),
        array( 'icon-heart' => esc_html__( 'Heart', 'heroes' ) ),
        array( 'icon-info' => esc_html__( 'Info', 'heroes' ) ),
        array( 'icon-key' => esc_html__( 'Key', 'heroes' ) ),
        array( 'icon-link' => esc_html__( 'Link', 'heroes' ) ),
        array( 'icon-lock' => esc_html__( 'Lock', 'heroes' ) ),
        array( 'icon-lock-open' => esc_html__( 'Lock', 'heroes' ) ),
        array( 'icon-magnifier' => esc_html__( 'Magnifier', 'heroes' ) ),
        array( 'icon-magnifier-add' => esc_html__( 'Magnifier', 'heroes' ) ),
        array( 'icon-magnifier-remove' => esc_html__( 'Magnifier', 'heroes' ) ),
        array( 'icon-paper-clip' => esc_html__( 'Paper', 'heroes' ) ),
        array( 'icon-paper-plane' => esc_html__( 'Paper', 'heroes' ) ),
        array( 'icon-plus' => esc_html__( 'Plus', 'heroes' ) ),
        array( 'icon-pointer' => esc_html__( 'Pointer', 'heroes' ) ),
        array( 'icon-power' => esc_html__( 'Power', 'heroes' ) ),
        array( 'icon-refresh' => esc_html__( 'Refresh', 'heroes' ) ),
        array( 'icon-reload' => esc_html__( 'Reload', 'heroes' ) ),
        array( 'icon-settings' => esc_html__( 'Settings', 'heroes' ) ),
        array( 'icon-star' => esc_html__( 'Star', 'heroes' ) ),
        array( 'icon-symbol-female' => esc_html__( 'Symbol', 'heroes' ) ),
        array( 'icon-symbol-male' => esc_html__( 'Symbol', 'heroes' ) ),
        array( 'icon-target' => esc_html__( 'Target', 'heroes' ) ),
        array( 'icon-volume-1' => esc_html__( 'Volume', 'heroes' ) ),
        array( 'icon-volume-2' => esc_html__( 'Volume', 'heroes' ) ),
        array( 'icon-volume-off' => esc_html__( 'Volume', 'heroes' ) ),
        array( 'icon-users' => esc_html__( 'Users', 'heroes' ) )
    );

    // Return icons
    return $icons;
}
add_filter( 'vc_iconpicker-type-simple_line_icons', 'vc_iconpicker_type_simple_line_icons' );