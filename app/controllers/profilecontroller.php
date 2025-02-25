<?php
session_start();

class ProfileController extends Controller {

    function beforeAction(){
    }

    function afterAction() {}
    
    public function index() {
            if (!isset($_SESSION['user_id'])) {
                header("Location: /login");
                exit();
            }
    
            // Učitavanje modela za korisnika
            $userModel = new Profile();
            $userData = $userModel->getUserById($_SESSION['user_id']);
    
            // Postavljanje podataka u view
            $this->set('first_name', $userData['first_name']);
            $this->set('last_name', $userData['last_name']);
            $this->set('email', $userData['email']);
        }
        function logoutUser(){
            $this->doNotRenderHeader = 1;
            $userModel = new Profile();
            $userModel->logOut();
        }
        
    }
    ?>
    
