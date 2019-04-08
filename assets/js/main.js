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

		PM.option.title_scale_x = 1;
		PM.option.title_scale_y= 1;
		
		PM.option.subtitle_scale_x = 1;
		PM.option.subtitle_scale_y = 1;

		PM.option.symbol_rate_x = 1.6;
		PM.option.symbol_rate_y = 1.6;

		PM.option.title_rate_x = 1;
		PM.option.title_rate_y = 1;

		PM.option.subtitle_rate_x = 1;
		PM.option.subtitle_rate_y = 1;

		// PM.getIcons();
		$( "body" ).off( "keypress", "input[name='letter-spacing']");

		h1 = $(".search").offset().top;
		h2 = $(".save-button").offset().top;
		$("#show_icons").css("height",h2-h1-80);
		$("#search-input").focus();
		// $("#search_window").addClass("visible");
		
		PM.option.setElement = "";
		PM.option.init_icon = $("#show_icons").html();

	if($("#after_ele").data("start") == "1"){
		canvas_width = $("#canvas_window").width();
		canvas_height = $("#canvas_window").height();

		// symbol_width = $('#symbol')[0].getBoundingClientRect().width;
		// symbol_height = $('#symbol')[0].getBoundingClientRect().height;

		// // alert(canvas_width);
		// symbol_left = (canvas_width - symbol_width)/2;
		// symbol_top = (canvas_height - symbol_width-100)/2;
		// scale = $("#symbol").data("scale");
		// rotate_x = $("#symbol").data("rotate_x");
		// $("#symbol").attr("transform","translate("+symbol_left+", "+symbol_top+") scale("+scale+","+scale+") rotate(0,"+rotate_x+","+rotate_x+")");
		symbol_top = canvas_height/2; 
		symbol_height = 0;
		$("#title text").text($("input[name='title-input']").val());
		rotate_x = $('#title')[0].getBoundingClientRect().width/2;
		rotate_y = $('#title')[0].getBoundingClientRect().height/2;

		title_width = $('#title')[0].getBoundingClientRect().width;
		title_height = $('#title')[0].getBoundingClientRect().height;
		title_left = (canvas_width - title_width)/2;
		title_top = symbol_top + symbol_height+20;

		
		$("#title").attr("data-rotate_x",rotate_x);
		$("#title").attr("data-rotate_y",rotate_y);
		
		$("#title").attr("transform","translate("+title_left+", "+title_top+") scale("+PM.option.title_scale_x+","+PM.option.title_scale_y+") rotate(0,"+rotate_x+","+rotate_y+")");
		
		// $("#subtitle text").text($("input[name='title-input']").val());
		subtitle_width = $('#subtitle')[0].getBoundingClientRect().width;
		subtitle_left = (canvas_width - subtitle_width)/2;
		subtitle_top = symbol_top + symbol_height +title_height+20;



		rotate_x = $('#subtitle')[0].getBoundingClientRect().width/2;
		rotate_y = $('#subtitle')[0].getBoundingClientRect().height/2;
		$("#subtitle").attr("data-rotate_x",rotate_x);
		$("#subtitle").attr("data-rotate_y",rotate_y);
		
		$("#subtitle").attr("transform","translate("+subtitle_left+", "+subtitle_top+") scale("+PM.option.subtitle_scale_x+","+PM.option.subtitle_scale_y+") rotate(0,"+rotate_x+","+rotate_y+")");
		// $("#title").attr("transform","translate("+title_left+", "+title_top+") scale("+PM.option.title_scale_x+","+PM.option.title_scale_y+") rotate(0,"+rotate_x+","+rotate_y+")");
		$("#after_ele").attr("data-start","0");
		$("#after_ele").data("start","0");
	}

		PM.bindEvents();
		PM.showSvg();

		if($("#download_flg").val() == "1"){
			PM.downloadPng();
		}


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

		$(".click-over").click(function(e){
			if(e.target!=this) return;
			$(".search-overlay").removeClass("visible");
		})

		$("#payment_window").click(function(e){
			if(e.target!=this) return;
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
		$("body").on("click","#category_list li",function(){
			$(".li-checked").removeClass("li-checked");
			$(this).addClass("li-checked");
			
			PM.option.category_id = $(this).data("id");
			PM.option.search_flg = 0;
			PM.getIcons();
		
		})

		$("body").on("click",".copy",function(){

			ele = $("#"+PM.option.setElement).html();
			pos_x = $("#"+PM.option.setElement)[0].getBoundingClientRect().left + $("#"+PM.option.setElement)[0].getBoundingClientRect().width+30*1-PM.option.siderbar_width ;
			r_c = $("#"+PM.option.setElement).data("rotate_x");
			xx = $("#"+PM.option.setElement).data("xx");
			yy = $("#"+PM.option.setElement).data("yy");
			scale = $("#"+PM.option.setElement).data("scale");
			transform = $("#"+PM.option.setElement).attr("transform");
			s1 = transform.substr(10,transform.indexOf(")")-10).split(",");
			s2 = "translate("+(s1[0]*1 + $("#"+PM.option.setElement)[0].getBoundingClientRect().width+30*1)+","+s1[1]+") " + transform.substr(transform.indexOf("scale"));
			transform = s2;
			PM.option.symbol_count ++; 
			symbol_id = 'symbol'+PM.option.symbol_count; 
			$("#canvas_window>#after_ele").before('<g data-rotate_x = "'+r_c+'" data-xx="'+xx+'" data-scale="'+scale+'" data-yy="'+yy+'" class="logo-entity" id="'+symbol_id+'" transform="'+transform+'"></g>')

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

		})

		$(".up").click(function(){
			ele_index = $("#" + PM.option.setElement).index()
			ele_id = $(".logo-entity").eq(ele_index).attr("id");
			if(ele_id == "end_ele") return;
			$("#" + PM.option.setElement).remove().insertAfter($('#'+ele_id));
		})
		$(".below").click(function(){
			ele_index = $("#" + PM.option.setElement).index()
			ele_id = $(".logo-entity").eq(ele_index-2).attr("id");
			if(!ele_id) return;
			if(ele_id == "after_ele") return;
			$("#" + PM.option.setElement).remove().insertBefore($('#'+ele_id));
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
				r_c = sub_str[2]/2;
				$("#canvas_window>#after_ele").before('<g data-rotate_x = "'+r_c+'" data-xx="'+xx+'" data-scale="'+scale+'" data-yy="'+yy+'" class="logo-entity" id="'+symbol_id+'" transform="translate(736.5, 26) scale('+scale+","+scale+') rotate(0,'+r_c+','+r_c+')"></g>')

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

				// $(".visible").removeClass("visible");
				// $("." + PM.option.setElement ).addClass("visible");
				// $("." + PM.option.setElement).find(".static").css("display","none");
				// ww = $("." + PM.option.setElement )[0].getBoundingClientRect().width;
				// $("." + PM.option.setElement ).css("left",($("#canvas_window").width() - ww)/2+PM.option.siderbar_width);
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
			PM.option.keyMoveFlg = 1;

			PM.option.mouseStartx = e.pageX;
			PM.option.mouseStarty = e.pageY;

			PM.option.scale_left = scale_left;
			PM.option.scale_top = scale_top;
			PM.option.scale_width = scale_width;
			PM.option.scale_height = scale_height;

			if(PM.option.setElement.indexOf("symbol")>=0){
				str = $("#" + PM.option.setElement)	.attr("transform");
				str_s = str.indexOf("scale(");
				
				PM.option.symbol_scale_x = str.substr(str_s+6).split(",")[0];
				PM.option.symbol_scale_y = str.substr(str_s+6).split(",")[0];
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
			str = $("#" + PM.option.setElement).attr("transform");
			rotate_str = str.substr(str.indexOf("rotate")+7,str.lastIndexOf(")")-str.indexOf("rotate")-7);
			rotate_ = rotate_str.split(",");
			PM.option.init_rotate = rotate_[0];
			
			PM.option.direction =  $(this).data("direction");

			PM.option.center_x = $(".focused")[0].getBoundingClientRect().left + $(".focused")[0].getBoundingClientRect().width/2;
			PM.option.center_y = $(".focused")[0].getBoundingClientRect().top + $(".focused")[0].getBoundingClientRect().height/2;
			PM.option.init_angle =Math.atan(Math.abs(e.pageX-PM.option.center_x)/Math.abs(e.pageY-PM.option.center_y));			
			PM.option.init_angle = PM.option.init_angle * 180/Math.PI;
			if(e.pageX>=PM.option.center_x && e.pageY>=PM.option.center_y) PM.option.init_angle = 360 - PM.option.init_angle;
			// if(e.pageX<PM.option.center_x && e.pageY>=PM.option.center_y) PM.option.init_angle = 180 - PM.option.init_angle;
			if(e.pageX<PM.option.center_x && e.pageY<PM.option.center_y) PM.option.init_angle = 180 - PM.option.init_angle;
			if(e.pageX>PM.option.center_x && e.pageY<PM.option.center_y) PM.option.init_angle = 180 + PM.option.init_angle;


			PM.option.angle_count = 1;
		})

		$("body").on("mouseup",function(){
			
			PM.option.mouseFlg = 0;
			PM.option.mouseMoveFlg = 0;
			// PM.option.mouseMoveFlg = 0;
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

		
		$("body").on("keydown",function(e){
			if(PM.option.keyMoveFlg != 1) return;
			$("input[name='letter-spacing']").focusout();
			$("input[name='letter-spacing']").blur();

			$("input[name='letter-spacing']").unbind("keydown");
			$("input[name='letter-spacing']").unbind("keypress");
			$("input[name='letter-spacing']").unbind("keyup");
			PM.option.scale_width = $("#"+PM.option.setElement)[0].getBoundingClientRect().width;
			PM.option.scale_height = $("#"+PM.option.setElement)[0].getBoundingClientRect().height;
			if(e.keyCode == 38){
				top_ = $(".focused")[0].getBoundingClientRect().top;
				top_ -= 2;
				if(top_<10) top_ = 10;
				$(".focused").css("top",top_);
				PM.fillContent();
				
			}
			if(e.keyCode == 40){
				top_ = $(".focused")[0].getBoundingClientRect().top;
				top_ += 2;
				// if(top_<10) top_ = 10;
				$(".focused").css("top",top_);
				PM.fillContent();
				
			}
			if(e.keyCode == 37){
				left_ = $(".focused")[0].getBoundingClientRect().left- PM.option.siderbar_width;
				left_ = left_ - 2*1;
				$(".focused").css("left",left_);
				PM.fillContent();
				
			}

			if(e.keyCode == 39){
				left_ = $(".focused")[0].getBoundingClientRect().left- PM.option.siderbar_width;
				left_ = left_ + 2*1;
				$(".focused").css("left",left_);
				PM.fillContent();
				
			}

		})

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
				// PM.option.init_rotate;
				angle_s = Math.atan(Math.abs(e.pageX - PM.option.center_x)/Math.abs(e.pageY - PM.option.center_y))*180/Math.PI;
		
				if(e.pageX>=PM.option.center_x && e.pageY>=PM.option.center_y) angle_s = 360 - angle_s;
				// if(e.pageX<PM.option.center_x && e.pageY>=PM.option.center_y) PM.option.init_angle = 180 - PM.option.init_angle;
				if(e.pageX<PM.option.center_x && e.pageY<PM.option.center_y) angle_s = 180 - angle_s;
				if(e.pageX>PM.option.center_x && e.pageY<PM.option.center_y) angle_s = 180 + angle_s;


				rotate_angle1 =  angle_s - PM.option.init_angle;
				if(rotate_angle1<0) rotate_angle1 += 360;
				// console.log("first_angle : " + PM.option.init_angle);
				// console.log("second_angle : " + angle_s);
				// console.log("angle  : " + rotate_angle1);

				rotate_angle = PM.option.init_rotate *1 + rotate_angle1;
				// if(rotate_angle<0) rotate_angle += 360;

				str = $("#" + PM.option.setElement).attr("transform");
				center_x = $("#" + PM.option.setElement).data("rotate_x");
				center_y = $("#" + PM.option.setElement).data("rotate_y");
				if(!center_y) center_y = center_x;
				transform = str.substr(0,str.indexOf("rotate")) + "rotate("+rotate_angle+","+center_x+","+center_y+")";
				$("#" + PM.option.setElement).attr("transform",transform);

				scale_left = $("#"+PM.option.setElement)[0].getBoundingClientRect().left;

				scale_top = $("#"+PM.option.setElement)[0].getBoundingClientRect().top;

				scale_width = $("#"+PM.option.setElement)[0].getBoundingClientRect().width;
				scale_height = $("#"+PM.option.setElement)[0].getBoundingClientRect().height;

				$(".focused").css("left",scale_left-PM.option.siderbar_width);
				$(".focused").css("top",scale_top);
				$(".focused").css("width",scale_width);
				$(".focused").css("height",scale_height);

			}
		});


		$("input[name='title-input']").keyup(function(){

			$("#title text").text($(this).val());
			
			$(".focused").css("display","none");
			$(".focused").removeClass("focused");
			
			$("div[data-id='title']").css("display","inherit");
			$("div[data-id='title']").addClass("focused");
			PM.option.setElement = "title";	
 
		 	PM.setBoard();
			PM.showSvg();
		})

		$("input[name='subtitle-input']").keyup(function(){
			PM.option.setElement = "subtitle";
			$("#subtitle text").text($(this).val());
			$(".focused").css("display","none");
			$(".focused").removeClass("focused");
			
			$("div[data-id='subtitle']").css("display","inherit");
			$("div[data-id='subtitle']").addClass("focused");
  
			PM.setBoard();
			PM.showSvg();

		})

		$('body').on('click',"#canvas_window", function(e) {
		  	if (e.target !== this)
		    	return;
		  	// alert(e.target);

		    PM.option.setElement = "";
		    PM.option.keyMoveFlg = 0;
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
			$("#"+PM.option.setElement).find("text").attr("font-family",font_family);

			scale_left = $("#"+PM.option.setElement)[0].getBoundingClientRect().left;
			scale_top = $("#"+PM.option.setElement)[0].getBoundingClientRect().top;

			scale_width = $("#"+PM.option.setElement)[0].getBoundingClientRect().width;
			scale_height = $("#"+PM.option.setElement)[0].getBoundingClientRect().height;

			PM.setBoard();
			PM.showSvg();

		})
		$(".font-family .value-wrapper").click(function(){
			$(this).closest("section").find("ul").css("display","inherit");
			$(this).closest("section").find("ul").css("visibility","inherit");
			$(this).closest("section").find("ul").css("opacity","1");
		})

		$(".font-weight .value span").click(function(){
			if($(this).closest(".value").data("value") == "regular"){
				$(this).closest(".value").data("value",bold);

			} else {
				$(this).closest(".value").data("value",regular);
			}
			font_weight =  $(this).closest(".value").data("value");
			$(this).html(font_weight.charAt(0).toUpperCase() + font_weight.slice(1));

			if(font_weight == "regular") font_weight = "normal";
			$(this).css("font-weight",font_weight);
			$("#"+PM.option.setElement).find("text").css("font-weight",font_weight);

			PM.setBoard();
			PM.showSvg();

		})

		$(".font-style .value span").click(function(){
			if($(this).closest(".value").data("value") == "regular"){
				$(this).closest(".value").data("value",italic);

			} else {
				$(this).closest(".value").data("value",regular);
			}
			font_weight =  $(this).closest(".value").data("value");
			$(this).html(font_weight.charAt(0).toUpperCase() + font_weight.slice(1));

			if(font_weight == "regular") font_weight = "normal";
			$(this).css("font-style",font_weight);
			$("#"+PM.option.setElement).find("text").css("font-style",font_weight);

			PM.setBoard();
			PM.showSvg();

		})
		$(".letter-spacing input[type='range']").mouseup(function(){
			$(this).unbind("keypress");
			$(this).unbind("keydown");
			$(this).unbind("keyup");
			$(this).blur();
			$(this).focusout();
			// $("#" + PM.option.setElement).find("text").attr("letter-spacing",$(this).val());
			text = $("#" + PM.option.setElement).find("text").text();
			strleng = text.length;
			dx = "0 ";
			for(i=0; i<strleng; i++) dx+= $(this).val()+ " ";
			$("#" + PM.option.setElement).find("text").attr("dx",dx);

			PM.setBoard();
			PM.showSvg()
		})

		$(".value-box")	.click(function(){
			$(this).closest(".value-wrapper").find(".color-picker-custom").removeClass("color-picker-custom");

			$(this).closest(".value-wrapper").find(".static").toggle();
		})
		 

		$(".value").change(function(){
			color = $(this).val();
			
			if($(this).closest("section").hasClass("fill-color")){
				picker2.set($(this).val());
				$(".symbol-fill-color").closest(".value-wrapper").find("span").css("background-color","" + color);
		   		PM.option.obj.attr("fill","" + color);
				PM.showSvg();
			}
			if($(this).closest("section").hasClass("first-color")){
				picker3.set($(this).val());
				$(".symbol-first-color").closest(".value-wrapper").find("span").css("background-color","" + color);
		   		gradient_id = PM.option.obj.data("gradient_id");
	   			$("#"+gradient_id+" .first_value").css("stop-color",color);
				PM.showSvg();
			}

			if($(this).closest("section").hasClass("last-color")){
				picker4.set($(this).val());
				$(".symbol-last-color").closest(".value-wrapper").find("span").css("background-color","" + color);
		   		gradient_id = PM.option.obj.data("gradient_id");
	   			$("#"+gradient_id+" .last_value").css("stop-color", color);
				PM.showSvg();
			}

		})
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
    			$(".canvas-wrapper-inner").html($(".canvas-wrapper-inner").html());

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
    		$(".canvas-wrapper-inner").html($(".canvas-wrapper-inner").html());

			PM.showSvg();
		});



		$(".canvas-wrapper").on("click","path,rect,circle,polygon,text",function(e){
			
			obj = $(this);
			PM.option.obj = obj;

			$(".symbol").find(".static").css("display","none");

			if(!obj.attr("fill")){
					
				if(obj.closest("g").attr("fill")){
					obj.attr("fill",obj.closest("g").attr("fill"));	
				}
				else {
					if(!obj.css("fill"))
						obj.attr("fill","#000000");	
					else 
						obj.attr("fill",obj.css("fill"));	
				}
				obj.removeAttr("style");
			} 

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
			if(e.target.tagName == "text"){
				$(".for-font").css("display","inline-block");
				$(".for-font").find("span").attr("font-family",obj.attr("font-family"));
				$(".for-font").find("span").css("font-family",obj.attr("font-family"));
				$(".selected").removeClass("selected");
				$("li[data-value='"+obj.attr("font-family")+"']").addClass("selected");
				$(".font-family span").html(obj.attr("font-family"));
				// alert(obj.attr("font-family"));
				$(".for-symbole").css("display","none");
			} else {
				$(".for-font").css("display","none");
				$(".for-symbole").css("display","inline-block");
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
					ele += '<stop class="first_value" offset="0" style="stop-color:'+first_color+'"></stop>'; 
					ele += '<stop class="last_value" offset="1" style="stop-color:'+last_color+'"></stop>'; 
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

			if(PM.option.setElement.indexOf("symbol")>=0){
				$(".for-font").css("display","none");
				$(".for-symbole").css("display","inline-block");
			} else {
				$(".for-font").css("display","inline-block");
				$(".for-symbole").css("display","none");
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
						if(transform){
							sx = transform.indexOf("(");
							ex = transform.indexOf(") ");
							st = transform.substr(sx+1,ex-sx-1);
							st_arr = st.split(",");
							sub_x = st_arr[0]*1 + 135*1 ;
							sub_y = st_arr[1]*1 + 115*1 ;
							str = "translate(" + sub_x + ", " + sub_y +  transform.substr(ex);
							$(this).attr("transform",str);
						}
					// console.log(transform);
					// console.log(str);
				})

				PM.option.siderbar_width = 0; 
			}
			else {

				$("#canvas_window > .logo-entity").each(function(){
					transform = $(this).attr("transform");
					// translate(816.5, 305) scale(1,1)
					if(transform){ 
						sx = transform.indexOf("(");
						ex = transform.indexOf(") ");
						st = transform.substr(sx+1,ex-sx-1);
						st_arr = st.split(",");
						sub_x = st_arr[0] - 135;
						sub_y = st_arr[1] - 115 ;
						str = "translate(" + sub_x + ", " + sub_y +  transform.substr(ex);
						$(this).attr("transform",str);
					}
					// console.log(transform);
					// console.log(str);
				})


				PM.option.siderbar_width = 270; 
			}

		})

		
	 	$("#save_logo").click(function(){

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
			$("#logo_preview").html('<svg id="export_svg" viewBox="0 0 '+width+' '+height+'" class="canvas" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"></svg>');
			svg_ele = $("#canvas_window").html();
			$("#export_svg").html(svg_ele);

			// $("#export_svg").attr("viewBox","0 0 "+width+" "+height);
			// $("#export_svg").width();
			// $("#export_svg").height(height);


			// $("#export_svg").css("width",width);
			// $("#export_svg").css("height",height);

			$("#export_svg").find(".logo-entity").each(function(){
				transform = $(this).attr("transform");
				// translate(816.5, 305) scale(1,1)
				if(transform){
					sx = transform.indexOf("(");
					ex = transform.indexOf(") ");
					st = transform.substr(sx+1,ex-sx-1);
					st_arr = st.split(",");
					sub_x = st_arr[0] - min_x +PM.option.siderbar_width;
					sub_y = st_arr[1] - min_y;
					str = "translate(" + sub_x + ", " + sub_y +  transform.substr(ex);
					$(this).attr("transform",str);
				}
				// console.log(transform);
				// console.log(str);
			})
			 $("#export_svg").removeAttr("class");
			 $("#export_svg g,text").removeAttr("class");

			$("#export_svg").find(".logo-entity").removeAttr("id").removeAttr("class");
    		// $("#export_svg").removeAttr("style");
    		$("#logo_preview").html($("#logo_preview").html());

			
			$("#payment_error").html("");
 
			$.ajax({
	 			url: base_url + "home/saveTemplate",
	 			data:{"icon_content":$("#export_svg").html(), "content": $("#canvas_window").html(), "title": $("input[name='title-input']").val(), "subtitle": $("input[name='subtitle-input']").val() },
				dataType: "json",
				type: "post",
				success: function(res){
					$(".visible").removeClass("visible");
					$("#payment_window").addClass("visible");
				}
	 		})
// 			max_x = 0;
// 			max_y = 0;
// 			min_x = $("#canvas_window").width();
// 			min_y = $("#canvas_window").height();

// 			$("#canvas_window .logo-entity").each(function(){
// 				if($(this)[0].getBoundingClientRect().width != 0 && $(this)[0].getBoundingClientRect().height != 0) {
// 					if(min_x > $(this)[0].getBoundingClientRect().left)  min_x = $(this)[0].getBoundingClientRect().left; 
// 					if(min_y > $(this)[0].getBoundingClientRect().top)  min_y = $(this)[0].getBoundingClientRect().top; 
// 					if(max_x < $(this)[0].getBoundingClientRect().right)  max_x = $(this)[0].getBoundingClientRect().right; 
// 					if(max_y < $(this)[0].getBoundingClientRect().bottom)  max_y = $(this)[0].getBoundingClientRect().bottom; 
// 				}

// 			})

// 			width = max_x - min_x;
// 			height = max_y - min_y;
// 			$("#sub_svg").append('<svg id="export_svg" viewBox="0 0 '+width+' '+height+'" class="canvas" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"></svg>');
// 			svg_ele = $("#canvas_window").html();
// 			$("#export_svg").html(svg_ele);

// 			// $("#export_svg").attr("viewBox","0 0 "+width+" "+height);
// 			$("#export_svg").width(width);
// 			$("#export_svg").height(height);


// 			$("#export_svg").css("width",width);
// 			$("#export_svg").css("height",height);

// 			$("#export_svg").find(".logo-entity").each(function(){
// 				transform = $(this).attr("transform");
// 				// translate(816.5, 305) scale(1,1)
// 				if(transform){
// 					sx = transform.indexOf("(");
// 					ex = transform.indexOf(") ");
// 					st = transform.substr(sx+1,ex-sx-1);
// 					st_arr = st.split(",");
// 					sub_x = st_arr[0] - min_x +PM.option.siderbar_width;
// 					sub_y = st_arr[1] - min_y;
// 					str = "translate(" + sub_x + ", " + sub_y +  transform.substr(ex);
// 					$(this).attr("transform",str);
// 				}
// 				// console.log(transform);
// 				// console.log(str);
// 			})
// 			 $("#export_svg").removeAttr("class");
// 			 $("#export_svg g,text").removeAttr("class");

// 			$("#export_svg").find(".logo-entity").removeAttr("id").removeAttr("class");
//     		// $("#export_svg").removeAttr("style");
//     		$("#sub_svg").html($("#sub_svg").html());

			
// //---------			 need -------------------------
// 			var doctype = '<?xml version="1.0" standalone="no"?>'
// 			  + '<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">';

// 			// serialize our SVG XML to a string.
// 			var source = (new XMLSerializer()).serializeToString(d3.select('#export_svg').node());

// 			// create a file blob of our SVG.
// 			var blob = new Blob([ doctype + source], { type: 'image/svg+xml;charset=utf-8' });

// 			var url = window.URL.createObjectURL(blob);
// 			canvas_w = $("#export_svg")[0].getBoundingClientRect().width;
// 			canvas_h = $("#export_svg")[0].getBoundingClientRect().height;

// 			var img = d3.select('body').append('img')
// 			 .attr('width', canvas_w)
// 			 .attr('height', canvas_h)
// 			 .attr('id','remove_img')
// 			 .attr('style',"border:1px solid red;")
// 			 .node();

// 			img.onload = function(){
// 			  // Now that the image has loaded, put the image into a canvas element.
// 			  var canvas = d3.select('body').append('canvas').attr('style',"border:1px solid red;").node();
// 			  canvas_w = $("#remove_img")[0].getBoundingClientRect().width;
// 			  canvas_h = $("#remove_img")[0].getBoundingClientRect().height;
			  
// 			  canvas.width = 5000;
// 			  canvas.height = 5000*canvas_h/canvas_w;
// 			  console.log(canvas_w);
// 			  console.log(canvas_h);
// 			  var ctx = canvas.getContext('2d');
			  
// 			  ctx.drawImage(img, 0, 0, 5000 , 5000 *canvas_h/canvas_w, 0, 0, 5000, 5000*canvas_h/canvas_w);
// 			  var canvasUrl = canvas.toDataURL("image/png");
// 			  triggerDownload(canvasUrl);
// 			}
// 			// start loading the image.
// 			img.src = url;
			 


// 		    function triggerDownload (imgURI) {
// 		      var evt = new MouseEvent('click', {
// 		        view: window,
// 		        bubbles: false,
// 		        cancelable: true
// 		      });

// 		      var a = document.createElement('a');
// 		      a.setAttribute('download', 'MY_COOL_IMAGE.png');
// 		      a.setAttribute('href', imgURI);
// 		      a.setAttribute('target', '_blank');
// 		      a.dispatchEvent(evt);
// 		      $("#remove_img").remove();
// 		      $("canvas").remove();
		      
// 		    }

// 		    $("#export_svg").removeAttr("style");
// 		 	var doctype = '<?xml version="1.0" standalone="no"?>'
// 			  + '<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">';

// 			// serialize our SVG XML to a string.
// 			var source = (new XMLSerializer()).serializeToString(d3.select('#export_svg').node());

// 			// create a file blob of our SVG.
// 			var blob = new Blob([ doctype + source], { type: 'image/svg+xml;charset=utf-8' });

// 			var url = window.URL.createObjectURL(blob);
// 			setTimeout(function(){
// 				var downloadLink = document.createElement("a");
// 				downloadLink.href = url;
// 				downloadLink.download = "MY_COOL_IMAGE.svg";
// 				document.body.appendChild(downloadLink);
				
// 				downloadLink.click();
// 				document.body.removeChild(downloadLink);
// 			},3000);
			
	 	 
			
 
// //---------------------------------			
// 			$("#export_svg").remove();

		})

		$("#preview_btn").click(function(){
			var doctype = '<?xml version="1.0" standalone="no"?>'
			  + '<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">';

			// serialize our SVG XML to a string.
			$("#export_svg style").html("");
			font_family = "";
			$("#export_svg text").each(function(){
				if(font_family != $(this).attr("font-family")){
					font_family = $(this).attr("font-family");	
					ele = "";
					ele += '@font-face {';
                    ele += '    font-family:'+font_family+';';
                    ele += '    src: url("'+$("textarea[data-url='"+font_family+"']").html()+'")';
                    ele += '}';
                    $("#export_svg style").append(ele); 
				}
			})
			var source = (new XMLSerializer()).serializeToString(d3.select('#export_svg').node());

			// create a file blob of our SVG.
			var blob = new Blob([ doctype + source], { type: 'image/svg+xml;charset=utf-8' });

			var url = window.URL.createObjectURL(blob);
			canvas_w = $("#export_svg")[0].getBoundingClientRect().width;
			canvas_h = $("#export_svg")[0].getBoundingClientRect().height;

			var img = d3.select('body').append('img')
			 .attr('width', canvas_w)
			 .attr('height', canvas_h)
			 .attr('id','remove_img')
			 .attr('style',"border:1px solid red;")
			 .node();

			img.onload = function(){
			  // Now that the image has loaded, put the image into a canvas element.
			  var canvas = d3.select('body').append('canvas').attr('style',"border:1px solid red;").node();
			  canvas_w = $("#remove_img")[0].getBoundingClientRect().width;
			  canvas_h = $("#remove_img")[0].getBoundingClientRect().height;
			  
			  canvas.width = 50;
			  canvas.height = 50*canvas_h/canvas_w;
			  var ctx = canvas.getContext('2d');
			  
			  ctx.drawImage(img, 0, 0, 50 , 50 *canvas_h/canvas_w, 0, 0, 50, 50*canvas_h/canvas_w);
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
	setBoard: function(){

		transform = $("#"+PM.option.setElement).attr("transform");
		rotate_str = transform.substr(transform.indexOf("rotate") + 7,transform.lastIndexOf(")")-7).split(",");
		ag = rotate_str[0];

		scale_str = transform.substr(transform.indexOf("scale") + 6).split(",");
		sc = scale_str[0];

		scale_left = $("#"+PM.option.setElement)[0].getBoundingClientRect().left;
		scale_top = $("#"+PM.option.setElement)[0].getBoundingClientRect().top;

		scale_width = $("#"+PM.option.setElement)[0].getBoundingClientRect().width;
		scale_height = $("#"+PM.option.setElement)[0].getBoundingClientRect().height;
		ag1 = ag;
		if(ag>180) ag1 = 360-(ag%360);
		cos_val = Math.cos(ag1*Math.PI/180);
		sin_val = Math.sin(ag1*Math.PI/180);

		a = Math.abs(scale_width *cos_val  - scale_height*sin_val)/Math.abs(Math.pow(cos_val,2)-Math.pow(sin_val,2)) / sc;
		b = Math.abs(scale_width *sin_val  - scale_height*cos_val)/Math.abs(Math.pow(sin_val,2)-Math.pow(cos_val,2)) / sc;

		rotate_x = a/2;
		rotate_y = b/2;

		$("#"+PM.option.setElement).attr("data-rotate_x",rotate_x);
		$("#"+PM.option.setElement).attr("data-rotate_y",rotate_y);

		$("#"+PM.option.setElement).data("rotate_x",rotate_x);
		$("#"+PM.option.setElement).data("rotate_y",rotate_y);
		transform = transform.substr(0,transform.indexOf("rotate")) + "rotate("+ag+","+rotate_x+","+rotate_y+")";
		$("#"+PM.option.setElement).attr("transform",transform);

		$(".focused").css("left",scale_left-PM.option.siderbar_width);
		$(".focused").css("top",scale_top);
		$(".focused").css("width",scale_width);
		$(".focused").css("height",scale_height);

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

		// if(xx!=0&&xx) scale_left -= xx/scale *rate_x;
		// if(yy!=0&&yy) scale_top -= yy/scale*rate_y;

		transform_str = obj.attr("transform");
		rotate_str = transform_str.substr(transform_str.indexOf("rotate"));

		rotate_x = obj.data("rotate_x");
		rotate_y = obj.data("rotate_y");
		if(!rotate_y) rotate_y = rotate_x;
		
		rotate_ang = rotate_str.substr(7, rotate_str.indexOf(")")-7).split(",");
		// rotate_x1 =Math.floor((rotate_x - Math.sqrt(Math.pow(rotate_x,2) + Math.pow(rotate_y,2) ) * Math.cos((rotate_ang[0]+45)*Math.PI/180) )*rate_x*1000)/1000;
		// rotate_y1 = Math.floor((rotate_y - Math.sqrt(Math.pow(rotate_x,2) + Math.pow(rotate_y,2) ) * Math.sin((rotate_ang[0]+45)*Math.PI/180) )*rate_y)/1000;
		// if(PM.option.setElement == "title"){

		// 	rotate_x1 = Math.floor((rotate_x - Math.sqrt(Math.pow(rotate_x,2) + Math.pow(rotate_y,2) ) * Math.cos((rotate_ang[0]+45)*Math.PI/180) )*rate_x*1000)/1000;
		// 	rotate_y1 = Math.floor((rotate_y - Math.sqrt(Math.pow(rotate_x,2) + Math.pow(rotate_y,2) ) * Math.sin((rotate_ang[0]+45)*Math.PI/180) )*rate_y)/1000;

		// 	scale_left -= rotate_x1;
		// 	scale_top -= rotate_y1;
		// 	console.log("rotate_y : "  +rotate_x1)
		

		// }

		scale_left =scale_left + (scale_width -rotate_x*rate_x*2)/2;
		scale_top =scale_top + (scale_height -rotate_y*rate_y*2)/2;
		
		// console.log("rotate_x : "+rotate_x);
		// console.log("scale_left : "+scale_left);
		// console.log(rate_x);

		transform="translate("+scale_left+", "+scale_top+") scale("+rate_x+","+rate_y+") "+ rotate_str;
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
				if(transform){
					sx = transform.indexOf("(");
					ex = transform.indexOf(") ");
					st = transform.substr(sx+1,ex-sx-1);
					st_arr = st.split(",");
					sub_x = st_arr[0] - min_x +PM.option.siderbar_width;
					sub_y = st_arr[1] - min_y;
					str = "translate(" + sub_x + ", " + sub_y +  transform.substr(ex);
					$(this).attr("transform",str);
				}
				// console.log(transform);
				// console.log(str);
			})

		})
			$(".wrapper").html($(".wrapper").html());

 		// $("body").html($("body").html());

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
				if(transform){ 
					// translate(816.5, 305) scale(1,1)
					sx = transform.indexOf("(");
					ex = transform.indexOf(") ");
					st = transform.substr(sx+1,ex-sx-1);
					st_arr = st.split(",");
					sub_x = st_arr[0] - min_x +PM.option.siderbar_width + center_x;
					sub_y = st_arr[1] - min_y + center_y;
					// sub_x = st_arr[0] - min_x +PM.option.siderbar_width;
					// sub_y = st_arr[1] - min_y ;
					str = "translate(" + sub_x + ", " + sub_y +  transform.substr(ex);
					$(this).attr("transform",str);
				}
				// console.log(transform);
				// console.log(str);
			})

		})
			$(".wrapper").html($(".wrapper").html());


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
	downloadPng : function(){

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
		$("#sub_svg").append('<svg id="export_svg" viewBox="0 0 '+width+' '+height+'" class="canvas" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"></svg>');
		svg_ele = $("#canvas_window").html();
		$("#export_svg").html(svg_ele);

		// $("#export_svg").attr("viewBox","0 0 "+width+" "+height);
		$("#export_svg").width(width);
		$("#export_svg").height(height);


		$("#export_svg").css("width",width);
		$("#export_svg").css("height",height);

		$("#export_svg").find(".logo-entity").each(function(){
			transform = $(this).attr("transform");
			// translate(816.5, 305) scale(1,1)
			if(transform){
				sx = transform.indexOf("(");
				ex = transform.indexOf(") ");
				st = transform.substr(sx+1,ex-sx-1);
				st_arr = st.split(",");
				sub_x = st_arr[0] - min_x +PM.option.siderbar_width;
				sub_y = st_arr[1] - min_y;
				str = "translate(" + sub_x + ", " + sub_y +  transform.substr(ex);
				$(this).attr("transform",str);
			}
			// console.log(transform);
			// console.log(str);
		})
		 $("#export_svg").removeAttr("class");
		 $("#export_svg g,text").removeAttr("class");

		$("#export_svg").find(".logo-entity").removeAttr("id").removeAttr("class");
		// $("#export_svg").removeAttr("style");
		$("#sub_svg").html($("#sub_svg").html());

		
//---------			 need -------------------------
		var doctype = '<?xml version="1.0" standalone="no"?>'
		  + '<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">';

		// serialize our SVG XML to a string.
		var source = (new XMLSerializer()).serializeToString(d3.select('#export_svg').node());

		// create a file blob of our SVG.
		var blob = new Blob([ doctype + source], { type: 'image/svg+xml;charset=utf-8' });

		var url = window.URL.createObjectURL(blob);
		canvas_w = $("#export_svg")[0].getBoundingClientRect().width;
		canvas_h = $("#export_svg")[0].getBoundingClientRect().height;

		var img = d3.select('body').append('img')
		 .attr('width', canvas_w)
		 .attr('height', canvas_h)
		 .attr('id','remove_img')
		 .attr('style',"border:1px solid red;")
		 .node();

		img.onload = function(){
		  // Now that the image has loaded, put the image into a canvas element.
		  var canvas = d3.select('body').append('canvas').attr('style',"border:1px solid red;").node();
		  canvas_w = $("#remove_img")[0].getBoundingClientRect().width;
		  canvas_h = $("#remove_img")[0].getBoundingClientRect().height;
		  
		  canvas.width = 5000;
		  canvas.height = 5000*canvas_h/canvas_w;
		  var ctx = canvas.getContext('2d');
		  
		  ctx.drawImage(img, 0, 0, 5000 , 5000 *canvas_h/canvas_w, 0, 0, 5000, 5000*canvas_h/canvas_w);
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

	    $("#export_svg").removeAttr("style");
	 	var doctype = '<?xml version="1.0" standalone="no"?>'
		  + '<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">';

		// serialize our SVG XML to a string.
		var source = (new XMLSerializer()).serializeToString(d3.select('#export_svg').node());

		// create a file blob of our SVG.
		var blob = new Blob([ doctype + source], { type: 'image/svg+xml;charset=utf-8' });

		var url = window.URL.createObjectURL(blob);
		setTimeout(function(){
			var downloadLink = document.createElement("a");
			downloadLink.href = url;
			downloadLink.download = "MY_COOL_IMAGE.svg";
			document.body.appendChild(downloadLink);
			
			downloadLink.click();
			document.body.removeChild(downloadLink);
		},3000);
		
 	 
		

//---------------------------------			
		$("#export_svg").remove();

	},
	getIcons: function(){
		// ln = "";


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
					$("#div_title").html(searching_icons_for + " <span style='color:red; font-weight:700;'>"+PM.option.icon_slug+"</span>");
				} else {
					top_y = $(".li-checked").offset().top - $(".category-window ")[0].getBoundingClientRect().top+14;
					str = 'top:'+top_y+'px';
					$("#div_title").html("<span style='color:red; font-weight:700;'>"+$(".li-checked").html()+"</span> "+icons);

				}
				if(icon_datas.length == 0) $("#icon_list").append("<li style='width:100% !important; '>There are no any icons.</li>");
				// document.styleSheets[6].addRule('.category-window:before',str);
				$("#category_window").addClass("visible"); 
				// alert();
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

