<?php
// Faktury, płatności
class Weblu_Payments {
    public function get_payments($user_id) {
        $user = get_userdata($user_id);
        $email = $user ? $user->user_email : '';
        // Pobierz zamówienia WooCommerce użytkownika po e-mailu
        $args = array(
            'limit' => 20,
            'status' => array('wc-completed', 'wc-processing', 'wc-on-hold', 'wc-pending'),
            'billing_email' => $email
        );
        $orders = wc_get_orders($args);
        $result = [];
        foreach($orders as $order) {
            $invoice_url = '';
            if (function_exists('wpo_wcpdf_get_invoice')) {
                $invoice = wpo_wcpdf_get_invoice($order);
                if ($invoice && $invoice->exists()) {
                    $invoice_url = $invoice->get_pdf_url();
                }
            }
            $result[] = [
                'number' => $order->get_order_number(),
                'date' => $order->get_date_created() ? $order->get_date_created()->date('Y-m-d') : '',
                'amount' => wc_price($order->get_total()),
                'status' => wc_get_order_status_name($order->get_status()),
                'pdf_url' => $invoice_url,
                'view_url' => $order->get_view_order_url()
            ];
        }
        return $result;
    }
}
