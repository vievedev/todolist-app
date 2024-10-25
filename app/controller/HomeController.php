<?php

class HomeController extends Controller
{
    public function __construct()
    {
        $this->taskModel = $this->model("Task");
    }

    public function index()
    {
        if(!empty($_SESSION['loggedInUserId']))
        {
            $userTasks = $this->taskModel->getTasks($_SESSION['loggedInUserId']);
            $this->view('tasks/index', ['userTasks' => $userTasks]);
        }
        else 
        {
            $this->view('auth/login');
        }
    }

    public function error()
    {
        $this->view("error");
    }
}