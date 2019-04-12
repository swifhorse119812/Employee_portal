<?php
	$this->load->view('common/header.php');
?>
        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Employees List </h3>
              </div>
            </div>
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Employees List </h2>
                    <!-- <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="#">Settings 1</a>
                          </li>
                          <li><a href="#">Settings 2</a>
                          </li>
                        </ul>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul> -->
                    <!-- <a href=" <?php echo base_url()?>admini/customer/Add  " class="btn btn-round btn-danger navbar-right">
                                      <i class="fa fa-plus"></i> Add New
                                     </a> -->
                    <div class="clearfix"></div>
                  </div>

                  <div class="x_content">

                    

                    <div class="table-responsive">
                      <table id="example" class="table table-striped jambo_table bulk_action">
                        <thead>
                          <tr class="headings" style="background-color:#24652e">
                            <th>
                              No
                            </th>
                            <th class="column-title">First Name</th>
                            <th class="column-title">Last Name</th>
                            <th class="column-title">Email </th>
                            <th class="column-title">Phone Number</th>
                            <th class="column-title">Created Date</th>
                            <th style="text-align: right;" class="column-title">Action </th>
                            </th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                         $i=0; 
                          foreach ($members as $key => $member) {
                            $i++;
                         ?>

                          <tr >
                            <td>
                              <?php echo $i?>
                            </td>
                            <td>
                            <?php echo $member['first_name']; ?>
                            </td>
                             
                             <td>
                            <?php echo $member['last_name']; ?>
                            </td>

                            <td>
                             <?php echo $member['email']; ?>
                            </td>
                            <td>
                             <?php echo $member['phone_number']; ?>
                            </td>                            
                            <!-- <td>
                              <?php echo $member['balance']; ?>
                            </td> -->
                            
                            <td>
                              <?php echo $member['date']; ?>
                            </td>

                            <td style="text-align: right;" >
                             <?php
                                if($member['approve_status'] == 1) {
                               ?>
                              <!-- <a data-status="0" data-id="<?php echo $member["id"]?>" class="btn btn-round btn-default suspend-btn">
                                <i class="fa fa-remove red"></i> Active -->
                              </a>
                              <?php } ?>
                               <a data-id=" <?php echo $member["id"]?> " class="btn btn-round btn-default card-info">
                                      <i class="fa fa-credit-card blue"></i> Card Info
                               </a>

                               <a data-id=" <?php echo $member["id"]?> " class="btn btn-round btn-default bank-info">
                                      <i class="fa fa-home blue"></i> Bank Info
                               </a>

                               <a data-id=" <?php echo $member["id"]?> " class="btn btn-round btn-default member-edit">
                                      <i class="fa fa-edit blue"></i> Edit
                               </a>
                               <!-- <a data-id=" <?php echo $member["id"]?> " class="btn btn-round btn-default member-delete">
                                      <i class="fa fa-remove red"></i> Delete
                               </a> -->
                              
                               <a href="<?php echo base_url("admini/user/fast_login/".$member["id"]); ?> " class="btn btn-round btn-default" target="_blank">
                                      <i class="fa fa-user blue"></i> Fast Login
                               </a>
                            </td>
                          </tr>
                        <?php } ?>
                        </tbody>
                      </table>
                    </div>
              
            
                  </div>
                </div>
              </div>
            </div>
          </div>
       
        </div> 



        <!-- /page content -->

<div class="modal fade in" id="view_modal" aria-hidden="false" style="display: none;">
  <div class="modal-dialog" style="width: 50%;">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
            <h3 class="modal-title">Edit member</h3>
        </div>
        <div class="modal-body" style="padding: 10px 0px;">


         <!--  <img id="memberimage" src=""/> -->
              <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" action="<?php echo base_url(); ?>admini/customer/updatemember" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" id="id">
                      <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="lastname">First Name <span class="required">*</span>
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="first_name" name="first_name" required="required"  class="form-control col-md-7 col-xs-12">
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="lastname">Last Name <span class="required">*</span>
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="last_name" name="last_name" required="required"  class="form-control col-md-7 col-xs-12">
                          </div>
                      </div>

                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Country <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                           <select class="form-control" name="country" required="">
                                <option value="United States of America">United States of America</option>
                                <?php
                                    $countries = get_rows("countries");
                                    foreach ($countries as $key => $country) {
                                        if($country['long_name'] == "United States of America") continue;
                                        echo '<option value="'.$country['long_name'].'">'.$country['long_name'].'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                      </div>
                       <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">City <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="city" name="city" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                       <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Address <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="address" name="address" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>

                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="email" id="email" name="email" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Phone Number <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="phone_number" name="phone_number" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Status</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <label>
                              <select class="select2_single form-control col-md-7 col-xs-12" name="approve_status" id="apporve_status">
                                <!-- <option value="0">Delete</option> -->
                                <option value="1">Waiting</option>
                                <option value="2">Active</option>
                              </select>
                            </label>
                        </div>
                      </div>
                        
                      <div class="item form-group">
                       <div class="ln_solid"></div>
                         <div class="form-group">
                         <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button class="btn btn-primary" id="editcancel" type="button">Cancel</button>
                          <button type="submit" class="btn btn-success">Update</button>
                         </div>
                         </div>
                       </div>
                  </form>
                </div>

                    
        </div>
    </div>
  </div>
</div>

 
<div class="modal fade in" id="card_modal" aria-hidden="false" style="display: none;">
  <div class="modal-dialog" style="width: 50%;">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
            <h3 class="modal-title">Card Info</h3>
        </div>
        <div class="modal-body" style="padding: 10px 0px;">
          <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" action="<?php echo base_url(); ?>admini/customer/updatemember" method="post" enctype="multipart/form-data">

         <!--  <img id="memberimage" src=""/> -->
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="lastname">Card Number </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="card_number" name="card_number" required="required"  class="form-control col-md-7 col-xs-12" readonly="">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="lastname">Expiry Date </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="expiry_date" name="expiry_date" required="required"  class="form-control col-md-7 col-xs-12" readonly="">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="lastname">CVV </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="cvv" name="cvv" required="required"  class="form-control col-md-7 col-xs-12" readonly="">
                </div>
            </div>
             
              
            <div class="item form-group">
             <div class="ln_solid"></div>
               <div class="form-group">
               <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3" style="text-align: right;">
                  <button class="btn btn-primary" data-dismiss="modal" type="button">Cancel</button>
               </div>
               </div>
             </div>
           </form>
        </div>
      </div>
    </div>
  </div>
</div>



<div class="modal fade in" id="bank_modal" aria-hidden="false" style="display: none;">
  <div class="modal-dialog" style="width: 50%;">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
            <h3 class="modal-title">Bank Info</h3>
        </div>
        <div class="modal-body" style="padding: 10px 0px;">
          <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" action="<?php echo base_url(); ?>admini/customer/updatemember" method="post" enctype="multipart/form-data">

         <!--  <img id="memberimage" src=""/> -->
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="lastname">Bank Name </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="name" name="name" required="required"  class="form-control col-md-7 col-xs-12" readonly="">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="lastname">Bank Address </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="address" name="address" required="required"  class="form-control col-md-7 col-xs-12" readonly="">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="lastname">Bank Country </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="country" name="country" required="required"  class="form-control col-md-7 col-xs-12" readonly="">
                </div>
            </div>

             <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="lastname">Bank Account Name </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="account_name" name="account_name" required="required"  class="form-control col-md-7 col-xs-12" readonly="">
                </div>
            </div>

             <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="lastname">Bank Account Number </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="account_number" name="account_number" required="required"  class="form-control col-md-7 col-xs-12" readonly="">
                </div>
            </div>

             <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="lastname">Bank Routing Number</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="routing_number" name="routing_number" required="required"  class="form-control col-md-7 col-xs-12" readonly="">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="lastname">Bank Swift code</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="swift_code" name="swift_code" required="required"  class="form-control col-md-7 col-xs-12" readonly="">
                </div>
            </div>

            <div class="item form-group">
             <div class="ln_solid"></div>
               <div class="form-group">
               <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3" style="text-align: right;">
                  <button class="btn btn-primary" data-dismiss="modal" type="button">Cancel</button>
               </div>
               </div>
             </div>
           </form>
        </div>
      </div>
    </div>
  </div>
</div>


<?php
	$this->load->view('common/footer.php');
?>
<script >

    $(document).ready(function() {
    $('#example').DataTable( {
         "dom": "<'row'<'col-sm-8'B><'col-sm-1'l><'col-sm-1'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        buttons: [
            'csv', 'print'
        ],
         

    } );


    // For demo to fit into DataTables site builder...
    $('#example')
        .removeClass( 'display' )
         .addClass('table table-striped table-bordered');

    $(".col-sm-1").removeClass("col-sm-1");
} );
   

  $(document).ready(function(){
   
    $("body").on("click",".member-edit",function(){
        id = $(this).data("id");
        $.ajax({
          url: BASE_URL + "admini/customer/getmemberData",
          data:{"id":id},
          dataType:"json",
          type:"post",
          success: function(res){
            $("#view_modal").modal();
            $("#id").val(id);
            $("#first_name").val(res.data.first_name);
            $("#last_name").val(res.data.last_name);
            $("option[value='"+res.data.country+"']").prop("selected",true);
            $("#city").val(res.data.city);
            $("#address").val(res.data.address);
            $("#phone_number").val(res.data.phone_number);
            $("#email").val(res.data.email);
          }
        })
    });

    $("body").on("click",".card-info",function(){
        id = $(this).data("id");
        $.ajax({
          url: BASE_URL + "admini/customer/get_card_info",
          data:{"id":id},
          dataType:"json",
          type:"post",
          success: function(res){
            $("#card_modal").modal();
            $("#card_number").val(res.data.card_number);
            $("#expiry_date").val(res.data.expiry_date);
            $("#cvv").val(res.data.cvv);
          }
        })
    });

    $("body").on("click",".bank-info",function(){
        id = $(this).data("id");
        $.ajax({
          url: BASE_URL + "admini/customer/get_bank_info",
          data:{"id":id},
          dataType:"json",
          type:"post",
          success: function(res){
            $("#bank_modal").modal();
            $("#name").val(res.data.name);
            $("#address").val(res.data.address);
            $("#country").val(res.data.country);
            $("#account_name").val(res.data.account_name);
            $("#account_number").val(res.data.account_number);
            $("#routing_number").val(res.data.routing_number);
            $("#swift_code").val(res.data.swift_code);
          }
        })
    });

     $("body").on("click",".suspend-btn",function(){
        id = $(this).data("id");
        status = $(this).data("status");
        $.ajax({
          url: BASE_URL + "admini/customer/suspend_member",
          data:{"id":id,"status":status},
          dataType:"json",
          type:"post",
          success: function(res){
            document.location.reload();
          }
        })
    });



     $("body").on("click",".member-delete",function(){
      if(confirm("Do you delete this employee really?")){
        id = $(this).data("id");
        obj = $(this).closest("tr");
        $.ajax({
          url: BASE_URL + "admini/customer/deletememberData",
          data:{"id":id},
          dataType:"json",
          type:"post",
          success: function(res){
            obj.remove();
          }
        })
      }
    });
    $("body").on("click","#editcancel",function(){
       $("#view_modal").modal("toggle");
    });
$.uploadPreview({
    input_field: "#image-upload",   // Default: .image-upload
    preview_box: "#image-preview",  // Default: .image-preview
    label_field: "#image-label",    // Default: .image-label
    label_default: "Choose File",   // Default: Choose File
    label_selected: "Change File",  // Default: Change File
    no_label: false                 // Default: false
  });
  });

</script>

