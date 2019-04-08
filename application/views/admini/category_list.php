<?php
	$this->load->view('common/header.php');
?>
        <!-- page content -->
        <div class="right_col" role="main">

          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Category List </h3>
              </div>
             
            </div>

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Category List </h2>
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
                    <a href=" <?php echo base_url()?>admini/category/Add  " class="btn btn-round btn-danger navbar-right">
                                      <i class="fa fa-plus"></i> Add New
                                     </a>
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
                                <th class="column-title">Name(English)</th>
                                <th class="column-title">Name(French)</th>
                              <th class="column-title" style="text-align: center;">Status </th>
                              <th class="column-title" style="text-align: right;">Action </th>
                           
                            </th>
                            
                          </tr>
                        </thead>
                        <tbody>
                         
                          <?php
                         $i=0; 
                          foreach ($categories as $key => $category) {
                            $i++;
                         ?>

                          <tr >
                            <td>
                              <?php echo $i?>
                            </td>
                            <td>
                            <?php echo $category['name']; ?>
                            </td>
                            <td>
                            <?php echo $category['fr_name']; ?>
                            </td>
                            
                            <td style="text-align: center">
                             <?php if($category['status']==1) {?> <h5 style="display: none">1</h5><input type="checkbox" class="js-switch" disabled="disabled" checked="checked"  />  
                                <?php }  else 
                                    
                                   {?> <input type="checkbox" class="js-switch" disabled="disabled"  /> 
                                <?php }?>
                            </td>
                            
                            <td style="text-align: right;">
                              <a data-id="<?php echo $category["id"]?>" class="btn btn-round btn-default category-delete">
                               <i class="fa fa-remove red"></i> Delete
                              </a>
                               <a data-id=" <?php echo $category["id"]?> " class="btn btn-round btn-default category-edit">
                                <i class="fa fa-edit green"></i> Edit
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
            <h3 class="modal-title">Edit feature</h3>
        </div>
        <div class="modal-body" style="padding: 10px 0px;">


         <!--  <img id="featureimage" src=""/> -->
              <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" action="<?php echo base_url(); ?>admini/category/updateCategory" method="post" enctype="multipart/form-data">
                      <input type="hidden" id="id" name="id"/>
                      <div class="form-group" style="margin-top: 50px;">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Name <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="name" name="name" required="required"  class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>      
                       <div class="form-group" style="margin-top: 50px;">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Name <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="fr_name" name="fr_name" required="required"  class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>      

                     
                      <div class="form-group" style="margin-top: 50px;">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Status</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <label id="status1">
                              <input type="checkbox" id="featurestatus1"  name="status" class="js-switch" checked="checked" /> Active
                            </label>

                            <label id="status2">
                              <input type="checkbox" id="featurestatus2"  name="status" class="js-switch"  /> Active
                            </label>

                        </div>
                      </div>
                
                      <div class="ln_solid" style="margin-top: 50px;"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <button class="btn btn-primary" id="editcancel" type="button">Cancel</button>
                          <button class="btn btn-warning" type="reset">Reset</button>
                          <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                      </div>

                    </form>
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
  
    $("body").on("click",".category-edit",function(){
        id = $(this).data("id");
        $.ajax({
          url: BASE_URL + "admini/category/getCategoryData",
          data:{"id":id},
          dataType:"json",
          type:"post",
          success: function(res){
            $("#view_modal").modal();
            $("#id").val(id);
            $("#name").val(res.data.name);
            $("#fr_name").val(res.data.fr_name);
            if (res.data.status == 1){
              $("#status1").show();
              $("#status2").hide();
            } else {
              $("#status2").show();
              $("#status1").hide();
            }
          }

        })
    });

     $("body").on("click",".category-delete",function(){
        id = $(this).data("id");
        obj = $(this).closest("tr");
        $.ajax({
          url: BASE_URL + "admini/category/deleteCategory",
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

