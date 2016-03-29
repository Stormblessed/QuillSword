// Index JavaScript Document

function register()
{
	$("#register_slide_body").css('display', 'none');
	$("#nav_login_form").css('display', 'none');
	$("#register_slide_form").css("display", "block");
}

var login_form_flag = false;
function login()
{
	if(login_form_flag == false)
	{
		$("#register_slide_body").css('display', 'none');
		$("#register_slide_form").css('display', 'none');
		$("#nav_login_form").css('display', 'block');
		login_form_flag = true;
	}
	else
	{
		$("#nav_login_form").css('display', 'none');
		$("#register_slide_form").css('display', 'none');
		$("#register_slide_body").css('display', 'block');
		login_form_flag = false;
	}
}


$(document).ready(function(e) {
    var metrics = [
		[ '#first_name', 'presence', 'Cannot be empty'],
		[ '#last_name', 'presence', 'Cannot be empty'],
		[ '#email', 'email', 'Must be a valid email (RFC 822)' ],
		[ '#password', 'min-length:6', 'Password must be 6-32 characters' ],
		[ '#password', 'max-length:32', 'Password must be 6-32 characters' ],
		[ '#password_repeat', 'same-as:#password', 'Your passwords do not match' ]
	];
	
	var optionValues = {
		disableSubmitBtn : false
	};
	
	$('#register_form').nod( metrics, optionValues );
});
