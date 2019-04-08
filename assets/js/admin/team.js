$('document').ready(function(){

 if( typeof ($.fn.DataTable) === 'undefined'){ return; }
	 
	 
	var $datatable = $('#datatable-checkbox');

	$datatable.dataTable({
	  'order': [[ 1, 'asc' ]],
	   'columnDefs': [
		{ orderable: false, targets: [3] }
	  ]
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
			url:BASE_URL+"order/teamList",
			data:{"idUser":id},
			dataType:'html',
			type:"post",
			success:function(res){
				$('#order_list_show').html(res);
				$('#order-table').dataTable({
				  'order': [[ 1, 'asc' ]],
				  'columnDefs': [
					{ orderable: false, targets: [3] }
				  ]
				});
				$('#client_name').html(obj.find(".click-td:first-child").html()+"'s Teams");
				obj = $('#order-table_length').closest(".col-sm-6");
				obj.addClass("col-sm-5");
			}
		})
		
	})

	$('body').on("click",".team-select",function(){

		id = $(this).closest("tr").data('id');

		$.ajax({
			url:BASE_URL+"order/teamDetail",
			data:{"id":id},
			dataType:'html',
			type:"post",
			success:function(res){
				 $('#order_detail').html(res);
				
				$('#author-table').dataTable({
				  'order': [[ 1, 'asc' ]],
				});

				$('#order-table1').dataTable({
				  'order': [[ 1, 'asc' ]],
				});

				 $('#order_detail').modal();

			}
		})
	})
	
	$('body').on('click','.remove_btn',function(){
		$('#remove_modal').modal();
	})

	$('body').on('click','.action_btn',function(){
	 
		var data = {};
		data['id'] = $(this).closest("tr").data("id");
		data['flg'] = $(this).data("flg");
		obj = $(this).closest("tr").find(".activate");
		$.ajax({
			url:BASE_URL+"order/activeTeam",
			data: data,
			type:'post',
			dataType:'json',
			success: function(res){
				if(res.result == "ok"){
					obj.html(res.str_status);
				}
			}
		})
	})
})