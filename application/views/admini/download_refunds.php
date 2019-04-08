<div style="width: 100%;">
	<div style="float: left;">
	<img style="width: 70px; " src="<?php echo base_url("assets/client_assets/images/logo.png"); ?>" alt="..." class="profile_img">
	</div>
	<div style="font-size: 35px; float: left;">
	 	Virsympay Refund History
	 </div>
</div>
<div style="clear: both;">
<table id="example" class="table table-striped jambo_table bulk_action">
    <thead>
      <tr class="headings" style="background-color:#24652e; color: white;">
        <th>Transaction Id</th>
        <th>Transaction Date</th>
        <th>Refund Date</th>
        <th>Customer Name</th>
        <th>Refund Amount</th>
        <th>Card Number</th>
        <th>Status</th>
      </tr>
    </thead>

    <tbody>
      <?php
            $transactions = get_rows("transaction",array("date>="=>$from_date,"date<"=>$to_date,"status"=>"Refund"),"date DESC");
            foreach ($transactions as $key => $transaction) {
                $member = get_row("member",array("id"=>$transaction['user_id']));
                echo "<tr class='".$transaction['status']."'>";
                echo '<td>'.$transaction['id'].'</td>';
                echo '<td>'.$transaction['date'].'</td>';
                echo '<td>'.$transaction['refund_date'].'</td>';
                echo '<td>'.$transaction['first_name']." ".$transaction["last_name"].'</td>';
                echo '<td>$'.$transaction['price'].'</td>';
                echo '<td>'.$transaction['card_number'].'</td>';
                echo '<td>'.(str_replace("_", " ", $transaction['status'])).'</td>';
                echo "</tr>";
            }
         ?>
    </tbody>
  </table>
  </div> 