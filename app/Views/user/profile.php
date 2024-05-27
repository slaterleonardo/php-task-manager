<?php

if (!isset($_SESSION['user'])) {
    header('Location: /');
}

$user = $_SESSION['user'];
$username = $user['username'];
$isAdmin = $user['isAdmin'];

?>

<main class="flex flex-col">
    <h1 class="text-2xl font-bold">Hi, <?php echo $user['username']; ?>!</h1>
    <p class="text-gray-700">You are logged in as <?php echo $isAdmin ? 'an admin' : 'a user'; ?></p>
    <a class="block p-2 px-0 bg-blue-500 w-[150px] text-center font-bold text-white rounded-lg mt-2" href="/user/reset-password">Reset Password</a>
    <a class="block p-2 px-0 bg-red-500 w-[100px] text-center font-bold text-white rounded-lg mt-2" href="/user/logout">Logout</a>
</main>