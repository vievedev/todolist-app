<?php

class RegisterController extends Controller
{
    public function index()
    {
        if(!empty($_SESSION['loggedInUserId']))
        {
            header("Location: " . ROOT);
            exit;
        }
        else 
        {
            $this->view('auth/register');
        }
    }

    public function error()
    {
        $this->view("error");
    }
}