<?php
require 'inc/functions.php';

$pageTitle = "Task | Time Tracker";
$page = "tasks";
$project_id = $title= $date = $time = '';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $project_id = trim(filter_input(INPUT_POST, 'project_id', FILTER_SANITIZE_NUMBER_INT));
    $title = trim(filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING));
    $date = trim(filter_input(INPUT_POST, 'date', FILTER_SANITIZE_STRING));
    $time = trim(filter_input(INPUT_POST, 'time', FILTER_SANITIZE_NUMBER_INT));

    $dateMatch = explode('/', $date);

    if(empty($title) || empty($project_id) || empty($date) || empty($time)) {
        $error_message = 'Please fill in required fields (Project, Title, Date and Time)!';
    } elseif (count($dateMatch) !== 3 ||
        strlen($dateMatch[0]) !== 2 ||
        strlen($dateMatch[1]) !== 2 ||
        strlen($dateMatch[2]) !== 4 ||
        !checkdate($dateMatch[0],$dateMatch[1],$dateMatch[2])
    ) {
      $error_message = 'Invalid date';
    }else {
        if(add_tasks($project_id, $time, $date, $time)) {
            header('location: task_list.php');
        } else {
            $error_message = 'Could not add task';
        }
    }
}


include 'inc/header.php';
?>

<div class="section page">
    <div class="col-container page-container">
        <div class="col col-70-md col-60-lg col-center">
            <h1 class="actions-header">Add Task</h1>
            <?php
            if (isset($error_message)) {
                echo "<p class='message'>$error_message</p>";
            }
            ?>
            <form class="form-container form-add" method="post" action="task.php">
                <table>
                    <tr>
                        <th>
                            <label for="project_id">Project</label>
                        </th>
                        <td>
                            <select name="project_id" id="project_id">
                                <?php
                                foreach (get_project_items() as $item) {
                                    echo '<option value="' . $item['project_id'] . '"';
                                    if ($item['project_id'] == $project_id) {
                                      echo 'selected';
                                    }
                                    echo '>' . $item['title'] . '</option>';
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="title">Title<span class="required">*</span></label></th>
                        <td><input type="text" id="title" name="title" value="<?= htmlspecialchars($title); ?>" /></td>
                    </tr>
                    <tr>
                        <th><label for="date">Date<span class="required">*</span></label></th>
                        <td><input type="text" id="date" name="date" value="<?= htmlspecialchars($date) ?>" placeholder="mm/dd/yyyy" /></td>
                    </tr>
                    <tr>
                        <th><label for="time">Time<span class="required">*</span></label></th>
                        <td><input type="text" id="time" name="time" value="<?= htmlspecialchars($time) ?>" /> minutes</td>
                    </tr>
                </table>
                <input class="button button--primary button--topic-php" type="submit" value="Submit" />
            </form>
        </div>
    </div>
</div>

<?php include "inc/footer.php"; ?>
