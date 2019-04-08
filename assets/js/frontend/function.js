var Saved = 'Saved'
var EnterCurrPassword = 'Please Enter Current Password.'
var EnterNewPassword = 'Please Enter New Password.'
var PasswordShouldCharNumber = 'Your Password should be characters and numbers'
var EnterConfPassword = 'Please Enter Confirm Password.'
var PasswordNotMatch = 'Passwords not matching'
var OldNewNotSame = 'Old and new paswords should not be same.'
var MinimumCharacters = 'Password should be minimum 6 characters'
var RequiredField = 'This field is required.'
var OnlyCharacter = 'only characters'
var Weak = 'Weak'
var Good = 'Good'
var Strong = 'Strong'
var VeryStrong = 'Very Strong'
var Oops = 'Oops';
var Enter_email = "Please enter the email adddress";
var Enter_first_name = "Please enter the first name!";
var Enter_last_name = "Please enter the last name";
var Enter_pass = "Please enter the password";
var Enter_pass_char = "Password must be minimum of 6 characters";
var Pass_not_match = "Passwords not matching";
var weak_pass = "Password should contain numeric and alphabets";
var pass_again= "Please enter the password again";
var EnterEmailAddress = 'Please enter the email address';
var EnterPassword = 'Please enter the passwords';
var PasswordSixCharacters = 'Password must be minimum of 6 character';
var EnterValidCaptcha = 'Enter valid captcha';

(function ($) {
	$(document).ready(function () {
		setInterval("slideSwitch()", 5000);

		$("#broswe_box4").click(function() {

			if($('#broswe_box_li').css('display')=='block'){
				$("#broswe_box_li").hide();
				$("#broswe_box_li").addClass("intro");
				$("#broswe_box4").toggleClass("broswe_selected");
			}else{
				$("#broswe_box_li").show();
				$("#broswe_box_li").removeClass("intro");
				$("#broswe_box4").toggleClass("");
			}
		});

		$("#broswe_box5").click(function() {
			if($('#broswe_box5_li').css('display')=='block'){
				$("#broswe_box5_li").hide();
				$("#broswe_box5_li").addClass("intro");
				$("#broswe_box5").toggleClass("broswe_selected");
			}else{

				$("#broswe_box5_li").show();
				$("#broswe_box5_li").removeClass("intro");
				$("#broswe_box5").toggleClass("");
			}
		});

		$('#cssmenu').prepend('<div id="menu-button">Menu</div>');
		$('#cssmenu #menu-button').on('click', function () {
			var menu = $(this).next('ul');
			if (menu.hasClass('open')) {
				menu.removeClass('open');
			}
			else {
				menu.addClass('open');
			}
		});
		var boxpostwindowsize = $(window).width();
		$(".cboxClose1").click(function () {
			$("#cboxOverlay,#colorbox").hide();
		});
		if (boxpostwindowsize > 559) {
			$(".rental-contactme").colorbox({ width: "665px", height: "630px", inline: true, href: "#inline_contactme" });

			$(".rental-wishlist").colorbox({ width: "665px", height: "630px", inline: true, href: "#inline_wishlist" });

			$(".create").colorbox({ width: "665px", height: "630px", inline: true, href: "#create_wishlist" });

			$(".login-popup").colorbox({ width: "365px", height: "480px", inline: true, href: "#inline_login" });

			$(".reg-popup").colorbox({ width: "380px", height: "450px", inline: true, href: "#inline_reg" });


			$(".forgot-popup").colorbox({ width: "365px", height: "310px", inline: true, href: "#inline_forgot" });

			$(".register-popup").colorbox({ width: "365px", height: "630px", inline: true, href: "#inline_register" });

			$(".add-address").colorbox({ width: "550px", height: "680px", inline: true, href: "#inline_mapaddress" });
			$(".example16").colorbox({ width: "800px", height: "600px", inline: true, href: "#inline_example11" });

		} else {

			$(".login-popup").colorbox({ width: "310px", inline: true, href: "#inline_login" });

			$(".reg-popup").colorbox({ width: "310px", height: "380px", inline: true, href: "#inline_reg" });

			$(".rental-contactme").colorbox({ width: "310px", height: "630px", inline: true, href: "#inline_contactme" });

			$(".rental-wishlist").colorbox({ width: "280px", height: "630px", inline: true, href: "#inline_wishlist" });

			$(".create").colorbox({ width: "310px", height: "630px", inline: true, href: "#create_wishlist" });

			$(".forgot-popup").colorbox({ width: "310px", height: "310px", inline: true, href: "#inline_forgot" });

			$(".register-popup").colorbox({ width: "310px", height: "630px", inline: true, href: "#inline_register" });

			$(".add-address").colorbox({ width: "310px", height: "680px", inline: true, href: "#inline_mapaddress" });

			$(".example16").colorbox({ width: "310px", height: "600px", inline: true, href: "#inline_example11" });

		}

		$("#onLoad").click(function () {
			$('#onLoad').css({ "background-color": "#f00", "color": "#fff", "cursor": "inherit" }).text("Open this window again and this message will still be here.");
			return false;
		});
		
		if (localStorage.chkbx && localStorage.chkbx != '') {
			$('#remember').attr('checked', 'checked');
			$('#signin_email_address').val(localStorage.signin_email_address);
			$('#signin_password').val(localStorage.signin_password);
		} else {
			$('#remember').removeAttr('checked');
			$('#signin_email_address').val('');
			$('#signin_password').val('');
		}

		$('#remember').click(function() {

			if ($('#remember').is(':checked')) {
				// save username and password
				localStorage.signin_email_address = $('#signin_email_address').val();
				localStorage.signin_password = $('#signin_password').val();
				localStorage.chkbx = $('#remember').val();
			} else {
				localStorage.signin_email_address = '';
				localStorage.signin_password = '';
				localStorage.chkbx = '';
			}
		});
	});
})(jQuery);
var boxpostwindowsize1 = $(window).width();
$(document).on('click', '.login-popup', function () {
	if (boxpostwindowsize1 > 559) {
		$.colorbox({ width: "365px", height: "480px", inline: true, href: "#inline_login" });
	} else {
		$.colorbox({ width: "310px", inline: true, href: "#inline_login" });
	}
});
function loginpopupopen() {
	$(".login-popup").colorbox({ width: "365px", height: "480px", open: true, href: "#inline_login" });
}
function loginpopupsignin() {
	$(".register-popup").colorbox({ width: "365px", height: "630px", open: true, href: "#inline_register" });
}

function slideSwitch() {
	var $active = $('#slidebanner IMG.active');

	if ($active.length == 0) $active = $('#slidebanner IMG:last');


	var $next = $active.next().length ? $active.next()
		: $('#slidebanner IMG:first');



	$active.addClass('last-active');

	$next.css({ opacity: 0.0 })
		.addClass('active')
		.animate({ opacity: 1.0 }, 1000, function () {
			$active.removeClass('active last-active');
		});
}
function showView(val){
	if($('.showlist'+val).css('display')=='block'){
		$('.showlist'+val).hide('');
	}else{
		$('.showlist'+val).show('');
	}
}