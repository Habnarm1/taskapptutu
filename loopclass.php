<?php
$riderData = [
    ["name" => "Tunde", "zone" => "Mainland", "distance" => 12, "urgent" => false],
    ["name" => "Abubakar", "zone" => "Island", "distance" => 35, "urgent" => true],
    ["name" => "Chidi", "zone" => "Express (inter-state)", "distance" => 60, "urgent" => false],
    ["name" => "Musa", "zone" => "Outskirts", "distance" => 18, "urgent" => false],
    ["name" => "Tunde", "zone" => "Island", "distance" => 8, "urgent" => true],
    ["name" => "Abubakar", "zone" => "X", "distance" => 25, "urgent" => false],
    ["name" => "Chidi", "zone" => "Mainland", "distance" => 55, "urgent" => true]
];

for($i=0;$i<count($riderData);$i++){
    $selectedzone=$riderData[$i]['zone'];
    $selectedDistance=$riderData[$i]['distance'];
    $selectedUrgent=$riderData[$i]['urgent'];
    $selectedName=$riderData[$i]['name'];

    $totalPrice=0;
    $skip=false;
    switch($selectedzone){
        case "Mainland":
         $totalPrice=150*$selectedDistance;
        break;
        case "Island":
          $totalPrice=300*$selectedDistance;
        break; 
        case "Outskirts":
           $totalPrice=100*$selectedDistance;
        break; 
        case "Express (inter-state)":
            $totalPrice=500*$selectedDistance;
        break; 
        default:
           $skip=true ;
    }
    if($skip){
        continue;
    }
    
    if($selectedDistance>50){
       $discount=0.2; 
    }else if($selectedDistance>30 && $selectedDistance<50){
        $discount=0.1;
    }else if($selectedDistance>15 && $selectedDistance<30){
        $discount=0.05;
    }else{
        $discount=0;
    }

    $discountAmount=$totalPrice* $discount;
    $priceAfterDiscount=$totalPrice-$discountAmount;
    
    $finalPrice=$priceAfterDiscount;
    if($selectedUrgent){
        $urgentFee=$priceAfterDiscount*0.25;
        $finalPrice=$priceAfterDiscount+$urgentFee;
    }
    
    print("Name:$selectedName<br> zone: $selectedzone <br>Distance:$selectedDistance <br> Base price:$totalPrice <br> Discount applied:$discountAmount <br> Urgent:$selectedUrgent<br> FinalPrice:$finalPrice <br><br>");
}


?>