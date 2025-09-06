<?php
// Obsługa usług klienta (hosting, strony, domeny)
class Weblu_Services {
    public function get_services($user_id) {
        // Tu pobierz usługi z bazy/API
        return [
            ['name'=>'Hosting WordPress'],
            ['name'=>'Strona firmowa']
        ];
    }
}
