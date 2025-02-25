<?php
class Spcp extends Model
{
    // Dohvaća sve lekcije iz tablice spcp_lessons
    public function getAllLessons()
    {
$sql = "SELECT * FROM spcp_lessons WHERE id<16";

        $lessons = $this->selectFrom($sql, array())['data'];    
        return $lessons;
    }
    public function getLessonById($id)
    {
        $sql = "SELECT id, title, description,link FROM spcp_lessons WHERE id = :id";
        $lesson = $this->selectFrom($sql, ['id' => $id])['data'];
        return !empty($lesson) ? $lesson[0] : null; // Vraća prvu lekciju ako postoji
    }
    public function getTasksByLessonId($lessonId)
{
    $sql = "SELECT * FROM spcp_tasks WHERE lesson_id = :lesson_id";
    $tasks = $this->selectFrom($sql, ['lesson_id' => $lessonId])['data'];
    return $tasks;
}

function addSolution($data){
        

    $task= $this->update("UPDATE spcp_tasks SET solution = ? WHERE id = ?", array($data['solution'], $data['task_id']));
    $task_backup= $this->insertInto("INSERT INTO spcp_sol_tasks (task_id, user_id, solution) VALUES (?, ?, ?)", array($data['task_id'], $_SESSION['user_id'], $data['solution']));
    if(isset($task)){
        return ['status' => 'success'];
    }
    else{
        return ['status' => 'error'];
    }
}
public function zabiljeziSkidanjeSkripte($lessonId)
{
    if (isset($_SESSION['user_id'])) {
        $sql = "INSERT INTO skidanje_skripte (user_id, lesson_id, time) VALUES (?, ?, ?)";
        $task = $this->insertInto($sql, [$_SESSION['user_id'], $lessonId, date('Y-m-d H:i:s')]);
        if ($task) {
            return ['status' => 'success'];
        } else {
            return ['status' => 'error'];
        }
    } else {
        $sql = "INSERT INTO skidanje_skripte (lesson_id, time) VALUES (?, ?)";
        $task = $this->insertInto($sql, [$lessonId, date('Y-m-d H:i:s')]);
        if ($task) {
            return ['status' => 'success'];
        } else {
            return ['status' => 'error'];
        }
    }
}
public function getTasksGroupedByDifficulty($lessonId)
{
    if ($_SESSION['foi'] == '5') {
    $sql = "SELECT 
        id, 
        title, 
        description, 
        solution, 
        explanation, 
        difficulty
    FROM 
        spcp_tasks
    WHERE 
        lesson_id = :lesson_id
          AND (visibility = 1 OR visibility = 3)
    ORDER BY 
        id ASC;";
} else {
    $sql = "SELECT 
        id, 
        title, 
        description, 
        solution, 
        explanation, 
        difficulty
    FROM 
        spcp_tasks
    WHERE 
        lesson_id = :lesson_id
        AND (visibility = 1 OR visibility = 3)
    ORDER BY 
        id ASC;";
}


    $tasks = $this->selectFrom($sql, ['lesson_id' => $lessonId])['data'];
  
    
    
    // Grupiranje zadataka po težini
    $groupedTasks = [];
    foreach ($tasks as $task) {
        $groupedTasks[$task['difficulty']][] = $task;
    }

    return $groupedTasks;
}

public function zabiljeziGeneriranje($lessonId)
{   
    if (isset($_SESSION['user_id'])) {
    $sql = "INSERT INTO generirani_zadaci (user_id, lesson_id, time) VALUES (?, ?, ?)";
    $task = $this->insertInto($sql, [$_SESSION['user_id'], $lessonId, date('Y-m-d H:i:s')]);
    if ($task) {
        return ['status' => 'success'];
    } else {
        return ['status' => 'error'];
    }}else{
        $sql = "INSERT INTO generirani_zadaci (lesson_id, time) VALUES (?, ?)";
        $task = $this->insertInto($sql, [$lessonId, date('Y-m-d H:i:s')]);
        if ($task) {
            return ['status' => 'success'];
        } else {
            return ['status' => 'error'];
        } 
    }
}
public function getTaskById($taskId)
{
    $sql = "SELECT * FROM spcp_tasks WHERE id = :id";
    $task = $this->selectFrom($sql, ['id' => $taskId])['data'];
    return !empty($task) ? $task[0] : null; // Vraća zadatak ako postoji
}
}