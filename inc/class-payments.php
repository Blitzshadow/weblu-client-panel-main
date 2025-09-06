<?php
// Faktury, płatności
class Weblu_Payments {
    public function get_payments($user_id) {
        $user = get_userdata($user_id);
        $email = $user ? $user->user_email : '';
        // Pobierz zamówienia WooCommerce po meta_key _billing_email, dowolny status
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
        $orders = [];
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
        return $orders;
    }
}
