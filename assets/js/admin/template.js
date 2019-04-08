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

	$('body').on('click','.action_btn',function(){
		var flg = $(this).data('flg');
		obj = $(this).closest('tr');
		$('#sure_btn').show();
		$('#action_error').html('');
		$('#action_error').hide('');
		var title = obj.find('.template-name').text();
		$('input[type="text"]').removeAttr("disabled");
		$('textarea').removeAttr("disabled");
		$('select').removeAttr("disabled");
		if(flg == undefined) {
			$('#sure_btn').hide();
			$('input[type="text"]').attr("disabled","disabled");
			$('textarea').attr("disabled","disabled");
			$('select').attr("disabled","disabled");

		}

		if(flg == "delete"){
			title = title_1+"?";
		}
		if(flg == "edit"){
			title = title_2+"?";
		}

		if(flg == "create")
			title = title_3+"?";
		$('#flg').val(flg);
		$('#workingTime').val(3).change();
		$('#sure_btn').html(flg);
		if(flg=="edit")$('#sure_btn').html("save");
		$('#action_title').html(title);
		if(flg == "create"){
			$('input[type="text"]').val("");
			$('textarea').val("");
			$('option[value="1"]').prop("selected",true);
			$('#action_modal').modal();	
		} else {
			$('#template_id').val(obj.data('id'));
			$.ajax({
				url:BASE_URL+"order/getTemplateData",
				data: {"id": $('#template_id').val()},
				type:'post',
				dataType:'json',
				success: function(res){
					if(res.result == "ok"){
					 	$('#templateName').val(res.template.templateName);
					 	$('#orderDescription').val(res.template.orderDescription);
					 	$('#orderTitle').val(res.template.orderTitle);
					 	$('#wordmax').val(res.template.wordmax);
					 	$('#wordmin').val(res.template.wordmin);
					 	$('#workingTime').val(res.template.workingTime).change();
						$('option[value="'+res.template.categoryId+'"]').prop("selected",true);
						$('#action_modal').modal();	
					}
				}
			})
		}
		

	})

	$('#workingTime').rangeslider({
            // Deactivate the feature detection
            polyfill: false,
            // Callback function
            onInit: function() {
            },
            // Callback function
            onSlide: function(position, value) {
                $('#time_show').html(value);
            },
    });

	$('body').on('click','#sure_btn',function(){
		var data = {};
		data['flg'] = $('#flg').val();
		data['template_id'] = $('#template_id').val();

		obj = $("tr[data-id='"+$('#template_id').val()+"']");
		
		data['templateName'] = $('#templateName').val();
	 	data['orderDescription'] = $('#orderDescription').val();
	 	data['orderTitle'] = $('#orderTitle').val();
	 	data['wordmax'] = $('#wordmax').val();
	 	data['wordmin'] = $('#wordmin').val();
	 	data['workingTime'] = $('#workingTime').val()
		data['categoryId'] = $('#categoryId').val();

		var error = "";
		if(data['templateName']=="") error += "You have to enter template name. please try again.<br/>";
		if(!/^\d*$/.test(data['wordmax'])||!/^\d*$/.test(data['wordmin'])) 
			error += "You have to enter only number in word count field. please try again.<br/>";
		
		if(data['wordmin']*1>data['wordmax']*1)
			error += "Max word count have to bigger than min word count always. please try again.<br/>";

		if(data['flg'] == "delete"){
			if(data['isEmail']=="no") error = "";
		}
		if(error!=""){
			$('#action_error').html(error);
			$('#action_error').fadeIn();		
			return;		
		}
		
		$.ajax({
			url:BASE_URL+"order/orderTemplateAction",
			data: data,
			type:'post',
			dataType:'html',
			success: function(res){
				 $('body').append('<div data-notify="container" class="col-xs-11 col-sm-4 alert alert-success animated fadeInDown" role="alert" data-notify-position="top-right" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out; z-index: 2000; top: 20px; right: 20px;"><button type="button" aria-hidden="true" class="close" data-notify="dismiss" style="position: absolute; right: 10px; top: 5px; z-index: 2002;" data-dismiss="alert">×</button><span data-notify="icon"></span> <span data-notify="title"><strong></strong></span> <span data-notify="message">Successly Process !</span><a href="#" target="_blank" data-notify="url"></a></div>');
	             setTimeout(function(){
	                $('.alert-success').fadeOut(500);
	                $('.alert-success').remove();

	             },5000)

	             if(data['flg'] == "create"){
	             	$("#template_body").append(res);
	             }
	             if(data['flg'] == "edit"){
	             	obj.html(res);
	             }
	             if(data['flg'] == "delete"){
	             	obj.remove();
	             }
	             $('button[data-dismiss="modal"]').click();
			}
		})
	})
})