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
		// PM.getIcons();
		h1 = $(".search").offset().top;
		h2 = $(".save-button").offset().top;
		$("#show_icons").css("height",h2-h1-80);
		$("#search-input").focus();
		// $("#search_window").addClass("visible");
		
		PM.option.setElement = "";
		PM.option.init_icon = $("#show_icons").html();
		canvas_width = $("#canvas_window").width();
		canvas_height = $("#canvas_window").height();

		symbol_width = $('#symbol')[0].getBoundingClientRect().width;
		symbol_height = $('#symbol')[0].getBoundingClientRect().height;

		// alert(canvas_width);
		PM.option.symbol_scale_x = 1.6;
		PM.option.symbol_scale_y = 1.6;
		symbol_left = (canvas_width - symbol_width)/2;
		symbol_top = (canvas_height - symbol_width-100)/2;
		$("#symbol").attr("transform","translate("+symbol_left+" "+symbol_top+") scale("+PM.option.symbol_scale_x+" "+PM.option.symbol_scale_y+")");

		$("#title text").text($("input[name='title-input']").val());
		title_width = $('#title')[0].getBoundingClientRect().width;
		title_height = $('#title')[0].getBoundingClientRect().height;
		title_left = (canvas_width - title_width)/2;
		title_top = symbol_top + symbol_height+20;

		PM.option.title_scale_x = 1;
		PM.option.title_scale_y= 1;
		$("#title").attr("transform","translate("+title_left+" "+title_top+") scale("+PM.option.title_scale_x+" "+PM.option.title_scale_y+")");
		
		// $("#subtitle text").text($("input[name='title-input']").val());
		subtitle_width = $('#subtitle')[0].getBoundingClientRect().width;
		subtitle_left = (canvas_width - subtitle_width)/2;
		subtitle_top = symbol_top + symbol_height +title_height+20;
		PM.option.subtitle_scale_x = 1;
		PM.option.subtitle_scale_y = 1;

		PM.option.symbol_rate_x = 1.6;
		PM.option.symbol_rate_y = 1.6;

		PM.option.title_rate_x = 1;
		PM.option.title_rate_y = 1;

		PM.option.subtitle_rate_x = 1;
		PM.option.subtitle_rate_y = 1;


		$("#subtitle").attr("transform","translate("+subtitle_left+" "+subtitle_top+") scale("+PM.option.subtitle_scale_x+" "+PM.option.subtitle_scale_y+")");
		PM.bindEvents();
		PM.showSvg();

		setTimeout(PM.showTitle,2000);	


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

		$(".click-over").click(function(){
			$(".search-overlay").removeClass("visible");
		})
		$(".search-button").click(function(e){
			e.preventDefault();
			$("#search-input").focus();
 			$("#search_window").addClass("visible");
		})

		$(".search-submit").click(function(){
			PM.option.icon_slug = $(".search-input").val();
			PM.option.icon_offset = 0;
			PM.option.search_flg = 1;
			PM.getIcons();

			$("#search_window").removeClass("visible");
			if($(".search-input").val() == "") 
				$(".clear-button").css("visibility","hidden");
			else 
				$(".clear-button").css("visibility","unset");

		})


		$(".search-input").keypress(function(e){
			if (e.keyCode == 13) {
			    PM.option.icon_slug = $(".search-input").val();
				PM.option.icon_offset = 0;
				PM.option.search_flg = 1;

				PM.getIcons();
				$("#search_window").removeClass("visible");
				if($(".search-input").val() == "") 
					$(".clear-button").css("visibility","hidden");
				else 
					$(".clear-button").css("visibility","unset");
			}
		})
		$(".clear-button").click(function(){
			$(".clear-button").css("visibility","hidden");
			$(".search-input").val("");
			PM.option.search_flg = 0;
			PM.option.icon_slug = $(".search-input").val();
			PM.option.icon_offset = 0;
			// PM.getIcons();
		})
		$("body").on("click","#category_list>li",function(){
			$(".li-checked").removeClass("li-checked");
			$(this).addClass("li-checked");
			
			PM.option.category_id = $(this).data("id");
			PM.option.search_flg = 0;
			PM.getIcons();
		
		})

		$("body").on("click",".show_svg",function(){

			str = $(this).html();
			str_index = str.indexOf("viewBox");
			sub_str = str.substr(str_index+9,30).split(" ");
			scale = 200/sub_str[2];

			xx = 0; yy = 0;
			$(this).find("svg").find("path").each(function(){
				if($(this)[0].getBoundingClientRect().width > xx) xx = $(this)[0].getBoundingClientRect().width;
				if($(this)[0].getBoundingClientRect().width > yy) yy = $(this)[0].getBoundingClientRect().height;
			})
			$(this).find("svg").find("g").each(function(){
				if($(this)[0].getBoundingClientRect().width > xx) xx = $(this)[0].getBoundingClientRect().width;
				if($(this)[0].getBoundingClientRect().width > yy) yy = $(this)[0].getBoundingClientRect().height;
			})
			xx = 100 - xx;
			yy = 100 - yy;

			// if(PM.option.setElement.indexOf("symbol")>=0) { 
			// 	ele = $(this).find("svg").html();
			// // ele.replace("translate(25px, 25px)","translate(0px, 0px)");
			// 	$("#" + PM.option.setElement).html(ele);
			// 	$("#" + PM.option.setElement).attr("data-xx",xx);
			// 	$("#" + PM.option.setElement).attr("data-yy",yy);
			// 	$("#" + PM.option.setElement).attr("data-scale",scale);
			// 	translate = $("#" + PM.option.setElement).attr("transform");
			// 	sx = translate.indexOf("translate");
			// 	ex = translate.indexOf("scale");
			// 	sub_trans = translate.substr(sx,ex-sx);
			// 	$("#" + PM.option.setElement).attr("transform",sub_trans + " scale("+scale+","+scale+")");

			// 	$("#" + PM.option.setElement+">g").css("transform","translate(0px, 0px) scale(1)");

			// 	scale_left = $("#"+PM.option.setElement)[0].getBoundingClientRect().left;
			// 	scale_top = $("#"+PM.option.setElement)[0].getBoundingClientRect().top;
			// 	scale_width = $("#"+PM.option.setElement)[0].getBoundingClientRect().width;
			// 	scale_height = $("#"+PM.option.setElement)[0].getBoundingClientRect().height;
			// 	$(".focused").css("left",scale_left-PM.option.siderbar_width);
			// 	$(".focused").css("top",scale_top);

			// 	$(".focused").css("width",scale_width);
			// 	$(".focused").css("height",scale_height);
			// } else {

				ele = $(this).find("svg").html();
				PM.option.symbol_count ++; 
				symbol_id = 'symbol'+PM.option.symbol_count; 
				$("#canvas_window>#after_ele").after('<g data-xx="'+xx+'" data-scale="'+scale+'" data-yy="'+yy+'" class="logo-entity" id="'+symbol_id+'" transform="translate(736.5, 26) scale('+scale+","+scale+')"></g>')

				$("#" +symbol_id).html(ele);
				$("#" +symbol_id+">g").css("transform","translate(0px, 0px) scale(1)");
				arr_ele = "";

				arr_ele += '<div class="transformer" data-id="'+symbol_id+'" style="position: absolute; left: 678.242px; top: 223px; width: 276.516px; height: 97px; display: none;">';
				arr_ele += '<div class="anchor" data-direction="nw"></div>';
                arr_ele += '<div class="anchor" data-direction="ne"></div>';
                arr_ele += '<div class="anchor" data-direction="sw"></div>';
				arr_ele += '<div class="anchor" data-direction="se"></div>';
				arr_ele += '<div class="anchor-rotate" data-direction="nw"></div>';
                arr_ele += '<div class="anchor-rotate" data-direction="ne"></div>';
                arr_ele += '<div class="anchor-rotate" data-direction="sw"></div>';
                arr_ele += '<div class="anchor-rotate" data-direction="se"></div>';
    			arr_ele += '</div>';
    			$(".settings-canvas").after(arr_ele);

    			$(".canvas-wrapper-inner").html($(".canvas-wrapper-inner").html());
			// }
			
			$(".symbol").removeClass("visible");
			PM.showSvg();
		})

		$("body").on("mousedown", "#canvas_window > g", function(e){
			$(".fontlist").css("display","none");

			obj = $(this);

			$(".focused").css("display","none");
			$(".focused").removeClass("focused");
			
			$("div[data-id='"+$(this).attr('id')+"']").css("display","inherit");
			$("div[data-id='"+$(this).attr('id')+"']").addClass("focused");

			
			PM.option.setElement = $(this).attr("id");
			if(PM.option.setElement.indexOf("symbol")>=0){

			} else {

				$(".visible").removeClass("visible");
				$("." + PM.option.setElement ).addClass("visible");
				$("." + PM.option.setElement).find(".static").css("display","none");
				ww = $("." + PM.option.setElement )[0].getBoundingClientRect().width;
				$("." + PM.option.setElement ).css("left",($("#canvas_window").width() - ww)/2+PM.option.siderbar_width);
			}

			scale_left = $("#"+PM.option.setElement)[0].getBoundingClientRect().left;

			scale_top = $("#"+PM.option.setElement)[0].getBoundingClientRect().top;

			scale_width = $("#"+PM.option.setElement)[0].getBoundingClientRect().width;
			scale_height = $("#"+PM.option.setElement)[0].getBoundingClientRect().height;

			$(".focused").css("left",scale_left-PM.option.siderbar_width);
			$(".focused").css("top",scale_top);
			$(".focused").css("width",scale_width);
			$(".focused").css("height",scale_height);
			
			PM.option.mouseMoveFlg = 1;
			PM.option.mouseStartx = e.pageX;
			PM.option.mouseStarty = e.pageY;

			PM.option.scale_left = scale_left;
			PM.option.scale_top = scale_top;
			PM.option.scale_width = scale_width;
			PM.option.scale_height = scale_height;

			if(PM.option.setElement.indexOf("symbol")>=0){
				str = $("#" + PM.option.setElement)	.attr("transform");
				str_s = str.indexOf("scale(");
				
				PM.option.symbol_scale_x = str.substr(str_s+6).split(" ")[0];
				PM.option.symbol_scale_y = str.substr(str_s+6).split(" ")[0];
			}

			PM.showSvg();

		})


		$("body").on("mousedown",".anchor",function(e){
			
			// $("#"+PM.option.setElement).css("transform-origin","center");

			PM.option.mouseFlg = 1;
			PM.option.direction =  $(this).data("direction");
			PM.option.scale_left = $(".focused")[0].getBoundingClientRect().left;
			PM.option.scale_top = $(".focused")[0].getBoundingClientRect().top;
			PM.option.scale_width = $(".focused")[0].getBoundingClientRect().width;
			PM.option.scale_height = $(".focused")[0].getBoundingClientRect().height;

			
		})

		$("body").on("mousedown",".anchor-rotate",function(e){
			if(e.target != this) return;
			// $("#"+PM.option.setElement).css("transform-origin","center");

			PM.option.mouseRotateFlg = 1;
			PM.option.direction =  $(this).data("direction");
			// alert();
		})

		$("body").on("mouseup",function(){
			
			PM.option.mouseFlg = 0;
			PM.option.mouseMoveFlg = 0;
			PM.option.mouseRotateFlg = 0;

			if(PM.option.rate_x){


				if(PM.option.setElement == "title"){
					PM.option.title_scale_x = PM.option.title_rate_x;
					PM.option.title_scale_y = PM.option.title_rate_y;
				}
				if(PM.option.setElement == "subtitle"){
					PM.option.subtitle_scale_x = PM.option.subtitle_rate_x;
					PM.option.subtitle_scale_y = PM.option.subtitle_rate_y;
				}
				if(PM.option.setElement.indexOf("symbol")>=0){
					 PM.option.symbol_scale_x = PM.option.rate_x;
					 PM.option.symbol_scale_y = PM.option.rate_y;
				}

			}

			

		});

		 

		$("body").on("mousemove",function(e){

			if(PM.option.mouseMoveFlg == 1){
				xx = e.pageX - PM.option.mouseStartx;
				yy = e.pageY - PM.option.mouseStarty;

				scale_left = PM.option.scale_left+xx;
				scale_top = PM.option.scale_top+yy;

				$(".focused").css("left",scale_left-PM.option.siderbar_width);
				$(".focused").css("top",scale_top);
				PM.fillContent();


			}
			if(PM.option.mouseFlg == 1){
				
				rate =  PM.option.scale_height/PM.option.scale_width;
				if(PM.option.direction == "nw"){
					scale_left = e.pageX;
					scale_top = PM.option.scale_top + (e.pageX - PM.option.scale_left ) * rate;

					scale_width = PM.option.scale_left - scale_left + PM.option.scale_width;
					scale_height = PM.option.scale_top - scale_top + PM.option.scale_height;

					if(scale_width < 0) scale_width = 0;
					if(scale_height < 0) scale_height = 0;

					if(scale_left>(PM.option.scale_left+PM.option.scale_width))  scale_left = (PM.option.scale_left+PM.option.scale_width);
					if(scale_top>(PM.option.scale_top+PM.option.scale_height))  scale_top = (PM.option.scale_top+PM.option.scale_height);
				}

				if(PM.option.direction == "ne"){

					scale_left = PM.option.scale_left;
					scale_width =  e.pageX -  PM.option.scale_left;
					scale_height = scale_width * rate;

					// scale_top = e.pageY;
					scale_top = PM.option.scale_top - scale_height + PM.option.scale_height;

					

					if(scale_width < 0) scale_width = 0;
					if(scale_height < 0) scale_height = 0;

					if(scale_left>(PM.option.scale_left+PM.option.scale_width))  scale_left = (PM.option.scale_left+PM.option.scale_width);
					if(scale_top>(PM.option.scale_top+PM.option.scale_height))  scale_top = (PM.option.scale_top+PM.option.scale_height);
				}
				
				if(PM.option.direction == "sw"){
					scale_left = e.pageX;
					scale_top = PM.option.top;

					scale_width = PM.option.scale_left - scale_left + PM.option.scale_width;
					scale_height = scale_width * rate;

					if(scale_width < 0) scale_width = 0;
					if(scale_height < 0) scale_height = 0;

					if(scale_left>(PM.option.scale_left+PM.option.scale_width))  scale_left = (PM.option.scale_left+PM.option.scale_width);
					if(scale_top>(PM.option.scale_top+PM.option.scale_height))  scale_top = (PM.option.scale_top+PM.option.scale_height);
				}

				if(PM.option.direction == "se"){
					scale_left = PM.option.left;
					scale_top = PM.option.top;
					
					scale_width =  e.pageX -  PM.option.scale_left;
					scale_height = scale_width * rate;

					if(scale_width < 0) scale_width = 0;
					if(scale_height < 0) scale_height = 0;

					if(scale_left>(PM.option.scale_left+PM.option.scale_width))  scale_left = (PM.option.scale_left+PM.option.scale_width);
					if(scale_top>(PM.option.scale_top+PM.option.scale_height))  scale_top = (PM.option.scale_top+PM.option.scale_height);
				}



				$(".focused").css("left",scale_left-PM.option.siderbar_width);
				$(".focused").css("top",scale_top);

				$(".focused").css("width",scale_width);
				$(".focused").css("height",scale_height);
				PM.fillContent();
			}

			if(PM.option.mouseRotateFlg == 1){
				$("#"+PM.option.setElement).css("ratate","45deg");
			}
		});


		$("input[name='title-input']").keyup(function(){
			$("#title text").text($(this).val());
			if(PM.option.setElement == "title"){
				scale_left = $("#"+PM.option.setElement)[0].getBoundingClientRect().left;
				scale_top = $("#"+PM.option.setElement)[0].getBoundingClientRect().top;

				scale_width = $("#"+PM.option.setElement)[0].getBoundingClientRect().width;
				scale_height = $("#"+PM.option.setElement)[0].getBoundingClientRect().height;

				$(".focused").css("left",scale_left-PM.option.siderbar_width);
				$(".focused").css("top",scale_top);
				$(".focused").css("width",scale_width);
				$(".focused").css("height",scale_height);
			}
			PM.showSvg();
		})

		$("input[name='subtitle-input']").keyup(function(){

			$("#subtitle text").text($(this).val());

			if(PM.option.setElement == "subtitle"){
				scale_left = $("#"+PM.option.setElement)[0].getBoundingClientRect().left;
				scale_top = $("#"+PM.option.setElement)[0].getBoundingClientRect().top;

				scale_width = $("#"+PM.option.setElement)[0].getBoundingClientRect().width;
				scale_height = $("#"+PM.option.setElement)[0].getBoundingClientRect().height;

				$(".focused").css("left",scale_left-PM.option.siderbar_width);
				$(".focused").css("top",scale_top);
				$(".focused").css("width",scale_width);
				$(".focused").css("height",scale_height);
			}
			PM.showSvg();

		})

		$('body').on('click',"#canvas_window", function(e) {
		  	if (e.target !== this)
		    	return;
		  	// alert(e.target);

		    PM.option.setElement = "";

			$(".focused").css("display","none");
			$(".focused").removeClass("focused");
			$(".fontlist").css("display","none");

			$(".visible").removeClass("visible");
			$(".static").css("display","none");

		});

		$(".fontlist li").click(function(){
			$(".fontlist li.selected").removeClass("selected");
			
			font_family = $(this).data("value");
			$(this).closest("section").find(".value").html(font_family);
			$(this).addClass("selected");
			$(this).closest("aside").find("span").css("font-family",font_family);
			$("#"+PM.option.setElement).find("text").css("font-family",font_family);
			scale_left = $("#"+PM.option.setElement)[0].getBoundingClientRect().left;
			scale_top = $("#"+PM.option.setElement)[0].getBoundingClientRect().top;

			scale_width = $("#"+PM.option.setElement)[0].getBoundingClientRect().width;
			scale_height = $("#"+PM.option.setElement)[0].getBoundingClientRect().height;

			$(".focused").css("left",scale_left-PM.option.siderbar_width);
			$(".focused").css("top",scale_top);
			$(".focused").css("width",scale_width);
			$(".focused").css("height",scale_height);
			PM.showSvg();

		})
		$(".font-family .value-wrapper").click(function(){
			$(this).closest("section").find("ul").css("display","inherit");
			$(this).closest("section").find("ul").css("visibility","inherit");
			$(this).closest("section").find("ul").css("opacity","1");
		})

		$(".font-weight .value span").click(function(){
			if($(this).closest(".value").data("value") == "regular"){
				$(this).closest(".value").data("value","bold");

			} else {
				$(this).closest(".value").data("value","regular");
			}
			font_weight =  $(this).closest(".value").data("value");
			$(this).html(font_weight.charAt(0).toUpperCase() + font_weight.slice(1));

			if(font_weight == "regular") font_weight = "normal";
			$(this).css("font-weight",font_weight);
			$("#"+PM.option.setElement).find("text").css("font-weight",font_weight);

			scale_left = $("#"+PM.option.setElement)[0].getBoundingClientRect().left;
			scale_top = $("#"+PM.option.setElement)[0].getBoundingClientRect().top;

			scale_width = $("#"+PM.option.setElement)[0].getBoundingClientRect().width;
			scale_height = $("#"+PM.option.setElement)[0].getBoundingClientRect().height;

			$(".focused").css("left",scale_left-PM.option.siderbar_width);
			$(".focused").css("top",scale_top);
			$(".focused").css("width",scale_width);
			$(".focused").css("height",scale_height);
			PM.showSvg();

		})

		$(".font-style .value span").click(function(){
			if($(this).closest(".value").data("value") == "regular"){
				$(this).closest(".value").data("value","italic");

			} else {
				$(this).closest(".value").data("value","regular");
			}
			font_weight =  $(this).closest(".value").data("value");
			$(this).html(font_weight.charAt(0).toUpperCase() + font_weight.slice(1));

			if(font_weight == "regular") font_weight = "normal";
			$(this).css("font-style",font_weight);
			$("#"+PM.option.setElement).find("text").css("font-style",font_weight);

			scale_left = $("#"+PM.option.setElement)[0].getBoundingClientRect().left;
			scale_top = $("#"+PM.option.setElement)[0].getBoundingClientRect().top;

			scale_width = $("#"+PM.option.setElement)[0].getBoundingClientRect().width;
			scale_height = $("#"+PM.option.setElement)[0].getBoundingClientRect().height;

			$(".focused").css("left",scale_left-PM.option.siderbar_width);
			$(".focused").css("top",scale_top);
			$(".focused").css("width",scale_width);
			$(".focused").css("height",scale_height);
			PM.showSvg();

		})

		$(".value-box")	.click(function(){
			$(this).closest(".value-wrapper").find(".color-picker-custom").removeClass("color-picker-custom");

			$(this).closest(".value-wrapper").find(".static").toggle();
		})
		var container = document.querySelector('.subtitle-font-color'),
		picker = new CP(container, false, container);
		picker.self.classList.add('static');
    	picker.set("#000000");
		picker.enter();
		picker.on("change", function(color) {
	   		$(".subtitle-font-color").closest(".value-wrapper").find("input").val("#" + color);
	   		$(".subtitle-font-color").closest(".value-wrapper").find("span").css("background-color","#" + color);
	   		$("#"+PM.option.setElement).find("text").attr("fill","#" + color);
			PM.showSvg();

		});

		var container1 = document.querySelector('.title-font-color'),
		picker1 = new CP(container1, false, container1);
		picker1.self.classList.add('static');
    	picker1.set("#000000");
		picker1.enter();
		picker1.on("change", function(color) {
	   		$(".title-font-color").closest(".value-wrapper").find("input").val("#" + color);
	   		$(".title-font-color").closest(".value-wrapper").find("span").css("background-color","#" + color);
	   		$("#"+PM.option.setElement).find("text").attr("fill","#" + color);
			PM.showSvg();
	   		
		});

		var container2 = document.querySelector('.symbol-fill-color'),
		picker2 = new CP(container2, false, container2);
		picker2.self.classList.add('static');
    	picker2.set("#000000");
		picker2.enter();
		picker2.on("change", function(color) {
	   		
	   		$(".symbol-fill-color").closest(".value-wrapper").find("input").val("#" + color);
	   		$(".symbol-fill-color").closest(".value-wrapper").find("span").css("background-color","#" + color);
	   		PM.option.obj.attr("fill","#" + color);
			PM.showSvg();
	   		
		});

		var container3 = document.querySelector('.symbol-first-color'),
		picker3 = new CP(container3, false, container3);
		picker3.self.classList.add('static');
    	picker3.set("#000000");
		picker3.enter();
		picker3.on("change", function(color) {
	   		
	   		$(".symbol-first-color").closest(".value-wrapper").find("input").val("#" + color);
	   		$(".symbol-first-color").closest(".value-wrapper").find("span").css("background-color","#" + color);
	   		// PM.option.obj.attr("fill","#" + color);
	   		gradient_id = PM.option.obj.data("gradient_id");
	   		$("#"+gradient_id+" .first_value").css("stop-color","#" + color);
			PM.showSvg();
	   		
		});

		var container4 = document.querySelector('.symbol-last-color'),
		picker4 = new CP(container4, false, container4);
		picker4.self.classList.add('static');
    	picker4.set("#000000");
		picker4.enter();
		picker4.on("change", function(color) {
	   		
	   		$(".symbol-last-color").closest(".value-wrapper").find("input").val("#" + color);
	   		$(".symbol-last-color").closest(".value-wrapper").find("span").css("background-color","#" + color);
	   		gradient_id = PM.option.obj.data("gradient_id");
	   		$("#"+gradient_id+" .last_value").css("stop-color","#" + color);
			PM.showSvg();
		});



		$(".canvas-wrapper").on("click","path,rect,circle,polygon",function(){

			obj = $(this);
			PM.option.obj = obj;
			
			$(".symbol").find(".static").css("display","none");

			if(!obj.attr("fill")) obj.attr("fill","#000000");

			if(obj.attr("fill").indexOf("url")>=0){

				$(".symbol section").css("display","inline-block");
				$(".symbol .fill-color").css("display","none");
				$("#gradient_co").prop("checked","checked");
				first_co = $("#"+obj.data("gradient_id")+" .first_value").css("stop-color");
				last_co = $("#"+obj.data("gradient_id")+" .last_value").css("stop-color");

				rgb = first_co.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);

				function hex(x) {
			        return ("0" + parseInt(x).toString(16)).slice(-2);
			    }
			    first_co =  "#" + hex(rgb[1]) + hex(rgb[2]) + hex(rgb[3]);

				rgb = last_co.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
				last_co =  "#" + hex(rgb[1]) + hex(rgb[2]) + hex(rgb[3]);


				$(".first-color input").val(first_co);
				$(".last-color input").val(last_co);

				$(".first-color .value-box").css("background-color",first_co);
				$(".last-color .value-box").css("background-color",last_co);

			} else {
				$(".symbol section").css("display","inline-block");
				$(".symbol .border-color").css("display","none");
				$("#solid_co").prop("checked","checked");

				$(".fill-color input").val(obj.attr('fill'));
				$(".fill-color .value-box").css("background-color",obj.attr('fill'));
			}
			$(".visible").removeClass("visible");
			$(".symbol").addClass("visible");
			// $(".").find(".static").css("display","none");
			ww = $(".symbol")[0].getBoundingClientRect().width;
			$(".symbol").css("left",($("#canvas_window").width() - ww)/2+PM.option.siderbar_width);

		})

		$("body").on("click","input[name='fill_color_style']",function(){
			if($(this).val() == "solid") {
				$(".symbol section").css("display","inline-block");
				$(".symbol .border-color").css("display","none");
				PM.option.obj.attr("fill", $(".symbol .fill-color input[type='text']").val());

			} else {
				$(".symbol section").css("display","inline-block");
				$(".symbol .fill-color").css("display","none");
				parent_id = PM.option.obj.closest(".logo-entity").attr("id");
				child_index = PM.option.obj.index();
				gradient_id = parent_id + "_" + child_index;
				if(!PM.option.obj.data("gradient_id")) {

					PM.option.obj.attr("data-gradient_id",gradient_id);
					ele = "";
					ele += '<linearGradient id="'+gradient_id+'" gradientUnits="objectBoundingBox" x1="0.5" y1="0" x2="0.5" y2="1">'; 
					ele += '<stop class="first_value" offset="0" style="stop-color:#ff0000"></stop>'; 
					ele += '<stop class="last_value" offset="1" style="stop-color:#00ff00"></stop>'; 
					ele += '</linearGradient>'; 

					PM.option.obj.before(ele);
					PM.option.obj.attr("fill","url(#"+gradient_id+")");

				}
				gradient_id = PM.option.obj.data("gradient_id"); 
				PM.option.obj.attr("fill","url(#"+gradient_id+")");

				first_co = $("#" + gradient_id + " .first_value").css("stop-color");
				last_co = $("#" + gradient_id + " .last_value").css("stop-color");
				rgb = first_co.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);

				function hex(x) {
			        return ("0" + parseInt(x).toString(16)).slice(-2);
			    }
			    first_co =  "#" + hex(rgb[1]) + hex(rgb[2]) + hex(rgb[3]);

				rgb = last_co.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
				last_co =  "#" + hex(rgb[1]) + hex(rgb[2]) + hex(rgb[3]);


				 

				$(".first-color input[type='text']").val(first_co);
				$(".last-color input[type='text']").val(last_co);

				$(".first-color .value-box").css("background-color",first_co);
				$(".last-color .value-box").css("background-color",last_co);
				$(".canvas-wrapper-inner").html($(".canvas-wrapper-inner").html());

			}

			ww = $(".symbol")[0].getBoundingClientRect().width;
			$(".symbol").css("left",($("#canvas_window").width() - ww)/2+PM.option.siderbar_width);
			PM.showSvg();

		})

		$("body").on("click",".remove-symbol",function(){
			symbol_id = PM.option.obj.closest(".logo-entity").attr("id");

			PM.option.obj.closest(".logo-entity").remove();
			$("div[data-id='"+symbol_id+"']").remove();
			PM.showSvg();
		})

		$(".preview").on("click","section",function(){
			if($(this).hasClass("cta-wrapper")) return;
			$(".preview_sub").removeClass("preview_sub");

			$(this).closest(".preview").addClass("expanded");
			index = $(this).index();
			$(this).closest(".inner").attr("style",'transform: translateX(-'+(index*100)+'%); transition: all 0.6s cubic-bezier(0.86, 0, 0.07, 1) 0s; display: block;');
			PM.showSvg1();
			if(index == 0) {
				$(".preview-controls .paginate-right").css({"visibility":"unset", "opacity":"1"});
				$(".preview-controls .paginate-left").css({"visibility":"hidden", "opacity":"0"});
				
			}
			if(index == 1) {
				$(".preview-controls .paginate-right").css({"visibility":"unset", "opacity":"1"});
				$(".preview-controls .paginate-left").css({"visibility":"unset", "opacity":"1"});
				
			}
			if(index == 2) {
				$(".preview-controls .paginate-left").css({"visibility":"unset", "opacity":"1"});
				$(".preview-controls .paginate-right").css({"visibility":"hidden", "opacity":"0"});
				
			}
			PM.option.preview_index = index;
		})
		
		$(".preview-controls").on("click","button",function(){
			if($(this).hasClass("close")){
				return;
			}
			index = PM.option.preview_index;
			if($(this).hasClass("paginate-left")){
				index -- ;
				if(index == -1) index = 2;
			}
			if($(this).hasClass("paginate-right")){
				index ++ ;
				if(index == 3) index = 0;
			}
			if(index == 0) {
				$(".preview-controls .paginate-right").css({"visibility":"unset", "opacity":"1"});
				$(".preview-controls .paginate-left").css({"visibility":"hidden", "opacity":"0"});
				
			}
			if(index == 1) {
				$(".preview-controls .paginate-right").css({"visibility":"unset", "opacity":"1"});
				$(".preview-controls .paginate-left").css({"visibility":"unset", "opacity":"1"});
				
			}
			if(index == 2) {
				$(".preview-controls .paginate-left").css({"visibility":"unset", "opacity":"1"});
				$(".preview-controls .paginate-right").css({"visibility":"hidden", "opacity":"0"});
				
			}

			PM.option.preview_index = index;
			$(this).closest(".preview ").find(".inner").attr("style",'transform: translateX(-'+(index*100)+'%); transition: all 0.6s cubic-bezier(0.86, 0, 0.07, 1) 0s; display: block;');


		})
		$(".close").click(function(){
			$(".expanded .inner").removeAttr("style");

			$(".expanded").addClass("preview_sub");
			$(".expanded").removeClass("expanded");
			PM.showSvg();

		});

		$("#more_icon").click(function(){
			PM.option.icon_offset ++; 
			PM.getIcons();
		})

		$("body").on("click",".fullscreen-toggle",function(){

			$("#logomark").toggleClass("editor-expanded");
			if(PM.option.siderbar_width == 270) {

				$("#canvas_window > .logo-entity").each(function(){
					transform = $(this).attr("transform");
					// translate(816.5, 305) scale(1,1)
					sx = transform.indexOf("(");
					ex = transform.indexOf(") ");
					st = transform.substr(sx+1,ex-sx-1);
					st_arr = st.split(" ");
					sub_x = st_arr[0]*1 + 135*1 ;
					sub_y = st_arr[1]*1 + 115*1 ;
					str = "translate(" + sub_x + " " + sub_y +  transform.substr(ex);
					$(this).attr("transform",str);
					// console.log(transform);
					// console.log(str);
				})

				PM.option.siderbar_width = 0; 
			}
			else {

				$("#canvas_window > .logo-entity").each(function(){
					transform = $(this).attr("transform");
					// translate(816.5, 305) scale(1,1)
					sx = transform.indexOf("(");
					ex = transform.indexOf(") ");
					st = transform.substr(sx+1,ex-sx-1);
					st_arr = st.split(" ");
					sub_x = st_arr[0] - 135 ;
					sub_y = st_arr[1] - 115 ;
					str = "translate(" + sub_x + " " + sub_y +  transform.substr(ex);
					$(this).attr("transform",str);
					// console.log(transform);
					// console.log(str);
				})


				PM.option.siderbar_width = 270; 
			}

		})

		
	 	$("#save_logo").click(function(){
			 var doctype = '<?xml version="1.0" standalone="no"?>'
			  + '<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">';

			// serialize our SVG XML to a string.
			var source = (new XMLSerializer()).serializeToString(d3.select('#canvas_window').node());

			// create a file blob of our SVG.
			var blob = new Blob([ doctype + source], { type: 'image/svg+xml;charset=utf-8' });

			var url = window.URL.createObjectURL(blob);
			var img = d3.select('body').append('img')
			 .attr('width', "100%")
			 .attr('height', "100%")
			 .attr('id','remove_img')
			 .attr('style',"border:1px solid red;")
			 .node();


			img.onload = function(){
			  // Now that the image has loaded, put the image into a canvas element.
			  var canvas = d3.select('body').append('canvas').attr('style',"border:1px solid red;").node();
			  canvas_w = $("#canvas_window")[0].getBoundingClientRect().width;
			  canvas_h = $("#canvas_window")[0].getBoundingClientRect().height;
			  
			  canvas.width = 5000;
			  canvas.height = 5000*canvas_h/canvas_w;
			  var ctx = canvas.getContext('2d');
			  
			  ctx.drawImage(img, 0, 0, canvas_w ,canvas_h ,0,0, 5000, 5000*canvas_h/canvas_w);
			  var canvasUrl = canvas.toDataURL("image/png");
			  triggerDownload(canvasUrl);
			}
			// start loading the image.
			img.src = url;


		    function triggerDownload (imgURI) {
		      var evt = new MouseEvent('click', {
		        view: window,
		        bubbles: false,
		        cancelable: true
		      });

		      var a = document.createElement('a');
		      a.setAttribute('download', 'MY_COOL_IMAGE.png');
		      a.setAttribute('href', imgURI);
		      a.setAttribute('target', '_blank');
		      a.dispatchEvent(evt);
		      $("#remove_img").remove();
		      $("canvas").remove();
		    }


		})

	},
	fillContent : function(){
		obj = $("#" + PM.option.setElement);
		scale_width = $(".focused")[0].getBoundingClientRect().width;
		scale_height = $(".focused")[0].getBoundingClientRect().height;

		scale_left = $(".focused")[0].getBoundingClientRect().left-PM.option.siderbar_width;
		scale_top = $(".focused")[0].getBoundingClientRect().top;

		if(PM.option.setElement.indexOf("symbol")>=0){

			scale_rate_x = PM.option.symbol_scale_x;
			scale_rate_y = PM.option.symbol_scale_y;
		}


		if(PM.option.setElement == "title"){
			scale_rate_x = PM.option.title_scale_x;
			scale_rate_y = PM.option.title_scale_y;
		}
		if(PM.option.setElement == "subtitle"){
			scale_rate_x = PM.option.subtitle_scale_x;
			scale_rate_y = PM.option.subtitle_scale_y;
		}

		rate_x = scale_rate_x  * scale_width/PM.option.scale_width;
		rate_y = scale_rate_y  * scale_height/PM.option.scale_height;

		if(PM.option.setElement.indexOf("symbol")>=0){
			PM.option.symbol_rate_x = rate_x;
			PM.option.symbol_rate_y = rate_y;
		}

		if(PM.option.setElement == "title"){
			PM.option.title_rate_x = rate_x;
			PM.option.title_rate_y = rate_y;
		}
		if(PM.option.setElement == "subtitle"){
			PM.option.subtitle_rate_x = rate_x;
			PM.option.subtitle_rate_y = rate_y;
		}

		PM.option.rate_x = rate_x;
		PM.option.rate_y = rate_y;
		
		xx = obj.data("xx");
		yy = obj.data("yy");
		scale = obj.data("scale");

		xx = xx*1;
		yy = yy*1;
		scale = scale * 1;

		if(xx!=0&&xx) scale_left -= xx/scale *rate_x;
		if(yy!=0&&yy) scale_top -= yy/scale*rate_y;

		transform="translate("+scale_left+" "+scale_top+") scale("+rate_x+" "+rate_y+") rotate(45 10 10)" ;
		obj.attr("transform",transform);
		PM.showSvg();
	},
	showSvg : function(){

		svg_ele = $("#canvas_window").html();
		$(".wrapper svg").html(svg_ele);
		max_x = 0;
		max_y = 0;
		min_x = $("#canvas_window").width();
		min_y = $("#canvas_window").height();

		$("#canvas_window .logo-entity").each(function(){
			if($(this)[0].getBoundingClientRect().width != 0 && $(this)[0].getBoundingClientRect().height != 0) {
				if(min_x > $(this)[0].getBoundingClientRect().left)  min_x = $(this)[0].getBoundingClientRect().left; 
				if(min_y > $(this)[0].getBoundingClientRect().top)  min_y = $(this)[0].getBoundingClientRect().top; 
				if(max_x < $(this)[0].getBoundingClientRect().right)  max_x = $(this)[0].getBoundingClientRect().right; 
				if(max_y < $(this)[0].getBoundingClientRect().bottom)  max_y = $(this)[0].getBoundingClientRect().bottom; 
			}

		})

		width = max_x - min_x;
		height = max_y - min_y;

 		$(".wrapper").each(function(){
			div_width = $(this)[0].getBoundingClientRect().width;
			div_height = $(this)[0].getBoundingClientRect().height;

			div_width1 = $(this).width();
			div_height1 = $(this).height();

			$(this).find(".logo-entity").attr("id","");

			$(this).find(".canvas").width(width);
			$(this).find(".canvas").height(height);
			$(this).find(".canvas").css("transform","scale(1)");
			canvas_width = $(this).find(".canvas")[0].getBoundingClientRect().width;
			canvas_height = $(this).find(".canvas")[0].getBoundingClientRect().height;

			rate_x = div_width/canvas_width;
			rate_y = div_height/canvas_height;

			// console.log("rate_x " + rate_x);
			// console.log("rate_y " + rate_y);
			// console.log("width " + width);
			// console.log("div_width " + div_width);
			// console.log("div_width1 " + div_width1);


			if(rate_x>rate_y) 
				$(this).find(".canvas").css("transform","translate(0px, 0px) scale("+rate_y+")");
			else
				$(this).find(".canvas").css("transform","translate(0px, 0px) scale("+rate_x+")");

		 
			$(this).find(".canvas").find(".logo-entity").each(function(){
				transform = $(this).attr("transform");
				// translate(816.5, 305) scale(1,1)
				sx = transform.indexOf("(");
				ex = transform.indexOf(") ");
				st = transform.substr(sx+1,ex-sx-1);
				st_arr = st.split(" ");
				sub_x = st_arr[0] - min_x +PM.option.siderbar_width;
				sub_y = st_arr[1] - min_y;
				str = "translate(" + sub_x + " " + sub_y +  transform.substr(ex);
				$(this).attr("transform",str);
				// console.log(transform);
				// console.log(str);
			})

		})


	},
	showSvg1 : function(){

		svg_ele = $("#canvas_window").html();
		$(".wrapper svg").html(svg_ele);
 		
		max_x = 0;
		max_y = 0;
		min_x = $("#canvas_window").width();
		min_y = $("#canvas_window").height();
		$("#canvas_window .logo-entity").each(function(){
			if($(this)[0].getBoundingClientRect().width != 0 && $(this)[0].getBoundingClientRect().height != 0) {
				if(min_x > $(this)[0].getBoundingClientRect().left)  min_x = $(this)[0].getBoundingClientRect().left; 
				if(min_y > $(this)[0].getBoundingClientRect().top)  min_y = $(this)[0].getBoundingClientRect().top; 
				if(max_x < $(this)[0].getBoundingClientRect().right)  max_x = $(this)[0].getBoundingClientRect().right; 
				if(max_y < $(this)[0].getBoundingClientRect().bottom)  max_y = $(this)[0].getBoundingClientRect().bottom; 
			}

		})

		center_x = ( $("#canvas_window").width()/2 + PM.option.siderbar_width - (max_x-min_x)/2 - min_x);
		center_y = ( $("#canvas_window").height()/2 - (max_y-min_y)/2 - min_y);

		min_x = PM.option.siderbar_width;
		min_y = 0;
		max_x = $("#canvas_window").width();
		max_y = $("#canvas_window").height();
		 
		width = max_x - min_x+PM.option.siderbar_width;
		height = max_y - min_y;
 		$(".wrapper").each(function(){
			div_width = $(this)[0].getBoundingClientRect().width;
			div_height = $(this)[0].getBoundingClientRect().height;
			$(this).find(".logo-entity").attr("id","");

			$(this).find(".canvas").width(width);
			$(this).find(".canvas").height(height);
			$(this).find(".canvas").css("transform","scale(1)");
			canvas_width = $(this).find(".canvas")[0].getBoundingClientRect().width;
			canvas_height = $(this).find(".canvas")[0].getBoundingClientRect().height;

			rate_x = div_width/canvas_width;
			rate_y = div_height/canvas_height;
			if(rate_x>rate_y) 
				$(this).find(".canvas").css("transform","scale("+rate_y+")");
			else
				$(this).find(".canvas").css("transform","scale("+rate_x+")");

		 
			$(this).find(".canvas").find(".logo-entity").each(function(){
				transform = $(this).attr("transform");
				// translate(816.5, 305) scale(1,1)
				sx = transform.indexOf("(");
				ex = transform.indexOf(") ");
				st = transform.substr(sx+1,ex-sx-1);
				st_arr = st.split(" ");
				sub_x = st_arr[0] - min_x +PM.option.siderbar_width + center_x;
				sub_y = st_arr[1] - min_y + center_y;
				// sub_x = st_arr[0] - min_x +PM.option.siderbar_width;
				// sub_y = st_arr[1] - min_y ;
				str = "translate(" + sub_x + " " + sub_y +  transform.substr(ex);
				$(this).attr("transform",str);
				// console.log(transform);
				// console.log(str);
			})

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
	getIcons: function(){
		// ln = "";
		if(PM.option.icon_slug!=""){ 
			ln = $("input[name='ln_flg']:checked").val();
			if(ln == "fr"){ 
				$.ajax({
					url:"https://translate.googleapis.com/translate_a/single?client=gtx&sl=fr&tl=en&hl=en-US&dt=t&dt=bd&dj=1&q=" + $("#search-input").val(),
					async:false,
					success:function(res){
						// console.log(res.sentences[0].trans);
						PM.option.icon_slug = res.sentences[0].trans;
					}	
				})
 			}
 		}

		$.ajax({
			url: base_url + "/home/get_icons",
			dataType: "json",
			type: "post",
			data:{"icon_slug": PM.option.icon_slug,"category_id": PM.option.category_id,"search_flg":PM.option.search_flg},
			beforeSend: function(){
				// $("#show_icons").css("opacity",0.5);
				// $("#show_icons").css("background-color","#e8e8e8");
				// $("#loading_img").show();
			},
			success: function(res){
				icon_datas = res.icons;								
				$("#icon_list").html("");

				for(i=0; i<icon_datas.length; i++){
					url = icon_datas[i].file_name;
					$("#icon_list").append("<li class='show_svg'> <img style='width:auto; height:100px; ' src='"+base_url + "assets/icons/" + url+"' onload='SVGInject(this)' /></li>");
				}

				if(PM.option.search_flg == 1){
					top_y = $(".search-button").offset().top - $(".category-window ")[0].getBoundingClientRect().top+14;
					str = 'top:'+top_y+'px';
					$("#div_title").html("Searching icons for <span style='color:red; font-weight:700;'>"+PM.option.icon_slug+"</span>");
				} else {
					top_y = $(".li-checked").offset().top - $(".category-window ")[0].getBoundingClientRect().top+14;
					str = 'top:'+top_y+'px';
					$("#div_title").html("<span style='color:red; font-weight:700;'>"+$(".li-checked").html()+"</span> Icons");

				}
				if(icon_datas.length == 0) $("#icon_list").append("<li style='width:100% !important; '>There are no any icons.</li>");
				document.styleSheets[6].addRule('.category-window:before',str);
				$("#category_window").addClass("visible"); 
			},
			complete: function(){
				// console.log("end");
				// $("#show_icons").css("opacity",1);
				// $("#show_icons").css("background-color","white");
				// $("#loading_img").hide();

			}
		});
		}

}

$(function(){
	PM.init();
})

$( window ).resize(function() {
 	h1 = $(".search").offset().top;
	h2 = $(".save-button").offset().top;
	$("#show_icons").css("height",h2-h1-80);
});

