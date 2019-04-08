<?php 
    $this->load->view("header");
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
</style>

        <!-- 
        ================================================== 
            Global Page Section Start
        ================================================== -->
        <section class="global-page-header">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="block">
                            <h2>F A Q</h2>
                            <ol class="breadcrumb">
                                <li>
                                    <a href="<?php echo base_url("account/dashboard"); ?>">
                                        <i class="ion-ios-home"></i>
                                        Home
                                    </a>
                                </li>
                                <li class="active">Help</li>
                                <li class="active"><a href="<?php echo base_url("help/faq"); ?>">FAQ</a></li>
                                <li class="active">Question #<?php echo $id; ?></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </section>


<!-- 
================================================== 
    Company Description Section Start
================================================== -->
<section class="company-description">
    <div class="container">
        <div class="row">
            <!-- <div class="col-md-12" style="margin-bottom: 20px;">
                <button class="btn btn-warning pull-right" id="question_btn">Ask Question</button>
            </div> -->
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

                    if($question['user_id'] == $this->session->userdata("member_id")) echo "I";
                    else {
                        $user = get_row("member",array("id"=>$question['user_id']));
                        echo " by ".$user['first_name'].' '.$user['last_name'];
                    }

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
        
        </div>
    </div>
</section>

 
            <!--
            ==================================================
            Call To Action Section Start
            ================================================== -->
            <section id="call-to-action">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="block">
                                <h2 class="title wow fadeInDown" data-wow-delay=".3s" data-wow-duration="500ms">SO WHAT YOU THINK ?</h1>
                                <p class="wow fadeInDown" data-wow-delay=".5s" data-wow-duration="500ms">All purchases with Virsympay are purchases of the Virsymcoin Cryptocurrency,<br/> we convert all purchases to the currency of your choice.</p>
                                <a href="<?php echo site_url("contact"); ?>" class="btn btn-default btn-contact wow fadeInDown" data-wow-delay=".7s" data-wow-duration="500ms">Contact With Me</a>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </section>
<?php 
    $this->load->view("footer");
?> 

 

  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/mode/xml/xml.min.js"></script>

  <script type="text/javascript" src="<?php echo base_url("assets/editor/js/froala_editor.min.js"); ?>" ></script>
  <script type="text/javascript" src="<?php echo base_url("assets/editor/js/plugins/align.min.js"); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url("assets/editor/js/plugins/char_counter.min.js"); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url("assets/editor/js/plugins/code_beautifier.min.js"); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url("assets/editor/js/plugins/code_view.min.js"); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url("assets/editor/js/plugins/colors.min.js"); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url("assets/editor/js/plugins/draggable.min.js"); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url("assets/editor/js/plugins/emoticons.min.js"); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url("assets/editor/js/plugins/entities.min.js"); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url("assets/editor/js/plugins/file.min.js"); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url("assets/editor/js/plugins/font_size.min.js"); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url("assets/editor/js/plugins/font_family.min.js"); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url("assets/editor/js/plugins/fullscreen.min.js"); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url("assets/editor/js/plugins/image.min.js"); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url("assets/editor/js/plugins/image_manager.min.js"); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url("assets/editor/js/plugins/line_breaker.min.js"); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url("assets/editor/js/plugins/inline_style.min.js"); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url("assets/editor/js/plugins/link.min.js"); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url("assets/editor/js/plugins/lists.min.js"); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url("assets/editor/js/plugins/paragraph_format.min.js"); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url("assets/editor/js/plugins/paragraph_style.min.js"); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url("assets/editor/js/plugins/quick_insert.min.js"); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url("assets/editor/js/plugins/quote.min.js"); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url("assets/editor/js/plugins/table.min.js"); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url("assets/editor/js/plugins/save.min.js"); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url("assets/editor/js/plugins/url.min.js"); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url("assets/editor/js/plugins/video.min.js"); ?>"></script>



<script type="text/javascript">
    var ajax_url = "<?php echo base_url(); ?>";
     $.extend( true, $.fn.dataTable.defaults, {
        "searching": true,
        "ordering": false
    } );

    $(function(){
        $('#faq_table').DataTable();
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
            if($(this).hasClass("dataTables_empty")) return;
            id = $(this).closest("tr").data("id");
            document.location.replace(ajax_url + "help/answer/"+id);
        })
          

    })

</script>

