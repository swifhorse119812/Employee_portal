<div style="width: 100%;">
	<div style="float: left;">
	<img style="width: 70px; " src="<?php echo base_url("assets/client_assets/images/logo.png"); ?>" alt="..." class="profile_img">
	</div>
	<div style="font-size: 35px; float: left;">
	 	Virsympay Transaction Details
	 </div>
</div>
<div style="clear: both;">
<table id="example" class="table table-striped jambo_table bulk_action">
    <thead>
      <tr class="headings" style="background-color:#24652e; color: white;">
        <th>Transaction Id</th>
        <th>Transaction Date</th>
        <th>Merchant</th>
        <th>Type</th>
        <th>Customer Name</th>
        <th>Gross</th>
        <th>Fee</th>
        <th>Net</th>
        <th>Status</th>
      </tr>
    </thead>

    <tbody>
      <?php
            $transactions = get_rows("transaction",array("date>="=>$from_date,"date<"=>$to_date),"date DESC");
            foreach ($transactions as $key => $transaction) {
              $member = get_row("member",array("id"=>$transaction['user_id']));
                echo "<tr class='".$transaction['status']."'>";
                echo '<td>'.$transaction['id'].'</td>';
                echo '<td>'.$transaction['date'].'</td>';
                echo '<td>'.$member['first_name']." ".$member["last_name"].'</td>';
                if($transaction['payment_type'] == "checkout"){
                    echo '<td>Payment from</td>';
                    echo '<td><span class="customer-details" data-id="'.$transaction['id'].'" data-publish_key="'.$transaction['publish_key'].'" data-status="'.$transaction['status'].'">'.$transaction['first_name']." ".$transaction['last_name'].'</span></td>';
                    echo '<td>$'.($transaction['price'] + $transaction['checkout_fee'] ).'USD</td>';
                    echo '<td>$'.($transaction['fee']+$transaction['checkout_fee']).'USD</td>';
                    echo '<td>$'.($transaction['price']-$transaction['fee']).'USD</td>';
                } else if($transaction['payment_type'] == "service_fee") {
                    echo '<td>Service Fee</td>';
                    echo '<td> - </td>';
                    echo '<td> - </td>';
                    echo '<td>$'.$transaction['fee'].'USD</td>';
                    echo '<td style="color:blue;">-$'.$transaction['fee'].'USD</td>';
                } else if($transaction['payment_type'] == "withdraw_money"){
                    echo '<td>Withdraw</td>';
                    echo '<td>-</td>';
                    $fee = $transaction['fee'];
                    echo '<td>$'.$transaction['price'].'USD</td>';
                    echo '<td>$'.$fee.'USD</td>';
                    echo '<td style="color:red;">-$'.($transaction['price']-$fee).'USD</td>';
                }
                echo '<td>'.(str_replace("_", " ", $transaction['status'])).'</td>';
                echo "</tr>";

            }
         ?>
    </tbody>
  </table>
  </div> 