<?php

class Task
{
    private $conn;

    public function __construct()
    {
        $db = new Database;
        $this->conn = $db->connect();
    }

    public function addTask($user_id, $task)
    {
        $sql = "INSERT INTO tasks (user_id, task) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("is", $user_id, $task);
        if($stmt->execute())
        {
            $stmt->close();
            return true;
        }
    }

    public function getTasks($user_id)
    {
        $sql = "SELECT * FROM tasks WHERE user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $array = array();
        while($row = $result->fetch_assoc())
        {
            $array[] = $row;
        }
        
        $stmt->close();
        return $array;
    }

    public function deleteTask($id)
    {
        $sql = "DELETE FROM tasks WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute())
        {
            $stmt->close();
            return true;
        }
        else
        {
            $stmt->close();
            return false;
        }
    }

    public function doneTask($id)
    {
        $sql = "UPDATE tasks SET status = 1 WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute())
        {
            $stmt->close();
            return true;
        }
        else
        {
            $stmt->close();
            return false;
        }
    }

    public function updateTask($task, $id)
    {
        
        $sql = "UPDATE tasks SET task = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $task, $id);

        if ($stmt->execute())
        {
            $stmt->close();
            return true;
        }
        else
        {
            $stmt->close();
            return false;
        }
    }

    public function getUserIdByTaskId($id)
    {
        $sql = "SELECT user_id FROM tasks WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        if($stmt->execute())
        {
            $result = $stmt->get_result();
            if($result->num_rows > 0)
            {
                $row = $result->fetch_assoc();
                $stmt->close();
                return $row['user_id'];
            }
            else
            {
                $stmt->close();
                return false;
            }
        }
    }

    public function getTaskById($id)
    {
        $sql = "SELECT task FROM tasks WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        if($stmt->execute())
        {
            $result = $stmt->get_result();
            if($result->num_rows > 0)
            {
                $row = $result->fetch_assoc();
                $stmt->close();
                return $row['task'];
            }
            else
            {
                $stmt->close();
                return false;
            }
        }
    }

    public function hasChanges($previous_task, $current_task)
    {
        if($previous_task === $current_task)
        {
            return false;
        }
        else
        {
            return true;
        }
    }
}