function login(){
	var u = _("loginusername").value;
	var p = _("loginpassword").value;
	if(u == "" || p == ""){
		_("loginstatus").innerHTML = "Fill out all of the form data";
	} else {
		_("loginbtn").style.display = "none";
		_("loginstatus").innerHTML = 'please wait ...';
		var ajax = ajaxObj("POST", "assets/ajax/login.php");
        ajax.onreadystatechange = function() {
        	console.log(ajax.responseText);
	        if(ajaxReturn(ajax) == true) {
	            if(ajax.responseText == "login_failed"){
					_("loginstatus").innerHTML = "Login unsuccessful, please try again.";
					_("loginbtn").style.display = "block";
				} else {
					window.location = "assets/templates/user.php?u="+ajax.responseText;
				}
	        }
        }
        ajax.send("u="+u+"&p="+p);
	}
}