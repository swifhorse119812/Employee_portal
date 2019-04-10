<?php
	$this->load->view('header.php');
?>
<!DOCTYPE html>

    <body>
                  <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <!-- <div class="page-title">
              

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
            <div class="clearfix"></div> -->

            <div class="row">

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                  <div class="col-md-3 col-sm-12 col-xs-12">
                    </div>
                    <div class="col-md-9 col-sm-12 col-xs-12">
                      <h2>Add Customer</h2>
                    </div>
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
                   <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" action="<?php echo base_url(); ?>/account/createrealcustomer" method="post" enctype="multipart/form-data">
                        <div id="step-1">
                          <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="firstname">First Name <span class="required">*</span>
                                </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="firstname" name="firstname" required="required"  class="form-control col-md-7 col-xs-12">
                            </div>
                          </div>
                          <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="lastname">Last Name <span class="required">*</span>
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="itprice" name="lastname" required="lastname"  class="form-control col-md-7 col-xs-12">
                              </div>
                          </div>
                          <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="country">Country <span class="required">*</span>
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
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="city">City <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="city" name="city" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>

                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="address">Address <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="address" name="address" required="required" class="form-control col-md-7 col-xs-12">
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
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="phone_number">Phone Number <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="phone_number" name="phone_number" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                     <br/>
                     <br/>
                    </div>
                        <div id="step-2">
                          <div class="item form-group">
                          <div class="ln_solid"></div>
                            <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                              <button type="submit" class="btn btn-success">Save</button>
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
</body>

        
           


       
        
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
