$('document').ready(function(){

 if( typeof ($.fn.DataTable) === 'undefined'){ return; }
	 
	 
	var $datatable = $('#datatable-checkbox');

	$datatable.dataTable({
	  'order': [[ 1, 'asc' ]],
	  'columnDefs': [
		{ orderable: false, targets: [8] }
	  ]
	});
	$datatable.on('draw.dt', function() {
	  $('input[type="checkbox"]').iCheck({
		checkboxClass: 'icheckbox_flat-green'
	  });
	});

	// TableManageButtons.init();
	$('body').on('click','.click-td',function(){
		id = $(this).closest('tr').data('id');
		$.ajax({
			url:BASE_URL+"user/getUserDetail",
			data:{"idUser":id,'type':'author'},
			dataType:'html',
			type:"post",
			success:function(res){
				$('#create-new-message').html(res);
				$('#create-new-message').modal();			
			}
		})
		
	})

	$('body').on('click','.click-td-balance',function(){
		id = $(this).closest('tr').data('id');
		$.ajax({
			url:BASE_URL+"user/getUserBalance",
			data:{"idUser":id,'type':'client'},
			dataType:'html',
			type:"post",
			success:function(res){
				$('#create-new-message').html(res);
				$('#create-new-message').modal();			
			}
		})
		
	})

	$('body').on('click','.click-td-article',function(){
		id = $(this).closest('tr').data('id');
		$.ajax({
			url:BASE_URL+"user/getUserArticle",
			data:{"idUser":id,'type':'client'},
			dataType:'html',
			type:"post",
			success:function(res){
				$('#create-new-message').html(res);
				$('#create-new-message').modal();			
			}
		})
		
	})
	
	$('body').on('click','.remove_btn',function(){
		$('#remove_modal').modal();
	})

	$('body').on('click','.action_btn',function(){
		var flg = $(this).data('flg');
		var msg_to = $(this).closest('tr').find('.user-email').text();
		// if(flg=="remove"){
		// 	title = "Are you sure remove this account?";
		// 	description = "You may be send email about reason of remove to this account email";
		// 	$('#action_status').css('display','');
		// }
		// if(flg=="close"){
		// 	title = "Are you sure close this account?";
		// 	description = "You may be send email about reason of close to this account email";
		// 	$('#action_status').css('display','');
		// }
		// if(flg=="susepend"){
		// 	title = "Are you sure susepend this account?";
		// 	description = "You may be send email about reason of susepend to this account email";
		// 	$('#action_status').css('display','');

		// }
		// if(flg=="creidt"){
		// 	title = "Are you sure creidt this account?";
		// 	description = "You may be send email about activate to this account email";
		// 	$('#action_status').css('display','');

		// }
		// if(flg=="activate"){
		// 	title = "Are you sure activate this account?";
		// 	description = "You may be send email about activate to this account email";
		// 	$('#action_status').css('display','');

		// }

		// if(flg=="mail"){
		// 	title = "Are you sure send mail to this account email?";
		// 	description = "";
		// 	$('#action_status').css('display','none');
		// }


		if(flg =="creidt") 
			$('#amount_show').show();

		if(flg=="remove"){
			title = Message_1+"?";
			description = Description_1;
			$('#action_status').css('display','');
		}
		if(flg=="close"){
			title = Message_2+"?";
			description = Description_2;
			$('#action_status').css('display','');
		}
		if(flg=="susepend"){
			title = Message_3+"?";
			description = Description_3;
			$('#action_status').css('display','');

		}
		if(flg=="creidt"){

			title = Message_4+"?";
			description = Description_4;
			$('#action_status').css('display','');

		}
		if(flg=="activate"){
 
			title = Message_5+"?";
			description = Description_5;

			$('#action_status').css('display','');

		}
		if(flg=="mail"){

			title = Message_6+"?";

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

		if(data['flg'] == "remove"||data['flg'] == "close"||data['flg'] == "susepend"||data['flg'] == "creidt"||data['flg'] == "activate"){
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
                     $('button[data-dismiss="modal"]').click();
                     var str = "Activate";
                     switch(data['flg']){
                     	case "susepend" : str = "Susepend"; break;
                     	case "remove" : str = "Removed"; break;
                     	case "close" : str = "Closed"; break;
                     	case "creidt" : str = "Activate"; break;
                     	break;
                     }
                     obj.find(".user-status").text(str);
                     
				}
			}
		})
	})
})