<?php

class fwp_settings {
	static function set_var( $var = '', $value = '' ){
	    if( empty( $var ) ) return ;
        global ${$var};
		${$var} = $value;
	}
    static function get_var( $var = '' ){
	    if( empty( $var ) ) return ;
        global ${$var};
        return ${$var};
    }
}