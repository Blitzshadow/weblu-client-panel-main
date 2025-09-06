<?php
/**
 * Plugin Name: Weblu Client Panel
 * Description: Custom panel for Weblu clients. Displays user's services and info in branded UI.
 * Version: 0.1.1
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
        $tab = isset($_GET['tab']) ? $_GET['tab'] : 'main';
        $tabs = [
            'main' => 'Panel główny',
            'services' => 'Moje usługi',
            'account' => 'Dane kontaktowe',
            'payments' => 'Faktury',
            'notifications' => 'Powiadomienia',
            'support' => 'Kontakt z supportem'
        ];
        ?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Panel klienta Weblu</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?php echo plugin_dir_url(__FILE__); ?>assets/weblu-client-panel.css?v=<?php echo rand(1000,9999); ?>">
</head>
<body>
    <div class="weblu-client-panel">
        <aside class="weblu-sidebar">
            <img src="<?php echo plugin_dir_url(__FILE__); ?>assets/weblu-logo.png" alt="Weblu Logo" class="weblu-logo" />
            <nav class="weblu-nav">
                <?php foreach($tabs as $key => $label): ?>
                    <a href="?weblu_panel=1&tab=<?php echo $key; ?>"<?php if($tab==$key) echo ' style="background:#2176ff22;color:#2176ff;font-weight:700"'; ?>><?php echo $label; ?></a>
                <?php endforeach; ?>
                <a href="<?php echo wp_logout_url(home_url('/')); ?>" class="weblu-btn">Wyloguj</a>
            </nav>
        </aside>
        <main class="weblu-panel-main">
            <?php
            switch($tab) {
                case 'services':
                    include dirname(__FILE__).'/templates/panel-services.php';
                    break;
                case 'account':
                    include dirname(__FILE__).'/templates/panel-account.php';
                    break;
                case 'payments':
                    include dirname(__FILE__).'/templates/panel-payments.php';
                    break;
                case 'notifications':
                    include dirname(__FILE__).'/templates/panel-notifications.php';
                    break;
                case 'support':
                    include dirname(__FILE__).'/templates/panel-support.php';
                    break;
                case 'main':
                default:
                    include dirname(__FILE__).'/templates/panel-main.php';
                    break;
            }
            ?>
        </main>
    </div>
</body>
</html>
        <?php
        return ob_get_clean();
    }
}

new Weblu_Client_Panel();
