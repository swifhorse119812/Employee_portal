
        <!-- footer content -->
        <footer>
          <div class="pull-right">
            <!-- Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a> -->
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>

    <!-- jQuery -->
    <script src="<?php echo base_url(); ?>assets/vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="<?php echo base_url(); ?>assets/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
   
<script src="<?php echo base_url(); ?>assets/js/other_js/jquery.uploadPreview.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="<?php echo base_url(); ?>assets/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <!-- <script src="<?php echo base_url(); ?>assets/vendors/datatables.net/js/dataTables.editor.js"></script> -->
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/select/1.2.5/js/dataTables.select.min.js"></script>
    <!-- <script src="<?php echo base_url(); ?>assets/js/custom1.js"></script> -->
<script src="<?php echo base_url(); ?>assets/js/admin/custom.js"></script>

 
    <script type="text/javascript">
        function get_email_count(){
            $.ajax({
                url:"<?php echo base_url("admini/inbox/get_email_count"); ?>",
                dataType:"json",
                type:"post",
                success: function(res){
                    if(res.count*1 != 0){
                        $(".message-count-box").show();
                        $(".message-count-box").html(res.count);
                    }
                }
            })
        }
        $(function(){
            if($(".message-count-box").hasClass("message-count-box")){
                get_email_count();
                setInterval(get_email_count, 1000);

            }

            $("body").on("click","#full_screen",function(){
                // alert();
                $("#menu_toggle").click();
                $(".col-sm-1").removeClass("col-sm-1");
                
            })
        })
    </script>


    
	
  </body>
</html>
