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
        height: 25px;
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
    
</style>

                  <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Sent</h3>
              </div>
            </div>
            <div class="clearfix"></div>
            <div class="row" style="padding: 15px;">
                 <div class="col-md-12" style="padding: 20px; border: 1px solid #ccc;">
                    <?php 
                        $messages = get_rows("message",array("sender"=>"admin"),"date DESC");
                    ?>
                    <p style="font-weight: 500;">
                        Sent Message(<?php echo count($messages); ?>)
                    </p>
                    <table class="table table-striped" id="transaction_table" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th style="width: 10px;"></th>
                                <th>Message ID</th>
                                <th>To</th>
                                <th>Subject</th>
                                <th>Date</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                     <?php
                        foreach ($messages as $key => $message) {
                            echo "<tr data-id='".$message['id']."'>";
                            echo "<td style='width:10px;'><span class='read'></span></td>";
                            $user = get_row("member",array("id"=>$message['receiver']));
                            echo "<td>".$message['id']."</td>";
                            echo "<td>".$user['first_name']." ".$user['last_name']."</td>";
                            echo "<td>".$message['subject']."</td>";
                            $date1 = strtotime($message['date']);
                            $date = date("F d,Y", $date1)." at ".date("H:i",$date1);
                            echo "<td>".$date."</td>";
                            echo '<td class="td-action">Remove</td>';
                            echo "</tr>";
                        }
                     ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th></th>
                               <th>Message ID</th>
                                <th>From</th>
                                <th>Subject</th>
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
 
<script type="text/javascript">
 
    var base_url = "<?php echo base_url("admini/message/"); ?>";
    $.extend( true, $.fn.dataTable.defaults, {
        "searching": true,
        "ordering": false
    } );

    $(function(){
        $('#transaction_table').DataTable({
            "columnDefs": [ {
            "targets": [0,1],
            "orderable": false
            } ],
            "aaSorting": [[2, 'asc']]
        });

        $("body").on("click","#transaction_table tbody td",function(){
            id = $(this).closest("tr").data("id");
            if($(this).hasClass("td-action")) return;
            if(id==""||id===undefined) return;
            document.location.replace(base_url+"sent_message/"+id);
        })
        $("body").on("click",".td-action",function(){
            id = $(this).closest("tr").data("id");
            document.location.replace(base_url+"message_remove_sent/"+id);

        })
    })
</script>
            