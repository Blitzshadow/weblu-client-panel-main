<?php
/**
 * Plugin Name: Weblu Client Panel
 * Description: Custom panel for Weblu clients. Displays user's services and info in branded UI.
 * Version: 0.2.4
 * Author: Blitzshadow
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Weblu_Client_Panel {

    public function __construct() {
        add_action('init', array($this, 'add_panel_endpoint'));
        add_action('template_redirect', array($this, 'handle_panel_endpoint'));
    }

    public function add_panel_endpoint() {
        add_rewrite_rule('^panel/?$', 'index.php?weblu_panel=1', 'top');
        add_rewrite_tag('%weblu_panel%', '1');
    }

    public function handle_panel_endpoint() {
        if (get_query_var('weblu_panel')) {
            if (is_user_logged_in()) {
                status_header(200);
                header("Content-Type: text/html; charset=utf-8");
                $current_user = wp_get_current_user();
                echo $this->get_full_panel_html($current_user);
                exit;
            } else {
                wp_redirect(wp_login_url(home_url('/panel')));
                exit;
            }
        }
    }

    private function get_full_panel_html($user) {
        ob_start();
        include dirname(__FILE__).'/templates/dashboard.php';
        return ob_get_clean();
    }
}

define('WEBLU_CLIENT_PANEL_VERSION', '0.2.4');
new Weblu_Client_Panel();
