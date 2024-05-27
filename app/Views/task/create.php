<?php

use App\Services\TaskService;

if (!isset($_SESSION['user'])) {
    header('Location: /');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['user']['id'];
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

    if ($ok) {
        if (TaskService::create($userId, $name, $description, $status)) {
            header('Location: /');
        } else {
            $error = 'An error occurred';
        }
    }
}

?>

<main class="flex flex-col items-center">
    <h1 class="text-2xl font-bold mb-5">Create New Task</h1>
    <form class="flex flex-col gap-2 w-96" action="/task/create" method="POST">
        <input class="h-10 px-2 bg-gray-100 rounded" type="text" placeholder="name" name="name" value="<?php echo isset($name) ? htmlspecialchars($name) : ''; ?>">
        <textarea class="pt-2 px-2 bg-gray-100 rounded" name="description" placeholder="description" id="description" cols="30" rows="2"><?php echo isset($description) ? htmlspecialchars($description) : ''; ?></textarea>
        <select class="h-10 px-2 bg-gray-100 rounded" name="status" id="status">
            <option selected disabled>Status</option>
            <option value="todo">To Do</option>
            <option value="doing">Doing</option>
            <option value="done">Done</option>
        </select>
        <?php if (isset($error)): ?>
                <p class="text-red-500"><?php echo $error; ?></p>
        <?php endif; ?>
        <input class="h-10 px-2 font-bold bg-blue-300 rounded cursor-pointer" type="submit" value="Create Task">
    </form>
</main>