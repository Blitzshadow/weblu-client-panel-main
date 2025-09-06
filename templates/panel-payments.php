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
        $pdf_url = '';
        $view_url = '';
        $amount = '';
        if ($order) {
            $amount = wc_price($order->get_total());
            $view_url = $order->get_view_order_url();
            if (function_exists('wpo_wcpdf_get_invoice')) {
                $invoice_obj = wpo_wcpdf_get_invoice($order);
                if ($invoice_obj && $invoice_obj->exists()) {
                    $pdf_url = $invoice_obj->get_pdf_url();
                }
            }
        }
        echo '<tr>';
        echo '<td>'.esc_html($inv->id).'</td>';
        echo '<td>'.esc_html($inv->order_id).'</td>';
        echo '<td>'.esc_html($inv->date).'</td>';
        echo '<td>'.esc_html($amount).'</td>';
        echo '<td>';
        if ($pdf_url) {
            echo '<a href="'.esc_url($pdf_url).'" class="weblu-btn" target="_blank">Pobierz fakturę PDF</a> ';
            echo '<a href="'.esc_url($pdf_url).'" class="weblu-btn weblu-btn-secondary" target="_blank">Wyświetl fakturę</a>';
        } else {
            $access_key = get_post_meta($inv->order_id, '_wcpdf_access_key', true);
            if ($access_key) {
                $ajax_url = admin_url('admin-ajax.php?action=generate_wpo_wcpdf&document_type=invoice&order_ids='.$inv->order_id.'&access_key='.$access_key);
                echo '<a href="'.esc_url($ajax_url).'" class="weblu-btn" target="_blank">Wygeneruj/Pobierz fakturę PDF</a> ';
                echo '<a href="'.esc_url($ajax_url).'" class="weblu-btn weblu-btn-secondary" target="_blank">Wyświetl fakturę</a>';
            }
        }
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


// DEBUG: Zamówienia z HPOS
global $wpdb;
$table_wc_orders = $wpdb->prefix . 'wc_orders';
$table_wcpdf_invoice = $wpdb->prefix . 'wcpdf_invoice_number';
$orders_hpos = $wpdb->get_results("SELECT * FROM {$table_wc_orders} ORDER BY id DESC LIMIT 10");
echo '<div style="background:#232a3d;color:#fff;padding:12px 18px;border-radius:8px;margin-bottom:18px;font-size:0.98rem;">';
echo '<strong>DEBUG: Zamówienia z HPOS (ostatnie 10):</strong><br>';
foreach($orders_hpos as $o) {
    $invoice = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$table_wcpdf_invoice} WHERE order_id = %d", $o->id));
    echo 'ID: '.$o->id.', Status: '.esc_html($o->status).', Billing email: '.esc_html($o->billing_email).', Kwota: '.esc_html($o->total_amount).', Faktura PDF: '.($invoice ? 'TAK' : 'NIE').', Numer faktury: '.($invoice && $invoice->calculated_number ? esc_html($invoice->calculated_number) : 'brak').'<br>';
}
echo '</div>';
