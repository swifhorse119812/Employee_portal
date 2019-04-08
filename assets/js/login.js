
$(function(){

	Stripe.setPublishableKey(stripe_publish_key);
        
        //callback to handle the response from stripe
	function stripeResponseHandler(status, response) {
	    if (response.error) {
	        //enable the submit button
	        $('#payBtn').removeAttr("disabled");
	        //display the errors on the form
	        // $('#payment-errors').attr('hidden', 'false');
	        $('#payment_error').addClass('alert alert-danger');
	        $("#payment_error").html(response.error.message);
	    } else {
	        var form$ = $("#stripe_form");
	        //get token id
	        var token = response['id'];
	        //insert the token into the form
	        form$.append("<input type='hidden' name='stripeToken' value='" + token + "' />");
	        //submit form to the server
	        form$.get(0).submit();
	    }
	}

	 $("#stripe_form").submit(function(event) {
	 	exp_date = $("#expiry_date").val().split("/");
	 	console.log(exp_date);
	    Stripe.createToken({
	        number: $('#card_num').val(),
	        cvc: $('#cvc').val(),
	        exp_month: exp_date[0]*1,
	        exp_year: exp_date[1]*1
	    }, stripeResponseHandler);
	    
	    //submit from callback
	    return false;
    });

	$("#pay_btn").click(function(){
		// $("#payment_form").preventDefault();
		payment_getway = $(".payment_window input[type='radio']:checked").attr("id");
		user_id = $("#user_id").val();
		if(user_id=="") {
			if($("#user_name").val()==""||$("#user_email").val()==""||$("#user_password").val()=="") {
				$("#payment_error").html("Please enter your details");
				return;
			}
			var re = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/
			if (!re.test($("#user_email").val())){
				$("#payment_error").html("Please enter valid email!");
				return;
			}
		}
		
		if(payment_getway == "stripe"){
		 
			if($('#card_num').val() == ''){
				$("#payment_error").html("Please enter the Card Number!");
				return false;
			}else if($('#cvc').val() == ''){
				$("#payment_error").html("Please enter the Security Code!");
				return false;
			}
			else{
				$("#stripe_form").attr("action",base_url + "stripe/check")
				$('#stripe_form').submit();
			}

		}
		if(payment_getway == "paypal"){
			// $("#user_name").val()==""||$("#user_email").val()==""||$("#user_password").val()==""
			$("#pay_user_name").val($("#user_name").val());
			$("#pay_email").val($("#user_email").val());
			$("#pay_password").val($("#user_password").val());

			$("#paypal_form").attr("action",base_url + "paypal/create_payment_with_paypal")
			$("#paypal_form").submit();
		}

		
		$("#payment_error").html("");

	})
	$("#payment_window input[type='radio']").click(function(){
		$("#payment_window input[type='radio']").removeAttr("checked");
		$(this).prop("checked",true);
	})
	$("#view_login").click(function(){
		$(".visible").removeClass("visible");
		$("#login_window").addClass("visible");
		$("#login_error").css("display","none");
	})

	$("#forgot_view").click(function(){
		$(".visible").removeClass("visible");
		$("#s_error").css('display',"none");

		$("#forgot_window").addClass("visible");
	})

	$("#view_register").click(function(){
		$(".visible").removeClass("visible");
		$("#register_window").addClass("visible");
	})

	$(".for-login").click(function(e){
		if(e.target != this) return;
		$(".visible").removeClass("visible");
	});
	$("#login_btn").click(function(){
		$.ajax({
			url: base_url + "maker/loginAjax",
			data: {"email": $("#login_email").val(),"password":$("#login_password").val(),"content": $("#canvas_window").html(), "title": $("input[name='title-input']").val(), "subtitle": $("input[name='subtitle-input']").val() },
			dataType:"json",
			type:"post",
			success: function(res){
				if(res.status == "ok"){
					$("#login_form").submit();
				} 
				else {
					$("#login_error").css("display","block");
				}
			}
		})
	});

	$("#register_btn").click(function(){
		user_name = $("#r_user_name").val();
		email = $("#r_email").val();
		password = $("#r_password").val();
		r_password = $("#r_r_password").val();
		$("#register_error").css("display","block");

		if(user_name==""||email==""||password==""||r_password==""){
			$("#register_error").html("Please enter all fields!");
			return;
		}
		
		var re = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/
		if (!re.test(email)){
			$("#register_error").html("Please enter valid email!");
			return;
		}
		if(password!=r_password){
			$("#register_error").html("Password no match!");
			return;	
		}
		$.ajax({
			url: base_url + "maker/creatUser",
			data:{"user_name":user_name, "password":password, "email":email },
			dataType:"json",
			type: "post",
			success: function(res){
				if(res.status == "error"){
					$("#register_error").html("Email is registerd already! <span id='view_login' style='cursor: pointer; color:red; font-weight:bold; '>Login Here</span>");
					return;
				} else {
					$("#register_error").html("<span style='color:green'>Successfully Created! <span id='view_login' style='cursor: pointer; color:red; font-weight:bold; '>Login Here</span>");

				}
			}
		})
	})


	$("body").on("click","#view_login,#go_login",function(){
		$(".visible").removeClass("visible");
		$("#login_window").addClass("visible");
		$("#login_error").css("display","none");
	})

	$("#user_profile").click(function(){
		$("#profile_item").fadeToggle();
	})

	$("#canvas_window").click(function(e){
		if(e.target != this) return;
		$("#profile_item").fadeOut();	
	})

	$("#update_view").click(function(){
		$("#update_error").css("display","none");
		$(".visible").removeClass("visible");
		$.ajax({
			url:base_url + "maker/getUserData",
			data:{"id":$("#user_id").val()},
			type:"post",
			dataType: "json",
			success: function(res){
				$("#u_user_name").val(res.data.user_name);
				$("#u_email").val(res.data.email);
				$("#u_password").val("");
				$("#r_u_password").val("");
				$("#update_window").addClass("visible");
			}
		})
	})
	$("#update_btn").click(function(){
		user_name = $("#u_user_name").val();
		email = $("#u_email").val();
		password = $("#u_password").val();
		r_password = $("#r_u_password").val();
		$("#update_error").css("display","block");

		if(user_name==""||email==""){
			$("#update_error").html("Please enter user name and email fields!");
			return;
		}
		
		var re = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/
		if (!re.test(email)){
			$("#update_error").html("Please enter valid email!");
			return;
		}
		if(password!="" && password!=r_password){
			$("#update_error").html("Password no match!");
			return;	
		}
		$.ajax({
			url: base_url + "maker/updateUser",
			data:{"id": $("#user_id").val(),"user_name":user_name, "password":password, "email":email },
			dataType:"json",
			type: "post",
			success: function(res){
				if(res.status == "error"){
					$("#update_error").html("");
				} else {
					$("#update_error").html("<span style='color:green'>Successfully Updated! Please Log In again.</span>");
				}
			}
		})

	})

	$("#send_link").click(function(){
		email = $("#s_email").val();
		password = $("#s_password").val();
		$.ajax({
			url: base_url + "maker/sendConfirm",
			data:{"email":email,"password":password},
			dataType:"json",
			type:"post",
			success: function(res){
				$("#s_error").css('display',"block");
				if(res.status == "ok"){
					$("#s_error").html("Please check on your email inbox and click confirm link.");
				}	 else if(res.status == "error") {
					$("#s_error").html("email is not registered.");
				}	else if(res.status == "no")			{
					$("#s_error").html("Sending error! please try again");
				}
			}
		})
	})

	
})