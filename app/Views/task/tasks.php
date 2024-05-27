<?php
use App\Services\TaskService;

if (!isset($_SESSION['user'])) {
    header('Location: /user/login');
}

$userId = $_SESSION['user']['id'];
$username = $_SESSION['user']['username'];
$currentHour = date('H');
$message = $currentHour < 12 ? 'Good Morning' : ($currentHour < 18 ? 'Good Afternoon' : 'Good Evening');

$tasks = TaskService::listTasksByUserId($userId);
$todoTasks = array_filter($tasks, function($element) {
    return $element["status"] == "todo";
});
$doingTasks = array_filter($tasks, function($element) {
    return $element["status"] == "doing";
});
$doneTasks = array_filter($tasks, function($element) {
    return $element["status"] == "done";
});

$hasTodoTasks = count($todoTasks) > 0;
$hasDoingTasks = count($doingTasks) > 0;
$hasDoneTasks = count($doneTasks) > 0;

function buildTask($task)
{
    $id = $task["id"];
    $name = $task["name"];
    $description = $task["description"];
    $createdAt = new DateTime($task["createdAt"]);

    return '<div id="' . $id . '" class="task w-full bg-neutral-200 bg-opacity-50 rounded p-2 cursor-pointer overflow-hidden"><div class="flex justify-between"><h1 class="font-bold text-lg">' . $name . '</h1><a id="edit-button" href="/task?id=' . $id . '" class="block bg-blue-500 rounded text-white px-2 py-1">Edit</a></div><p class="text-lg overflow-auto break-words whitespace-normal">' . $description . '</p><p class="text-xs text-gray-700 mt-3">Created At: ' . $createdAt->format('m/d/Y') . '</p></div>';
}

?>

<main class="h-full">
    <h1 class="text-lg font-bold"><?php echo $message . ', ' . $username ?>!</h1>
    <a class="block md:w-[250px] w-full my-5 py-5 bg-blue-300 cursor-pointer hover:bg-blue-400 text-lg text-center font-bold rounded-lg" href="/task/create">
        Create New Task ✨
    </a>
    <section class="flex flex-col items-start md:flex-row gap-2 justify-between w-full">
        <div data-status="todo" class="z-10 flex flex-col bg-red-300 w-full overflow-auto md:max-w-xl p-2 rounded grow-0">
            <h2 class="font-bold w-full text-center">To Do (<span id="todo-count"><?php echo count($todoTasks)?></span>)</h2>
            <input class="placeholder:text-gray-700 text-gray-700 text-lg bg-inherit outline-none pl-2 bg-neutral-200 bg-opacity-30 h-[35px] border-gray-500 rounded" placeholder="search">
            <div class="flex flex-col gap-2 mt-3">
                <?php foreach ($todoTasks as $task) {
                    echo buildTask($task);
                } ?>
            </div>
        </div>
        <div data-status="doing" class="z-10 flex flex-col bg-yellow-300 w-full overflow-auto md:max-w-xl p-2 rounded grow-0">
            <h2 class="font-bold w-full text-center">Doing (<span id="doing-count"><?php echo count($doingTasks)?></span>)</h2>
            <input class="placeholder:text-gray-700 text-gray-700 text-lg bg-inherit outline-none pl-2 bg-neutral-200 bg-opacity-30 h-[35px] border-gray-500 rounded" placeholder="search">
            <div class="flex flex-col gap-2 mt-3">
                <?php foreach ($doingTasks as $task) {
                    echo buildTask($task);
                } ?>
            </div>
        </div>
        <div data-status="done" class="z-10 flex flex-col bg-green-300 w-full overflow-auto md:max-w-xl p-2 rounded grow-0">
            <h2 class="font-bold w-full text-center">Done (<span id="done-count"><?php echo count($doneTasks)?></span>)</h2>
            <input class="placeholder:text-gray-700 text-gray-700 text-lg bg-inherit outline-none pl-2 bg-neutral-200 bg-opacity-30 h-[35px] border-gray-500 rounded" placeholder="search">
            <div class="flex flex-col gap-2 mt-3">
                <?php foreach ($doneTasks as $task) {
                    echo buildTask($task);
                } ?>
            </div>
        </div>
    </section>
</main>
<script src="/js/drag.js"></script>
