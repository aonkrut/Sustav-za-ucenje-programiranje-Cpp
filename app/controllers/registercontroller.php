<?php
class RegisterController extends Controller
{
    

    function beforeAction(){
    }

    public function index()
    {
        
    }

    function registerUser(){
        $this->doNotRenderHeader = 1;


        $data = [
            'first_name' => $_POST['first_name'],
            'last_name' => $_POST['last_name'],
            'email' => $_POST['email'],
            'password' => $_POST['password'], // Hash the password
            'active' => 1 // Assuming the user is active by default
        ];


        $action = $this->Register->registerUser($data);
	if ($action['status'] == 'success') {
            echo json_encode([
                'status' => 'success',
                'message' => 'Registration successful! A code has been sent to your email.',
                'public_id' => $action['public_id']  // Send back public_id
            ]);
        } elseif ($action['status'] == 'email_exists') {
            echo json_encode([
                'status' => 'email_exists',
                'message' => 'An account with that email already exists.'
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'An unknown error occurred.'
            ]);
        }
    
    }

    public function verification($public_id){

	 $this->set("public_id", $public_id);
	 $action = $this->Register->checkUserPublicID($public_id); 
	 if ($action['status']== 'id_error') {
        	$this->set('redirect', 'id_error');	
	 }

    }

	
    function verifyUser(){
	    $this->doNotRenderHeader =1;

	    $data = [
		    'code'=> $_POST['code'],
	    	'public_id' => $_POST['id']
	    ];

		    $action = $this->Register->verifyUser($data);
	    if ($action['status'] == 'success') {
            echo json_encode([
                'status' => 'success'
            ]);
        } elseif ($action['status'] == 'wrong_code') {
            echo json_encode([
                'status' => 'wrong_code',
            ]);
        } elseif($action['status']== 'code_expiered'){
		 echo json_encode([
                	'status' => 'code_expiered',
            	]);
	}

    }


    function afterAction() {}

}
