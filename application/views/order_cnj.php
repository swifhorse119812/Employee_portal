<?php
	$this->load->view('header.php');
?>
<!DOCTYPE html>

    <body>
                  <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              

              <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search for...">
                    <span class="input-group-btn">
                              <button class="btn btn-default" type="button">Go!</button>
                          </span>
                  </div>
                </div>
              </div>
            </div>
            <div class="clearfix"></div>

            <div class="row">

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Create Order</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <!-- <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="#">Settings 1</a>
                          </li>
                          <li><a href="#">Settings 2</a>
                          </li>
                        </ul>
                      </li> -->
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">


                    <!-- Smart Wizard -->
                    <div id="" class="">

                   <!-- <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" action="<?php echo base_url(); ?>admini/customer/createmember" method="post" enctype="multipart/form-data"> -->
                   <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" action="<?php echo base_url(); ?>account/createorder" method="post" enctype="multipart/form-data">
                        <div id="step-1">
                          <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Item Number <span class="required">*</span></label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="itnumber" name="itnumber" required="required"  class="form-control col-md-7 col-xs-12">
                            </div>
                          </div>
                          <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Item Name <span class="required">*</span></label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="itname" name="itname" required="required"  class="form-control col-md-7 col-xs-12">
                            </div>
                          </div>
                          <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Item Price <span class="required">*</span></label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="itprice" name="itprice" required="required"  class="form-control col-md-7 col-xs-12">
                              </div>
                          </div>
                          <div class="item form-group">
                            <label for="password" class="control-label col-md-3" for="name">Item Size</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" id="itsize" name="itsize" required="required" class="form-control col-md-7 col-xs-12" >
                            </div>
                          </div>
                          <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Item Color <span class="required">*</span></label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input id="itcolor" name="itcolor" required="required" class="form-control col-md-7 col-xs-12">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Customer <span class="required">*</span></label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <select  id="itcustom" name="itcustom" required="required"  class="select2_single form-control col-md-7 col-xs-12">
                                <?php
                                //////////////////////////////////////////////////////////////////////////////////////////////////////////////
                                  $customers = get_rows("customers");
                                  foreach ($customers as $key => $customer) {
                                    echo '<option data-id='.$customer['id'].'>'.$customer['first_name'].' '.$customer['last_name'].' '.$customer['phone_number'].' '.$customer['address'].'</option>';
                                    //echo '<td>'.$customer['last_name'].'</td>';
                                    //echo "<tr data-id='".$customer['id']."'>";
                                    //echo '<td>'.$customer['id'].'</td>';
                                    //echo '<td>'.$customer['first_name'].'</td>';
                                    //echo '<td>'.$customer['last_name'].'</td>';
                                    //echo '<td>'.$customer['phone_number'].'</td>';
                                    //echo '<td>'.$customer['address'].'</td>';
                                    //echo "</tr>";
                                }
                                //////////////////////////////////////////////////////////////////////////////////////////////////////////////
                                ?>
                              </select>
                            </div>
                          </div>
                      
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Shipping fee</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="itshippingfee"  name="itshippingfee" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Uplod Image<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <div id="image-preview">
                            <label for="image-upload" id="image-label">Choose Image</label>
                            <input type="file" name="photo" id="image-upload" />
                          </div>
                        </div>

                      </div>
                     <br/>
                     <br/>
                      <!-- <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Status</span>
                          </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <label>
                                  <select class="select2_single form-control col-md-7 col-xs-12" name="roll" id="roll">
                                    <option value="2"></option>  
                                    <option value="1">Customer1</option>
                                    <option value="0">Customer2</option>
                                  </select>
                                </label>
                            </div>
                          </div>
                        </div>
                      <div id="step-2"> -->
                      <div class="item form-group">
                       <div class="ln_solid"></div>
                         <div class="form-group">
                         <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <button type="submit" class="btn btn-success">Complete</button>
                          <button class="btn btn-success">Cancel</button>
                         </div>
                        </div>
                      </div>

                  </form>
                    </div>
                    <!-- End SmartWizard Content -->

                    <!-- Tabs -->
                   
                    <!-- End SmartWizard Content -->
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
<!-- </body> -->
        <!-- /page content -->
    
        <!-- /page content -->
<?php
	$this->load->view('common/footer.php');
?>
 
<script type="text/javascript">
$(document).ready(function() {
  $(".stepContainer").css("height","0px")
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
