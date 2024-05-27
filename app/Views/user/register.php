<?php

use App\Services\UserService;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm-password'];

    if ($password != $confirmPassword) {
        $error = 'Passwords do not match';
    }

    if (!isset($error)) {
        if (!UserService::usernameAvailable($username)) {
            $error = 'Username is already taken';
        }
    }

    if (!isset($error)) {
        if (!UserService::register($username, $password)) {
            $error = 'An error occurred';
        }
    }

    if (!isset($error)) {
        header('Location: /');
    }
}

if (isset($_SESSION['user'])) {
    header('Location: /');
}

?>

<main class="flex flex-col items-center">
    <h1 class="text-2xl font-bold mb-5">Register</h1>
    <form class="flex flex-col gap-2 w-96" action="/user/register" method="POST">
        <input class="h-10 px-2 bg-gray-100 rounded" type="text" placeholder="username" name="username" value="<?php echo isset($username) ? htmlspecialchars($username) : ''; ?>">
        <input class="h-10 px-2 bg-gray-100 rounded" type="password" placeholder="password" name="password" value="<?php echo isset($password) ? htmlspecialchars($password) : ''; ?>">
        <input class="h-10 px-2 bg-gray-100 rounded" type="password" placeholder="confirm password" name="confirm-password" value="<?php echo isset($confirmPassword) ? htmlspecialchars($confirmPassword) : ''; ?>">
        <?php if (isset($error)): ?>
                <p class="text-red-500"><?php echo $error; ?></p>
        <?php endif; ?>
        <input class="h-10 px-2 font-bold bg-blue-300 rounded cursor-pointer" type="submit" value="Register">
        <p class="text-gray-400">Already have an account? <a class="text-blue-500" href="/user/login">Login</a></p>
    </form>
</main>