<div class="row">
    <div class="col-lg-10">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Płatności i faktury</h4>
                <?php
                // ...istniejąca logika pobierania i wyświetlania faktur...
                ?>
            </div>
        </div>
    </div>
</div>
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
// Wyświetl tylko faktury
global $wpdb;
$table_wcpdf_invoice = $wpdb->prefix . 'wcpdf_invoice_number';
$table_wc_orders = $wpdb->prefix . 'wc_orders';
$user_email = is_object($user) ? $user->user_email : '';
$user_id = is_object($user) ? $user->ID : 0;
$invoices = $wpdb->get_results("SELECT * FROM {$table_wcpdf_invoice} ORDER BY id DESC LIMIT 50");
$filtered = [];
foreach($invoices as $inv) {
    $order = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$table_wc_orders} WHERE id = %d", $inv->order_id));
    if ($order) {
        if (($order->billing_email && strtolower($order->billing_email) == strtolower($user_email)) || ($order->customer_id && $order->customer_id == $user_id)) {
            $filtered[] = $inv;
        }
    }
}
if (empty($filtered)) {
    echo '<p>Brak faktur do wyświetlenia.</p>';
} else {
    echo '<table class="weblu-table">';
    echo '<thead><tr><th>Numer faktury</th><th>ID zamówienia</th><th>Data</th><th>Kwota faktury</th><th>Akcje</th></tr></thead><tbody>';
    foreach($filtered as $inv) {
        $order = wc_get_order($inv->order_id);
            $amount = wc_price($order->get_total());
