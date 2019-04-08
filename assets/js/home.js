var PM = {
	option : {
		
	},
	init: function(){
		PM.option.str_index = 0;
		PM.option.flg = 0;
		PM.option.symbol_count = 0;
		PM.option.icon_slug = "";
		PM.option.icon_offset = 0;
		PM.option.siderbar_width = 270;
		 
		setTimeout(PM.showTitle,2000);	

		PM.bindEvents();
	},
	bindEvents: function(){
		$("#company_name").click(function(){
			if(PM.option.flg == 2) return;
			$("#company_name").val("");
			PM.option.flg = 2;
		})
		$("#company_name").keypress(function(){

			if(PM.option.flg == 2 && $("#company_name").val()!="") 
				$(".submit").addClass("enabled");
			else 
				$(".submit").removeClass("enabled");

		})

		$(".submit").click(function(){
			if($(this).hasClass("enabled"))
				document.location.replace("main.php");
				$("#first_form").submit();
		})

		$("input[type='radio']").click(function(){
			$("#user_lang").val($(this).val());
			$("#lang_form").submit();
		})

	},
	 
	showTitle : function(){
		if(PM.option.flg == 2) $("#company_name").val(""); 
		if(PM.option.flg == 2) return;
		company_name = "COMPANY NAME";
		$("#company_name").val(company_name.substring(0,PM.option.str_index));
		if(PM.option.flg == 0)  PM.option.str_index++;
		if(PM.option.str_index == 13 && PM.option.flg == 0) {
			PM.option.flg = 1;
			setTimeout(PM.showTitle,2000);
			return;

		}
		if(PM.option.flg == 1) PM.option.str_index--;
		if(PM.option.str_index<0) PM.option.flg = 2;
		if(PM.option.flg == 2) return;
		

		setTimeout(PM.showTitle,200);
	},

}

$(function(){
	PM.init();
})

 