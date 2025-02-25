<?php
class Spcp extends Model
{
    // Dohvaća sve lekcije iz tablice spcp_lessons
    public function getAllLessons()
    {
        $sql = "SELECT * FROM spcp_lessons";
        $lessons = $this->selectFrom($sql, array())['data'];    
        return $lessons;
    }
    public function getLessonById($id)
    {
        $sql = "SELECT id, title, description FROM spcp_lessons WHERE id = :id";
        $lesson = $this->selectFrom($sql, ['id' => $id])['data'];
        return !empty($lesson) ? $lesson[0] : null; // Vraća prvu lekciju ako postoji
    }
    public function getTasksByLessonId($lessonId)
    {
        $sql = "SELECT * FROM spcp_tasks WHERE lesson_id = :lesson_id";
        $tasks = $this->selectFrom($sql, ['lesson_id' => $lessonId])['data'];
        return $tasks;
    }

    
    public function getTasksGroupedByDifficulty($lessonId)
    {
        $sql = "SELECT id, title, description, solution, difficulty
                FROM spcp_tasks
                WHERE lesson_id = :lesson_id
                ORDER BY difficulty ASC";

        $tasks = $this->selectFrom($sql, ['lesson_id' => $lessonId])['data'];

        // Grupiranje zadataka po težini
        $groupedTasks = [];
        foreach ($tasks as $task) {
            $groupedTasks[$task['difficulty']][] = $task;
        }

        return $groupedTasks;
    }
    public function getTaskById($taskId)
    {
        $sql = "SELECT * FROM spcp_tasks WHERE id = :id";
        $task = $this->selectFrom($sql, ['id' => $taskId])['data'];
        return !empty($task) ? $task[0] : null; // Vraća zadatak ako postoji
    }
}