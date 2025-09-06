<?php
// Faktury, płatności
class Weblu_Payments {
    public function get_payments($user_id) {
        $user = get_userdata($user_id);
        $email = $user ? $user->user_email : '';
        $orders = [];
        // Najpierw WP_Query (standardowy sposób)
        $args = array(
            'post_type' => 'shop_order',
            'posts_per_page' => 20,
            'post_status' => 'any',
            'meta_query' => array(
                array(
                    'key' => '_billing_email',
                    'value' => $email,
                    'compare' => '='
                )
            )
        );
        $query = new WP_Query($args);
        foreach($query->posts as $post) {
            $order = wc_get_order($post->ID);
            if ($order) {
                $invoice_url = '';
                if (function_exists('wpo_wcpdf_get_invoice')) {
                    $invoice = wpo_wcpdf_get_invoice($order);
                    if ($invoice && $invoice->exists()) {
                        $invoice_url = $invoice->get_pdf_url();
                    }
                }
                $orders[] = [
                    'number' => $order->get_order_number(),
                    'date' => $order->get_date_created() ? $order->get_date_created()->date('Y-m-d') : '',
                    'amount' => wc_price($order->get_total()),
                    'status' => wc_get_order_status_name($order->get_status()),
                    'pdf_url' => $invoice_url,
                    'view_url' => $order->get_view_order_url()
                ];
            }
        }
        // Alternatywnie: pobieranie zamówień przez $wpdb z dynamicznym prefiksem
        global $wpdb;
        $table_orders = $wpdb->prefix . 'posts';
        $table_postmeta = $wpdb->prefix . 'postmeta';
        $results = $wpdb->get_results($wpdb->prepare(
            "SELECT p.ID FROM {$table_orders} p
            INNER JOIN {$table_postmeta} pm ON p.ID = pm.post_id
            WHERE p.post_type = 'shop_order' AND pm.meta_key = '_billing_email' AND pm.meta_value = %s",
            $email
        ));
        foreach($results as $row) {
            $order = wc_get_order($row->ID);
            if ($order) {
                $invoice_url = '';
                if (function_exists('wpo_wcpdf_get_invoice')) {
                    $invoice = wpo_wcpdf_get_invoice($order);
                    if ($invoice && $invoice->exists()) {
                        $invoice_url = $invoice->get_pdf_url();
                    }
                }
                $orders[] = [
                    'number' => $order->get_order_number(),
                    'date' => $order->get_date_created() ? $order->get_date_created()->date('Y-m-d') : '',
                    'amount' => wc_price($order->get_total()),
                    'status' => wc_get_order_status_name($order->get_status()),
                    'pdf_url' => $invoice_url,
                    'view_url' => $order->get_view_order_url()
                ];
            }
        }
        // HPOS: pobieranie zamówień z wc_orders
        $table_wc_orders = $wpdb->prefix . 'wc_orders';
        $table_wc_orders_meta = $wpdb->prefix . 'wc_orders_meta';
        $results_hpos = $wpdb->get_results($wpdb->prepare(
            "SELECT o.id FROM {$table_wc_orders} o
            INNER JOIN {$table_wc_orders_meta} om ON o.id = om.order_id
            WHERE om.meta_key = '_billing_email' AND om.meta_value = %s",
            $email
        ));
        foreach($results_hpos as $row) {
            $order = wc_get_order($row->id);
            if ($order) {
                $invoice_url = '';
                if (function_exists('wpo_wcpdf_get_invoice')) {
                    $invoice = wpo_wcpdf_get_invoice($order);
                    if ($invoice && $invoice->exists()) {
                        $invoice_url = $invoice->get_pdf_url();
                    }
                }
                $orders[] = [
                    'number' => $order->get_order_number(),
                    'date' => $order->get_date_created() ? $order->get_date_created()->date('Y-m-d') : '',
                    'amount' => wc_price($order->get_total()),
                    'status' => wc_get_order_status_name($order->get_status()),
                    'pdf_url' => $invoice_url,
                    'view_url' => $order->get_view_order_url()
                ];
            }
        }
        return $orders;
    }
}
