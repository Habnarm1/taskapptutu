<?php
$studentage=22;
$studentAccountStatus="suspended";
$totalcoursregisteredfor=78;
$oustandingfine=900;
$officalapproval=true;
$readingSession=3;
$stayedOverNight=true;
$allowDoubleOverNightStay=true;
$OverNightHours=true;

// if($studentage>=18){
//  if($studentAccountStatus!="suspended"){
//    if($totalcoursregisteredfor>=1){
//          if($oustandingfine<=0){
//                if($officalapproval==true){
//                    if($readingSession<2){
//                         if(($stayedOverNight==false)||($stayedOverNight==true&&$allowDoubleOverNightStay==true)){
//                            if($OverNightHours==true){
//                                     print("ENTER");
//                            }else{

//                            }
//                         }else{

//                         }
//                   }else{
                     
//                   }
//                }else{
//                   print("leave");
//                }
              
//          }else{

//          }
//     }else{

//     }
//  }else{

//  }
// }else{
//  print("politely turned away");

// }



$age=20;
switch($age){
   case 20:
      print("20 years old");
   break;
   case 10:
      print("10 years old");
   break;
   case 30:
      print("30 years old");
   break;
   default:
      print("no years old");
   break;
}

?>