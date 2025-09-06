<?php
// Widok główny panelu
?>
<div class="weblu-panel-header">
    <h1>Witaj, <?php echo esc_html($user->display_name); ?>!</h1>
</div>
<section class="weblu-card">
    <h2 style="color:#ff3ebf; font-size:1.3rem; margin:0 0 12px 0; font-weight:600;">Twoje usługi</h2>
    <?php
    $services = (new Weblu_Services())->get_services($user->ID);
    echo '<ul class="weblu-services-list">';
    foreach($services as $service) {
        echo '<li>'.esc_html($service['name']).'</li>';
    }
    echo '</ul>';
    ?>
</section>
<section class="weblu-card">
    <h2 style="color:#2176ff; font-size:1.15rem; margin:0 0 12px 0; font-weight:600;">Powiadomienia</h2>
    <?php
    $notifications = (new Weblu_Notifications())->get_notifications($user->ID);
    if(empty($notifications)) {
        echo '<p>Brak nowych powiadomień.</p>';
    } else {
        echo '<ul>'; foreach($notifications as $n) echo '<li>'.esc_html($n).'</li>'; echo '</ul>';
    }
    ?>
</section>
