<?php
  $this->load->view("common/header.php");
?>
  <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Profile <small>admin</small></h3>
              </div>

             <!--  <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search for...">
                    <span class="input-group-btn">
                      <button class="btn btn-default" type="button">Go!</button>
                    </span>
                  </div>
                </div>
              </div> -->
            </div>

            <div class="clearfix"></div>

            <div class="row">

      <div class="col-md-12 col-sm-12 col-xs-12" style="min-height: 800px">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>My Profile</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                   <form   name="form1" class="form-horizontal form-label-left" action="<?php echo base_url(); ?>admini/user/updateProfile" method="post" enctype="multipart/form-data">
                        
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
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Uplod file<span class="required">*</span>
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
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Status 
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <label>
                              <select class="select2_single form-control col-md-7 col-xs-12" name="roll" id="roll">
                                <option value="0">Inactive</option>
                                <option value="1">Super Admin</option>
                                <option value="2">Admin</option>
                              </select>
                            </label>
                        </div>
                      </div>
                        
                      <div class="item form-group">
                         <div class="form-group">
                         <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <button type="submit" class="btn btn-success">Save</button>
                         </div>
                         </div>
                       </div>
                  </form>

                </div>
                  <div class="x_title">
                     <h2>
                    Password Setting
                  </h2>
                     
                    <div class="clearfix"></div>
                  </div>
                 
                  <form id="demo-form"  name="form1" class="form-horizontal form-label-left" action="<?php echo base_url(); ?>admini/user/updateAccount" method="post" enctype="multipart/form-data">
                          <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="firstname">Old Passward <span class="required">*</span>
                                </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="password" id="old_password" name="old_password" required="required"  class="form-control col-md-7 col-xs-12">
                            </div>
                          </div>
                          <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="firstname">New Passward <span class="required">*</span>
                                </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="password" id="new_password" name="new_password" required="required"  class="form-control col-md-7 col-xs-12">
                            </div>
                          </div>
                          <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="firstname">Cinfirm Passward <span class="required">*</span>
                                </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="password" id="con_password" name="con_password" required="required"  class="form-control col-md-7 col-xs-12">
                            </div>
                          </div>
                      <div class="row" style="text-align: center; color: red;">
                        <?php 
                           echo $error;
                        ?>
                      </div>
                      <div class="item form-group">
                         <div class="form-group">
                         <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <button type="submit" class="btn btn-success">Save</button>
                         </div>
                         </div>
                       </div>
                  </form>
                </div>
          </div>
      </div>
  
<script type="text/javascript">
  $(function(){
      id = '<?php echo $user['id']; ?>';
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
            
          }
        })

  })
</script>
<?php
  $this->load->view("common/footer.php");
?>

 