<?php

class User
{
    private $conn;

    public function __construct()
    {
        $db = new Database;
        $this->conn = $db->connect();
    }

    public function emailExists($email)
    {
        $sql = "SELECT email FROM users WHERE email=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $email);
        if($stmt->execute())
        {
            $result = $stmt->get_result();

            if($result->num_rows > 0)
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
    }

    public function passwordsMatch($password, $confirmpassword)
    {
        if($password === $confirmpassword)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function register($name, $email, $password)
    {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sss", $name, $email, $hashed_password);
        if($stmt->execute())
        {
            $stmt->close();
            return true;
        }
    }

    public function login($email, $password)
    {
        $sql = "SELECT id, password FROM users WHERE email=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $email);
        if($stmt->execute())
        {
            $result = $stmt->get_result();

            if($result->num_rows > 0)
            {
                $row = $result->fetch_assoc();

                $id = $row ['id'];
                $hashed_password = $row ['password'];

                if(password_verify($password, $hashed_password))
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
            else
            {
                $stmt->close();
                return false;
            }            
        }
    }

    public function accountVerified($email)
    {
        $sql = "SELECT verified FROM users WHERE email=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $email);
        if($stmt->execute())
        {
            $result = $stmt->get_result();
            if($result->num_rows > 0)
            {
                $row = $result->fetch_assoc();
                if($row['verified'] === 0)
                {
                    $stmt->close();
                    return false;
                }
                else
                {
                    $stmt->close();
                    return true;
                }
            }
            else
            {
                $stmt->close();
                return false;
            }
        }
    }

    public function getIdByEmail($email)
    {
        $sql = "SELECT id FROM users WHERE email=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $email);
        if($stmt->execute())
        {
            $result = $stmt->get_result();
            if($result->num_rows > 0)
            {
                $row = $result->fetch_assoc();
                $stmt->close();
                return $row['id'];
            }
            else
            {
                $stmt->close();
                return false;
            }
        }
    }

    // public function getQuestion($question_id)
    // {
    //     $sql = "SELECT question_id, question_text FROM questions WHERE question_id = ?";
    //     $stmt = $this->conn->prepare($sql);
    //     $stmt->bind_param("s", $question_id);
    //     $stmt->execute();
    //     $result = $stmt->get_result();
    //     $row = $result->fetch_assoc();
    //     return $row;
    // }

    // public function getOptions($question_id)
    // {
    //     $sql = "SELECT option_id, option_text FROM options WHERE question_id = ?";
    //     $stmt = $this->conn->prepare($sql);
    //     $stmt->bind_param("s", $question_id);
    //     $stmt->execute();
    //     $result = $stmt->get_result();
    //     $array = array();
    //     while($row = $result->fetch_assoc())
    //     {
    //         $array[] = $row;
    //     }
        
    //     return $array;
    // }

    // public function getMaxTakerID()
    // {
    //     $maxTakerID = 0;
    //     $sql = "SELECT MAX(taker_id) as maxTakerID FROM takers";
    //     $result = $this->conn->query($sql);
    //     if($result->num_rows > 0)
    //     {
    //         $row = $result->fetch_assoc();
    //         $maxTakerID = $row['maxTakerID'];
    //     }
    //     else
    //     {
    //         $maxTakerID = 0;
    //     }
        
    //     return $maxTakerID;
        
    // }

    // public function questionID($question_id)
    // {
    //     $sql = "SELECT id FROM questions WHERE question_id = ?";
    //     $stmt = $this->conn->prepare($sql);
    //     $stmt->bind_param("s", $question_id);
    //     $stmt->execute();
    //     $result = $stmt->get_result();
    //     $row = $result->fetch_assoc();        
    //     return $row['id'];
    // }

    // public function insertAnswers($taker_id, $question_id, $option_id, $specify_other = null, $specify_text_field = null)
    // {
    //     $sql = "INSERT INTO answers (taker_id, question_id, option_id, specify_other, specify_text_field) VALUES (?, ?, ?, ?, ?)";
    //     $stmt = $this->conn->prepare($sql);
    //     $stmt->bind_param("isiss", $taker_id, $question_id, $option_id, $specify_other, $specify_text_field);
    //     if($stmt->execute())
    //     {
    //         $stmt->close();
    //         return true;
    //     }
    // }
}