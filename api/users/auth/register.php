<?php
$method="POST";
$cache="no-cache";
include "../../head.php";

// name, email and password are required for registration
if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password'])){
    $name=cleanme($_POST['name']);
    $email=cleanme($_POST['email']);
    $password=cleanme($_POST['password']);
    //validation
    if(input_is_invalid($name) || input_is_invalid($email) || input_is_invalid($password)){
        respondBadRequest("Name, email and password are required");
    }else if(!validateEmail($email)){
        respondBadRequest("Invalid email address");
    }else if(!validatePassword($password)){
        respondBadRequest("Password must contain at least 6 characters, including uppercase, lowercase, number and special character");
    }else{
        // check if email already exists
        $checkemail = $connect->prepare("SELECT id FROM users WHERE email=?");
        $checkemail->bind_param("s",$email);
        $checkemail->execute();
        $checkresult = $checkemail->get_result();
        if($checkresult->num_rows > 0){
            respondBadRequest("Email already exists");
        }else{
            // insert new user
            $hashedpassword = Password_encrypt($password);
            $insert_data = $connect->prepare("INSERT INTO users (`name`, `email`, `password`) VALUES (?,?,?)");
            $insert_data->bind_param("sss",$name,$email,$hashedpassword);
            $insert_data->execute();

            if($insert_data){
                $newuserid = $connect->insert_id;
                $accesstoken = getTokenToSendAPI($newuserid);
                respondOK(["userid"=>$newuserid,"access_token"=>$accesstoken],"Registration successful");
            }else{
                respondBadRequest("Registration failed. Please try again");
            }
        }
    }
}else{
   respondBadRequest("Invalid request. Name, email and password are required.");
}

?>