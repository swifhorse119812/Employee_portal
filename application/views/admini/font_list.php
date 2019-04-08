<?php
	$this->load->view('common/header.php');
?>
<style type="text/css">
  #image-preview{
    background-repeat: no-repeat !important;
    background-size: 100% !important;
  }
  <?php 
    foreach ($fonts as $key => $font) {
    ?>
      @font-face {
          font-family: <?php echo $font['title']; ?>;
          src: url(<?php echo base_url("assets/fonts")."/".$font['file_name']; ?>);
      }

  <?php   
    }
  ?>
</style>
        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Font List </h3>
              </div>
            </div>
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Font List </h2>
                    
                    <a href=" <?php echo base_url()?>admini/font/Add  " class="btn btn-round btn-danger navbar-right">
                          <i class="fa fa-plus"></i> Add New Font
                    </a>
                    <div class="clearfix"></div>
                  </div>

                  <div class="x_content">
                     <div class="row">
                      <div class="form-group col-md-3" >
                        <label class="control-label "><span>Category</span>
                        </label>
                        <select id="category" class="form-control">
                            <option value="-1"> All </option>
                           <?php 
                            $categories = $this->common_model->readDatas("category");
                            foreach ($categories as $key => $category) {
                              echo "<option value='".$category['name']."'>".$category['name']."</option>";
                            }
                          ?>
                        </select>
                      </div>
                    </div>

                    <div class="table-responsive">
                      <table id="example" class="table table-striped jambo_table bulk_action">
                        <thead>
                          <tr class="headings" style="background-color:#24652e">
                            <th>
                              No
                            </th>
                            <th class="column-title">Title(English) </th>
                            <th class="column-title">Title(French) </th>
                            <th class="column-title">Status </th>
                            <th class="column-title" style="text-align: right;">Action </th>
                            </th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                         $i=0; 
                          foreach ($fonts as $key => $font) {
                            $i++;
                         ?>

                          <tr style="font-size: 24px; font-family: '<?php echo $font['title']; ?>'">
                            <td style="vertical-align: middle; font-family: '<?php echo $font['title']; ?>'">
                              <?php echo $i?>
                            </td>
                            <td style="vertical-align: middle; font-family: '<?php echo $font['title']; ?>'">
                             <?php echo $font['title']; ?>
                            </td>
                             <td style="vertical-align: middle; font-family: '<?php echo $font['title']; ?>'">
                             <?php echo $font['fr_title']; ?>
                            </td>
                            
                            <td style="vertical-align: middle;">
                                <?php if($font['status']==1) {?> <h5 style="display: none">1</h5><input type="checkbox" class="js-switch" disabled="disabled" checked="checked"  />  
                                <?php }  else 
                                    
                                   {?> <input type="checkbox" class="js-switch" disabled="disabled"  /> 
                                <?php }?>
                             
                            </td>
                            
                            <td  style="vertical-align: middle; text-align: right;">
                            
                              <a data-id=" <?php echo $font["id"]?> " class="btn btn-round btn-default font-edit">
                                      <i class="fa fa-edit blue"></i> Edit
                                     </a>
                              <a data-id="<?php echo $font["id"]?>" class="btn btn-round btn-default font-delete">
                              <i class="fa fa-remove red"></i> delete
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
            <h3 class="modal-title">Edit font</h3>
        </div>
        <div class="modal-body" style="padding: 10px 0px;">


         <!--  <img id="fontimage" src=""/> -->
              <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" action="<?php echo base_url(); ?>admini/font/updatefont" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" id="id">
                         <div id="step-1">
                          <div class="form-group" style="margin-top: 30px;">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="firstname">Title <span class="required">*</span>
                                </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="title" name="title" required="required"  class="form-control col-md-7 col-xs-12">
                            </div>
                          </div>

                          <div class="form-group" style="margin-top: 30px;">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="firstname">Title <span class="required">*</span>
                                </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="fr_title" name="fr_title" required="required"  class="form-control col-md-7 col-xs-12">
                            </div>
                          </div>

                      
                      <div class="form-group" style="margin-top: 30px;">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Uplod file<span class="required">*</span>
                        </label>

                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="file" name="file_name" id="file_name" class="form-control col-md-7 col-xs-12"/>
                        </div>

                      </div>
                     <br/>
                     <br/>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Status</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12" style="padding: 7px;">
                            <label id="status1">
                              <input type="checkbox" id="featurestatus1"  name="status" class="js-switch" checked="checked" /> Active
                            </label>

                            <label id="status2">
                              <input type="checkbox" id="featurestatus2"  name="status" class="js-switch"  /> Active
                            </label>
                        </div>
                      </div>
                    </div>
                        
                      <div class="item form-group">
                       <div class="ln_solid"></div>
                         <div class="form-group">
                         <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button class="btn btn-primary" id="editcancel" type="button">Cancel</button>
                          <button class="btn btn-warning" type="reset">Reset</button>
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
    var table = $('#example').DataTable( {
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

    $("body").on("change","#category",function(){

            search_key = $(this).find("option:selected").text();
            search_key = search_key.trim();

            if($(this).val() == -1){
                table.columns(2).search("").draw();
            } else {
                
                table.columns(2).search("^"+search_key+"$",true,false).draw();
            }
            
   })

} );
   

  $(document).ready(function(){
    $('#image-upload').change(function(){
      $('#flg_change').val('1');
    });

    $("body").on("click",".font-edit",function(){
        id = $(this).data("id");
        $.ajax({
          url: BASE_URL + "admini/font/getfontData",
          data:{"id":id},
          dataType:"json",
          type:"post",
          success: function(res){
            $("#view_modal").modal();
            $("#id").val(id);
            $("#title").val(res.data.title);
            $("#fr_title").val(res.data.fr_title);
            // $("#image-upload").val(res.data.file_name);

            if(res.data.status == 1) {
              $("#status1").show();
              $("#status2").hide();
            } else {
              $("#status1").hide();
              $("#status2").show();
            }
          }
        })
    });

     $("body").on("click",".font-delete",function(){
        id = $(this).data("id");
        obj = $(this).closest("tr");
        $.ajax({
          url: BASE_URL + "admini/font/deletefontData",
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

