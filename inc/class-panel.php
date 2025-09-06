<?php
// Główna klasa panelu klienta Weblu
class Weblu_Panel {
    public function render($user) {
        include dirname(__FILE__,2).'/templates/panel-main.php';
    }
}
