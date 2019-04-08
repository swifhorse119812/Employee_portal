<?php
	$this->load->view('common/header.php');
?>
        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Site Settings</h3>
              </div>
            </div>
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <!-- <h2>Payment Getway</h2> -->
                    <div class="clearfix"></div>
                  </div>

                  <div class="x_content">

                    <div class="table-responsive" style="    height: 500px;">
                      <?php 
                          $getway = $this->common_model->readData("paymentgetway",array("id"=>1));
                      ?>
                   <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" action="<?php echo base_url(); ?>admini/payment/updateGetway" method="post" enctype="multipart/form-data">

                         
                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Stripe Publish Key
                          </label>
                          <div class="col-md-7 col-sm-7 col-xs-12">
                            <input type="text" id="stripe_publish_key" name="stripe_publish_key" required="required"  class="form-control col-md-7 col-xs-12" value="<?php echo $getway['stripe_publish_key']; ?>">
                          </div>
                        </div> 
                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Stripe Secret Key
                          </label>
                          <div class="col-md-7 col-sm-7 col-xs-12">
                            <input type="text" id="stripe_secret_key" name="stripe_secret_key" required="required"  class="form-control col-md-7 col-xs-12" value="<?php echo $getway['stripe_secret_key']; ?>">
                          </div>
                        </div> 
                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Checout fee($)
                          </label>
                          <div class="col-md-7 col-sm-7 col-xs-12">
                            <input type="text" id="checkout_fee" name="checkout_fee" required="required"  class="form-control col-md-7 col-xs-12" value="<?php echo $getway['checkout_fee']; ?>">
                          </div>
                        </div> 

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Transaction Fee(%)
                          </label>
                          <div class="col-md-7 col-sm-7 col-xs-12">
                            <input type="text" id="transaction_fee" name="transaction_fee" required="required"  class="form-control col-md-7 col-xs-12" value="<?php echo $getway['transaction_fee']; ?>">
                          </div>
                        </div> 

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Service fee per month($)
                          </label>
                          <div class="col-md-7 col-sm-7 col-xs-12">
                            <input type="text" id="service_fee" name="service_fee" required="required"  class="form-control col-md-7 col-xs-12" value="<?php echo $getway['service_fee']; ?>">
                          </div>
                        </div> 

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name"> Wire Transfer fee
                          </label>
                          <div class="col-md-7 col-sm-7 col-xs-12">
                            <input type="text" id="wire_fee_fix" name="wire_fee_fix" required="required"  class="form-control" value="<?php echo $getway['wire_fee_fix']; ?>" style="width: 150px; display: inline-block;">($)  + 
                            <input type="text" id="wire_fee_pro" name="wire_fee_pro" required="required"  class="form-control" value="<?php echo $getway['wire_fee_pro']; ?>" style="width: 150px; display: inline-block;">(%)
                          </div>
                        </div> 

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Report download type
                          </label>
                          <div class="col-md-7 col-sm-7 col-xs-12">
                            <label><input type="radio" name="download_type" value="1" <?php if($getway['download_type'] == 1) echo 'checked="";' ?>> Pdf</label>
                            &nbsp;&nbsp;&nbsp;
                            <label><input type="radio" name="download_type" value="2" <?php if($getway['download_type'] == 2) echo 'checked="";' ?>> CSV</label>
                            &nbsp;&nbsp;&nbsp;
                            <label><input type="radio" name="download_type" value="3" <?php if($getway['download_type'] == 3) echo 'checked="";' ?>> Both</label>
                          </div>
                        </div> 
                        

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Suport Email
                          </label>
                          <div class="col-md-7 col-sm-7 col-xs-12">
                            <input type="text" id="support_email" name="support_email" class="form-control col-md-7 col-xs-12" value="<?php echo $getway['support_email']; ?>">
                          </div>
                        </div> 

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Checkout Page header text
                          </label>
                          <div class="col-md-7 col-sm-7 col-xs-12">
                            <input type="text" id="checkout_title" name="checkout_title" class="form-control col-md-7 col-xs-12" value="<?php echo $getway['checkout_title']; ?>">
                          </div>
                        </div> 


                        <div class="form-group">
                          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button type="submit" class="btn btn-success">Save</button>
                          </div>
                        </div>
                  </form>
                    </div>

            
                  </div>
                </div>
              </div>
            </div>
          </div>
       
        </div> 



        <!-- /page content -->
 

<?php
	$this->load->view('common/footer.php');
?>
<script >

    $(document).ready(function() {
    var table = $('#example').DataTable( {
         "dom": "<'row'<'col-sm-8'B><'col-sm-1'l><'col-sm-1'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        buttons: [
            'csv', 'print'
        ],
         

    } );

    $("body").on("change","#category",function(){
            search_key = $(this).find("option:selected").text();
            search_key = search_key.trim();
            if($(this).val() == -1){
                table.columns(1).search("").draw();
            } else {
                
                table.columns(1).search("^"+search_key+"$",true,false).draw();
            }
            
    })



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
    $("body").on("click",".feature-edit",function(){
        id = $(this).data("id");
        $.ajax({
          url: BASE_URL + "admini/feature/getfeatureData",
          data:{"id":id},
          dataType:"json",
          type:"post",
          success: function(res){
            
            $("#view_modal").modal();
            $("#id").val(id);
            $("#name").val(res.data.name);
            $("#category_id option[value='"+res.data.category_id+"']").prop("selected","selected");
             
            if (res.data.allowstatus==1){

              $("#featurestatus").attr("checked","checked");
              $(".icheckbox_flat-green").addClass("checked")
            }
          }
        })
    });

     $("body").on("click",".feature-delete",function(){
        id = $(this).data("id");
        obj = $(this).closest("tr");
        $.ajax({
          url: BASE_URL + "admini/feature/deletefeatureData",
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

