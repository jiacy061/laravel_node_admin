<!DOCTYPE html>
<html>
<head>
<title>Login</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- <meta name="keywords" content="Flat Dark Web Login Form Responsive Templates, Iphone Widget Template, Smartphone login_dir forms,Login form, Widget Template, Responsive Templates, a Ipad 404 Templates, Flat Responsive Templates" /> -->
<link href="{{ asset('vpn/login_dir/css/style.css') }}" rel='stylesheet' type='text/css' />
<!--webfonts-->
{{--<link href='http://fonts.useso.com/css?family=PT+Sans:400,700,400italic,700italic|Oswald:400,300,700' rel='stylesheet' type='text/css'>--}}
{{--<link href='http://fonts.useso.com/css?family=Exo+2' rel='stylesheet' type='text/css'>--}}
<!--//webfonts-->
<script src="http://cdn.bootcss.com/jquery/1.11.0/jquery.min.js"></script>
</head>
<body>

 <!--SIGN UP-->
 <h1>Welcome To My Space</h1>
<div class="login-form">
	<!-- <div class="close"> </div> -->
		<div class="head-info">
			<label class="lbl-1"> </label>
			<label class="lbl-2"> </label>
			<label class="lbl-3"> </label>
		</div>
			<div class="clear"> </div>
	<div class="avtar">
		<img src="{{ asset('vpn/images/avtar.png') }}" />
	</div>
			<form id="form" action="{{ route('loginPost') }}" method="post">
					<input id="email" name="email" type="text" class="text" placeholder="Username">
						<!-- <div class="key"> -->
					<input id="password" name="password" type="password" placeholder="Password">
						<!-- </div> -->
			</form>
	<div class="signin">
		<input id="submit_btn" type="submit" value="登录" >
	</div>
</div>
	<div class="copy-rights">
		@include('vpn.public_view.footer')
	</div>

</body>
<script type="text/javascript" src="{{ asset('vpn/login_dir/js/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vpn/login_dir/js/jquery.form.js') }}"></script>
<script type="text/javascript" src="{{ asset('vpn/js/tooltips.js') }}"></script>
<script type="text/javascript" src="{{ asset('vpn/js/md5.js') }}"></script>
<script type="text/javascript">
				document.onkeydown = function(e){
							if(!e) e = window.event;
							if((e.keyCode || e.which) == 13){
								var obtnLogin=document.getElementById("submit_btn")
								obtnLogin.focus();
							}
						}

		        $(function(){
		            // 提交表单
		        	$('#submit_btn').click(function(){
		            // 端口的正则表达式
								show_loading();
								var myReg = /^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/; //邮件正则
								if($('#email').val() == ''){
									show_err_msg('邮箱还没填呢！');
									$('#email').focus();
								}else if(!myReg.test($('#email').val())){
									show_err_msg('您的邮箱格式错咯！');
									$('#email').focus();
								}else if($('#password').val() == ''){
									show_err_msg('密码还没填呢！');
									$('#password').focus();
								}else{
									//ajax提交表单，#login_form为表单的ID。 如：$('#login_form').ajaxSubmit(function(data) { ... });
									// show_msg('登录成功咯！  正在为您跳转...','/');
									var pw = document.getElementById("password");
									pw.value = md5(pw.value);
									pw.value = md5(pw.value);
									var form = document.getElementById("form");
                  form.submit();
								}
            });
        });
</script>
<script type="text/javascript">
    if ('{{$email_ret}}' == 'bad email') {
        show_err_msg('账号错误！请确认您的账号是否输入正确！');
    } else if ('{{$password_ret}}' == 'bad password') {
        show_err_msg('密码错误！请重新输入密码或联系管理员！');
    }
</script>
</html>
