<div style="width: 100%;">
	<div style="float: left;">
	<img style="width: 70px; " src="<?php echo base_url("assets/client_assets/images/logo.png"); ?>" alt="..." class="profile_img">
	</div>
	<div style="font-size: 35px; float: left;">
	 	Virsympay Sold Product History
	 </div>
</div>
<div style="clear: both;">
<table id="example" class="table table-striped jambo_table bulk_action">
    <thead>
      <tr class="headings" style="background-color:#24652e; color: white;">
        <th>Transaction Id</th>
        <th>Sold Date</th>
        <th>Merchant Name</th>
        <th>Product Name</th>
        <th>Product Price</th>
      </tr>
    </thead>
    <tbody>
      <?php
            $transactions = get_rows("transaction",array("date>="=>$from_date,"date<"=>$to_date,"payment_type"=>"checkout"),"date DESC");
            foreach ($transactions as $key => $transaction) {
                $member = get_row("member",array("id"=>$transaction['user_id']));
                echo "<tr class='".$transaction['status']."'>";
                echo '<td>'.$transaction['id'].'</td>';
                echo '<td>'.$transaction['date'].'</td>';
                echo '<td>'.$member['first_name']." ".$member["last_name"].'</td>';
                $product = get_row("product",array("publish_key"=>$transaction['publish_key']));
                echo '<td>'.$product['title'].'</td>';
                echo '<td>$'.$transaction['price'].'</td>';
                echo "</tr>";
            }
         ?>
    </tbody>
  </table>
  </div> 