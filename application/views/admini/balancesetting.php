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

<?php
	$this->load->view('common/footer.php');
?>
  <form id="create_balance" data-parsley-validate class="form-horizontal form-label-left" action="<?php echo site_url("admini/balancesetting/addbalance"); ?>" method="post" enctype="multipart/form-data">
        <div class="col-md-4">
        </div>
        <div class="col-md-4">
          <div class="page-title">
            <div class="title_left">
              <h3></h3>
            </div>
          </div>
          <div class="page-title">
            <div class="title_left">Input Balance
              <h3></h3>
            </div>
          </div>
          <?php
              $balance = get_row("balance",array("id"=>1));
          ?>
                  
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Balance 
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text"  name="balance" id="balance" required="required" value="<?php echo $balance['balance']; ?>"  class="form-control col-md-7 col-xs-12">
            </div>
          </div> 
          <div class="item form-group">
            <div class="ln_solid"></div>
              <div class="form-group">
              <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
              <button type="submit" class="btn btn-success" >Save</button>
              </div>
              </div>
            </div>
          </div>  
        </div>
    <div class="col-md-4">
    </div>
</form>

<script type="text/javascript" src="<?php echo base_url("assets/client_assets/js/ckeditor.js"); ?>" ></script>
<script type="text/javascript" src="<?php echo base_url("assets/js/bootstrap-select.min.js?v=2.1.1"); ?>"></script>




            