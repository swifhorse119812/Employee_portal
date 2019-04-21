<?php
	$this->load->view('common/header.php');
?>
       
  
<style type="text/css">
    .fr-view{
        min-height: 150px !important;
    }
     .class1 {
        border-radius: 10%;
        border: 2px solid #efefef;
      }

      .class2 {
        opacity: 0.5;
      }
      #faq_table tbody tr{
        cursor: pointer;
      }
      td{
        height: 25px;
      }
      .sider-menu{
        padding-left: 0px;
      }
      .sider-menu li{
        list-style-type: none;
        line-height: 30px;
        cursor: pointer;
        /*border-bottom: 1px solid #ddd;*/
        padding-top: 20px;
        padding-left: 20px;
        box-shadow: 1px 1px 1px #e0e0e0;
        margin-bottom: 5px;

      }
      ul .li-active{
        background: #e0e0e0;
      }
</style>
 <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Balance Setting </h3>
              </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Input Ballance </h2>
                    <div class="clearfix"></div>
                </div>
                <form id="create_balance" data-parsley-validate class="form-horizontal form-label-left" action="<?php echo site_url("admini/balancesetting/addbalance"); ?>" method="post" enctype="multipart/form-data">

                      <div class="col-md-4">
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Upload Picture<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <div id="image-preview">
                                <label for="image-upload" id="image-label">Choose Image</label>
                                <input type="file" name="photo" id="image-upload" />
                              </div>
                            </div>
                          </div>
                      </div>

                      <div class="col-md-4">
                        <div class="page-title">
                          <div class="title_left">
                            <h3></h3>
                          </div>
                        </div>
                        
                        <?php
                            $balance = get_row("balance",array("id"=>1));
                        ?>
                                
                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name"> Add Balance &nbsp;: &nbsp;$ 
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text"  name="balance" id="balance" required="required" value=""  class="form-control col-md-7 col-xs-12">
                            <!-- <input type="text"  name="balance" id="balance" required="required" value="<?php echo $balance['balance']; ?>"  class="form-control col-md-7 col-xs-12"> -->
                          </div>
                        </div> 
                        <div class="item form-group">
                          <div class="ln_solid"></div>
                            <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button type="submit" class="btn btn-success" >Add Ballance</button>
                            </div>
                            </div>
                          </div>
                        </div>  
                      </div>
                  <div class="col-md-4">
                  </div>
              </form>
              <div class="clearfix"></div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_content">

                    

                    <div class="table-responsive">
                      <table id="example" class="table table-striped jambo_table bulk_action">
                        <thead>
                          <tr class="headings" style="background-color:#24652e">
                            <th class="column-title">No</th>
                            <th class="column-title">Date </th>
                            <th class="column-title">Image </th>
                            <th class="column-title">Add Balance History </th>
                            <!-- <th class="column-title">Already </th>
                            <th class="column-title">Price </th>
                            <th class="column-title">Balance </th> -->
                            <!-- <th class="column-title">Date </th>
                            <th class="column-title">Action </th> -->
                            </th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            // $i=0;
                            // $default_balance = get_rows('balance');
                            // $balance=$default_balance[0]['balance'];
                            // $datas = get_rows('balance_history');
                             $datas = get_rows('add_bal_history');
                            //var_dump($default_balance);exit;
                            foreach ($datas as $key => $data) {
                            //   $balance1=$balance;
                            //   $balance=$balance1-$data['balance'];
                            // $i++;
                         ?>

                          <tr >
                            <td>
                              <?php echo $data['id']?>
                            </td>
                            <td>
                            <?php echo $data['add_date']; ?>
                            </td>
                            <td>
                              <img src="<?php echo base_url()."assets/uploads/".$data['photo']; ?>" width= 50px; height=50px  onmouseover= "this.width=400;this.height=400;" onmouseout="this.width=50;this.height=50" />
                            </td>
                            <td>
                            <?php echo $data['add_bal']; ?>
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
<?php
	$this->load->view('common/footer.php');
?>

<script type="text/javascript" src="<?php echo base_url("assets/client_assets/js/ckeditor.js"); ?>" ></script>
<script type="text/javascript" src="<?php echo base_url("assets/js/bootstrap-select.min.js?v=2.1.1"); ?>"></script>
<script>
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




            