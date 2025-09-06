<?php
// Widok usług klienta
?>
<h2>Moje usługi</h2>
<?php
$services = (new Weblu_Services())->get_services($user->ID);
echo '<ul class="weblu-services-list">';
foreach($services as $service) {
    echo '<li>'.esc_html($service['name']).'</li>';
}
echo '</ul>';
