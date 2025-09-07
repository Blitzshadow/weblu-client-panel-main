// Widok główny panelu
if (!isset($user) || !is_object($user)) {
    $user = wp_get_current_user();
}
?>
<div class="weblu-panel-header">
    <h1>Witaj, <?php echo esc_html($user->display_name); ?>!</h1>
</div>
<section class="weblu-card">
    <h2 style="color:#2176ff; font-size:1.3rem; margin:0 0 12px 0; font-weight:600;">Twoje usługi</h2>
    <?php
    $services = class_exists('Weblu_Services') ? (new Weblu_Services())->get_services($user->ID) : [];
    if (!empty($services)) {
        echo '<ul class="weblu-services-list">';
        foreach($services as $service) {
            echo '<li>'.esc_html($service['name']).'</li>';
        }
        echo '</ul>';
    } else {
        echo '<p>Brak usług do wyświetlenia.</p>';
    }
    ?>
</section>
<section class="weblu-card">
    <h2 style="color:#2176ff; font-size:1.15rem; margin:0 0 12px 0; font-weight:600;">Powiadomienia</h2>
    <?php
    $notifications = class_exists('Weblu_Notifications') ? (new Weblu_Notifications())->get_notifications($user->ID) : [];
    if(empty($notifications)) {
        echo '<p>Brak nowych powiadomień.</p>';
    } else {
        echo '<ul>'; foreach($notifications as $n) echo '<li>'.esc_html($n).'</li>'; echo '</ul>';
    }
    ?>
</section>
    <section class="weblu-card">
            <h2 style="color:#2176ff; font-size:1.3rem; margin:0 0 12px 0; font-weight:600;">Konto</h2>
            <div class="ui segment" id="konto">
                <h2 class="ui header"><i class="user icon"></i> Konto</h2>
                <div class="ui list">
                    <div class="item"><strong>Email:</strong> <?php echo esc_html($user->user_email); ?></div>
                    <div class="item"><strong>Login:</strong> <?php echo esc_html($user->user_login); ?></div>
                    <!-- Dodaj więcej informacji o koncie tutaj -->
                </div>
            </div>
    </section>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Panel główny</h4>
                <p class="card-text">Witaj w panelu głównym. Tu znajdziesz podsumowanie swoich usług, powiadomień i aktywności.</p>
            </div>
        </div>
    </div>
</div>
