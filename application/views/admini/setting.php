<?php
	$this->load->view('common/header.php');
?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();  ?>assets/css/color-picker.min.css">    
    
                  <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
               
              </div>
            </div>
            <div class="clearfix"></div>

            <div class="row">

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Site Setting</h2>
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
                  <style type="text/css">
                    .static{
                      top: 34px !important;
                      left: 91px !important;  
                    }

                    <?php 
                    $fonts = $this->common_model->readDatas("font");
                    foreach ($fonts as $key => $font) {
                      if($font['id'] == $setting['font_id']) $font_str = $font['title'];
                    ?>
                      @font-face {
                          font-family: <?php echo $font['title']; ?>;
                          src: url(<?php echo base_url("assets/fonts")."/".$font['file_name']; ?>);
                      }

                  <?php   
                    }
                  ?>

                  </style>
                   <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" action="<?php echo base_url(); ?>admini/setting/add" method="post" enctype="multipart/form-data">
                        <div id="step-1">
                          <div class="form-group first-color" style="margin-top: 30px;">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="firstname">Gradient First Color<span class="required">*</span>
                                </label>
                            <div class="col-md-6 col-sm-6 col-xs-12 first-color">
                                <input type="text" id="first_color" name="first_color" required="required"  class="form-control col-md-3 col-xs-3" style="width: 200px;" value="<?php echo $setting['first_color']; ?>">
                                <span  id="first_color_show" style="display: inline-block; width: 34px; height: 34px; border: 1px solid;"></span>
                                
                            </div>
                          </div>
                          <div class="form-group last-color" style="margin-top: 145px;">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="firstname">Gradient Last Color<span class="required">*</span>
                                </label>
                            <div class="col-md-6 col-sm-6 col-xs-12 last-color">
                                <input type="text" id="last_color" name="last_color" required="required"  class="form-control col-md-3 col-xs-3" style="width: 200px;">
                                <span  id="last_color_show" style="display: inline-block; width: 34px; height: 34px; border: 1px solid;"></span>
                                
                            </div>
                          </div>

                          <div class="form-group" style="margin-top: 145px;">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="firstname">Default Font<span class="required">*</span>
                                </label>
                            <div class="col-md-6 col-sm-6 col-xs-12 last-color">
                                <select name = "font_id" id="font_id" class="form-control" style="width: 240px; font-family: <?php echo $font_str; ?>; font-size: 24px; height: 50px;" >
                                  <?php 
                                    $fonts = $this->common_model->readDatas("font",array(),"title");
                                    foreach ($fonts as $key => $font) {
                                      $str = "";
                                      if($font['id'] == $setting['font_id']) $str = "selected";
                                      echo "<option style='font-size:24px; font-family:{$font['title']}' value={$font['id']} {$str}>{$font['title']}</option>";
                                    }
                                  ?>

                                </select>
                            </div>
                          </div>
                        
                           <div class="form-group last-color" style="margin-top: 30px;">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="firstname">Subtitle<span class="required">*</span>
                                </label>
                            <div class="col-md-6 col-sm-6 col-xs-12 last-color">
                                <input type="text" id="subtitle" name="subtitle" required="required"  class="form-control col-md-3 col-xs-3" style="width: 240px;" value="<?php echo $setting['subtitle']; ?>">
                                
                            </div>
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
        <!-- /page content -->
    
        <!-- /page content -->


<?php
	$this->load->view('common/footer.php');
?>
<script type="text/javascript" src="<?php echo base_url();  ?>assets/js/color-picker.min.js"></script>
 
<script type="text/javascript">
$(document).ready(function() {

  $(".stepContainer").css("height","0px")
    var container1 = document.querySelector('#first_color_show'),
    picker1 = new CP(container1, false, container1);
    picker1.self.classList.add('static');
    picker1.set("<?php echo $setting['first_color']; ?>");
    picker1.enter();
    picker1.on("change", function(color) {
        $("#first_color").val("#" + color);
        $("#first_color_show").css("background-color","#" + color);
    });

    var container2 = document.querySelector('#last_color_show'),
    picker2 = new CP(container2, false, container2);
    picker2.self.classList.add('static');
    picker2.set("<?php echo $setting['last_color']; ?>");
    picker2.enter();
    picker2.on("change", function(color) {
        $("#last_color").val("#" + color);
        $("#last_color_show").css("background-color","#" + color);
    });

    // $("#first_color_show").click(function(){
    //     picker1.enter();
    // })
    $("#font_id").change(function(){
      $(this).css("font-family",$("option:selected").text());
    })

 
});
</script>
