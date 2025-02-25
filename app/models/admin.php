<?php

class Admin extends Model{
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
            3 => 'samo FOI studenti'
            ];
        
        return $visibility;
    }
    function addTask($data){
        

        $task= $this->insertInto("INSERT INTO spcp_tasks (title, description, lesson_id, difficulty, visibility, solution,input,output,explanation,public_id) VALUES (?, ?, ?, ?, ?, ?,?,?,?,?)", array($data['title'], $data['description'], $data['lesson_id'], $data['difficulty'], $data['visibility'], $data['solution'],$data['input'],$data['output'],$data['explanation'], $data['public_id']));
        if(isset($task)){

            $timestamp = time();
            $public_id = hash('sha256',  $task . $timestamp);

            return ['status' => 'success'];
        }
        else{
            return ['status' => 'error'];
        }
    }


}


	?>