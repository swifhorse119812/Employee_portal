<?php
	$this->load->view('common/header.php');
?>
    
                  <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Email Templates</h3>
              </div>
            </div>
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>To customer when pay on Virsympay</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                     <div class="row" style="padding: 0px 15px;">
                      <form method="post" action="<?php echo base_url("admini/setting/update_template"); ?>">
                        <input type="hidden" name="id" value="1">
                        <div class="col-md-12">
                          <?php 
                            $template = get_row("email_template",array("id"=>1));
                            if(!$template){
                              $template = array("subject"=>"","body"=>"");
                            }
                          ?>
                           <div class="form-group" style="margin-bottom: 20px; height: 50px;">
                                <label class="control-label" for="firstname">Subject <span class="required">*</span>
                                </label>
                                <input type="text" name="subject" required="required" class="form-control col-md-12 col-xs-12" value="<?php echo $template['subject']; ?>">
                            </div>
                            <div class="form-group" style="margin-bottom: 20px; height: 220px;">
                                <label class="control-label" for="firstname">Body <span class="required">*</span>
                                </label>
                                <textarea name="body" required="required" class="form-control col-md-12 col-xs-12" style="height: 200px;"><?php echo $template['body']; ?></textarea>
                            </div>
                            <div style="text-align: right;">
                              <button class="btn btn-info"> Save </button>
                            </div>
                          </div>
                      </form>
                     </div>
                  </div>
                </div>
              </div>

              <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>To merchant when pay on Virsympay</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                     <div class="row" style="padding: 0px 15px;">
                      <form method="post" action="<?php echo base_url("admini/setting/update_template"); ?>">
                        <input type="hidden" name="id" value="2">
                        <div class="col-md-12">
                          <?php 
                            $template = get_row("email_template",array("id"=>2));
                            if(!$template){
                              $template = array("subject"=>"","body"=>"");
                            }
                          ?>
                           <div class="form-group" style="margin-bottom: 20px; height: 50px;">
                                <label class="control-label" for="firstname">Subject <span class="required">*</span>
                                </label>
                                <input type="text" name="subject" required="required" class="form-control col-md-12 col-xs-12" value="<?php echo $template['subject']; ?>">
                            </div>
                            <div class="form-group" style="margin-bottom: 20px; height: 220px;">
                                <label class="control-label" for="firstname">Body <span class="required">*</span>
                                </label>
                                <textarea name="body" required="required" class="form-control col-md-12 col-xs-12" style="height: 200px;"><?php echo $template['body']; ?></textarea>
                            </div>
                            <div style="text-align: right;">
                              <button class="btn btn-info"> Save </button>
                            </div>
                          </div>
                      </form>
                     </div>
                  </div>
                </div>
              </div>

              <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>To admin when pay on Virsympay</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                     <div class="row" style="padding: 0px 15px;">
                      <form method="post" action="<?php echo base_url("admini/setting/update_template"); ?>">
                        <input type="hidden" name="id" value="3">
                        <div class="col-md-12">
                          <?php 
                            $template = get_row("email_template",array("id"=>3));
                            if(!$template){
                              $template = array("subject"=>"","body"=>"");
                            }
                          ?>
                           <div class="form-group" style="margin-bottom: 20px; height: 50px;">
                                <label class="control-label" for="firstname">Subject <span class="required">*</span>
                                </label>
                                <input type="text" name="subject" required="required" class="form-control col-md-12 col-xs-12" value="<?php echo $template['subject']; ?>">
                            </div>
                            <div class="form-group" style="margin-bottom: 20px; height: 220px;">
                                <label class="control-label" for="firstname">Body <span class="required">*</span>
                                </label>
                                <textarea name="body" required="required" class="form-control col-md-12 col-xs-12" style="height: 200px;"><?php echo $template['body']; ?></textarea>
                            </div>
                            <div style="text-align: right;">
                              <button class="btn btn-info"> Save </button>
                            </div>
                          </div>
                      </form>
                     </div>
                  </div>
                </div>
              </div>

             <!--  <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>To merchant when request withdraw on Virsympay</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                     <div class="row" style="padding: 0px 15px;">
                      <form method="post" action="<?php echo base_url("admini/setting/update_template"); ?>">
                        <input type="hidden" name="id" value="4">
                        <div class="col-md-12">
                          <?php 
                            $template = get_row("email_template",array("id"=>4));
                            if(!$template){
                              $template = array("subject"=>"","body"=>"");
                            }
                          ?>
                           <div class="form-group" style="margin-bottom: 20px; height: 50px;">
                                <label class="control-label" for="firstname">Subject <span class="required">*</span>
                                </label>
                                <input type="text" name="subject" required="required" class="form-control col-md-12 col-xs-12" value="<?php echo $template['subject']; ?>">
                            </div>
                            <div class="form-group" style="margin-bottom: 20px; height: 220px;">
                                <label class="control-label" for="firstname">Body <span class="required">*</span>
                                </label>
                                <textarea name="body" required="required" class="form-control col-md-12 col-xs-12" style="height: 200px;"><?php echo $template['body']; ?></textarea>
                            </div>
                            <div style="text-align: right;">
                              <button class="btn btn-info"> Save </button>
                            </div>
                          </div>
                      </form>
                     </div>
                  </div>
                </div>
              </div> -->

              <!-- <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>To admin when request withdraw on Virsympay</h2>

                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                     <div class="row" style="padding: 0px 15px;">
                      <form method="post" action="<?php echo base_url("admini/setting/update_template"); ?>">
                        <input type="hidden" name="id" value="5">
                        <div class="col-md-12">
                          <?php 
                            $template = get_row("email_template",array("id"=>5));
                            if(!$template){
                              $template = array("subject"=>"","body"=>"");
                            }
                          ?>
                           <div class="form-group" style="margin-bottom: 20px; height: 50px;">
                                <label class="control-label" for="firstname">Subject <span class="required">*</span>
                                </label>
                                <input type="text" name="subject" required="required" class="form-control col-md-12 col-xs-12" value="<?php echo $template['subject']; ?>">
                            </div>
                            <div class="form-group" style="margin-bottom: 20px; height: 220px;">
                                <label class="control-label" for="firstname">Body <span class="required">*</span>
                                </label>
                                <textarea name="body" required="required" class="form-control col-md-12 col-xs-12" style="height: 200px;"><?php echo $template['body']; ?></textarea>
                            </div>
                            <div style="text-align: right;">
                              <button class="btn btn-info"> Save </button>
                            </div>
                          </div>
                      </form>
                     </div>
                  </div>
                </div>
              </div> -->

              <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>To merchant when complete withdraw on Virsympay</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                     <div class="row" style="padding: 0px 15px;">
                      <form method="post" action="<?php echo base_url("admini/setting/update_template"); ?>">
                        <input type="hidden" name="id" value="6">
                        <div class="col-md-12">
                          <?php 
                            $template = get_row("email_template",array("id"=>6));
                            if(!$template){
                              $template = array("subject"=>"","body"=>"");
                            }
                          ?>
                           <div class="form-group" style="margin-bottom: 20px; height: 50px;">
                                <label class="control-label" for="firstname">Subject <span class="required">*</span>
                                </label>
                                <input type="text" name="subject" required="required" class="form-control col-md-12 col-xs-12" value="<?php echo $template['subject']; ?>">
                            </div>
                            <div class="form-group" style="margin-bottom: 20px; height: 220px;">
                                <label class="control-label" for="firstname">Body <span class="required">*</span>
                                </label>
                                <textarea name="body" required="required" class="form-control col-md-12 col-xs-12" style="height: 200px;"><?php echo $template['body']; ?></textarea>
                            </div>
                            <div style="text-align: right;">
                              <button class="btn btn-info"> Save </button>
                            </div>
                          </div>
                      </form>
                     </div>
                  </div>
                </div>
              </div>

              <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>To merchant when cancel withdraw on Virsympay</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                     <div class="row" style="padding: 0px 15px;">
                      <form method="post" action="<?php echo base_url("admini/setting/update_template"); ?>">
                        <input type="hidden" name="id" value="7">
                        <div class="col-md-12">
                          <?php 
                            $template = get_row("email_template",array("id"=>7));
                            if(!$template){
                              $template = array("subject"=>"","body"=>"");
                            }
                          ?>
                           <div class="form-group" style="margin-bottom: 20px; height: 50px;">
                                <label class="control-label" for="firstname">Subject <span class="required">*</span>
                                </label>
                                <input type="text" name="subject" required="required" class="form-control col-md-12 col-xs-12" value="<?php echo $template['subject']; ?>">
                            </div>
                            <div class="form-group" style="margin-bottom: 20px; height: 220px;">
                                <label class="control-label" for="firstname">Body <span class="required">*</span>
                                </label>
                                <textarea name="body" required="required" class="form-control col-md-12 col-xs-12" style="height: 200px;"><?php echo $template['body']; ?></textarea>
                            </div>
                            <div style="text-align: right;">
                              <button class="btn btn-info"> Save </button>
                            </div>
                          </div>
                      </form>
                     </div>
                  </div>
                </div>
              </div>

            <!--   <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>To merchant when pay servie fee per month on Virsympay</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                     <div class="row" style="padding: 0px 15px;">
                      <form method="post" action="<?php echo base_url("admini/setting/update_template"); ?>">
                        <input type="hidden" name="id" value="8">
                        <div class="col-md-12">
                          <?php 
                            $template = get_row("email_template",array("id"=>8));
                            if(!$template){
                              $template = array("subject"=>"","body"=>"");
                            }
                          ?>
                           <div class="form-group" style="margin-bottom: 20px; height: 50px;">
                                <label class="control-label" for="firstname">Subject <span class="required">*</span>
                                </label>
                                <input type="text" name="subject" required="required" class="form-control col-md-12 col-xs-12" value="<?php echo $template['subject']; ?>">
                            </div>
                            <div class="form-group" style="margin-bottom: 20px; height: 220px;">
                                <label class="control-label" for="firstname">Body <span class="required">*</span>
                                </label>
                                <textarea name="body" required="required" class="form-control col-md-12 col-xs-12" style="height: 200px;"><?php echo $template['body']; ?></textarea>
                            </div>
                            <div style="text-align: right;">
                              <button class="btn btn-info"> Save </button>
                            </div>
                          </div>
                      </form>
                     </div>
                  </div>
                </div>
              </div>-->

              <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>To admin when merchants asked question on Virsympay</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                     <div class="row" style="padding: 0px 15px;">
                      <form method="post" action="<?php echo base_url("admini/setting/update_template"); ?>">
                        <input type="hidden" name="id" value="9">
                        <div class="col-md-12">
                          <?php 
                            $template = get_row("email_template",array("id"=>9));
                            if(!$template){
                              $template = array("subject"=>"","body"=>"");
                            }
                          ?>
                           <div class="form-group" style="margin-bottom: 20px; height: 50px;">
                                <label class="control-label" for="firstname">Subject <span class="required">*</span>
                                </label>
                                <input type="text" name="subject" required="required" class="form-control col-md-12 col-xs-12" value="<?php echo $template['subject']; ?>">
                            </div>
                            <div class="form-group" style="margin-bottom: 20px; height: 220px;">
                                <label class="control-label" for="firstname">Body <span class="required">*</span>
                                </label>
                                <textarea name="body" required="required" class="form-control col-md-12 col-xs-12" style="height: 200px;"><?php echo $template['body']; ?></textarea>
                            </div>
                            <div style="text-align: right;">
                              <button class="btn btn-info"> Save </button>
                            </div>
                          </div>
                      </form>
                     </div>
                  </div>
                </div>
              </div>

              <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>To merchant when refund to csutomer on Virsympay</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                     <div class="row" style="padding: 0px 15px;">
                      <form method="post" action="<?php echo base_url("admini/setting/update_template"); ?>">
                        <input type="hidden" name="id" value="10">
                        <div class="col-md-12">
                          <?php 
                            $template = get_row("email_template",array("id"=>10));
                            if(!$template){
                              $template = array("subject"=>"","body"=>"");
                            }
                          ?>
                           <div class="form-group" style="margin-bottom: 20px; height: 50px;">
                                <label class="control-label" for="firstname">Subject <span class="required">*</span>
                                </label>
                                <input type="text" name="subject" required="required" class="form-control col-md-12 col-xs-12" value="<?php echo $template['subject']; ?>">
                            </div>
                            <div class="form-group" style="margin-bottom: 20px; height: 220px;">
                                <label class="control-label" for="firstname">Body <span class="required">*</span>
                                </label>
                                <textarea name="body" required="required" class="form-control col-md-12 col-xs-12" style="height: 200px;"><?php echo $template['body']; ?></textarea>
                            </div>
                            <div style="text-align: right;">
                              <button class="btn btn-info"> Save </button>
                            </div>
                          </div>
                      </form>
                     </div>
                  </div>
                </div>
              </div>

              <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>To merchant when signup  on Virsympay</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                     <div class="row" style="padding: 0px 15px;">
                      <form method="post" action="<?php echo base_url("admini/setting/update_template"); ?>">
                        <input type="hidden" name="id" value="11">
                        <div class="col-md-12">
                          <?php 
                            $template = get_row("email_template",array("id"=>11));
                            if(!$template){
                              $template = array("subject"=>"","body"=>"");
                            }
                          ?>
                           <div class="form-group" style="margin-bottom: 20px; height: 50px;">
                                <label class="control-label" for="firstname">Subject <span class="required">*</span>
                                </label>
                                <input type="text" name="subject" required="required" class="form-control col-md-12 col-xs-12" value="<?php echo $template['subject']; ?>">
                            </div>
                            <div class="form-group" style="margin-bottom: 20px; height: 220px;">
                                <label class="control-label" for="firstname">Body <span class="required">*</span>
                                </label>
                                <textarea name="body" required="required" class="form-control col-md-12 col-xs-12" style="height: 200px;"><?php echo $template['body']; ?></textarea>
                            </div>
                            <div style="text-align: right;">
                              <button class="btn btn-info"> Save </button>
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


<?php
	$this->load->view('common/footer.php');
?>
 
<script type="text/javascript">
$(document).ready(function() {
 
});
</script>
