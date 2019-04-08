<?php 
  header("Pragma: public");
  header("Expires: 0");
  header('Content-Type: application/csv');
  header("Content-Disposition: attachment; filename=\"wire_fee_report.csv\";");
  header("Content-Transfer-Encoding: binary");
  echo '"Transaction Id",';
  echo '"Transaction Date",';
  echo '"Merchant Name",';
  echo '"Withdraw Amount",';
  echo '"Wire Fee",';
 
  $transactions = get_rows("transaction",array("date>="=>$from_date,"date<"=>$to_date),"date DESC");
  foreach ($transactions as $key => $transaction) {
      $member = get_row("member",array("id"=>$transaction['user_id']));
      echo "\n";
      echo '"'.$transaction['id'].'",';
      echo '"'.$transaction['date'].'",';
      echo '"'.$member['first_name']." ".$member["last_name"].'",';
      echo '"$'.$transaction['price'].'",';
      echo '"$'.$transaction['fee'].'",';
  }
  exit;

?> 
     