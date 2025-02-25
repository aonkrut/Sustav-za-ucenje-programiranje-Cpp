<?php

class Profile extends Model{

    // Metoda za dohvat korisničkih podataka po ID-u
    function getUserById($id) {
        $user = $this->selectFrom("SELECT * FROM users WHERE public_id = ?", array($id));
        return $user['data'][0];
    }

    function logOut() {
        session_destroy();
        echo json_encode(array('status' => 'success'));
    }
}
?>
