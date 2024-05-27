<?php

use App\Services\TaskService;

if (!isset($_SESSION['user'])) {
    header('Location: /');
}


if (!$_SESSION['user']['isAdmin']) {
    header('Location: /');
    exit;
}

$taskId = $_GET['id'];
$task = TaskService::ReadById($taskId);
$name = $task['name'];
$description = $task['description'];
$status = $task['status'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $status = isset($_POST['status']) ? $_POST['status'] : '';

    $ok = true;

    if ($name == "") {
        $error = 'Task name is required';
        $ok = false;
    }

    if ($status == "") {
        $error = 'Task status is required';
        $ok = false;
    }

    if (TaskService::updateById($taskId, $name, $description, $status)) {
        header('Location: /admin');
    } else {
        $error = 'An error occurred';
    }
}

?>

<main class="flex flex-col items-center">
    <h1 class="text-2xl font-bold mb-5">Update Task</h1>
    <form class="flex flex-col gap-2 w-96" action="/admin/edit-task?id=<?php echo $taskId ?>" method="POST">
        <input class="h-10 px-2 bg-gray-100 rounded" type="text" placeholder="name" name="name" value="<?php echo isset($name) ? htmlspecialchars($name) : ''; ?>">
        <textarea class="h-20 px-2 bg-gray-100 rounded" placeholder="description" name="description"><?php echo isset($description) ? htmlspecialchars($description) : ''; ?></textarea>
        <select class="h-10 px-2 bg-gray-100 rounded" name="status" id="status">
            <option <?php echo $status == "todo" ? 'selected' : ''?> value="todo">To Do</option>
            <option <?php echo $status == "doing" ? 'selected' : ''?> value="doing">Doing</option>
            <option <?php echo $status == "done" ? 'selected' : ''?> value="done">Done</option>
        </select>
        <?php if (isset($error)): ?>
                <p class="text-red-500"><?php echo $error; ?></p>
        <?php endif; ?>
        <input class="h-10 px-2 font-bold bg-blue-300 rounded cursor-pointer" type="submit" value="Update Task">
    </form>
</main>
