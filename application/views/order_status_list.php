<?php
	$this->load->view('header.php');
?>
<?php 
    $member = get_row("member",array("id"=>$this->session->userdata("member_id")));
    $emp_level = $member['emp_level'];
?>
    
    
<link href="<?php echo base_url(); ?>assets/css/mycustom.css" rel="stylesheet">
   
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
<!-- <style>
  body {font-family: Arial, Helvetica, sans-serif;}

  #myImg {
    border-radius: 5px;
    cursor: pointer;
    transition: 0.3s;
  }

  #myImg:hover {opacity: 0.7;}

  /* The Modal (background) */
  .modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    padding-top: 100px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
  }

  /* Modal Content (image) */
  .modal-content {
    margin: auto;
    display: block;
    width: 80%;
    max-width: 700px;
  }

  /* Caption of Modal Image */
  #caption {
    margin: auto;
    display: block;
    width: 80%;
    max-width: 700px;
    text-align: center;
    color: #ccc;
    padding: 10px 0;
    height: 150px;
  }

  /* Add Animation */
  .modal-content, #caption {  
    -webkit-animation-name: zoom;
    -webkit-animation-duration: 0.6s;
    animation-name: zoom;
    animation-duration: 0.6s;
  }

  @-webkit-keyframes zoom {
    from {-webkit-transform:scale(0)} 
    to {-webkit-transform:scale(1)}
  }

  @keyframes zoom {
    from {transform:scale(0)} 
    to {transform:scale(1)}
  }

  /* The Close Button */
  .close {
    position: absolute;
    top: 15px;
    right: 35px;
    color: #f1f1f1;
    font-size: 40px;
    font-weight: bold;
    transition: 0.3s;
  }

  .close:hover,
  .close:focus {
    color: #bbb;
    text-decoration: none;
    cursor: pointer;
  }

  /* 100% Image Width on Smaller Screens */
  @media only screen and (max-width: 700px){
    .modal-content {
      width: 100%;
    }
}
</style> -->

                  <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Show Status Orders</h3>
              </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-2" style="padding: 0px 20px;">
                <div style="width: 100%; height: 50px;">
                  <!-- <button class="btn btn-info pull-right" id="add_tag_btn">Add Tag</button> -->
                </div>
                <div style="border: 1px solid #ccc; min-height: 500px; padding: 40px;">
                  <ul class="sider-menu">
                    <?php
                      $temp=0;
                      $tags = get_rows("order_status_list");
                      foreach ($tags as $key => $tag) {
                        $temp++;
                        if($emp_level==2)
                          if($temp==1 || $temp==5 || $temp==6|| $temp==7|| $temp==8){
                            
                            if(!$tag_id || $tag_id ==1) $tag_id = 2;
                            continue;
                          }
                        
                    ?>
                    <li data-id="<?php echo $tag['id']; ?>" class="<?php if($tag_id == $tag['id']) echo "li-active"; ?>">
                      <a class="click-tag"><?php echo $tag['title']; ?></a>
                    </li>
                    <?php
                      }
                    ?>
                  </ul>
                </div>
              </div>
              <div class="col-md-10" style="padding: 0px 20px;">
                     
                <div style="width: 100%; height: 50px;">
                <?php
                  if($emp_level==2){
                ?>
                  <button class="btn btn-warning pull-right" id="push_shipped_btn">Checking Shipped</button>
                  <?php
                  }
                ?>
                </div>

                <div style="border: 1px solid #ccc; min-height: 500px;">
                <div class="row" style="padding: 40px;">
                <div class="col-md-12" style="margin-bottom: 20px;">
                  <!-- <button class="btn btn-warning pull-right" id="question_btn">Ask Question</button> -->
              </div>
              <div class="col-md-12" style="min-height: 350px;" id="ticket_table_view">
                  
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
 


<div class="modal fade in" id="tag_modal" aria-hidden="false" style="display: none;">
  <div class="modal-dialog" style="width: 700px;">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
            <h3 class="modal-title">Status Management</h3>
        </div>
        <div class="modal-body" style="padding: 10px 0px;">
         <!--  <img id="featureimage" src=""/> -->
              <form id="tag_create" name="tag_create" data-parsley-validate class="form-horizontal form-label-left" action="<?php echo site_url("help/tag_create"); ?>" method="post" enctype="multipart/form-data">
                    <div class="form-group" style="padding: 20px; padding-bottom: 10px;">
                        <label class="control-label col-md-12 col-sm-12 col-xs-12" for="name" style="text-align: left;">Title <span class="required">*</span>
                        </label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <input type="text" name="title" id="tag_title" required="required"  class="form-control col-md-12 col-xs-12">
                        </div>
                    </div>
                    <div class="form-group" style="padding-right: 28px;">
                      <input type="hidden" name="id" id="tag_id">
                    </div>  
                    
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


<div class="modal fade in" id="ticket_modal" aria-hidden="false" style="display: none;">
  <div class="modal-dialog" style="width: 700px;">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
            <h3 class="modal-title">Insert Reference Number</h3>
        </div>
        <div class="modal-body" style="padding: 10px 0px;">
         <!--  <img id="featureimage" src=""/> -->
              <form id="create_ticket" name="create_ticket" data-parsley-validate class="form-horizontal form-label-left" action="<?php echo site_url("account/insert_referencenum"); ?>" method="post" enctype="multipart/form-data">
                    
                   
                    <div class="form-group" style="padding: 20px; padding-bottom: 10px;">
                        <label class="control-label col-md-12 col-sm-12 col-xs-12" for="name" style="text-align: left;">Reference Number<span class="required">*</span>
                        </label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <input type="text" name="reference_num" id="reference_num" required="required"  class="form-control col-md-12 col-xs-12">
                        </div>
                    </div>  
                    
                    <input type="hidden" name="order_id" id="sel_order_id">

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
<div class="modal fade in" id="reject_modal" aria-hidden="false" style="display: none;">
  <div class="modal-dialog" style="width: 700px;">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
            <h3 class="modal-title">Insert Reject Reason</h3>
        </div>
        <div class="modal-body" style="padding: 10px 0px;">
         <!--  <img id="featureimage" src=""/> -->
              <form id="create_ticket" name="create_ticket" data-parsley-validate class="form-horizontal form-label-left" action="<?php echo site_url("account/update_order_state_reject"); ?>" method="post" enctype="multipart/form-data">
                    
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Select Reject Reason</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <label>
                            <select class="select2_single form-control col-md-7 col-xs-12" name="roll" id="roll">
                              <option>Item arrived too late</option>
                              <option>Wrong Color/Size ordered</option>
                              <option>Wrong Item ordered</option>
                            </select>
                          </label>
                      </div>
                    </div>
                    <hr>
                    <div class="form-group" style="padding: 20px; padding-bottom: 10px;">
                        <label class="control-label col-md-12 col-sm-12 col-xs-12" for="name" style="text-align: left;">Somthing Else Write Here.</span>
                        </label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <input type="text" name="reject_reason" id="reject_reason" class="form-control col-md-12 col-xs-12">
                        </div>
                    </div>  
                    
                    <input type="hidden" name="order_id" id="sel_reject_order_id">

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
<div class="modal fade in" id="cancel_modal" aria-hidden="false" style="display: none;">
  <div class="modal-dialog" style="width: 700px;">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
            <h3 class="modal-title">Insert Cancel Reason</h3>
        </div>
        <div class="modal-body" style="padding: 10px 0px;">
         <!--  <img id="featureimage" src=""/> -->
              <form id="create_ticket" name="create_ticket" data-parsley-validate class="form-horizontal form-label-left" action="<?php echo site_url("account/update_order_state_cancel"); ?>" method="post" enctype="multipart/form-data">
                    
                   
                    <div class="form-group" style="padding: 20px; padding-bottom: 10px;">
                        <label class="control-label col-md-12 col-sm-12 col-xs-12" for="cancel_reason" style="text-align: left;">Cancel Reason<span class="required">*</span>
                        </label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <input type="text" name="cancel_reason" id="cancel_reason" required="required"  class="form-control col-md-12 col-xs-12">
                        </div>
                    </div>  
                    
                    <input type="hidden" name="id" id="cancel_orderid">

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

    function viewTicketTable(){
      tag_id = $("#tag_id").val();
      $.ajax({
          url: ajax_url + "help/get_tag_table",
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

        $("body").on("click","#push_btn",function(){
            var order_id = $(this).closest("tr").data("id");
            var id = $("#tag_id").val();
            if(!id) id=1;
            if(id!=1){
              $.ajax({
                  url: ajax_url + "account/update_order_state",
                  data:{id:id,order_id:order_id},
                  type:"post",
                  dataType:"json",
                  success: function(res){
                    console.log("success");
                    //console.log(ajax_url+"account/order_status_list/"+res.data.id)
                    //document.location.replace(ajax_url+"account/order_status_list/"+res.data.id);
                  }
              })
            }else{
              selorder_id = $(this).closest("tr").data("id");
              $("#sel_order_id").val(selorder_id);
              $("#ticket_modal").modal();
            }
          
        })

        // $("body").on("click","#reject_btn",function(){
        //     var order_id = $(this).closest("tr").data("id");
        //     //alert(order_id)
        //     var id = $("#tag_id").val();
        //     if(!id) id=1;
        //     $.ajax({
        //         url: ajax_url + "account/update_order_state_reject",
        //         data:{id:id,order_id:order_id},
        //         type:"post",
        //         dataType:"json",
        //         success: function(res){
        //           //console.log(ajax_url+"account/order_status_list/"+res.data.id)
        //           document.location.replace(ajax_url+"account/order_status_list/"+res.data.id);
        //         }
        //     })
          
        // })

        $("body").on("click","#reject_btn",function(){
            var selorder_id = $(this).closest("tr").data("id");
            $("#sel_reject_order_id").val(selorder_id);
            $("#reject_modal").modal();
        })

        $("body").on("click","#push_cancel",function(){
            var cancel_order_id = $(this).closest("tr").data("id");
            $("#cancel_orderid").val(cancel_order_id);
            $("#cancel_modal").modal();
        })

        // $("body").on("click","#edit_btn",function(){
        //     var selorder_id = $(this).closest("tr").data("id");
        //     $("#sel_order_id").val(selorder_id);
        //     $("#ticket_modal").modal();
        // })

        $("#push_shipped_btn").on("click", function () {
          var id = $('#ticket_table_view input[type="checkbox"]:checked').map(function () {
              return $(this).val();
          }).get();
          $.ajax({
                url: ajax_url + "account/update_shipped_state",
                data:{id:id},
                type:"post",
                dataType:"json",
                success: function(res){
                  //console.log(ajax_url+"account/order_status_list/"+res.data.id)
                  document.location.replace(ajax_url+"account/order_status_list/"+res.data.id);
                }
            })
        });


        // $("body").on("hover",".compress",function(){
        //   $(".image").show();

        // })

        // $("body").on("click",".edit-tag",function(){
        //     var id = $(this).closest("li").data("id");
        //     //console.log(id);
        //     $.ajax({
        //         url: ajax_url + "help/get_tag",
        //         data:{id:id},
        //         type:"post",
        //         dataType:"json",
        //         success: function(res){
        //             $("#tag_create")[0].reset();
        //             $("#tag_title").val(res.data.title);
        //             $("#tag_id").attr('value',res.data.id);
        //             //$("#tag_id").val(res.data.id);
        //             $("#tag_modal").modal();

        //         }
        //     })
        // })

        // $("body").on("click",".remove-tag",function(){
        //     var id = $(this).closest("li").data("id");
        //     $.ajax({
        //         url: ajax_url + "help/remove_tag",
        //         data:{id:id},
        //         type:"post",
        //         dataType:"json",
        //         success: function(res){
        //           document.location.replace(ajax_url+"help/get_support");
        //         }
        //     })
        // })


        // $("body").on("click",".edit-ticket",function(){
        //     var id = $(this).closest("tr").data("id");
        //     $.ajax({
        //         url: ajax_url + "admini/help/get_ticket",
        //         data:{id:id},
        //         type:"post",
        //         dataType:"json",
        //         success: function(res){
        //             $("#create_ticket")[0].reset();
        //             $("#ticket_title").val(res.data.title);
        //             $("#ticket_id").val(res.data.id);
        //             $("#edit_wrap").html('<textarea name="content" id="content"></textarea>');
        //             CKEDITOR.replace( 'content' );
        //             CKEDITOR.instances.content.setData(res.data.content);

        //             $("#ticket_modal").modal();

        //         }
        //     })
        // })

        // $("body").on("click",".remove-ticket",function(){
        //     if(confirm("Are you sure remove this ticket?")){
        //         var id = $(this).closest("tr").data("id");
        //         $.ajax({
        //             url: ajax_url + "admini/help/remove_ticket",
        //             data:{id:id},
        //             type:"post",
        //             dataType:"json",
        //             success: function(res){
        //                document.location.reload();
        //             }
        //         })

        //     }
        // })
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
          //$("#add_ticket_btn").val("asdfasfa");
          $("#tag_id").val($(this).data("id"));
          viewTicketTable();

        })

    })

</script>

            