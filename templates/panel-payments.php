<?php
// Widok faktur/płatności
if (!isset($user) || !is_object($user)) {
    $user = wp_get_current_user();
}
?>
<h2>Faktury i płatności</h2>
<?php
if (!class_exists('WooCommerce')) {
    echo '<p>WooCommerce nie jest aktywne. Faktury nie są dostępne.</p>';
    return;
}
if (!function_exists('wc_get_orders')) {
    echo '<p>Brak funkcji WooCommerce. Faktury nie są dostępne.</p>';
    return;
}
$payments = class_exists('Weblu_Payments') ? (new Weblu_Payments())->get_payments($user->ID) : [];
echo '<div style="background:#232a3d;color:#fff;padding:12px 18px;border-radius:8px;margin-bottom:18px;font-size:0.98rem;">';
echo '<strong>DEBUG:</strong> Znaleziono '.count($payments).' zamówień.<br>';
foreach($payments as $p) {
    echo 'Numer: '.esc_html($p['number']).', Status: '.esc_html($p['status']).', Data: '.esc_html($p['date']).', PDF: '.($p['pdf_url'] ? 'TAK' : 'NIE').'<br>';
}
echo '</div>';
if (empty($payments)) {
    echo '<p>Brak faktur do wyświetlenia.</p>';
} else {
    echo '<table class="weblu-table">';
    echo '<thead><tr><th>Numer zamówienia</th><th>Data</th><th>Kwota</th><th>Status</th><th>Akcje</th></tr></thead><tbody>';
    foreach($payments as $p) {
        echo '<tr>';
        echo '<td>'.esc_html($p['number']).'</td>';
        echo '<td>'.esc_html($p['date']).'</td>';
        echo '<td>'.esc_html($p['amount']).'</td>';
        echo '<td><span class="weblu-status-'.esc_attr($p['status']).'">'.esc_html($p['status']).'</span></td>';
        echo '<td>';
        if ($p['pdf_url']) {
            echo '<a href="'.esc_url($p['pdf_url']).'" class="weblu-btn" target="_blank">Pobierz fakturę PDF</a> ';
        }
        echo '<a href="'.esc_url($p['view_url']).'" class="weblu-btn weblu-btn-secondary" target="_blank">Pokaż zamówienie</a>';
        echo '</td>';
        echo '</tr>';
    }
    echo '</tbody></table>';
}

// DEBUG: Wyświetl wszystkie zamówienia i meta dane
$args = array(
    'post_type' => 'shop_order',
    'posts_per_page' => 10,
    'post_status' => 'any'
);
$query = new WP_Query($args);
echo '<div style="background:#232a3d;color:#fff;padding:12px 18px;border-radius:8px;margin-bottom:18px;font-size:0.98rem;">';
echo '<strong>DEBUG: Wszystkie zamówienia w bazie (ostatnie 10):</strong><br>';
foreach($query->posts as $post) {
    $order = wc_get_order($post->ID);
    $meta = get_post_meta($post->ID);
    echo 'ID: '.$post->ID.', Numer: '.($order ? $order->get_order_number() : '').', Status: '.($order ? $order->get_status() : '').', Billing email: '.($meta['_billing_email'][0] ?? '').'<br>';
}
echo '</div>';
