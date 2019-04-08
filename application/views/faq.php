<?php 
    $this->load->view("header");
?>        
  <link rel="stylesheet" href="<?php echo base_url("assets/css/vendor.css?v=2.1.1"); ?>">

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
      .bootstrap-select .dropdown-menu{
        background: white;
      }
      .bootstrap-select{
        width: 100% !important;
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
                            <h2>Merchant Ticket Support</h2>
                            <ol class="breadcrumb">
                                <li>
                                    <a href="<?php echo base_url("account/dashboard"); ?>">
                                        <i class="ion-ios-home"></i>
                                        Home
                                    </a>
                                </li>
                                <li class="active">Help</li>
                                <li class="active">Merchant Ticket Support</li>
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
            <div class="col-md-12" style="margin-bottom: 20px;">
                <button class="btn btn-warning pull-right" id="question_btn">Ask Question</button>
            </div>
            <div class="col-md-12" style="min-height: 350px;">
                <table id="faq_table" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>Question ID</th>
                            <th>Issue type</th>
                            <th>Title</th>
                            <th>Answer</th>
                            <th>Date</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $questions = get_rows("questions",array("status"=>1,"user_id"=>$this->session->userdata("member_id")),"date DESC");
                        foreach ($questions as $key => $question) {
                            $tag = get_row("help_tag",array("id"=>$question['tag_id']));
                            echo '<tr data-id="'.$question['id'].'">';
                            echo '<td>'.$question['id'].'</td>';
                            echo '<td>'.$tag['title'].'</td>';
                            echo '<td>'.$question['title'].'</td>';
                            $answer_count = get_rows_count("answers",array("question_id"=>$question['id']));
                            echo '<td>'.$answer_count.'</td>';
                            echo '<td>'.$question['date'].'</td>';
                            if($question['user_id'] == $this->session->userdata("member_id"))
                                echo '<td class="action_td"><a class="edit_question" title="edit"><i class="fa fa-edit"></i></a> | <a class="remove_question" title="remove"><i class="fa fa-trash"></i></a></td>';
                            else 
                                echo '<td class="action_td"></td>';

                        }
                    ?>
                    </tbody>
                </table>
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


<div class="modal fade in" id="question_modal" aria-hidden="false" style="display: none;">
  <div class="modal-dialog" style="width: 700px;">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
            <h3 class="modal-title">Question</h3>
        </div>
        <div class="modal-body" style="padding: 10px 0px;">
         <!--  <img id="featureimage" src=""/> -->
              <form id="create_question" name="create_question" data-parsley-validate class="form-horizontal form-label-left" action="<?php echo site_url("help/create_question"); ?>" method="post" enctype="multipart/form-data">

                    <div class="form-group" style="padding: 10px; padding-bottom: 0px;">
                        <label class="control-label col-md-12 col-sm-12 col-xs-12" for="name" style="text-align: left;">Ticket Nummber
                        </label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <input type="text" name="id" id="id" required="required"  readonly="" class="form-control col-md-12 col-xs-12">
                        </div>
                    </div> 

                    <div class="form-group" style="padding: 10px; padding-bottom: 0px;">
                        <label class="control-label col-md-12 col-sm-12 col-xs-12" for="name" style="text-align: left;">Issue Type <span class="required">*</span>
                        </label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                           <select id="tag_id" name="tag_id" class="form-control"  style="width: 100%;">
                                  <?php
                                    $tags = get_rows("help_tag");
                                    foreach ($tags as $key => $tag) {
                                        echo '<option value="'.$tag['id'].'">'.$tag['title'].'</option>';
                                    }
                                  ?>
                                  <option value="-1">Other</option>
                                </select>

                        </div>
                    </div> 

                    <div class="form-group" style="padding: 10px; padding-bottom: 0px;">
                        <label class="control-label col-md-12 col-sm-12 col-xs-12" for="name" style="text-align: left;">Title <span class="required">*</span>
                        </label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <input type="text" name="title" id="title" required="required"  class="form-control col-md-12 col-xs-12">
                        </div>
                    </div>

                    <div class="form-group" style="padding: 10px; padding-top: 0px;">
                        <label class="control-label col-md-12 col-sm-12 col-xs-12" for="name" style="text-align: left;">Question <span class="required">*</span>
                        </label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                          
                          <div id="edit_wrap" style="width: 100%;">
                            
                          </div>
                        </div>
                    </div>  
                    
                    <!-- <input type="hidden" name="id" id="id"> -->
                    <!-- <input type="hidden" name="content" id="content"> -->

                    <div class="form-group">
                        <div class="" style="text-align: center;">
                          <button type="submit" class="btn btn-info" id="submit_btn" style="">Save</button>
                          <button type="button" class="btn btn-warning" id="remove_btn" style=" margin-left: 20px;" data-dismiss="modal">Cancel</button>

                        </div>
                    </div>
                    
              <div class="ln_solid"></div>
            </form>
        </div>
        <div class="modal-footer">
            
        </div>
    </div>
  </div>
</div>



  
  <script type="text/javascript" src="<?php echo base_url("assets/client_assets/js/ckeditor.js"); ?>" ></script>
  <script type="text/javascript" src="<?php echo base_url("assets/js/bootstrap-select.min.js?v=2.1.1"); ?>"></script>



<script type="text/javascript">
 
    var ajax_url = "<?php echo base_url(); ?>";
     $.extend( true, $.fn.dataTable.defaults, {
        "searching": true,
        "ordering": false
    } );

    $(function(){
        $('#faq_table').DataTable();
        $("body").on("click","#question_btn",function(){

             $.ajax({
                url: ajax_url + "/help/before_question",
                data:{},
                type:"post",
                dataType:"json",
                success: function(res){
                    $("#create_question")[0].reset();
                    $("#title").val(res.data.title);
                    $("#id").val(res.data.id);
                    $("#edit_wrap").html('<textarea name="content" id="content"></textarea>');
                    CKEDITOR.replace( 'content' );
                    $("#question_modal").modal();

                }
            })
          
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
                    $("option[value='"+res.data.tag_id+"']").prop("selected",true);
                    $("#edit_wrap").html('<textarea name="content" id="content"></textarea>');
                    CKEDITOR.replace( 'content' );
                    CKEDITOR.instances.content.setData(res.data.content);
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
        // $("body").on("click","#submit_btn",function(){
        //     if($("#title").val() == "") {
        //         alert("Please enter title!");
        //         return;
        //     }
        //     // content = $('#edit').froalaEditor('html.get');
        //     document.create_question.submit();
        // })
      // #faq_table tbody tr
        $("body").on("click","#faq_table tbody tr td",function(){
            if($(this).hasClass("action_td")) return;
            if($(this).hasClass("dataTables_empty")) return;
            
            id = $(this).closest("tr").data("id");
            document.location.replace(ajax_url + "help/answer/"+id);
        })
          

    })

</script>

            