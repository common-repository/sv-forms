<?php
	if( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
		exit();
    }
    
    delete_option( 'sv_forms_index' );
    delete_transient( 'sv_forms' );