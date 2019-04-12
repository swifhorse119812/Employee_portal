<?php
	$this->load->view('common/header.php');
?>
        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Balance Report </h3>
              </div>
            </div>
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <!-- <h2>Balance Report </h2> -->
                    <h2>&nbsp;&nbsp;&nbsp;Default Balance : $<?php echo $default_balance[0]['balance']?></h2>
                    <h2>&nbsp;&nbsp;&nbsp;Remaining Balance : $<?php
                      $remain_bal =  $default_balance[0]['balance'];
                      foreach ($datas as $key => $data) {
                        $remain_bal -= $data['balance']; 
                      }
                      echo $remain_bal;
                    ?> </h2>
                    
                  <div class="clearfix"></div>
                </div>

                  <div class="x_content">

                    

                    <div class="table-responsive">
                      <table id="example" class="table table-striped jambo_table bulk_action">
                        <thead>
                          <tr class="headings" style="background-color:#24652e">
                            <th class="column-title">No</th>
                            <th class="column-title">Date </th>
                            <th class="column-title">Customer </th>
                            <th class="column-title">Price </th>
                            <th class="column-title">Balance </th>
                            <!-- <th class="column-title">Date </th>
                            <th class="column-title">Action </th> -->
                            </th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $i=0;
                            $balance=$default_balance[0]['balance'];
                            //var_dump($default_balance);exit;
                            foreach ($datas as $key => $data) {
                              $balance=$balance-$data['balance'];
                            $i++;
                         ?>

                          <tr >
                            <td>
                              <?php echo $i?>
                            </td>
                            <td>
                            <?php echo $data['bal_date']; ?>
                            </td>
                            <td>
                            <?php echo $data['customer']; ?>
                            </td>
                            <td>$
                            <?php echo $data['balance']; ?>
                            </td>
                            <td>$
                             <?php echo $balance; ?>
                            </td>
                            
                            <!-- <td>
                              <img src="<?php echo base_url()."assets/uploads/".$user['photo']; ?>" style="width: 50px; height:50px  "/>
                             
                            </td>
                            <td>
                                <?php 
                                  if($user['roll'] == 1) echo "Super Admin";
                                  else if($user['roll'] == 2) echo "Admin";
                                  else echo "Inactive";
                                ?>
                            </td>
                            <td>
                              <?php echo $user['date']; ?>
                            </td>
                            <td >
                            
                              <a data-id=" <?php echo $user["id"]?> " class="btn btn-round btn-default user-edit">
                                      <i class="fa fa-edit blue"></i> Edit
                                     </a>
                              <a data-id="<?php echo $user["id"]?>" class="btn btn-round btn-default user-delete">
                      <i class="fa fa-remove red"></i> delete
                    </a>
                            </td> -->
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
            <h3 class="modal-title">Edit user</h3>
        </div>
        <div class="modal-body" style="padding: 10px 0px;">


         <!--  <img id="userimage" src=""/> -->
              <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" action="<?php echo base_url(); ?>admini/user/updateuser" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id" id="id">
                        <div id="step-1">
                          <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="firstname">Firstname <span class="required">*</span>
                                </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="firstname" name="firstname" required="required"  class="form-control col-md-7 col-xs-12">
                            </div>
                          </div>
                          <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="lastname">Last Name <span class="required">*</span>
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="lastname" name="lastname" required="required"  class="form-control col-md-7 col-xs-12">
                              </div>
                          </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="gender">I am <span class="required">*</span>
                            </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select  id="gender" name="gender" required="required"  class="select2_single form-control col-md-7 col-xs-12">
                            <option value="1">Male</option>
                            <option value="0">Female</option>
                          </select>

                          </div>
                        </div>
                         

                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="email" id="email" name="email" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Upload file<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <div id="image-preview">
                            <label for="image-upload" id="image-label">Choose File</label>
                            <input type="file" name="photo" id="image-upload" />
                          </div>
                        </div>

                      </div>
                     <br/>
                     <br/>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Status</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <label>
                              <select class="select2_single form-control col-md-7 col-xs-12" name="roll" id="roll">
                                <option value="0">Inactive</option>
                                <!-- <option value="1">Super Admin</option> -->
                                <option value="2">Admin</option>
                              </select>
                            </label>
                        </div>
                      </div>
                        
                      <div class="item form-group">
                         <div class="form-group">
                         <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button class="btn btn-primary" id="editcancel" type="button">Cancel</button>
                          <button class="btn btn-warning" type="reset">Reset</button>
                          <button type="submit" class="btn btn-success">Update</button>
                         </div>
                         </div>
                       </div>
                  </form>
                  <div class="ln_solid"></div>
                  <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" action="<?php echo base_url(); ?>admini/user/update_password" method="post" enctype="multipart/form-data">
                          <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="old_password">Old Password <span class="required">*</span>
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="password" id="old_password" name="old_password" required="required"  class="form-control col-md-7 col-xs-12">
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="new_password">New Password <span class="required">*</span>
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="password" id="new_password" name="new_password" required="required"  class="form-control col-md-7 col-xs-12">
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="repeat_new_password">Repeat New Password <span class="required">*</span>
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="password" id="repeat_new_password" name="repeat_new_password" required="required"  class="form-control col-md-7 col-xs-12">
                              </div>
                          </div>
                          <div class="item form-group">
                            <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
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
    $('#image-upload').change(function(){
      $('#flg_change').val('1');
    });
    $("body").on("click",".user-edit",function(){
        id = $(this).data("id");
        $.ajax({
          url: BASE_URL + "admini/user/getuserData",
          data:{"id":id},
          dataType:"json",
          type:"post",
          success: function(res){
            $("#view_modal").modal();
            $("#id").val(id);
            $("#firstname").val(res.data.firstname);
            $("#lastname").val(res.data.lastname);
            $("#birthday").val(res.data.birthday);
            $("#email").val(res.data.email);
            $("#image-preview").css("background","url('"+BASE_URL+"assets/uploads/"+res.data.photo+"')");
            $("#image-upload").val(res.data.photo);
            $("option[value='"+res.data.roll+"']").prop("selected","selected");
            $("#oldpassword").val(res.data.firstname);
            $("#newpassord").val(res.data.firstname);
            $("#confirmnewpwd").val(res.data.firstname);
            
          }
        })
    });

     $("body").on("click",".user-delete",function(){
        id = $(this).data("id");
        obj = $(this).closest("tr");
        $.ajax({
          url: BASE_URL + "admini/user/deleteuserData",
          data:{"id":id},
          dataType:"json",
          type:"post",
          success: function(res){
            obj.remove();
          }
        })
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

