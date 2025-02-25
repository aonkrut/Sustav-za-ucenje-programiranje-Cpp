<?php

class TutorController extends Controller
{
    function beforeAction(){
    }

    public function createTask() {
        $this->doNotRenderHeader = 1;
        session_start();
        error_log(print_r($_POST, true)); // Prikazuje sve POST podatke
        error_log(print_r($_SESSION['public_id'], true)); // Prikazuje sesijski ID

        $data = [
            'lesson_id' => $_POST['lesson_id'],
            'title' => $_POST['title'],
            'description' => $_POST['description'],
            'input' => $_POST['input'],
            'output' => $_POST['output'],
            'solution' => $_POST['solution'],
            'explanation' => $_POST['explanation'],
            'visibility' => $_POST['visibility'],
            'difficulty' => $_POST['difficulty'],
            'creator_public_id' => $_SESSION['public_id']
        ];
        error_log(print_r($data, true));
        $action = $this->Tutor->cT($data);
        if ($action['status'] == 'success') {
            echo json_encode([
                'status' => 'success',
                'message' => 'Task created successfully!'
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'An unknown error occurred.'

            ]);
        }
    }

    function registerUser(){
        $this->doNotRenderHeader = 1;


        $data = [
            'first_name' => $_POST['first_name'],
            'last_name' => $_POST['last_name'],
            'email' => $_POST['email'],
            'password' => $_POST['password'], // Hash the password
            'active' => 0 // Assuming the user is active by default
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

    public function index()
    {
    // Dohvati sve lekcije iz modela
    $lessons = $this->Tutor->getAllLessons();
    // Proslijedi podatke pogledu
    $this->set('lessons', $lessons);
    //dohavaćanje svih težina
    $difficulties = $this->Tutor->getAllDifficulties();
    $this->set('difficulties', $difficulties);

    //dohvaćanje svih vidljivosti
    $visibility = $this->Tutor->getAllVisibility();
    $this->set('visibility', $visibility);

    }

    function afterAction() {}

}
