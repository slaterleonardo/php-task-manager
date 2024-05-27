<?php

namespace App\Services;

include (BASE_PATH . '/Config/database.php');

class TaskService
{
    public static function create($userId, $name, $description, $status)
    {
        global $db;
        $stmt = $db->prepare('INSERT INTO tasks (user, name, description, status, createdAt) VALUES (?, ?, ?, ?, ?)');
        if ($stmt->execute([$userId, $name, $description, $status, date('Y-m-d H:i:s')])) {
            return true;
        }

        return false;
    }

    public static function list()
    {
        global $db;
        $stmt = $db->prepare('SELECT tasks.id, tasks.user, users.username, tasks.name, tasks.description, tasks.status, tasks.createdAt FROM tasks JOIN users on tasks.user = users.id ORDER BY createdAt');
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function listTasksByUserId($userId)
    {
        global $db;
        $stmt = $db->prepare('SELECT id, name, description, status, createdAt FROM tasks WHERE user = ? ORDER BY createdAt');
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public static function readTaskByIdForUser($taskId, $userId)
    {
        global $db;
        $stmt = $db->prepare('SELECT id, name, description, status, createdAt FROM tasks WHERE id = ? AND user = ?');
        $stmt->execute([$taskId, $userId]);
        return $stmt->fetch();
    }

    public static function updateTaskByIdForUser($taskId, $userId, $name, $description, $status)
    {
        global $db;
        $stmt = $db->prepare('UPDATE tasks SET name = ?, description = ?, status = ? WHERE id = ? AND user = ?');
        if ($stmt->execute([$name, $description, $status, $taskId, $userId])) {
            return true;
        }

        return false;
    }

    public static function updateTaskStatusByIdForUser($taskId, $userId, $newStatus)
    {
        global $db;
        $stmt = $db->prepare('UPDATE tasks SET status = ? WHERE id = ? AND user = ?');
        if ($stmt->execute([$newStatus, $taskId, $userId])) {
            return true;
        }

        return false;
    }


    public static function deleteTaskByIdForUser($taskId, $userId)
    {
        global $db;
        $stmt = $db->prepare('DELETE FROM tasks WHERE id = ? AND user = ?');
        if ($stmt->execute([$taskId, $userId])) {
            return true;
        }

        return false;
    }

    public static function readById($taskId)
    {
        global $db;
        $stmt = $db->prepare('SELECT id, name, description, status, createdAt FROM tasks WHERE id = ?');
        $stmt->execute([$taskId]);
        $task = $stmt->fetch();

        if ($task) {
            return $task;
        }

        return null;
    }

    public static function updateById($taskId, $name, $description, $status)
    {
        global $db;
        $stmt = $db->prepare('UPDATE tasks SET name = ?, description = ?, status = ? WHERE id = ?');
        if ($stmt->execute([$name, $description, $status, $taskId])) {
            return true;
        }

        return false;
    }

    public static function deleteById($taskId)
    {
        global $db;
        $stmt = $db->prepare('DELETE FROM tasks WHERE id = ?');
        if ($stmt->execute([$taskId])) {
            return true;
        }

        return false;
    }

    public static function deleteTasksByUserId($userId)
    {
        global $db;
        $stmt = $db->prepare('DELETE FROM tasks WHERE user = ?');
        if ($stmt->execute([$userId])) {
            return true;
        }

        return false;
    }
}
