<?php

use App\Services\UserService;


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['user']['id'];
    $currentPassword = $_POST['currentPassword'];
    $newPassword = $_POST['newPassword'];
    $newPasswordConfirm = $_POST['newPasswordConfirm'];

    if (!UserService::isRightPassword($userId, $currentPassword)) {
        $error = 'Current password is incorrect';
    }

    if ($newPassword != $newPasswordConfirm) {
        $error = 'New passwords do not match';
    }

    if (!UserService::updatePassword($userId, $newPassword)) {
        $error = 'An error occurred';
    } else {
        header('Location: /user/profile');
    }
}

if (!isset($_SESSION['user'])) {
    header('Location: /');
}

?>

<main class="flex flex-col items-center">
    <h1 class="text-2xl font-bold mb-5">Reset Password</h1>
    <form class="flex flex-col gap-2 w-96" action="/user/reset-password" method="POST">
        <input class="h-10 px-2 bg-gray-100 rounded" type="password" placeholder="current password" name="currentPassword" value="<?php echo isset($currentPassword) ? htmlspecialchars($currentPassword) : ''; ?>">
        <input class="h-10 px-2 bg-gray-100 rounded" type="password" placeholder="new password" name="newPassword" value="<?php echo isset($newPassword) ? htmlspecialchars($newPassword) : ''; ?>">
        <input class="h-10 px-2 bg-gray-100 rounded" type="password" placeholder="confirm new password" name="newPasswordConfirm" value="<?php echo isset($newPasswordConfirm) ? htmlspecialchars($newPasswordConfirm) : ''; ?>">
        <?php if (isset($error)): ?>
            <p class="text-red-500"><?php echo $error; ?></p>
        <?php endif; ?>
        <input class="h-10 px-2 font-bold bg-blue-300 rounded cursor-pointer" type="submit" value="Reset Password">
    </form>
</main>