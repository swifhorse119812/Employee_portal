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
</style>

                  <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Merchant Ticket Support</h3>
              </div>
            </div>
            <div class="clearfix"></div>
            <div class="row" style="padding: 40px;">
                <div class="col-md-12" style="margin-bottom: 20px;">
                  <!-- <button class="btn btn-warning pull-right" id="question_btn">Ask Question</button> -->
              </div>
              <div class="col-md-12" style="min-height: 350px;">
                  <table id="faq_table" class="display" style="width:100%">
                      <thead>
                          <tr>
                              <th>Question ID</th>
                              <th>Issue type</th>
                              <th>Merchant</th>
                              <th>Title</th>
                              <th>Answer</th>
                              <th>Date</th>
                              <th></th>
                          </tr>
                      </thead>
                      <tbody>
                      <?php
                          $questions = get_rows("questions",array("status"=>1),"date DESC");
                          foreach ($questions as $key => $question) {
                            $tag = get_row("help_tag",array("id"=>$question['tag_id']));

                              echo '<tr data-id="'.$question['id'].'">';
                              echo '<td>'.$question['id'].'</td>';
                              echo '<td>'.$tag['title'].'</td>';

                              $user = get_row("member",array("id"=>$question['user_id']));
                              echo '<td>'.$user['first_name'].' '.$user['last_name'].'</td>';
                              echo '<td>'.$question['title'].'</td>';
                              $answer_count = get_rows_count("answers",array("question_id"=>$question['id']));
                              echo '<td>'.$answer_count.'</td>';
                              echo '<td>'.$question['date'].'</td>';
                              echo '<td style="text-align:right;" class="action_td"><a class="edit_question" title="edit"><i class="fa fa-edit"></i> Edit</a> | <a class="remove_question" title="remove"><i class="fa fa-trash"></i> Remove</a></td>';

                          }
                      ?>
                      </tbody>
                      <tfoot>
                        <tr>
                              <th>Question ID</th>
                              <th>Issue type</th>
                              <th>Merchant</th>
                              <th>Title</th>
                              <th>Answer</th>
                              <th>Date</th>
                              <th></th>
                          </tr>
                      </tfoot>
                  </table>
              </div>
            </div>
          </div>
        </div>


<?php
	$this->load->view('common/footer.php');
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
              <form id="create_question" name="create_question" data-parsley-validate class="form-horizontal form-label-left" action="<?php echo site_url("admini/help/create_question"); ?>" method="post" enctype="multipart/form-data">
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
                    <div class="form-group" style="padding: 20px; padding-bottom: 10px;">
                        <label class="control-label col-md-12 col-sm-12 col-xs-12" for="name" style="text-align: left;">Title <span class="required">*</span>
                        </label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <input type="text" name="title" id="title" required="required"  class="form-control col-md-12 col-xs-12">
                        </div>
                    </div>  
                    <div class="form-group" style="padding: 20px; padding-top: 10px;">
                        <label class="control-label col-md-12 col-sm-12 col-xs-12" for="name" style="text-align: left;">Question <span class="required">*</span>
                        </label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <div id="edit_wrap" style="width: 100%;">
                          </div>
                        </div>
                    </div>  
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


<script type="text/javascript">
    var ajax_url = "<?php echo base_url(); ?>";
     $.extend( true, $.fn.dataTable.defaults, {
        "searching": true,
        "ordering": false
    } );

    $(function(){
        $('#faq_table').DataTable();
        $("body").on("click","#question_btn",function(){
            $("#edit_wrap").html('<textarea name="content" id="content"></textarea>');
            CKEDITOR.replace( 'content' );
            $("#create_question")[0].reset();
            $("#question_modal").modal();
          
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
      
      // #faq_table tbody tr
        $("body").on("click","#faq_table tbody tr td",function(){
            if($(this).hasClass("action_td")) return;
            if($(this).hasClass("dataTables_empty")) return;
            
            id = $(this).closest("tr").data("id");
            document.location.replace(ajax_url + "admini/help/answer/"+id);
        })
          

    })

</script>

            