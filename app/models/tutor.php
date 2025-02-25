<?php
include 'email.php';
class Tutor extends Model {
  
    public function checkUserRole($public_id) {
        $query = "SELECT role FROM users WHERE public_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $public_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();

        return $user && ($user['role'] == 2 || $user['role'] == 3);
    }

    public function getAllLessons()
    {
        $sql = "SELECT * FROM spcp_lessons";
        $lessons = $this->selectFrom($sql, array())['data'];    
        return $lessons;
        
    }

    public function getAllDifficulties()
    {
        $difficulties = [
            1 => 'Lako',
            2 => 'Srednje lako',
            3 => 'Srednje',
            4 => 'Teško',
            5 => 'Vrlo teško',
            6 => 'Napredno'
        ]; 
        return $difficulties;
    }

    public function getAllVisibility()
    {   
        $visibility = [
            1 => 'Javno',
            2 => 'Privatno',
            3 => 'Greska'
            ];
        
        return $visibility;
    }

    function registerUser($data){
        $email_exists = $this->selectFrom("SELECT * FROM users WHERE email = ?", array($data['email']));
        if($email_exists['rowCount'] > 0){
            return ['status' => 'email_exists'];
        }

        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

        $user_id =  $this->insertInto("INSERT INTO users (first_name, last_name, email, password, active) VALUES (?,?,?,?,?)", array($data['first_name'], $data['last_name'], $data['email'], $data['password'], $data['active']));

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
            'text' => 'Dobrodosli na salabahter!',
            'description' => 'U prilogu se nalazi va verifikacijski kod koji morate upisati prilikom registracije, ako se zatvorili stranicu registracije mozete je ponovno otvoriti pomocu pritiska na tipku'
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
}
?>