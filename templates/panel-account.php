<?php
// Widok i edycja profilu
?>
<h2>Dane kontaktowe</h2>
<?php
$account = (new Weblu_Account())->get_account($user->ID);
echo '<ul>';
echo '<li>Email: '.esc_html($account['email']).'</li>';
echo '<li>Telefon: '.esc_html($account['phone']).'</li>';
echo '</ul>';
