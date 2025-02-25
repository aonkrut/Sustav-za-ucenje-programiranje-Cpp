<?php
class Login extends Model
{

    function loginUser($data)
    {
        $user = $this->selectFrom("SELECT * FROM users WHERE email = ? AND active=1", array($data['email']));
     
        if ($user['rowCount'] == 0) {
            return ['status' => 'no_user'];
        }
        if ($user['foi'] == '5') {
            $_SESSION['foi'] = 5;
        }else {
            $_SESSION['foi'] = 2;
        }
        $user = $user['data'][0];
        if (password_verify($data['password'], $user['password'])) {
            session_start();
            $_SESSION['user_id'] = $user['public_id'];
            $_SESSION['logged_in'] = true;
            $_SESSION['expires_at'] = time() + 3600; 
            $this->insertInto("INSERT INTO login (user_id, time) VALUES (?, ?)", array($user['public_id'], date('Y-m-d H:i:s')));

            return ['status' => 'success', 'user_id' => $user['public_id'], 'foi' => $user['foi']];

        } else {
            return ['status' => 'wrong_password'];
        }
        
    }   
}