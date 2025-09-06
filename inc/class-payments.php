<?php
// Faktury, płatności
class Weblu_Payments {
    public function get_payments($user_id) {
        $user = get_userdata($user_id);
        $email = $user ? $user->user_email : '';
        // Pobierz zamówienia WooCommerce użytkownika po ID i e-mailu
        $args_id = array(
            'limit' => 20,
            'customer_id' => $user_id,
            'status' => array_keys(wc_get_order_statuses())
        );
        $args_email = array(
            'limit' => 20,
            'billing_email' => $email,
            'status' => array_keys(wc_get_order_statuses())
        );
        $orders_id = wc_get_orders($args_id);
        $orders_email = wc_get_orders($args_email);
        // Połącz zamówienia, unikając duplikatów
        $orders = array_merge($orders_id, $orders_email);
        $unique = [];
        foreach($orders as $order) {
            $unique[$order->get_id()] = $order;
        }
        $result = [];
        foreach($unique as $order) {
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
