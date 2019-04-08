$('document').ready(function(){

 if( typeof ($.fn.DataTable) === 'undefined'){ return; }
	 
	 
	var $datatable = $('#datatable-checkbox');

	$datatable.dataTable({
	  'order': [[ 1, 'asc' ]],
	});
	$datatable.on('draw.dt', function() {
	  $('input[type="checkbox"]').iCheck({
		checkboxClass: 'icheckbox_flat-green'
	  });
	});

	// $('#datatable-checkbox_length').closest("div").removeClass("col-sm-6");
	obj = $('#datatable-checkbox_length').closest(".col-sm-6");
	obj.addClass("col-sm-5");

	// TableManageButtons.init();
	$('body').on('click','.click-td',function(){
		$('#show_error').fadeOut();
		$('#show_error').remove();
		$('.tr-active').removeClass("tr-active");
		obj = $(this).closest('tr');
		$(this).closest('tr').addClass("tr-active");
		id = $(this).closest('tr').data('id');
		name = $(this).closest('tr').find('.user-name').text();
		$.ajax({
			url:BASE_URL+"article/getFirstArticle",
			data:{"idUser":id},
			dataType:'json',
			type:"post",
			success:function(res){
				 if(name == "") name = "Author";
				 $('#author_name').html(name);
				 $('#wordCount').html(res.article['wordCount']);
				 $('#article_content').html(res.article['content']);
				 var code = "";

				 for(i=1; i<=res.article['rate']; i++){
				 	code += ' <span data-value="'+i+'" data-id="'+res.article['id']+'" class="rate fa fa-star" style="color:#ff4900; font-size:20px; cursor:pointer;" title="for rate of editors"></span> ';
				 }
				 for(i<=res.article['rate']+1; i<=5;  i++){
				 	code += ' <span data-value="'+i+'" data-id="'+res.article['id']+'" class="rate fa fa-star-o" style="color:#ff4900; font-size:20px; cursor:pointer;" title="for rate of editors"></span> ';
				 }
				 $('#article_rate').html(code);
				 $('#rate_show').html(res.article['rate']);

			}
		})
		
	})

	$('body').on('click','.rate',function(){
		id = $(this).data('id');
		if(id == "undefined") {
			ele = "<div id='show_error' style='position:fixed;z-index:1000; top:210px; right: 50px; width:280px; height:65px; background-color:#fbe1e1; color:#b70000; border:1px solid #757575; border-raduis:5px; padding:10px; display:none;'>Current There is no first artilce of author for verify. So you can't evaluation article.</div>"
			$('body').append(ele);
			$('#show_error').fadeIn();
			setTimeout(function(){
				$('#show_error').fadeOut();
				$('#show_error').remove();
			},3000)
			return;
		}
		rate = $(this).data("value");
		code = "";
		for(i=1; i<=rate; i++){
		 	code += ' <span data-value="'+i+'" data-id="'+id+'" class="rate fa fa-star" style="color:#ff4900; font-size:20px; cursor:pointer;" title="for rate of editors"></span> ';
		 }
		 for(i<=rate+1; i<=5;  i++){
		 	code += ' <span data-value="'+i+'" data-id="'+id+'" class="rate fa fa-star-o" style="color:#ff4900; font-size:20px; cursor:pointer;" title="for rate of editors"></span> ';
		 }
		 $('#article_rate').html(code);

		// if($(this).hasClass("fa-star-o")) {
		// 	$(this).removeClass("fa-star-o");
		// 	$(this).addClass("fa-star");
			
		// } else if($(this).hasClass("fa-star")) {
		// 	$(this).removeClass("fa-star");
		// 	$(this).addClass("fa-star-o");
		// }
		// var rate = 0;
	 
		$.ajax({
			url:BASE_URL+"article/setRate",
			data:{"idArticle":id,'rate':rate},
			dataType:'json',
			type:"post",
			success:function(res){
				 $('[data-id="'+res.idUser+'"]').find('.user-rate').html(res.code);
			}
		})
	})

	$('body').on("click",".click-tr",function(){

		id = $(this).data('id');
		$.ajax({
			url:BASE_URL+"order/orderDetail",
			data:{"idOrder":id},
			dataType:'html',
			type:"post",
			success:function(res){
				 $('#order_detail').html(res);
				 $('#order_detail').modal();
			}
		})
	})
	
	$('body').on('click','.remove_btn',function(){
		$('#remove_modal').modal();
	})

	$('body').on('click','.action_btn',function(){
		var flg = $(this).data('flg');
		var msg_to = $(this).closest('tr').find('.user-email').text();
		if(flg=="remove"){
			title = "Are you sure remove this account?";
			description = "You may be send email about reason of remove to this account email";
			$('#action_status').css('display','');
		}
		if(flg=="close"){
			title = "Are you sure close this account?";
			description = "You may be send email about reason of close to this account email";
			$('#action_status').css('display','');
		}
		if(flg=="message"){
			title = "Are you sure send message to this account?";
			description = "";
			msg_to = $(this).closest('tr').find('.user-name').text();
			$('#action_status').css('display','none');
		}
		if(flg=="mail"){
			title = "Are you sure send mail to this account email?";
			description = "";
			$('#action_status').css('display','none');
		}
		msg_to = msg_to.trim();
		$('#action_title').html(title);
		$('#action_description').html(description);
		$('#user_id').val($(this).closest('tr').data('id'));
		$('#msg_to').val(msg_to);
		$('#action_modal').modal();
		$('#msg_subject').val('');
		$('#msg_body').val('');
		$('#flg').val(flg);
		$('#action_error').css('display','none');
		$('#action_error').html("");
		$("input[type='radio']:first-child").prop("checked",true);
	})

	$('body').on('click','#sure_btn',function(){
		var data = {};
		data['flg'] = $('#flg').val();
		data['user_id'] = $('#user_id').val();
		data['isEmail'] = $("input[type='radio']:checked").val();
		data['msg_subject'] = $('#msg_subject').val();
		data['msg_body'] = $('#msg_body').val();
		obj = $("tr[data-id='"+$('#user_id').val()+"']");
		var error = "";
		if(data['msg_subject']=="") error += "You have to enter subject. please try again.";
		if(data['msg_body']=="") error += "<br/>You have to enter content. please try again.";

		if(data['flg'] == "remove"||data['flg'] == "close"){
			if(data['isEmail']=="no") error = "";
		}
		if(error!=""){
			$('#action_error').html(error);
			$('#action_error').fadeIn();		
			return;		
		}
		
		$.ajax({
			url:BASE_URL+"user/userAction",
			data: data,
			type:'post',
			dataType:'json',
			success: function(res){
				if(res.result == "ok"){
					 $('body').append('<div data-notify="container" class="col-xs-11 col-sm-4 alert alert-success animated fadeInDown" role="alert" data-notify-position="top-right" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out; z-index: 2000; top: 20px; right: 20px;"><button type="button" aria-hidden="true" class="close" data-notify="dismiss" style="position: absolute; right: 10px; top: 5px; z-index: 2002;" data-dismiss="alert">×</button><span data-notify="icon"></span> <span data-notify="title"><strong></strong></span> <span data-notify="message">Successly Process !</span><a href="#" target="_blank" data-notify="url"></a></div>');
                     setTimeout(function(){
                        $('.alert-success').fadeOut(500);
                        $('.alert-success').remove();

                     },5000)

                     $('button[data-dismiss="modal"]').click();
				}
			}
		})
	})
})