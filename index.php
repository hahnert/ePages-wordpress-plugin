<?php

/*
Plugin Name: SITe
Plugin URI: http://www.epages.com/us/
Description: Example integration of the SITe widget for WordPress.
Version: 0.1
Author: mindmatters
Author URI: http://mindmatters.de/
*/

defined("ABSPATH") or die("Plugin file cannot be accessed directly.");


if (!defined('EPAGES_PLUGIN_NAME'))
  define('EPAGES_PLUGIN_NAME', trim(dirname(plugin_basename(__FILE__)), '/'));

if (!defined('EPAGES_PLUGIN_DIR'))
  define('EPAGES_PLUGIN_DIR', WP_PLUGIN_DIR . '/' . EPAGES_PLUGIN_NAME);

if (!defined('EPAGES_PLUGIN_URL'))
  define('EPAGES_PLUGIN_URL', WP_PLUGIN_URL . '/' . EPAGES_PLUGIN_NAME);


static $epages_api_http_options = array(
  "headers" => array(
    "Authorization" => "Bearer M0mPgTiGPtw5LkdCGwhel3gcGc5PqIPF",
    "Accept"        => "application/vnd.epages.v1+json"
  ),
);

// FUNCTIONS
require_once EPAGES_PLUGIN_DIR . "/functions/log.php";
require_once EPAGES_PLUGIN_DIR . "/functions/load_template.php";
require_once EPAGES_PLUGIN_DIR . "/functions/options_page.php";

// ACTIONS
require_once EPAGES_PLUGIN_DIR . "/actions/init.php";
require_once EPAGES_PLUGIN_DIR . "/actions/add_options_page.php";
require_once EPAGES_PLUGIN_DIR . "/actions/show_admin_message.php";
require_once EPAGES_PLUGIN_DIR . "/actions/add_editor_button.php";


if (is_admin()) {
  add_action("admin_init",    "epages_init");
  add_action("admin_notices", "epages_show_admin_message");
  add_action("admin_menu",    "epages_add_options_page");
  add_action("media_buttons", "epages_add_editor_button" );

  # TODO: only load this on the editor page.
  add_filter("mce_external_plugins",  "epages_add_mce_plugin");
  add_action("admin_enqueue_scripts", "epages_add_scripts");
  add_action("in_admin_header",       "epages_add_popup");
} else {
  add_filter("script_loader_tag", "epages_build_script_tag", 10, 2);
}

function epages_build_script_tag($tag, $handle) {
  if ("epages_shop_widget" !== $handle) {
    return $tag;
  }
  return str_replace(" src", ' async="async" data-shop-url="' . get_option("epages_api_url") .'" id="epages-widget" src', $tag);
}

function epages_add_mce_plugin($args) {
  $args["epages"] = EPAGES_PLUGIN_URL . "/js/mce-editor.js";
  return $args;
}

function epages_add_popup() {
  global $epages_api_http_options;

  epages_load_template("popup", array(
    "epages_plugin_url"       => EPAGES_PLUGIN_URL,
    "epages_api_url"          => get_option("epages_api_url"),
    "epages_api_http_options" => $epages_api_http_options
  ));
}

function epages_add_scripts($hook) {
  if ($hook == "post-new.php" || $hook == "post.php") {
    wp_enqueue_script("epages-editor", EPAGES_PLUGIN_URL . "/js/editor.js", array(), false, true);
    add_editor_style(EPAGES_PLUGIN_URL . "/css/editor.css");
  }

  wp_enqueue_style("epages-editor-css", EPAGES_PLUGIN_URL . "/css/styles.css");
}

function epages_shop_widget_shortcode_handler($attrs) {
    wp_enqueue_script("epages_shop_widget", "https://site-production.herokuapp.com/site.js", array(), null, true);
    return '<div class="epages-shop-widget"></div>';
}

add_shortcode("epages", "epages_shop_widget_shortcode_handler");
