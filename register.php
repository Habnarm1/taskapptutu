<?php
// send some CORS headers so the API can be called from anywhere
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST"); // OPTIONS,GET,POST,PUT,DELETE
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
Header("Cache-Control: no-cache");
header("Access-Control-Max-Age: 3600");//3600 seconds
// 1)private,max-age=60 (browser is only allowed to cache) 2)no-store(public),max-age=60 (all intermidiary can cache, not browser alone)  3)no-cache (no ceaching at all)

include "functions.php";
include "apifunctions.php";

$data=getCurrentFileFullURL();
print($data);

<?php
//Database Connection to 
$server= 'localhost';
$username= 'root';
$password= '';
$dbname= 'todo_app'; 


$connect= mysqli_connect($server,$username,$password,$dbname);
  


// // $insert_data = $connect->prepare("UPDATE bill_voucher_saved_meters SET bankname=?,bankacc=?,accrefcode=?,accserverrefcode=?,banksystemtype=?,account_name=?,banktypeis=? WHERE trackid=? AND userid=?");
// // $insert_data->bind_param("ssssssssi",  $banktypename, $newbankaccno,$myrefcode,$newreseverref,$bankcode,$acctname,$type,$metertid,$userid);
// // $insert_data->execute();
// // $insert_data->close();

// if(isset($_POST['classname']) && isset($_POST['session'])){
//     $classNAme=$_POST['classname'];
//     $academicYear=$_POST['session'];
//     $insert_data = $connect->prepare("INSERT INTO classes (`name`, `academic_year`) VALUES (?,?)");
//     $insert_data->bind_param("ss", $classNAme, $academicYear);
//     $insert_data->execute();
//     $insert_data->close();

//     if($insert_data){
//         $responsise=array("status"=>true,"message"=>"Data Inserted Successfully","data"=>array("classname"=>$classNAme,"session"=>$academicYear));
//        print_r(json_encode($responsise));
//     }else{
//         print_r(json_encode(array("status"=>false,"message"=>"Data Not Inserted")));
//     }
//     exit;
// }

// if(isset($_GET['classid'])){
// //  $newname="Senior Secondary";
// // $classtid=4;
// // $insert_data = $connect->prepare("UPDATE classes SET name=? WHERE id=?");
// // $insert_data->bind_param("si", $newname, $classtid);
// // $insert_data->execute();
// // $insert_data->close();

//     $classtid=$_GET['classid'];
//     $insert_data = $connect->prepare(query: "DELETE FROM classes WHERE id=?");
//     $insert_data->bind_param("i", $classtid);
//     $insert_data->execute();
//     $insert_data->close();
//     }

// ?>


// <?php
// $totallimit=4;
// $getdataemail =  $connect->prepare("SELECT * FROM classes ");
// // $getdataemail->bind_param("i",$totallimit);
// $getdataemail->execute();
// $getresultemail = $getdataemail->get_result();
// if( $getresultemail->num_rows> 0){
//     while($getthedata= $getresultemail->fetch_assoc()){
//         // print_r($getthedata);
//         print_r("<br>");

//         print_r("Class id is ".$getthedata['id']." Class Name is ".$getthedata['name']." Class Academic year is ".$getthedata['academic_year']); 
//         echo"
//         <button><a href='connectdb.php?classid=".$getthedata['id']."'>Delete</a></button>
//         ";
//         print_r("<br>");
//     }
// }else{
//     print("No data found");
// }
?>
?>

