<?php
// send some CORS headers so the API can be called from anywhere
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST"); // OPTIONS,GET,POST,PUT,DELETE
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
Header("Cache-Control: no-cache");
// header("Access-Control-Max-Age: 60");//3600 seconds
// 1)private,max-age=60 (browser is only allowed to cache) 2)no-store(public),max-age=60 (all intermidiary can cache, not browser alone)  3)no-cache (no ceaching at all)
include "../../phpv3/functions.php";
include "../apifunctions.php";
?>
<?php
$method = getenv('REQUEST_METHOD');
$endpoint = "/api/".basename($_SERVER['PHP_SELF']);
$maindata=[];
if (getenv('REQUEST_METHOD') == 'POST') {



    if (isset($_POST['bankid'])) {
        $bankid = cleanme($_POST['bankid']);
    } else {
        $bankid = '';
    }
    if (isset($_POST['accno'])) {
        $accno = cleanme($_POST['accno']);
    } else {
        $accno = '';
    }
    $fail="";
    $myloc=1;
    $sysgetdata =  $connect->prepare("SELECT * FROM apidatatable WHERE id=?");
    $sysgetdata->bind_param("s", $myloc);
    $sysgetdata->execute();
    $dsysresult7 = $sysgetdata->get_result();
    $getsys = $dsysresult7->fetch_assoc();
    $companyprivateKey=$getsys['privatekey'];
    $minutetoend=$getsys['tokenexpiremin'];
    $serverName=$getsys['servername'];
    $sysgetdata->close();

    $datasentin=ValidateAPITokenSentIN($serverName, $companyprivateKey, $method, $endpoint);
    $loadid=$datasentin->usertoken;
    
    $dashid="null";
    $dashuname="";
    $checkdata =  $connect->prepare("SELECT activatepin,Sername,Password,ID,Email FROM users  WHERE userpubkey=? ");
    $checkdata->bind_param("s", $loadid);
    $checkdata->execute();
    $dresulttest = $checkdata->get_result();
    if($dresulttest->num_rows>0){
        $found= $dresulttest->fetch_assoc();
        //save fetcheced data inside session and proceed to dashboard
        $dashemail = $found['Email'];
        $dashid = $found['ID'];
        $dashpass = $found['Password'];
        $dashuname =  $found['Sername'];
        $dashactivatepin = $found['activatepin'];
    }


    if (empty($loadid)||empty($accno)|| empty($bankid)) {
        $fail= 'Please fill all fileds';
    } elseif ($dresulttest->num_rows == 0) {
        $fail="User not found";
    }

    $checkdata2 =  $connect->prepare("SELECT * FROM  userbanks WHERE id=? AND user_id=? AND account_no=?");
    $checkdata2->bind_param("sss", $bankid,$dashid, $accno);
    $checkdata2->execute();
    $dresult2 = $checkdata2->get_result();

   if (isset($dresult2) && $dresult2->num_rows == 0) {
        $fail='Bank does not exist'; 
    }

    if ($fail=="") {
        
       $ddata=$dresult2->fetch_assoc();
       $bankname=$ddata['bank_name'];
       $accname=$ddata['account_name'];
       $accno=$ddata['account_no'];
       $daccbankcode=$ddata['paystackbankcode'];
       $daccrefcode=$ddata['paystackrefcode'];
       
       $checktrans=isuserhavinginwallet($dashuname);
       if($checktrans==0){
            $update_data = $connect->prepare("UPDATE users SET Accbank2pay=?,Accname2pay=?,Accno2pay=?,Paystackbankcode2pay=?,Paystackrefcode2pay=? WHERE ID= ?");
            $update_data->bind_param("sssssi", $bankname, $accname, $accno, $daccbankcode, $daccrefcode, $dashid);
            if ($update_data->execute()) {
                  //convert resonse to JSON starts
                  $errordesc = " ";
                        $linktosolve = "htps://";
                        $hint = [];
                        $errordata = [];
                        $text = "Bank set successfully";
                        $method = getenv('REQUEST_METHOD');
                        $status = true;
                        $data = returnSuccessArray($text, $method, $endpoint, $errordata, $maindata, $status);
                        respondOK($data);
            } else {
                $errordesc = "Internal server error";
                $linktosolve = "htps://";
                $hint = ["System not saving user bank details into the bank table"];
                $errordata = returnError7003($errordesc, $linktosolve, $hint);
                $text = "Error deleting bank";
                $method = getenv('REQUEST_METHOD');
                $data = returnErrorArray($text, $method, $endpoint, $errordata);
                respondInternalError($data);
            }
       }else{
            $errordesc = "Bad request";
            $linktosolve = "htps://";
            $hint = ["Ensure user has no in wallet transaction","Ensure that all data specified in the API is sent", "Ensure that all data sent is not empty", "Ensure that the exact data type specified in the documentation is sent."];
            $errordata = returnError7003($errordesc, $linktosolve, $hint);
            $text = $changebnkerr;
            $data = returnErrorArray($text, $method, $endpoint, $errordata);
            respondBadRequest($data);
        }
    } else {
        $errordesc = "Bad request";
        $linktosolve = "htps://";
        $hint = ["Ensure user data exist in the database","Ensure that all data specified in the API is sent", "Ensure that all data sent is not empty", "Ensure that the exact data type specified in the documentation is sent."];
        $errordata = returnError7003($errordesc, $linktosolve, $hint);
        $text = $fail;
        $data = returnErrorArray($text, $method, $endpoint, $errordata);
        respondBadRequest($data);
    }
} else {
    $errordesc = "Method not allowed";
    $linktosolve = "htps://";
    $hint = ["Ensure to use the method stated in the documentation."];
    $errordata = returnError7003($errordesc, $linktosolve, $hint);
    $text = "Method used not allowed";
    $method = getenv('REQUEST_METHOD');
    $data = returnErrorArray($text, $method, $endpoint, $errordata);
    respondMethodNotAlowed($data);
}
?>