<?php

class AuthController extends Controller
{
    public function __construct()
    {
        $this->userModel = $this->model("User");
    }

    public function index()
    {
        header("Location: " . ROOT);
        exit;
    }

    public function register()
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $errors = [];

            $name = cleanInput($_POST['name']);
            $email = cleanInput($_POST['email']);
            $password = $_POST['password'];
            $confirmpassword = $_POST['confirmpassword'];

            $_SESSION['register_name'] = $name;
            $_SESSION['register_email'] = $email;

            if(empty($name))
            {
                $errors[] = "Name is required.";
            }
            elseif(strlen($name) > 255)
            {
                $errors[] = "Name cannot exceed 255 characters.";
            }

            if(empty($email))
            {
                $errors[] = "Email is required.";
            }
            elseif(strlen($email) > 255)
            {
                $errors[] = "Email cannot exceed 255 characters.";
            }
            elseif(!filter_var($email, FILTER_VALIDATE_EMAIL))
            {
                $errors[] = "Email address " . $email . " is not valid.";
            }
            elseif($this->userModel->emailExists($email))
            {
                $errors[] = "Email address " . $email . " already exists.";
            }

            if(empty($password))
            {
                $errors[] = "Password is required.";
            }
            elseif(strlen($password) > 255)
            {
                $errors[] = "Password cannot exceed 255 characters.";
            }
            elseif(!$this->userModel->passwordsMatch($password, $confirmpassword))
            {
                $errors[] = "Password and confirm password do not match.";
            }

            if(!empty($errors))
            {
                $_SESSION['errors'] = $errors;
                header("Location: " . ROOT . "register");
                exit;
            }
            else
            {
                unset($_SESSION['register_name']);
                unset($_SESSION['register_email']);

                if($this->userModel->register($name, $email, $password))
                {
                    $this->view('auth/registered');
                }
            }


        }
        else
        {
            header("Location: " . ROOT);
            exit;
        }
    }

    public function login()
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $errors = [];
            
            $email = cleanInput($_POST['email']);
            $password = cleanInput($_POST['password']);

            $_SESSION['login_email'] = $email;

            if(empty($email))
            {
                $errors[] = "Email is required.";
            }
            elseif(!filter_var($email, FILTER_VALIDATE_EMAIL))
            {
                $errors[] = "Email address '$email' is not valid.";
            }                

            if(empty($password))
            {
                $errors[] = "Password is required.";
            }

            if(!empty($email) && !empty($password))
            {
                if(!$this->userModel->login($email, $password))
                {
                    $errors[] = "Your login details are incorrect.";
                }
                elseif(!$this->userModel->accountVerified($email))
                {
                    $errors[] = "To continue, please verify your account.";
                }
            }

            if(!empty($errors))
            {
                $_SESSION['errors'] = $errors;
                header("Location: " . ROOT);
                exit;
            }
            else
            {
                unset($_SESSION['login_email']);
                $_SESSION['loggedInUserId'] = $this->userModel->getIdByEmail($email);
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

    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();
        header('Location: ' . ROOT);
        exit;
    }

    public function error()
    {
        $this->view("error");
    }
}