<?php

function show($smth)
{
    echo "<pre>";
    print_r($smth);
    echo "</pre>";
}

function getIP()
{  
    if(!empty($_SERVER['HTTP_CLIENT_IP']))
    {   
        return $_SERVER['HTTP_CLIENT_IP'];   
    }    
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
    {   
        return $_SERVER['HTTP_X_FORWARDED_FOR'];   
    }   
    else
    {   
        return $_SERVER['REMOTE_ADDR'];   
    }     
}

function cleanInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}