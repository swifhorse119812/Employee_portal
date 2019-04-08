<?php 
  header("Pragma: public");
  header("Expires: 0");
  header('Content-Type: application/csv');
  header("Content-Disposition: attachment; filename=\"sold_product_report.csv\";");
  header("Content-Transfer-Encoding: binary");
  echo '"Transaction Id",';
  echo '"Sold Date",';
  echo '"Merchant Name",';
  echo '"Product Title",';
  echo '"Product Price",';
  $transactions = get_rows("transaction",array("date>="=>$from_date,"date<"=>$to_date),"date DESC");
  foreach ($transactions as $key => $transaction) {
      $member = get_row("member",array("id"=>$transaction['user_id']));
      echo "\n";
      echo '"'.$transaction['id'].'",';
      echo '"'.$transaction['date'].'",';
      echo '"'.$member['first_name']." ".$member["last_name"].'",';
      $product = get_row("product",array("publish_key"=>$transaction['publish_key']));
      echo '"'.$product['title'].'",';
      echo '"$'.$transaction['price'].'",';
  }
  exit;

?> 
  