$('document').ready(function(){

 if( typeof ($.fn.DataTable) === 'undefined'){ return; }
	 
	 
	var $datatable = $('#dispute-table');

	$datatable.dataTable({
	  'order': [[ 1, 'asc' ]],
	});
	$datatable.on('draw.dt', function() {
	  $('input[type="checkbox"]').iCheck({
		checkboxClass: 'icheckbox_flat-green'
	  });
	});

	// $('#datatable-checkbox_length').closest("div").removeClass("col-sm-6");
	obj = $('#dispute-table_length').closest(".col-sm-6");
	obj.addClass("col-sm-3");

	// TableManageButtons.init();
	$('body').on('click','.click-tr',function(){
		$('.tr-active').removeClass("tr-active");
		obj = $(this);
		$(this).addClass("tr-active");
		id = $(this).data('id');
		disputeUser = $(this).data("disputeuser");
		client_name = $(this).find(".client_name").text();
		author_name = $(this).find(".author_name").text();
		$('#user_name').html("Dispute between "+ client_name + " and " + author_name);
		$.ajax({
			url:BASE_URL+"dispute/getDisputeDetail",
			data:{"dispute_id":id},
			dataType:'html',
			type:"post",
			success:function(res){
				$("#dispute_show").html(res);
			}
		})
		
	})

	$('body').on("click",".btn-cyan",function(){
		if($('#dispute_status').val()!="1"){
			return;
		}
		$('#dispute_status').val($(this).data("status"));
		$('.btn-cyan').removeClass("active");
		$(this).addClass("active");
		status = $(this).data("status");
		$.ajax({
			url:BASE_URL+"dispute/solveDispute",
			data:{"dispute_id":$('#dispute_id').val(),"status":status},
			dataType:'json',
			type:"post",
			success:function(res){
				
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
	 
	
 
})