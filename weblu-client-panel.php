<?php
/**
 * Plugin Name: Weblu Client Panel
 * Description: Custom panel for Weblu clients. Displays user's services and info in branded UI.
 * Version: 0.1.0
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
        ?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Panel klienta Weblu</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?php echo plugin_dir_url(__FILE__); ?>assets/weblu-client-panel.css?v=3">
</head>
<body>
    <div class="weblu-client-panel">
        <aside class="weblu-sidebar">
            <img src="<?php echo plugin_dir_url(__FILE__); ?>assets/weblu-logo.png" alt="Weblu Logo" class="weblu-logo" />
            <nav class="weblu-nav">
                <a href="#">Moje usługi</a>
                <a href="#">Dane kontaktowe</a>
                <a href="#">Faktury</a>
                <a href="#">Powiadomienia</a>
                <a href="#">Kontakt z supportem</a>
                <a href="<?php echo wp_logout_url(home_url('/')); ?>" class="weblu-btn">Wyloguj</a>
            </nav>
        </aside>
        <main class="weblu-panel-main">
            <div class="weblu-panel-header">
                <h1>Witaj, <?php echo esc_html($user->display_name); ?>!</h1>
            </div>
            <section class="weblu-card">
                <h2 style="color:#ff3ebf; font-size:1.3rem; margin:0 0 12px 0; font-weight:600;">Twoje usługi</h2>
                <ul class="weblu-services-list">
                    <li>Hosting WordPress</li>
                    <li>Strona firmowa</li>
                </ul>
            </section>
            <section class="weblu-card">
                <h2 style="color:#2176ff; font-size:1.15rem; margin:0 0 12px 0; font-weight:600;">Powiadomienia</h2>
                <p>Brak nowych powiadomień.</p>
            </section>
        </main>
    </div>
</body>
</html>
        <?php
        return ob_get_clean();
    }
}

new Weblu_Client_Panel();
