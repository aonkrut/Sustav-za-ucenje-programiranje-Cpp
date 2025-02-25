<?php

use GrahamCampbell\ResultType\Success;

class SpcpController extends Controller
{

    function beforeAction(){
    }

    public function index()
    {
        // Dohvati sve lekcije iz modela
        $lessons = $this->Spcp->getAllLessons();
        // Proslijedi podatke pogledu
        $action =$this->set('lessons', $lessons);
    }
    public function regenerateTasks()
    {
        $id = $_POST['lessonId'];
        unset($_SESSION['generatedTasks-' . $id]);
       //vrati poruku da je uspjesno
        echo json_encode([
              'status' => 'success',
              'message' => 'Uspješno.'
         ]);
    }
    public function lekcija($id)
{
    // Dohvat lekcije iz baze prema ID-u
    $lesson = $this->Spcp->getLessonById($id);

    // Ako lekcija ne postoji, prikaži grešku ili preusmjeri
    if (!$lesson) {
        //header("Location: /spcp");
        //exit;
    }

    // Dohvat zadataka grupiranih po težini
    $tasksGrouped = $this->Spcp->getTasksGroupedByDifficulty($id);

    // Proslijedi podatke pogledu
    $this->set('lesson', $lesson);
    $this->set('tasksGrouped', $tasksGrouped);
}
function addSolution(){
    $this->doNotRenderHeader = 1;

    $data = [
        'solution' =>  $_POST['userCode'],
        'task_id' =>  $_POST['task_id'],
        'lesson_id' =>  $_POST['lesson_id']
    ];

    $action = $this->Spcp->addSolution($data);
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
public function zabiljeziSkidanjeSkripte($lessonId) {
    $this->doNotRenderHeader = 1;

    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['status' => 'error', 'message' => 'Nedostaje korisnički ID.']);
        return;
    }

    $data = [
        'lesson_id' => $lessonId,
        'user_id' => $_SESSION['user_id'],
    ];

    $action = $this->Spcp->zabiljeziSkidanjeSkripte($data);

    if ($action['status'] == 'success') {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Greška u obradi na serveru.']);
    }
}
private function generirajZadatke($id)
{
    // Dohvat zadataka grupiranih po težini
    $tasksGrouped = $this->Spcp->getTasksGroupedByDifficulty($id);
    $this->Spcp->zabiljeziGeneriranje($id);
    // Generiranje nasumičnih zadataka (po jedan iz svake težine)
    $randomTasks = [];
    foreach ($tasksGrouped as $difficulty => $tasks) {
        $randomTasks[] = $tasks[array_rand($tasks)];
    }

    // Spremanje generiranih zadataka u sesiju
    $_SESSION['generatedTasks-' . $id] = $randomTasks;

    // Proslijedi podatke pogledu
    $this->set('lesson', $this->Spcp->getLessonById($id));
    $this->set('randomTasks', $randomTasks);
}

public function vjezba($id)
{
    if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit();
        }
    $lesson = $this->Spcp->getLessonById($id);
    // Ako lekcija ne postoji, preusmjeri na popis lekcija
    if (!$lesson) {
        header("Location: /spcp");
        exit;
    }

    // Provjera jesu li zadaci već generirani
    if (!isset($_SESSION['generatedTasks-' . $id])) {
        $this->generirajZadatke($id);
    } else {
        // Dohvati već generirane zadatke iz sesije
        $randomTasks = $_SESSION['generatedTasks-' . $id];
        $this->set('lesson', $lesson);
        $this->set('randomTasks', $randomTasks);
    }
}
public function provjeri()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $taskId = $_POST['task_id'];
            $userCode = $_POST['user_code'];

            if (empty($taskId) || empty($userCode)) {
                $_SESSION['message'] = "Kod i ID zadatka su obavezni.";
                header("Location: /spcp/vjezba/" . intval($_POST['lesson_id']));
                exit;
            }

            $task = $this->Spcp->getTaskById($taskId);

            if (!$task) {
                $_SESSION['message'] = "Zadatak ne postoji.";
                header("Location: /spcp/vjezba/" . intval($_POST['lesson_id']));
                exit;
            }

            $input = $task['input'];
            $expectedOutput = trim($task['output']);
            $result = $this->executeCppCode($userCode, $input);

            if (isset($result['statusCode']) && $result['statusCode'] == 200) {
                $actualOutput = trim($result['output']);
                if ($actualOutput === $expectedOutput) {
                    $_SESSION['message'] = "Točno rješenje! 🎉";
                } else {
                    $_SESSION['message'] = "Netočno rješenje. Očekivani izlaz: $expectedOutput, Vaš izlaz: $actualOutput";
                }
            } else {
                $error = $result['error'] ?? "Nepoznata greška";
                $_SESSION['message'] = "Greška pri izvršavanju koda: $error";
            }

            // Preusmjeri natrag na stranicu vježbe
            header("Location: /spcp/vjezba/" . intval($_POST['lesson_id']));
        }
    }

    private function executeCppCode($code, $input)
    {
        $apiUrl = "https://api.jdoodle.com/v1/execute";
        $clientId = "1dcd9de4bfe6328e75ef123d20613b96"; // Zamijenite svojim JDoodle Client ID-jem
        $clientSecret = "ec7042059acebef73c10b42e29f02e62b19d8eb4532e0d730ad40e55c2455d1"; // Zamijenite svojim JDoodle Client Secret-om

        $data = [
            "script" => $code,
            "language" => "cpp",
            "versionIndex" => "0",
            "stdin" => $input,
            "clientId" => $clientId,
            "clientSecret" => $clientSecret
        ];

        $ch = curl_init($apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, true);
    }


    

    function afterAction()
    {
        // Opcionalno: Kod koji se izvršava nakon svake akcije
    }
}
