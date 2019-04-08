<?php
	$this->load->view('common/header.php');
?>
       
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?php echo base_url("assets/editor/css/froala_editor.css"); ?>">
  <link rel="stylesheet" href="<?php echo base_url("assets/editor/css/froala_style.css"); ?>">
  <link rel="stylesheet" href="<?php echo base_url("assets/editor/css/plugins/code_view.css"); ?>">
  <link rel="stylesheet" href="<?php echo base_url("assets/editor/css/plugins/colors.css"); ?>">
  <link rel="stylesheet" href="<?php echo base_url("assets/editor/css/plugins/emoticons.css"); ?>">
  <link rel="stylesheet" href="<?php echo base_url("assets/editor/css/plugins/image_manager.css"); ?>">
  <link rel="stylesheet" href="<?php echo base_url("assets/editor/css/plugins/image.css"); ?>">
  <link rel="stylesheet" href="<?php echo base_url("assets/editor/css/plugins/line_breaker.css"); ?>">
  <link rel="stylesheet" href="<?php echo base_url("assets/editor/css/plugins/table.css"); ?>">
  <link rel="stylesheet" href="<?php echo base_url("assets/editor/css/plugins/char_counter.css"); ?>">
  <link rel="stylesheet" href="<?php echo base_url("assets/editor/css/plugins/video.css"); ?>">
  <link rel="stylesheet" href="<?php echo base_url("assets/editor/css/plugins/fullscreen.css"); ?>">
  <link rel="stylesheet" href="<?php echo base_url("assets/editor/css/plugins/file.css"); ?>">
  <link rel="stylesheet" href="<?php echo base_url("assets/editor/css/plugins/quick_insert.css"); ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.css">
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
        height: 35px;
      }
       tr{
        cursor: pointer;
    }
    .unread{
        display: inline-block;
        background: red;
        border-radius: 50%;
        width: 10px;
        height: 10px;
    }
    .td-action{
        color: #ff7600;
    }
    .td-action:hover{
        color: red;
    }
     tr{
        cursor: pointer;
    }
 
    .message_box{
        width: 100% !important;
    }
</style>

                  <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3><a href="<?php echo base_url("admini/message"); ?>" class="btn btn-default"><i class="fa fa-chevron-left"></i> Back</a>
                 &nbsp;&nbsp;
                  <a href="<?php echo base_url("admini/message/reply/".$id); ?>" class="btn btn-default"><i class="fa fa-reply"></i> Reply</a></h3>
              </div>
            </div>
            <div class="clearfix"></div>
            <div class="row" style="padding: 15px;">
              <div class="row">
                 <div class="col-md-12" style="border: 1px solid #e0e0e0; padding: 20px;">
                    <?php 
                        $message = get_row("message",array("id"=>$id));
                    ?>
                    <p style="font-weight: 500; font-size: 24px;">
                        <?php echo $message['subject']; ?>
                    </p>
                    <p>
                        From <b>
                        <?php 
                          $user = get_row("member",array("id"=>$message['sender']));
                          echo $user['first_name']." ".$user['last_name']; 
                        ?></b>
                    </p>
                    <p>
                        On <?php
                            $date1 = strtotime($message['date']);
                            $date = date("F d,Y", $date1)." at ".date("H:i",$date1);
                             echo $date; 
                            ?>
                    </p>
                    <div style="border: 1px solid #ccc;padding: 20px;">
                        <?php
                            echo $message['body'];
                        ?>
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
  
</script>
            