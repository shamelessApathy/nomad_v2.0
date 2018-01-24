<?php

class fwp_utils {
    static function fwp_escape ( $html ) {
    $allowed_tags = array(
          'a' => array(
           'class' => array(),
           'href'  => array(),
           'rel'   => array(),
           'title' => array(),
           'style' => array(),
          ),
          'abbr' => array(
           'title' => array(),
          ),
          'b' => array(),
          'blockquote' => array(
           'cite'  => array(),
          ),
          'br' => array(),
          'cite' => array(
           'title' => array(),
          ),
          'code' => array(),
          'del' => array(
           'datetime' => array(),
           'title' => array(),
          ),
          'dd' => array(),
          'div' => array(
           'class' => array(),
           'title' => array(),
           'style' => array(),
          ),
          'dl' => array(),
          'dt' => array(),
          'em' => array(),
          'h1' => array(
             'class'  => array(),
             ),
          'h2' => array(
             'class'  => array(),
             ),
          'h3' => array(
             'class'  => array(),
             ),
          'h4' => array(
             'class'  => array(),
             ),
          'h5' => array( 'class'  => array(),
            ),
          'h6' => array(
             'class'  => array(),
             ),
          'i' => array(
             'class'  => array(),
             ),
          'img' => array(
           'alt'    => array(),
           'class'  => array(),
           'height' => array(),
           'src'    => array(),
           'width'  => array(),
          ),
          'li' => array(
           'class' => array(),
          ),
          'ol' => array(
           'class' => array(),
          ),
          'p' => array(
           'class' => array(),
          ),
          'q' => array(
           'cite' => array(),
           'title' => array(),
          ),
          'span' => array(
           'class' => array(),
           'title' => array(),
           'style' => array(),
          ),
          'strike' => array(),
          'strong' => array(),
          'ul' => array(
           'class' => array(),
          ),
          'small' => array(),
         );
        
        return wp_kses ( $html, $allowed_tags );
    }
	static function url_from_vc( $link = '' ){
	    $link = urldecode( $link );
        if( empty( $link ) ) return array( 'title' => '', 'url' => '', 'target' => '' );
        $lnk = array();
        foreach( explode( '|', $link ) as $nlink ) {
            if( !empty( $nlink ) )
            $lnk[strstr($nlink, ':', true)] = substr( strstr($nlink, ':'), 1 );
        }
        return array_merge( array( 'title' => '', 'url' => '', 'target' => '_self' ), $lnk );
    }

    static function hex2rgba($color, $opacity = false) {

    	$default = 'rgb(0,0,0)';

    	if( empty($color ) ) return $default;

        if( $color[0] == '#' ) {
            $color = substr( $color, 1 );
        }

            if ( strlen( $color ) == 6 ) {
                $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
            } elseif ( strlen( $color ) == 3 ) {
                $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
            } else {
                return $default;
            }

            //Convert hexadec to rgb
            $rgb =  array_map('hexdec', $hex);

            //Check if opacity is set(rgba or rgb)
            if($opacity){
            	if( abs( $opacity ) > 1 ) $opacity = 1.0;
            	$output = 'rgba( ' . implode( ",", $rgb ) . ',' . $opacity . ')';
            } else {
            	$output = 'rgb(' . implode( ",", $rgb ) . ')';
            }

            return $output;
    }

}