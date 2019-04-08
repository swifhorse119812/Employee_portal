var PM = {
	option : {
		
	},
	init: function(){

		PM.option.siderbar_width = 270;
  

		// PM.getIcons();
		h1 = $(".search").offset().top;
		h2 = $(".save-button").offset().top;
		$("#show_icons").css("height",h2-h1-80);
		$("#search-input").focus();
		// $("#search_window").addClass("visible");
		
		PM.option.setElement = "";
		PM.option.init_icon = $("#show_icons").html();
		$("#history_list svg").each(function(){
			min_x = 3000;
			min_y = 3000;

			max_x = 0;
			max_y = 0;
			$(this).find("g").each(function(){
				if($(this)[0].getBoundingClientRect().width != 0&&$(this)[0].getBoundingClientRect().height!=0){

					left_ = $(this)[0].getBoundingClientRect().left;
					top_ = $(this)[0].getBoundingClientRect().top;
					right_ = $(this)[0].getBoundingClientRect().left + $(this)[0].getBoundingClientRect().width;
					bottom_ = $(this)[0].getBoundingClientRect().top + $(this)[0].getBoundingClientRect().height;
					if(left_<min_x) min_x = left_;
					if(top_<min_y) min_y = top_;

					if(right_>min_x) max_x = right_;
					if(bottom_>max_y) max_y = bottom_;
				}

			})
			w = max_x - min_x;
			h = max_y - min_y;
			viewBox = "0 ,0 ,"+w+", "+h;
			$(this).attr("viewBox",viewBox);
		})
		$("#history_list").html($("#history_list").html());
		PM.bindEvents();
		PM.showSvg();

		if($("#download_flg").val() == "1"){
			PM.downloadPng();
		}

	},
	bindEvents: function(){
		 
		$(".click-over").click(function(e){
			if(e.target!=this) return;
			$(".search-overlay").removeClass("visible");
		})

		 
		$("body").on("click","#category_list>li",function(){
			$(".li-checked").removeClass("li-checked");
			$(this).addClass("li-checked");
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

		$("#history_list").on("click","li",function(){
			$(".li-selected").removeClass("li-selected");
			$(this).addClass("li-selected");
			$("#canvas_window").html($(this).find("textarea").text());
			$(".canvas-wrapper-inner").html($(".canvas-wrapper-inner").html());
			$("input[name='title-input']").val($(this).find(".title").html().trim());
			$("input[name='subtitle-input']").val($(this).find(".subtitle").html().trim());
			PM.showSvg();
		})
	 	$("body").on("click","#save_logo",function(){
	 		PM.downloadPng();
		})

	} ,
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
	} ,
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

		$("#export_svg").find("style").html("");

		font_family = "";
		$("#export_svg").find("text").each(function(){
			if($(this).attr("font-family") != font_family){
				font_family = $(this).attr("font-family");
				ele = "";
				ele += '@font-face {'; 
                ele += '    font-family: '+font_family+';'; 
                ele += '    src: url('+$("textarea[data-url='"+font_family+"']").text()+');'; 
                ele += '}'; 
                $("#export_svg").find("style").append(ele);
			}
		})		
		$("#export_svg").css("width",width);
		$("#export_svg").css("height",height);
		$("#export_svg").attr("height",height);
		$("#export_svg").attr("width",width);

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
		 .attr('style', "width:" + canvas_w+"px; height : "+canvas_h + "px;")
		 // .attr('height', canvas_h)
		 .attr('id','remove_img')
		 .node();

		img.onload = function(){
		  // Now that the image has loaded, put the image into a canvas element.
		  var canvas = d3.select('body').append('canvas').attr('style',"border:1px solid red;").node();
		  canvas_w = $("#remove_img")[0].getBoundingClientRect().width;
		  canvas_h = $("#remove_img")[0].getBoundingClientRect().height;
		  
		  canvas.width = 3000;
		  canvas.height = 3000*canvas_h/canvas_w;
		  // canvas.css("width",2000);
		  // canvas.css("height", 2000*canvas_h/canvas_w);

		  var ctx = canvas.getContext('2d');
		  // alert();
		  ctx.drawImage(img, 0, 0, canvas_w , canvas_w *canvas_h/canvas_w, 0, 0, 3000, 3000*canvas_h/canvas_w);
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
	    $("#export_svg").removeAttr("height");
	    $("#export_svg").removeAttr("width");
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

