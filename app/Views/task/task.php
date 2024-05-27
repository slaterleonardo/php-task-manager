<?php

use App\Services\TaskService;

if (!isset($_SESSION['user'])) {
    header('Location: /');
}

$taskId = $_GET['id'];
$task = TaskService::readTaskByIdForUser($taskId, $_SESSION['user']['id']);
$userId = $_SESSION['user']['id'];
$name = $task['name'];
$description = $task['description'];
$status = $task['status'];
$action = isset($_GET['action']) ? $_GET['action'] : '';

if (!$task) {
    header('Location: /');
}

if ($action === 'delete') {
    if (TaskService::deleteTaskByIdForUser($taskId, $userId)) {
        header('Location: /');
    } else {
        $error = 'An error occurred';
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $inputData = json_decode(file_get_contents('php://input'), true);
    $newStatus = $inputData['status'];

    if (TaskService::updateTaskStatusByIdForUser($taskId, $userId, $newStatus)) {
        echo "success";        
    } else {
        echo "error";
    }

    return;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $status = isset($_POST['status']) ? $_POST['status'] : '';

    $ok = true;

    if ($name == "") {
        $error = 'task name is required';
        $ok = false;
    }

    if ($status == "") {
        $error = 'task status is required';
        $ok = false;
    }

    if (TaskService::updateTaskByIdForUser($taskId, $userId, $name, $description, $status)) {
        header('Location: /');
    } else {
        $error = 'An error occurred';
    }
}

?>

<main class="flex flex-col items-center">
    <h1 class="text-2xl font-bold mb-5">Update Task</h1>
    <form class="flex flex-col gap-2 w-96" action="/task?action=update&id=<?php echo $taskId ?>" method="POST">
        <input class="h-10 px-2 bg-gray-100 rounded" type="text" placeholder="name" name="name" value="<?php echo isset($name) ? htmlspecialchars($name) : ''; ?>">
        <textarea class="pt-2 px-2 bg-gray-100 rounded" name="description" placeholder="description" id="description" cols="30" rows="2"><?php echo isset($description) ? htmlspecialchars($description) : ''; ?></textarea>
        <select class="h-10 px-2 bg-gray-100 rounded" name="status" id="status">
            <option disabled>Status</option>
            <option <?php echo $status == "todo" ? 'selected' : ''?> value="todo">To Do</option>
            <option <?php echo $status == "doing" ? 'selected' : ''?> value="doing">Doing</option>
            <option <?php echo $status == "done" ? 'selected' : ''?> value="done">Done</option>
        </select>
        <?php if (isset($error)): ?>
                <p class="text-red-500"><?php echo $error; ?></p>
        <?php endif; ?>
        <input class="h-10 px-2 font-bold bg-blue-300 rounded cursor-pointer" type="submit" value="Update Task">
        <a class="h-10 px-2 font-bold bg-red-300 rounded cursor-pointer text-center content-center" href="/task?action=delete&id=<?php echo $taskId ?> " type="submit">Delete Task</a>
    </form>
</main>
