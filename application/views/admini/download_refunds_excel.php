<?php 
  header("Pragma: public");
  header("Expires: 0");
  header('Content-Type: application/csv');
  header("Content-Disposition: attachment; filename=\"refund_report.csv\";");
  header("Content-Transfer-Encoding: binary");
  echo '"Transaction Id",';
  echo '"Transaction Date",';
  echo '"Refund Date",';
  echo '"Customer Name",';
  echo '"Refund Amount",';
  echo '"Card Number",';
  echo '"Status",';

  $transactions = get_rows("transaction",array("date>="=>$from_date,"date<"=>$to_date),"date DESC");
  foreach ($transactions as $key => $transaction) {
      $member = get_row("member",array("id"=>$transaction['user_id']));
      echo "\n";
        echo '"'.$transaction['id'].'",';
        echo '"'.$transaction['date'].'",';
        echo '"'.$transaction['refund_date'].'",';
        echo '"'.$transaction['first_name']." ".$transaction["last_name"].'",';
        echo '"$'.$transaction['price'].'",';
        $card_number = "";
        for($i=0; $i<strlen($transaction['card_number']); $i++)
            $card_number .= "*";
        $card_number.= substr($transaction['card_number'], -4);
        echo '"'.$card_number.'",';
        echo '"'.(str_replace("_", " ", $transaction['status'])).'",';
  }
  exit;

?> 
   