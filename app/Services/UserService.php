<?php

namespace App\Services;

include (BASE_PATH . '/Config/database.php');

class UserService
{
    public static function usernameAvailable($username)
    {
        global $db;
        $stmt = $db->prepare('SELECT id FROM users WHERE username = ?');
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user) {
            return false;
        }

        return true;
    }
    
    public static function login($username, $password)
    {
        global $db;
        $password = sha1($password);

        $stmt = $db->prepare('SELECT id, username, isAdmin FROM users WHERE username = ? AND password = ?');
        $stmt->execute([$username, $password]);
        $user = $stmt->fetch();

        if ($user) {
            $_SESSION['user'] = $user;
            return true;
        }

        return false;
    }

    public static function register($username, $password)
    {
        global $db;
        $password = sha1($password);

        $stmt = $db->prepare('INSERT INTO users (username, password, createdAt) VALUES (?, ?, ?)');
        if ($stmt->execute([$username, $password, date('Y-m-d H:i:s')])) {
            $userId = $db->lastInsertId();
            $user = UserService::readById($userId);
            $_SESSION['user'] = $user;
            return true;
        }

        return false;
    }

    public static function readById($userId)
    {
        global $db;
        $stmt = $db->prepare('SELECT id, username, isAdmin FROM users WHERE id = ?');
        $stmt->execute([$userId]);
        $user = $stmt->fetch();

        if ($user) {
            return $user;
        }

        return null;
    }

    public static function list()
    {
        global $db;
        $stmt = $db->prepare('SELECT id, username, isAdmin, createdAt FROM users ORDER BY createdAt');
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function isRightPassword($userId, $password)
    {
        global $db;
        $password = sha1($password);

        $stmt = $db->prepare('SELECT id FROM users WHERE id = ? AND password = ?');
        $stmt->execute([$userId, $password]);
        $user = $stmt->fetch();

        if ($user) {
            return true;
        }

        return false;
    }

    public static function updatePassword($userId, $password)
    {
        global $db;
        $password = sha1($password);

        $stmt = $db->prepare('UPDATE users SET password = ? WHERE id = ?');
        if ($stmt->execute([$password, $userId])) {
            return true;
        }

        return false;
    }

    public static function updateUserById($userId, $username, $isAdmin)
    {
        global $db;
        $stmt = $db->prepare('UPDATE users SET username = ?, isAdmin = ? WHERE id = ?');
        if ($stmt->execute([$username, $isAdmin, $userId])) {
            return true;
        }

        return false;
    }

    public static function deleteUserById($userId)
    {
        global $db;
        $stmt = $db->prepare('DELETE FROM users WHERE id = ?');
        if ($stmt->execute([$userId])) {
            return true;
        }

        return false;
    }
}
