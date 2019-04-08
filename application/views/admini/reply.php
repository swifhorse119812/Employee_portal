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
      .question-title{
        font-size: 20px;
        font-weight: 400;
        border-bottom: 1px solid #ccc;
        padding: 10px;
      }
      .question-body{
        padding: 10px 20px;
        border: 1px solid #e2e2e2;
      }

      .remove-answer{
        cursor: pointer;
      }

</style>


                  <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <?php
                  $message = get_row("message",array("id"=>$message_id));
                  $user = get_row("member",array("id"=>$message['sender']));
                ?>
                <h3>Reply to <b><?php echo $user['first_name']." ".$user['last_name']; ?></b></h3>
              </div>

             
            </div>
            <div class="clearfix"></div>
            <div class="container" style="width: 1024px;">
            <div class="row" style="padding: 40px;">
                <form id="answer_form" name="answer_form" method="post" action="<?php echo base_url("admini/message/send_mail"); ?>">

                <div class="col-md-12" style="margin-bottom: 30px;">
                    <p style="font-size: 16px; font-weight: 400;">To</p>
                    <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                    <input type="text" class="form-control" readonly="" value="<?php echo $user['first_name']." ".$user['last_name']; ?>">

                </div>
                <div class="col-md-12" style="margin-bottom: 30px;">
                    <p style="font-size: 16px; font-weight: 400;">Subject</p>
                    <input type="text" name="subject" style="width: 100%;" class="form-control" required="">
                </div>
                <div class="col-md-12">
                    <p style="font-size: 16px; font-weight: 400;">Body</p>
                    <textarea name="body" id="content"></textarea>
                    </div>
                </div>
                <div class="col-md-12" style="margin:10px 0px;">
                    <button class="btn btn-info pull-right save-answer">Reply</button>
                </div>
              </form>

               
            </div>
          </div>
          </div>
        </div>
        <!-- /page content -->
    
        <!-- /page content -->


<?php
	$this->load->view('common/footer.php');
?>
  <script type="text/javascript" src="<?php echo base_url("assets/client_assets/js/ckeditor.js"); ?>" ></script>
<script type="text/javascript">
    var ajax_url = "<?php echo base_url(); ?>";
    var body_content = '<?php echo json_encode($message['body']); ?>';
    
    $(function(){
       CKEDITOR.replace( 'content' );
        // CKEDITOR.instances.content.setData(body_content);
      
    })

</script>

