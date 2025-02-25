<?php

class AdminController extends Controller
{
    

    function beforeAction(){
    }

    public function index()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit();
        }
           // Dohvati sve lekcije iz modela
    $lessons = $this->Admin->getAllLessons();
    // Proslijedi podatke pogledu
    $this->set('lessons', $lessons);
    //dohavaćanje svih težina
    $difficulties = $this->Admin->getAllDifficulties();
    $this->set('difficulties', $difficulties);

    //dohvaćanje svih vidljivosti
    $visibility = $this->Admin->getAllVisibility();
    $this->set('visibility', $visibility);
    }

    function addTask(){
        $this->doNotRenderHeader = 1;

        $data = [
            'title' => $_POST['title'],
            'description' => $_POST['description'],
            'lesson_id' => $_POST['lesson_id'],
            'difficulty' => $_POST['difficulty'],
            'visibility' => $_POST['visibility'],
            'solution' => $_POST['solution'],
            'input' => $_POST['input'],
            'output' => $_POST['output'],
            'explanation' => $_POST['explanation'],
            'public_id' => $_POST['public_id']
        ];

        $action = $this->Admin->addTask($data);
	if ($action['status'] == 'success') {
            echo json_encode([
                'status' => 'success',
                'message' => 'Uspješno.'
            ]);
        }  else {
            echo json_encode([
                'status' => 'error',
                'message' => 'An unknown error occurred.'
            ]);
        }
    
    }

    function afterAction() {}

}
