<?php

class LoginController extends Controller
{
    

    function beforeAction(){
    }

    public function index()
    {
        
    }

    function loginUser(){
        $this->doNotRenderHeader = 1;
        $data = [
            'email' => $_POST['email'],
            'password' => $_POST['password'], // Hash the password
        ];
        $action = $this->Login->loginUser($data);
        if ($action['status'] == 'success') {
            $_SESSION['user_id'] = $action['user_id'];
            $_SESSION['foi'] = $action['foi'];
            echo json_encode([
                'status' =>'success'
            ]);
        } elseif ($action['status'] == 'wrong_password') {
            echo json_encode([
                'status' => 'wrong_password',
                'message' => 'Wrong password'
            ]);
        } elseif ($action['status'] == 'no_user') {
            echo json_encode([
                'status' => 'no_user',
                'message' => 'No user with that email'
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'An unknown error occurred.'
            ]);
        }
    }

    function afterAction() {}

}
