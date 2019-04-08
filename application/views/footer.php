<!--
            ==================================================
            Footer Section Start
            ================================================== -->
            <footer id="footer">
                <div class="container">
                    <div class="col-md-12" style="text-align: center;">
                        <p class="copyright">&copy Employee All Rights Reserved Copyright: <span><script>document.write(new Date().getFullYear())</script><!-- </span> Design and Developed by <a href="http://www.Themefisher.com" target="_blank">Themefisher</a>. <br> 
                            Get More 
                            <a href="https://themefisher.com/free-bootstrap-templates/" target="_blank">
                                Free Bootstrap Templates
                            </a>
                        </p> -->
                    </div>
                    <!-- <div class="col-md-4">
                        <ul class="social">
                            <li>
                                <a href="http://wwww.fb.com/themefisher" class="Facebook">
                                    <i class="ion-social-facebook"></i>
                                </a>
                            </li>
                            <li>
                                <a href="http://wwww.twitter.com/themefisher" class="Twitter">
                                    <i class="ion-social-twitter"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="Linkedin">
                                    <i class="ion-social-linkedin"></i>
                                </a>
                            </li>
                            <li>
                                <a href="http://wwww.fb.com/themefisher" class="Google Plus">
                                    <i class="ion-social-googleplus"></i>
                                </a>
                            </li>
                        </ul>
                    </div> -->
                </div>
            </footer> <!-- /#footer -->

<div class="modal fade in" id="login_modal" aria-hidden="false" style="display: none;">
  <div class="modal-dialog" style="width: 700px;">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
            <h3 class="modal-title">Login now</h3>
        </div>
        <div class="modal-body" style="padding: 10px 0px;">
         <!--  <img id="featureimage" src=""/> -->
               

        </div>
        <div class="modal-footer">
            
        </div>
    </div>
  </div>
</div>

	<!-- Template Javascript Files
	================================================== -->
	<!-- jquery -->
	<script src="<?php echo base_url('assets/client_assets/plugins/jQurey/jquery.min.js'); ?>"></script>
	<!-- Form Validation -->
    <script src="<?php echo base_url('assets/client_assets/plugins/form-validation/jquery.form.js'); ?>"></script> 
    <script src="<?php echo base_url('assets/client_assets/plugins/form-validation/jquery.validate.min.js'); ?>"></script>
	<!-- owl carouserl js -->
	<script src="<?php echo base_url('assets/client_assets/plugins/owl-carousel/owl.carousel.min.js'); ?>"></script>
	<!-- bootstrap js -->
	<script src="<?php echo base_url('assets/client_assets/plugins/bootstrap/bootstrap.min.js'); ?>"></script>
	<!-- wow js -->
	<script src="<?php echo base_url('assets/client_assets/plugins/wow-js/wow.min.js'); ?>"></script>
	<!-- slider js -->
	<script src="<?php echo base_url('assets/client_assets/plugins/slider/slider.js'); ?>"></script>
	<!-- Fancybox -->
	<script src="<?php echo base_url('assets/client_assets/plugins/facncybox/jquery.fancybox.js'); ?>"></script>
	<!-- template main js -->
    <script src="<?php echo base_url('assets/client_assets/js/main.js'); ?>"></script>
	<script src="<?php echo base_url('assets/client_assets/js/jquery.dataTables.js'); ?>"></script>
    
    <script type="text/javascript">
        function get_email_count(){
            $.ajax({
                url:"<?php echo base_url("account/get_email_count"); ?>",
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
            setTimeout(function() {
                $('#alert_error_wrap').hide('fast', function() { $('#alert_error_wrap').remove(); });
            }, 3500);

            $(".login-btn").click(function(){
                $("#login_form").show();
                $("#signup_form").hide();
                $("#reset_password").hide();
                $(".modal-title").html("Login Now");
                $("#login_modal").modal();
            })
            $("body").on("click",".login_now",function(){
                $("#login_form").show();
                $("#signup_form").hide();
                $("#reset_password").hide();
                $(".modal-title").html("Login Now");
            })

            $("body").on("click",".signup_now",function(){
                $("#login_form").hide();
                $("#signup_form").show();
                $("#reset_password").hide();
                $(".modal-title").html("Sign up with free");

            })

            $("#signup_form").submit(function(e){
                e.preventDefault();
                $("#error_wrap").fadeOut();
                if($("#repeat_password").val()!=$("#password").val()){
                    $("#error_wrap").fadeIn();
                    return;
                }
                document.signup_form.submit();
            })

            $("body").on("click",".forgot_password",function(){
                $("#login_form").hide();
                $("#signup_form").hide();
                $("#reset_password").show();
                $(".modal-title").html("Reset Password");
            })
        })

    </script>
 	</body>
</html>