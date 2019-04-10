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
 


<div class="modal fade in" id="tag_modal" aria-hidden="false" style="display: none;">
  <div class="modal-dialog" style="width: 700px;">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
            <h3 class="modal-title">Tag Management</h3>
        </div>
        <div class="modal-body" style="padding: 10px 0px;">
         <!--  <img id="featureimage" src=""/> -->
              <form id="tag_create" name="tag_create" data-parsley-validate class="form-horizontal form-label-left" action="<?php echo site_url("admini/help/tag_create"); ?>" method="post" enctype="multipart/form-data">
                    <div class="form-group" style="padding: 20px; padding-bottom: 10px;">
                        <label class="control-label col-md-12 col-sm-12 col-xs-12" for="name" style="text-align: left;">Title <span class="required">*</span>
                        </label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <input type="text" name="title" id="tag_title" required="required"  class="form-control col-md-12 col-xs-12">
                        </div>
                    </div>  
                    
                    <input type="hidden" name="id" id="tag_id">
                    <div class="form-group" style="padding-right: 28px;">
                        <div class="" style="text-align: right;">
                          <button type="submit" class="btn btn-info" id="" style="">Save</button>
                          <button type="button" class="btn btn-warning" style=" margin-left: 20px;" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
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

    function viewTicketTable(){
      tag_id = $("#tag_id").val();
      $.ajax({
          url: ajax_url + "admini/help/get_tag_table",
          data:{tag_id:tag_id},
          type:"post",
          dataType:"html",
          success: function(res){
            $("#ticket_table_view").html(res);
            $('#ticket_table').DataTable();
          }
      })
    }
    $(function(){
        viewTicketTable();
        $("body").on("click","#add_tag_btn",function(){
                    $("#tag_create")[0].reset();

          $("#tag_modal").modal();
        })
        $("body").on("click","#add_ticket_btn",function(){
            $("#edit_wrap").html('<textarea name="content" id="content"></textarea>');
            CKEDITOR.replace( 'content' );
            $("#question_modal").modal();
            $("#create_ticket")[0].reset();
            tag_id = $("#tag_id").val();
            $("#ticket_tag_id option[value='"+tag_id+"']").prop("selected",true);
            $("#ticket_modal").modal();
          
        })

        $("body").on("click",".edit-tag",function(){
            var id = $(this).closest("li").data("id");
            $.ajax({
                url: ajax_url + "admini/help/get_tag",
                data:{id:id},
                type:"post",
                dataType:"json",
                success: function(res){
                    $("#tag_create")[0].reset();
                    $("#tag_title").val(res.data.title);
                    $("#tag_id").val(res.data.id);
                    $("#tag_modal").modal();

                }
            })
        })

        $("body").on("click",".remove-tag",function(){
            var id = $(this).closest("li").data("id");
            $.ajax({
                url: ajax_url + "admini/help/remove_tag",
                data:{id:id},
                type:"post",
                dataType:"json",
                success: function(res){
                  document.location.replace(ajax_url+"admini/help/get_support");
                }
            })
        })


        $("body").on("click",".edit-ticket",function(){
            var id = $(this).closest("tr").data("id");
            $.ajax({
                url: ajax_url + "admini/help/get_ticket",
                data:{id:id},
                type:"post",
                dataType:"json",
                success: function(res){
                    $("#create_ticket")[0].reset();
                    $("#ticket_title").val(res.data.title);
                    $("#ticket_id").val(res.data.id);
                    $("#edit_wrap").html('<textarea name="content" id="content"></textarea>');
                    CKEDITOR.replace( 'content' );
                    CKEDITOR.instances.content.setData(res.data.content);

                    $("#ticket_modal").modal();

                }
            })
        })

        $("body").on("click",".remove-ticket",function(){
            if(confirm("Are you sure remove this ticket?")){
                var id = $(this).closest("tr").data("id");
                $.ajax({
                    url: ajax_url + "admini/help/remove_ticket",
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
        //     if($("#ticket_title").val() == "") {
        //         alert("Please enter title!");
        //         return;
        //     }
        //     $("#content").val($('#edit').froalaEditor('html.get'));
        //     // content = $('#edit').froalaEditor('html.get');
        //     document.create_ticket.submit();
        // })
        
        $("body").on("click",".sider-menu li",function(){
          $(".li-active").removeClass("li-active");
          $(this).addClass("li-active");
          $("#tag_id").val($(this).data("id"));
          viewTicketTable();

        })

    })

</script>

            