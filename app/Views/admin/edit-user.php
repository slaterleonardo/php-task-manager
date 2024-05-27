<?php

use App\Services\UserService;

if (!isset($_SESSION['user'])) {
    header('Location: /');
}


if (!$_SESSION['user']['isAdmin']) {
    header('Location: /');
    exit;
}

$userId = $_GET['id'];
$user = UserService::ReadById($userId);
$username = $user['username'];
$isAdmin = $user['isAdmin'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = strtolower($_POST['username']);
    $isAdmin = isset($_POST['isAdmin']) ? 1 : 0;

    $ok = true;

    if ($username == "") {
        $error = 'username is required';
        $ok = false;
    }

    if (UserService::updateUserById($userId, $username, $isAdmin)) {
        header('Location: /admin');
    } else {
        $error = 'An error occurred';
    }
}

?>

<main class="flex flex-col items-center">
    <h1 class="text-2xl font-bold mb-5">Update User</h1>
    <form class="flex flex-col gap-2 w-96" action="/admin/edit-user?id=<?php echo $userId ?>" method="POST">
        <input class="h-10 px-2 bg-gray-100 rounded" type="text" placeholder="username" name="username" value="<?php echo isset($username) ? htmlspecialchars($username) : ''; ?>">
        <div class="flex">
            <label for="isAdmin" class="mr-2">Is Admin: </label>
            <input type="checkbox" name="isAdmin" id="isAdmin" <?php echo $isAdmin ? 'checked' : ''?>>
        </div>
        <?php if (isset($error)): ?>
                <p class="text-red-500"><?php echo $error; ?></p>
        <?php endif; ?>
        <input class="h-10 px-2 font-bold bg-blue-300 rounded cursor-pointer" type="submit" value="Update User">
    </form>
</main>
