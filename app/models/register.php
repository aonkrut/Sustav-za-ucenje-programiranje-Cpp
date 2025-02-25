<?php

include 'email.php';

class Register extends Model{


    function registerUser($data){
        $email_exists = $this->selectFrom("SELECT * FROM users WHERE email = ? AND active=1", array($data['email']));
        if($email_exists['rowCount'] > 0){
            return ['status' => 'email_exists'];
        }
        if (strpos($data['email'], '@student.foi.hr') !== false) {
            $data['foi'] = 5;
        }
        else{
            $data['foi'] = 2;
        }
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

        $user_id =  $this->insertInto("INSERT INTO users (first_name, last_name, email, password, active, foi) VALUES (?,?,?,?,?,?)", array($data['first_name'], $data['last_name'], $data['email'], $data['password'], $data['active'], $data['foi']));

        if(isset($user_id)){

            $timestamp = time();
            $public_id = hash('sha256',  $user_id . $timestamp);
            
            $this->update("UPDATE users SET public_id = ? WHERE ID = ?", array($public_id, $user_id)); 
 		
	    $this->sendAuthCode($data,$user_id);

            return ['status' => 'success', 'public_id' => $public_id];
        }
        else{
            return ['status' => 'error'];
        }
    }


    function sendAuthCode($user, $user_id){


	    $verification_code = rand(100000, 999999);

	    $expiry_time = date('Y-m-d H:i:s', strtotime('+1 hour'));	

        $this->insertInto("INSERT INTO verification (verification_code, expiry_time, user_id) VALUES (?,?,?)", array($verification_code, $expiry_time,  $user_id));
        $data = [
            'name' => $user['first_name'],
            'surname' => $user['last_name'], // Fixed the surname issue
            'CODE' => $verification_code,
            'link' => 'https://salabahter.eu',
            'text' => 'Dobrodosli na Spcp BETA sustav!',
            'description' => 'U prilogu se nalazi vaš verifikacijski kod koji morate upisati prilikom registracije, ako se zatvorili stranicu registracije mozete je ponovno otvoriti pomocu pritiska na tipku. '
        ];


	    $email = new Email();


            $templatePath = FULL_PATH . '/public/assets/templates/email_templates/registrationEmailTemplate.html'; // Adjust path as needed

            $email->send(
                $user['email'],
                'Welcome Email',
                file_get_contents($templatePath),
                'Please enable HTML to view this email',
            $data
            );

    }


    function verifyUser($data){

	$user_id = $this->checkUserPublicID($data['public_id']);
	$verification =  $this->selectFrom("SELECT expiry_time  FROM verification WHERE verification_code=? and user_id=?", array($data['code'], $user_id));

	if($verification['rowCount']<=0){
		 return ['status' => 'wrong_code'];
	
	}
	$expiry_time = $verification['data'][0]['expiry_time'];

	$current_time = date('Y-m-d H:i:s');

	if($expiry_time > $current_time){
		$this->update("UPDATE users SET active = 1 WHERE ID=?", array($user_id));
		return ['status' => 'success'];
	}
	else {
		return ['status' => 'code_expiered'];
	}
	

    }

    function checkUserPublicID($public_id){

	$user_id = $this->selectFrom("SELECT ID FROM users WHERE public_id =? AND active =0", array($public_id));
	if($user_id['rowCount'] <= 0){
		return['status' => 'id_error'];
	}
		return $user_id['data'][0]['ID'];
    }

}


	?>