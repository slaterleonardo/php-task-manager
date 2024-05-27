<?php

use App\Services\UserService;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    if (UserService::login($username, $password))
    {
        header('Location: /');
    }
    else
    {
        $error = 'Invalid username or password';
    }
}

if (isset($_SESSION['user'])) {
    header('Location: /');
}

?>

<main class="flex flex-col items-center">
    <h1 class="text-2xl font-bold mb-5">Login</h1>
    <form class="flex flex-col gap-2 w-96" action="/user/login" method="POST">
        <input class="h-10 px-2 bg-gray-100 rounded" type="text" placeholder="username" name="username" value="<?php echo isset($username) ? htmlspecialchars($username) : ''; ?>">
        <input class="h-10 px-2 bg-gray-100 rounded" type="password" placeholder="password" name="password" value="<?php echo isset($password) ? htmlspecialchars($password) : ''; ?>">
        <?php if (isset($error)): ?>
            <p class="text-red-500"><?php echo $error; ?></p>
        <?php endif; ?>
        <input class="h-10 px-2 font-bold bg-blue-300 rounded cursor-pointer" type="submit" value="Login">
        <p class="text-gray-400">Don't have an account? <a class="text-blue-500" href="/user/register">Register</a></p>
    </form>
</main>