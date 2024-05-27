<?php

if (!isset($_SESSION['user'])) {
    header('Location: /user/login');
    exit;
}

if (!$_SESSION['user']['isAdmin']) {
    header('Location: /');
    exit;
}

use App\Services\UserService;
use App\Services\TaskService;

$users = UserService::list();
$tasks = TaskService::list();

?>

<style>
    table {
        border-collapse: separate;
        border-spacing: 0 10px;
        width: 100%;
    }
</style>
<main class="flex flex-col items-center">
    <h1 class="text-2xl font-bold">Users</h1>
    <table class="w-3/5 m-5">
        <thead>
            <tr>
                <th class="text-xl text-left">ID</th>
                <th class="text-xl text-left">Username</th>
                <th class="text-xl text-left">Admin</th>
                <th class="text-xl text-left">Created At</th>
                <th class="text-xl text-left">Edit</th>
                <th class="text-xl text-right">Delete</th>
            </tr>
        </thead>
        <tbody class="gap-5">
            <?php foreach ($users as $user): ?>
                <tr class="mb-5">
                    <td class="text-lg"><?php echo $user['id']; ?></td>
                    <td class="text-lg"><?php echo $user['username']; ?></td>
                    <td class="text-lg"><?php echo $user['isAdmin'] ? 'Yes' : 'No'; ?></td>
                    <td class="text-lg"><?php echo $user['createdAt']; ?></td>
                    <td class="text-lg"><a class="py-2 px-4 bg-blue-400 rounded text-white" href="/admin/edit-user?id=<?php echo $user['id']; ?>">Edit</a></td>
                    <td class="text-lg text-right"><a class="py-2 px-4 bg-red-400 rounded text-white" href="/admin/delete-user?id=<?php echo $user['id']; ?>">Delete</a></td>
                </tr>
            <?php endforeach; ?>
    </table>
    <h1 class="text-2xl font-bold">Tasks</h1>
    <table class="w-3/5 m-5">
        <thead>
            <tr>
                <th class="text-xl text-left">ID</th>
                <th class="text-xl text-left">User</th>
                <th class="text-xl text-left">Name</th>
                <th class="text-xl text-left">Description</th>
                <th class="text-xl text-left">Status</th>
                <th class="text-xl text-left">Created At</th>
                <th class="text-xl text-left">Edit</th>
                <th class="text-xl text-right">Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tasks as $task): ?>
                <tr class="mb-5">
                    <td class="text-lg max-w-md mx-1"><?php echo $task['id']; ?></td>
                    <td class="text-lg max-w-md mx-1"><a href="/admin/edit-user?id=<?php echo $task["user"] ?>"><?php echo $task['username']; ?></a></td>
                    <td class="text-lg max-w-md mx-1 overflow-scroll"><?php echo $task['name']; ?></td>
                    <td class="text-lg max-w-80 mx-1 overflow-scroll"><?php echo $task['description']; ?></td>
                    <td class="text-lg max-w-md mx-1"><?php echo $task['status']; ?></td>
                    <td class="text-lg max-w-md mx-1"><?php echo $task['createdAt']; ?></td>
                    <td class="text-lg max-w-md mx-1"><a class="py-2 px-4 bg-blue-400 rounded text-white" href="/admin/edit-task?id=<?php echo $task['id']; ?>">Edit</a></td>
                    <td class="text-lg max-w-md mx-1 text-right"><a class="py-2 px-4 bg-red-400 rounded text-white" href="/admin/delete-task?id=<?php echo $task['id']; ?>">Delete</a></td>
                </tr>
            <?php endforeach; ?>
    </table>
</main>
