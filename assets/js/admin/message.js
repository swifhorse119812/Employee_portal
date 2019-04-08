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
		$('.tr-active').removeClass("tr-active");
		obj = $(this).closest('tr');
		$(this).closest('tr').addClass("tr-active");
		id = $(this).closest('tr').data('id');
		$.ajax({
			url:BASE_URL+"message/messageList",
			data:{"idUser":id,'userType':$('#userType').val()},
			dataType:'html',
			type:"post",
			success:function(res){
				$('#message_list_show').html(res);
				$('#message-table').dataTable({
				  'order': [[ 1, 'asc' ]],
				});
				obj = $('#message-table_length').closest(".col-sm-6");
				obj.addClass("col-sm-5");
			}
		})
		
	})

	$('body').on("click",".click-tr",function(){
		id = $(this).data('id');
		$.ajax({
			url:BASE_URL+"message/messageHistory",
			data:{"idMessage":id,'userType':$('#userType').val() },
			dataType:'html',
			type:"post",
			success:function(res){
				 $('#message_detail').html(res);
				 $('#message_detail').modal();

			}
		})
	})
	
	$('body').on("click",".timeline-heading",function(){
		obj = $(this).find("i");
		if(obj.hasClass("fa-chevron-down")){
			obj.removeClass("fa-chevron-down");
			obj.addClass("fa-chevron-right");
		} else {
			obj.removeClass("fa-chevron-right");
			obj.addClass("fa-chevron-down");
		}
	})
	// $('body').on('click','.remove_btn',function(){
	// 	$('#remove_modal').modal();
	// })

	// $('body').on('click','.rate',function(){
	// 	id = $(this).data('id');
	// 	if(id == "undefined") {
	// 		ele = "<div id='show_error' style='position:fixed;z-index:1000; top:210px; right: 50px; width:280px; height:65px; background-color:#fbe1e1; color:#b70000; border:1px solid #757575; border-raduis:5px; padding:10px; display:none;'>Current There is no first artilce of author for verify. So you can't evaluation article.</div>"
	// 		$('body').append(ele);
	// 		$('#show_error').fadeIn();
	// 		setTimeout(function(){
	// 			$('#show_error').fadeOut();
	// 			$('#show_error').remove();
	// 		},3000)
	// 		return;
	// 	}
	// 	if($(this).hasClass("fa-star-o")) {
	// 		$(this).removeClass("fa-star-o");
	// 		$(this).addClass("fa-star");
			
	// 	} else if($(this).hasClass("fa-star")) {
	// 		$(this).removeClass("fa-star");
	// 		$(this).addClass("fa-star-o");
	// 	}
	// 	var rate = 0;
	// 	$('#article_rate .fa-star').each(function(){
	// 		rate++;
	// 	})
	// 	$.ajax({
	// 		url:BASE_URL+"article/setRate",
	// 		data:{"idArticle":id,'rate':rate},
	// 		dataType:'json',
	// 		type:"post",
	// 		success:function(res){
	// 			 $('[data-id="'+res.idUser+'"]').find('.user-rate').html(res.code);
	// 		}
	// 	})
	// })
	
 
})