<?php 
  header("Pragma: public");
  header("Expires: 0");
  header('Content-Type: application/csv');
  header("Content-Disposition: attachment; filename=\"transaction_datails_report.csv\";");
  header("Content-Transfer-Encoding: binary");
    echo '"Transaction Id",';
    echo '"Transaction Date",';
    echo '"Merchant",';
    echo '"Type",';
    echo '"Customer Name",';
    echo '"Gross",';
    echo '"Fee",';
    echo '"Net",';
    echo '"Status",';
    $transactions = get_rows("transaction",array("date>="=>$from_date,"date<"=>$to_date),"date DESC");
    foreach ($transactions as $key => $transaction) {
      $member = get_row("member",array("id"=>$transaction['user_id']));
        echo "\n";
        echo '"'.$transaction['id'].'",';
        echo '"'.$transaction['date'].'",';
        echo '"'.$member['first_name']." ".$member["last_name"].'",';
        if($transaction['payment_type'] == "checkout"){
            echo '"Payment from",';
            echo '"'.$transaction['first_name']." ".$transaction['last_name'].'",';
            echo '"$'.($transaction['price'] + $transaction['checkout_fee'] ).'USD",';
            echo '"$'.($transaction['fee']+$transaction['checkout_fee']).'USD",';
            echo '"$'.($transaction['price']-$transaction['fee']).'USD",';
        } else if($transaction['payment_type'] == "service_fee") {
            echo '"Service Fee",';
            echo '" - ",';
            echo '" - ",';
            echo '"$'.$transaction['fee'].'USD",';
            echo '"-$'.$transaction['fee'].'USD",';
        } else if($transaction['payment_type'] == "withdraw_money"){
            echo '"Withdraw",';
            echo '"-",';
            $fee = $transaction['fee'];
            echo '"$'.$transaction['price'].'USD",';
            echo '"$'.$fee.'USD",';
            echo '"-$'.($transaction['price']-$fee).'USD",';
        }
        echo '"'.(str_replace("_", " ", $transaction['status'])).'",';
    }

  exit;

?> 