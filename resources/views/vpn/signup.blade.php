<!doctype html>
<html lang="zh">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>World of Nodes</title>

	<link rel="stylesheet" type="text/css" href="{{ asset('vpn/register_dir/css/styles.css') }}">
</head>
<body>


<div class="wrapper">

	<div class="container">
		<h1>Welcome to the World of Nodes</h1>
		<form id="registerForm" name="registerForm" class="form" action="{{ route('registerPost') }}" method="post">
			<input id="usrname" name="username" type="text" placeholder="用户名" onchange="trim(this)">
			<input id="email" name="email" type="text" placeholder="E-mail" onchange="trim(this)">
			<input id="pwd" name="password" type="password" placeholder="密码" onchange="trim(this)">
			<input id="cpwd" name="confirmPassword" type="password" placeholder="确认密码" onchange="trim(this)">
			<input id="port_pwd" name="port_password" type="text" placeholder="端口密码" onchange="trim(this)">
			<input id="code" name="code" type="text" placeholder="邀请码" onchange="trim(this)">
			<input type="button" class="j-button" id="submit_btn" value="注册">
		</form>
	</div>

	<ul class="bg-bubbles">
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
	</ul>

</div>

<script type="text/javascript" src="{{ asset('vpn/register_dir/js/jquery-2.1.1.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vpn/js/tooltips.js') }}"></script>
<script type="text/ecmascript" src="{{ asset('vpn/js/md5.js') }}"></script>
<script type="text/javascript">
    //使用JS的trim方法，去掉两边的空格
    function trim(x) {
        x.value = x.value.replace(/\s+/g, "");
    }
</script>
<script type="text/javascript">
    $(function(){
        // 提交表单
        $('#submit_btn').click(function(event){
            // 端口的正则表达式
            var myReg = /^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/; //邮件正则
            if ($('#usrname').val() == '') {
                show_err_msg('用户名不能为空！');
                $('#usrname').focus();
            } else if($('#email').val() == ''){
                show_err_msg('邮箱还没填呢！');
                $('#email').focus();
            } else if(!myReg.test($('#email').val())){
                show_err_msg('您的邮箱格式错咯！');
                $('#email').focus();
            } else if($('#pwd').val() == ''){
                show_err_msg('密码还没填呢！');
                $('#pwd').focus();
            } else if ($('#pwd').val()!=$('#cpwd').val()) {
                show_err_msg('用户密码不一致！');
                $('#cpwd').focus();
            } else if($('#port_pwd').val() == '') {
                show_err_msg('端口密码还没填呢！');
                $('#port_pwd').focus();
            } else if($('code').val() == '') {
                show_err_msg('邀请码还没填呢！');
                $('#code').focus();
            } else {
                var psw1 = document.getElementById("pwd");
                psw1.value = md5(psw1.value);
                var psw2 = document.getElementById("cpwd");
                psw2.value = md5(psw2.value);
                var form = document.getElementById("registerForm");
                form.submit();
                event.preventDefault();
                $('form').fadeOut(500);
                $('.wrapper').addClass('form-success');
            }
        });
    });
</script>
<script type="text/javascript">
    if ('{{$ret}}' == 'good register') {
        show_msg('注册成功！即将转跳至登陆页面！', '{{ route('loginUrl') }}');
    } else if ('{{$ret}}' == 'bad register') {
        show_err_msg('注册失败！详情请联系管理员！');
    }
</script>

</body>
</html>
