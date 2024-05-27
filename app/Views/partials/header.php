<?php

$isAdmin = isset($_SESSION['user']) && $_SESSION['user']['isAdmin'];

?>

<!DOCTYPE html>
<html class="h-full m-0 px-10 bg-[#ffffd1]">
<head>
    <title><?php echo isset($title) ? htmlspecialchars($title) : 'Task Manager'; ?></title>
    <script src="https://unpkg.com/feather-icons"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-full bg-[#ffffd1]">
<header class="flex justify-between items-center py-5 border-b border-black mb-10">
    <h1><a class="text-xl no-underline text-black font-bold" href="/">Task Manager</a></h1>
    <nav class="flex justify-between items-center gap-4">
        <?php if ($isAdmin): ?>
            <a href="/admin">Admin</a> 
        <?php endif; ?>
        <a href="/user/profile"><i data-feather="user"></i></a>
    </nav>
</header>
