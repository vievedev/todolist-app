<?php

class TaskController extends Controller
{
    public function __construct()
    {
        $this->taskModel = $this->model("Task");
    }

    public function index()
    {
        header("Location: " . ROOT);
        exit;
    }

    public function add()
    {
        if(!empty($_SESSION['loggedInUserId']))
        {
            if($_SERVER['REQUEST_METHOD'] === 'POST')
            {
                $error = "";
                $success = "";

                $task = cleanInput($_POST['task']);

                if(empty($task))
                {
                    $error = "Enter task.";
                }

                if(!empty($error))
                {
                    $_SESSION['error'] = $error;
                    header("Location: " . ROOT);
                    exit;
                }
                else
                {
                    $user_id = $_SESSION['loggedInUserId'];
                    if($this->taskModel->addTask($user_id, $task))
                    {
                        $success = "Task added.";
                        $_SESSION['success'] = $success;
                        header("Location: " . ROOT);
                        exit;
                    }
                }
            }
            else
            {
                header("Location: " . ROOT);
                exit;
            }
        }
        else 
        {
            header("Location: " . ROOT);
            exit;
        }
    }

    public function edit()
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $id = intval($_POST['id']);
            $_SESSION['edittask_id'] = $id;
            $task = $this->taskModel->getTaskById($_SESSION['edittask_id']);
            $_SESSION['edittask_task'] = $task;

            header("Location: " . ROOT);
            exit;
        }
        else
        {
            header("Location: " . ROOT);
            exit;
        }
    }

    public function update()
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            if(isset($_POST['btnTaskUpdate']))
            {
                $id = intval($_SESSION['edittask_id']);
                $task = cleanInput($_POST['task']);

                $task_user_id = $this->taskModel->getUserIdByTaskId($id);
                
                if($task_user_id && $task_user_id === $_SESSION['loggedInUserId'])
                {
                    $previous_task = $this->taskModel->getTaskById($id);
                    $current_task = $task;

                    if($this->taskModel->hasChanges($previous_task, $current_task))
                    {
                        if($this->taskModel->updateTask($task, $id))
                        {
                            unset($_SESSION['edittask_id']);
                            unset($_SESSION['edittask_task']);

                            $_SESSION['success'] = 'Task updated successfully.';
                        }
                        else
                        {
                            $_SESSION['error'] = 'Failed to update task. Please try again later.';
                        }
                    }
                    else
                    {
                        unset($_SESSION['edittask_id']);
                        unset($_SESSION['edittask_task']);

                        $_SESSION['success'] = 'No changes made.';
                    }
                }
                else
                {
                    $_SESSION['error'] = 'You do not have the permission update this task.';
                }

                header('Location: ' . ROOT);
                exit;
            }

            if(isset($_POST['btnCancelUpdate']))
            {
                unset($_SESSION['edittask_id']);
                unset($_SESSION['edittask_task']);

                header("Location: " . ROOT);
                exit;
            }
        }
        else
        {
            header("Location: " . ROOT);
            exit;
        }
    }

    public function done()
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $id = intval($_POST['id']);
            $task_user_id = $this->taskModel->getUserIdByTaskId($id);
            
            if($task_user_id && $task_user_id === $_SESSION['loggedInUserId'])
            {
                if($this->taskModel->doneTask($id))
                {
                    $_SESSION['success'] = 'The task has been marked as completed successfully.';
                }
                else
                {
                    $_SESSION['error'] = 'Unable to mark the task as completed. Please try again later.';
                }
            }
            else
            {
                $_SESSION['error'] = 'You do not have the permission to mark this task as completed.';
            }

            header('Location: ' . ROOT);
            exit;
        }
        else
        {
            header("Location: " . ROOT);
            exit;
        }
    }

    public function delete()
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $id = intval($_POST['id']);
            $task_user_id = $this->taskModel->getUserIdByTaskId($id);
            
            if($task_user_id && $task_user_id === $_SESSION['loggedInUserId'])
            {
                if($this->taskModel->deleteTask($id))
                {
                    $_SESSION['success'] = 'Task deleted successfully.';
                }
                else
                {
                    $_SESSION['error'] = 'Failed to delete task. Please try again.';
                }
            }
            else
            {
                $_SESSION['error'] = 'You do not have permission to delete this task.';
            }

            header('Location: ' . ROOT);
            exit;
        }
        else
        {
            header("Location: " . ROOT);
            exit;
        }
    }

    public function error()
    {
        $this->view("error");
    }
}