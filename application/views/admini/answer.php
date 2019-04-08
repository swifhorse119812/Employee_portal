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
                <h3>Question #<?php echo $id; ?></h3>
              </div>

             
            </div>
            <div class="clearfix"></div>
            <div class="container" style="width: 1024px;">
            <div class="row" style="padding: 40px;">
              <?php
                  $question = get_row("questions",array("id"=>$id));
                ?>
                <div class="col-md-12" style="">
                    <p class="question-title"> 
                        <span style="padding: 0px 10px;background: red;border-radius: 5px;color: white;"> Question #<?php echo $id; ?> </span> &nbsp;
                      <?php
                        echo $question['title'];
                        echo '<span style="color:#a0a0a0;" class="pull-right">';
                        $date = strtotime($question['date']);
                        $date1 = date("F d, Y",$date)." at ". date("H:i",$date);

                        // if($question['user_id'] == $this->session->userdata("member_id")) echo "I";
                        // else {
                            $user = get_row("member",array("id"=>$question['user_id']));
                            echo "  ".$user['first_name'].' '.$user['last_name'];
                        // }

                        echo " asked on ".$date1;
                        
                        echo "</span>";
                      ?>

                    </p>
                    <div class="question-body fr-element fr-view">
                        <?php
                            echo $question['content'];
                        ?>
                    </div>
                </div>
                <div class="col-md-12" style="margin: 20px 0px;">
                    <div style="width: 100%; border: 1px solid #c6f3cf; padding: 0px 10px 20px 50px;">
                    <?php
                        $answers = get_rows("answers",array("question_id"=>$id));
                        foreach ($answers as $key => $answer) {
                            $user = get_row("member",array("id"=>$answer['user_id']));
                            $date = strtotime($answer['date']);
                            $date1 = date("F d, Y",$date)." at ". date("H:i",$date);
                    ?>
                    <div class="answer-body" style="margin-top: 40px;">
                        <p style="font-size: 20px; font-weight: 400;">  
                            <span style="padding: 0px 20px;color: white;background: #218800;border-radius: 5px;">Answer #<?php echo $answer['id']; ?></span> Answered
                            <?php
                                if($answer['user_type'] == "member"){
                                    echo "<b>".$user['first_name']." ".$user['last_name']."</b>";
                                } else {
                                    echo "<b>Admin</b>";
                                }
                                echo " on ".$date1;
                            ?>
                          <a data-answer_id="<?php echo $answer['id']; ?>" class="pull-right remove-answer" style="margin-right: 20px; color: #ff6c00;"><i class="fa fa-trash"></i> remove</a>
                        </p>
                        <div class="question-body fr-element fr-view">
                            <?php
                                echo $answer['content'];
                            ?>
                        </div>
                    </div>
                    <?php
                        }
                    ?>
                    </div>
                </div>
                <form id="answer_form" name="answer_form" method="post" action="<?php echo base_url("admini/help/save_answer"); ?>">
             
                <div class="col-md-12">
                    <p style="font-size: 20px; font-weight: 400;">Admin Answer</p>
                      <textarea name="content" id="content"></textarea>
                    </div>
                </div>
                <div class="col-md-12" style="margin:10px 0px;">
                        <input type="hidden" name="url" value="<?php echo "admini/help/answer/".$id; ?>">
                        <input type="hidden" name="question_id" value="<?php echo $id; ?>">
                    <button class="btn btn-info pull-right save-answer">Post Answer</button>
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
     $.extend( true, $.fn.dataTable.defaults, {
        "searching": true,
        "ordering": false
    } );

    $(function(){
        $('#faq_table').DataTable();
        CKEDITOR.replace( 'content' );

        $("body").on("click",".edit_question",function(){
            var id = $(this).closest("tr").data("id");
            $.ajax({
                url: ajax_url + "/help/get_question",
                data:{id:id},
                type:"post",
                dataType:"json",
                success: function(res){
                    $("#create_question")[0].reset();
                    $("#title").val(res.data.title);
                    $("#id").val(res.data.id);
                    $("#edit_wrap").html('<div id="edit" style="width:100%;"></div>');
                    $('#edit').froalaEditor()
                        .on('froalaEditor.image.beforeUpload', function (e, editor, files) {
                          if (files.length) {
                            var reader = new FileReader();
                            reader.onload = function (e) {
                              var result = e.target.result;

                              editor.image.insert(result, null, null, editor.image.get());
                            };

                            reader.readAsDataURL(files[0]);
                          }

                          return false;
                        })
                    $('#edit').froalaEditor('html.set', res.data.content);
                    $("#question_modal").modal();

                }
            })
        })
        $("body").on("click",".remove_question",function(){
            if(confirm("Are you sure remove this question?")){
                var id = $(this).closest("tr").data("id");
                $.ajax({
                    url: ajax_url + "/help/remove_question",
                    data:{id:id},
                    type:"post",
                    dataType:"json",
                    success: function(res){
                       document.location.reload();
                    }
                })

            }
        })
        $("body").on("click",".save-answer",function(){
            $("#content").val($('#edit').froalaEditor('html.get'));
            document.answer_form.submit();
        })
      // #faq_table tbody tr
        $("body").on("click","#faq_table tbody tr td",function(){
            if($(this).hasClass("action_td")) return;
            id = $(this).closest("tr").data("id");
            document.location.replace(ajax_url + "help/answer/"+id);
        })

         $("body").on("click",".remove-answer",function(){
            obj = $(this).closest(".answer-body");
            if(confirm("Are you sure remove this question?")){
                var id = $(this).data("answer_id");
                $.ajax({
                    url: ajax_url + "admini/help/remove_answer",
                    data:{id:id},
                    type:"post",
                    dataType:"json",
                    success: function(res){
                       obj.fadeOut(function(){
                        obj.remove();
                       })
                    }
                })

            }
        })

    })

</script>

