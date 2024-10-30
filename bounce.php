<?php
/*
	Plugin Name: Bounce.cc
	Plugin URI: http://bounce.cc/wordpress
	Description: Monetize outgoing links with Bounce! This plugin allows you to blog normally, but get credit for all outbound links you include in your blog posts.
	Version: 1.3.2
	Author: Eric Marden
	Author URI: http://xentek.net/
*/

register_activation_hook(__FILE__, 'bounce_activate');
add_action('admin_menu', 'add_bounce_options_page');
add_action('wp_ajax_bounce_login','bounce_ajax_login');
add_action('wp_ajax_bounce_register','bounce_ajax_register');
add_filter('the_content','bounce_content');
add_filter('comment_text','bounce_comment');
add_action('wp_footer','bounce_footer');

function bounce_activate()
{
	update_option('bounce_footer',1);
	update_option('bounce_affiliate',_bounce_affiliate());
}

function add_bounce_options_page()
{
	if (function_exists('add_options_page'))
	{
		add_options_page('Bounce.cc Settings', 'Bounce.cc Settings', 10, dirname(__FILE__) . '/bounce-options.php');
	}
}

function bounce_content($content)
{	
	$content = _bounce_regex($content);
	return $content;
}

function bounce_comment($content)
{	
	$content = _bounce_regex($content);
	return $content;
}

function bounce_footer()
{
	$bounce_footer = get_option('bounce_footer');
	$bounce_affiliate = get_option('bounce_affiliate');
	if ($bounce_footer && !is_admin())
	{
		echo '<p class="bounce-footer"><a href="http://bounce.cc/index.php?inc=home&bounceID='.$bounce_affiliate.'" title="Bounce.cc - Monetize Blogs, Forums, Web Sites via User Generated Content">Monetize My Blog</a></p>';
	}
}

function bounce_ajax_login()
{
	require_once( ABSPATH . 'wp-includes/class-snoopy.php');
	$snoopy = new Snoopy();
	$result = $snoopy->submit('http://bounce.cc/wpl.php',$_POST);
	if($result) {
		echo $snoopy->results;
	} else {
		echo '{userID:"-1",error:"Could not reach remote web service"}';
	}
	exit;
}

function bounce_ajax_register()
{
	require_once( ABSPATH . 'wp-includes/class-snoopy.php');
	$snoopy = new Snoopy();
	$result = $snoopy->submit('http://bounce.cc/wpr.php',$_POST);
	if($result) {
		echo $snoopy->results;
	} else {
		echo '{userID:"-1",error:"Could not reach remote web service"}';
	}
	exit;
}

function _bounce_affiliate()
{
	$bounce_affiliate = get_option('bounce_affiliate');
	if (!is_numeric($bounce_affiliate))
	{
		$bounce_affiliate = _bounce_aff_domain();
	}
	return $bounce_affiliate;
}

function _bounce_aff_domain() {
	return str_replace(array('http://','https://'),'',get_option('siteurl'));
}

function _bounce_regex($content)
{
	$content = preg_replace_callback("/<a\s[^>]*href=(\"??)(http[^\" >]*?)\\1[^>]*>(.*)<\/a>/siU",'_bounce_replace',$content,-1,$bounce_count);
	return $content;
}

function _bounce_replace($matches)
{
	$bounce_affiliate = get_option('bounce_affiliate');
	if (!is_numeric($bounce_affiliate)) { $bounce_affiliate = 2; }
	$aff_domain = _bounce_aff_domain();
	$pos = strpos($matches[2],get_option('siteurl'));
	if ($pos === FALSE) {
		$return = '<a href="http://bounce.cc/redirect/bounce.php?bounceID='.$bounce_affiliate.'&affID='.$aff_domain.'&bounceURL='.$matches[2].'">'.$matches[3].'</a>';	
	} else {
		$return = '<a href="'.$matches[2].'">'.$matches[3].'</a>';
	}
	return $return;
}

?>