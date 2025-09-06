<?php
// Widok faktur/płatności
?>
<h2>Faktury i płatności</h2>
<?php
$payments = (new Weblu_Payments())->get_payments($user->ID);
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
