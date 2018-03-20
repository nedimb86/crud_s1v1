<?php
//application functions
function get_project_items() {
    include('connection.php');
    try {
        return $db->query('SELECT * FROM projects');
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "</br>";
        return array();
  }
}

function get_task_items() {
    include('connection.php');
    $sql = 'SELECT tasks.*, projects.title as project FROM tasks JOIN projects ON tasks.project_id = projects.project_id';
    try {
        return $db->query($sql);
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "</br>";
        return array();
  }
}

function add_project($title, $category) {
    include('connection.php');

    $sql = 'INSERT INTO projects (title, category) VALUES (?, ?)';

    try {
        $results = $db->prepare($sql);
        $results->bindValue(1, $title, PDO::PARAM_STR);
        $results->bindValue(2, $category, PDO::PARAM_STR);
        $results->execute();
    } catch (Exception $e) {
        echo 'Could not add new project';
        return false;
    }
    return true;
}

function add_tasks($project_id, $title, $date, $time) {
    include('connection.php');

    $sql = 'INSERT INTO tasks (project_id, title, "date", "time") VALUES (?, ?, ?, ?)';

    try {
        $results = $db->prepare($sql);
        $results->bindValue(1, $project_id, PDO::PARAM_INT);
        $results->bindValue(2, $title, PDO::PARAM_STR);
        $results->bindValue(3, $date, PDO::PARAM_STR);
        $results->bindValue(4, $time, PDO::PARAM_INT);
        $results->execute();
    } catch (Exception $e) {
        echo 'Could not add new project';
        return false;
    }
    return true;
}