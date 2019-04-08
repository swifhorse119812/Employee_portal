$('document').ready(function(){

 if( typeof ($.fn.DataTable) === 'undefined'){ return; }
	 
	 
	var $datatable = $('#deposit_list');

	$datatable.dataTable({
	  'order': [[ 1, 'asc' ]],
	});
	 

	// $('#datatable-checkbox_length').closest("div").removeClass("col-sm-6");
	obj = $('#dispute-table_length').closest(".col-sm-6");
	obj.addClass("col-sm-3");

	 
	$('body').on('click','.action_btn',function(){
		var flg = $(this).data('flg');
		var msg_to = $(this).closest('tr').find('.user-email').text();
		 
		msg_to = msg_to.trim();
		$('#withdraw_id').val($(this).closest('tr').data('id'));
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
		data['user_id'] = $('#withdraw_id').val();
		data['isEmail'] = $("input[type='radio']:checked").val();
		data['msg_subject'] = $('#msg_subject').val();
		data['msg_body'] = $('#msg_body').val();
		obj = $("tr[data-id='"+$('#user_id').val()+"']");
		var error = "";

		if(data['msg_subject']=="") error += "You have to enter subject. please try again.";
		if(data['msg_body']=="") error += "<br/>You have to enter content. please try again.";

		if(data['flg'] == "withdraw"){
			if(data['isEmail']=="no") error = "";
		}
		if(data['flg'] == "creidt"&& !/^[+-]?(?=.)(?:\d+,)*\d*(?:\.\d+)?$/.test($('#amount').val())){
			error += "<br/>You have to enter only number in amount field.";
		}
		if(error!=""){
			$('#action_error').html(error);
			$('#action_error').fadeIn();		
			return;		
		}
		if(data['flg'] == "creidt") data['amount'] = $('#amount').val();
		obj = $("tr[data-id='"+data['user_id']+"']");
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
                     var str = "Activate";
                     switch(data['flg']){
                     	case "withdraw" : str = "Complete"; break;
                     	break;
                     }
                     obj.find(".user-status").text(str);
                     obj.find("button").remove();
                     
                     
				}
			}
		})
	})
	
 
})