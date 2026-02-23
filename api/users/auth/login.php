<?php
$method="POST";
$cache="no-cache";
include "../../head.php";

// user id and password are required for login
if(isset($_POST['userid']) && isset($_POST['password'])){
    $userid=cleanme($_POST['userid']);
    $password=cleanme($_POST['password']);
    //validation
    if(input_is_invalid($userid) || input_is_invalid($password)){
        respondBadRequest("User ID and password are required");
    }else if(!is_numeric($userid)){ 
        respondBadRequest("User ID must be numeric");
    }else{
        $getdataemail =  $connect->prepare("SELECT id FROM users where id=? and password=?"); 
        $getdataemail->bind_param("is",$userid,$password);
        $getdataemail->execute();
        $getresultemail = $getdataemail->get_result();
        if( $getresultemail->num_rows> 0){
            $userid=['id'];
            $accesstoken=getTokenToSendAPI($userid);
            
          respondOK(["userid"=>$userid,'access_token'=>$accesstoken],"Login successful");
        }else{ respondBadRequest("Invalid user ID or password"); } 
   }
}else{
   respondBadRequest("Invalid request. User ID and password are required.");
}
 
?>