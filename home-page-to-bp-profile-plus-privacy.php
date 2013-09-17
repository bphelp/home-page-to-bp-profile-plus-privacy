<?php
// Dashboard/Reading setting
function bphelp_initialize_hptbpp_plugin_options() {
	
	add_settings_field(
		'bphelp_hptp_profile_redirect',
		'Redirect Home Page To Profile On Login?',
		'bphelp_hptbpp_field_one',
		'reading'
	);
	
	add_settings_field(
		'bphelp_hptp_privacy',
		'Add Sitewide Privacy?',
		'bphelp_hptbpp_field_two',
		'reading'
	);
	
	register_setting(
	'reading',
	'bphelp_hptbpp'
	);
	
	register_setting(
	'reading',
	'bphelp_hptbpp_privacy'
	);
}
add_action( 'admin_init', 'bphelp_initialize_hptbpp_plugin_options' );

function bphelp_hptbpp_field_one() {
	$options = (array)get_option( 'bphelp_hptbpp' );
	$settings = $options['settings'];
	
	$html = '<label for="bphelp_hptbpp[settings]">';
		$html .= '<input type="checkbox" name="bphelp_hptbpp[settings]" id="[settings]" value="1" ' . checked( 1, $settings, false ) . ' />';
		$html .= '&nbsp;';
		$html .= 'If checked user will be redirected to profile on login.';
	$html .= '</label>';
	
	echo $html;
}

function bphelp_hptbpp_field_two() {	
	$privacy = (array)get_option( 'bphelp_hptbpp_privacy');
	$myprivacy = $privacy['myprivacy'];
	
	$html = '<label for="bphelp_hptbpp_privacy[myprivacy]">';
		$html .= '<input type="checkbox" name="bphelp_hptbpp_privacy[myprivacy]" id="[myprivacy]" value="1" ' . checked( 1, $myprivacy, false ) . ' />';
		$html .= '&nbsp;';
		$html .= 'If checked site-wide privacy will be enabled.';
	$html .= '</label>';
	
	echo $html;
}

// Plugin function
if( $options = get_option( 'bphelp_hptbpp' ) ) {
	function bp_help_redirect_to_profile(){
		if( is_user_logged_in() && is_home() ) {
			bp_core_redirect( get_option( 'home' ) . '/members/' . bp_core_get_username( bp_loggedin_user_id() ) . '/profile/' );
		}
	}
	add_action( 'template_redirect', 'bp_help_redirect_to_profile',1 );
}

if( $privacy = get_option( 'bphelp_hptbpp_privacy' ) ) {
	function bp_help_add_privacy() {
		if ( !is_user_logged_in() && !bp_is_register_page() && !bp_is_activation_page() && !is_home() ) {
				bp_core_redirect( get_option( 'home' ) );
		}
	}
	add_action( 'template_redirect', 'bp_help_add_privacy',1 );
}

	
/* Prevent RSS Feeds */
function cut_nonreg_visitor_rss_feed() {
	if ( !is_user_logged_in() ) {
		remove_action( 'bp_actions', 'bp_activity_action_sitewide_feed' ,3      );
		remove_action( 'bp_actions', 'bp_activity_action_personal_feed' ,3      );
		remove_action( 'bp_actions', 'bp_activity_action_friends_feed'  ,3      );
		remove_action( 'bp_actions', 'bp_activity_action_my_groups_feed',3      );
		remove_action( 'bp_actions', 'bp_activity_action_mentions_feed' ,3      );
		remove_action( 'bp_actions', 'bp_activity_action_favorites_feed',3      );
		remove_action( 'groups_action_group_feed', 'groups_action_group_feed',3 );
	}
}
add_action('init', 'cut_nonreg_visitor_rss_feed'); 
/* End Prevent RSS Feeds */
?>