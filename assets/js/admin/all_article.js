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
			url:BASE_URL+"article/articleList",
			data:{"idUser":id},
			dataType:'html',
			type:"post",
			success:function(res){
				$('#article_list_show').html(res);
				$('#article-table').dataTable({
				  'order': [[ 1, 'asc' ]],
				});
				$('#client_name').html(obj.find(".click-td:first-child").html()+"'s Articles");
				obj = $('#article-table_length').closest(".col-sm-6");
				obj.addClass("col-sm-5");
			}
		})
		
	})

	$('body').on("click",".click-tr",function(){

		id = $(this).data('id');
		$.ajax({
			url:BASE_URL+"article/articleDetail",
			data:{"idArticle":id},
			dataType:'html',
			type:"post",
			success:function(res){
				 $('#article_detail').html(res);
				 $('#article_detail').modal();

			}
		})
	})
	
	$('body').on('click','.remove_btn',function(){
		$('#remove_modal').modal();
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
	
 
})