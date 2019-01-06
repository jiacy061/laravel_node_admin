<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <title>配置 - VPN管理</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
{{--<link rel="apple-touch-icon" href="../../adminDir/images/icons/favicon.png">--}}
{{--<link rel="apple-touch-icon" sizes="72x72" href="../../adminDir/images/icons/favicon-72x72.png">--}}
{{--<link rel="apple-touch-icon" sizes="114x114" href="../../adminDir/images/icons/favicon-114x114.png">--}}
<!--Loading bootstrap css-->
    <link type="text/css" rel="stylesheet" href="{{ asset('vpn/admin_dir/styles/font-awesome.min.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('vpn/admin_dir/styles/bootstrap.min.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('vpn/admin_dir/styles/main.css') }}">
</head>
<body>
<div>
    <!--BEGIN BACK TO TOP-->
    <a id="totop" href="#"><i class="fa fa-angle-up"></i></a>
    <!--END BACK TO TOP-->
    <!--BEGIN TOPBAR-->
    <div id="header-topbar-option-demo" class="page-header-topbar">
        <nav id="topbar" role="navigation" style="margin-bottom: 0;" data-step="3" class="navbar navbar-default navbar-static-top">
            <div class="navbar-header">
                <button type="button" data-toggle="collapse" data-target=".sidebar-collapse" class="navbar-toggle"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
                <a id="logo" href="{{ route('accountUrl', $port) }}" class="navbar-brand"><span class="fa fa-rocket"></span><span class="logo-text">VPN管理界面</span><span style="display: none" class="logo-text-icon">µ</span></a></div>
            <div class="topbar-main"><a id="menu-toggle" href="#" class="hidden-xs"><i class="fa fa-bars"></i></a>

                <ul class="nav navbar navbar-top-links navbar-right mbn">
                    <li class="dropdown topbar-user"><a data-hover="dropdown" href="#" class="dropdown-toggle">&nbsp;<span class="hidden-xs">{{$usr_name}}，你好！</span>&nbsp;</a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
    <!--END TOPBAR-->
    <div id="wrapper">
        <!--BEGIN SIDEBAR MENU-->
        <nav id="sidebar" role="navigation" data-step="2" data-intro="Template has &lt;b&gt;many navigation styles&lt;/b&gt;"
             data-position="right" class="navbar-default navbar-static-side">
            <div class="sidebar-collapse menu-scroll">
                <ul id="side-menu" class="nav">

                    <div class="clearfix"></div>
                    <li><a href="{{ route('accountUrl', $port) }}"><i class="fa fa-tachometer fa-fw">
                                <div class="icon-bg bg-orange"></div>
                            </i><span class="menu-title">个人信息</span></a></li>

                    <li  class="active"><a href="{{ route('configUrl', $port) }}"><i class="fa fa-send-o fa-fw">
                                <div class="icon-bg bg-violet"></div>
                            </i><span class="menu-title">更改配置</span></a>

                    </li>

                    <li><a href="{{ route('aboutUrl', $port) }}"><i class="fa fa-slack fa-fw">
                                <div class="icon-bg bg-green"></div>
                            </i><span class="menu-title">关于我</span></a></li>
                </ul>
            </div>
        </nav>
        <!--END SIDEBAR MENU-->

        <!--BEGIN PAGE WRAPPER-->
        <div id="page-wrapper">
            <!--BEGIN TITLE & BREADCRUMB PAGE-->
            <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
                <div class="page-header pull-left">
                    <div class="page-title">
                        更改配置</div>
                </div>
                <ol class="breadcrumb page-breadcrumb pull-right">
                    <li><i class="fa fa-home"></i>&nbsp;<a href="{{ route('accountUrl', $port) }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                    <li class="active">更改配置</li>
                </ol>
                <div class="clearfix">
                </div>
            </div>
            <!--END TITLE & BREADCRUMB PAGE-->
            <!--BEGIN CONTENT-->
            <div class="page-content">
                <div id="tab-general">
                    <div class="row mbl">
                        <div class="col-lg-12">
                            <div class="col-md-12">
                                <div id="area-chart-spline" style="width: 100%; height: 300px; display: none;">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="panel panel-orange">
                                    <div class="panel-heading">
                                        配置</div>
                                    <div class="panel-body pan">
                                        <form action="{{ route('updateConfigUrl', $port) }}" method="post" id="updateForm">
                                            <div class="form-body pal">
                                                <div class="form-group">
                                                    <div class="input-icon right">
                                                        <i class="fa fa-envelope"></i>
                                                        <input name="email" type="text" value="{{$email}}" readonly="readonly" class="form-control" />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="input-icon right">
                                                        <i class="fa fa-user"></i>
                                                        <input id="usrname" name="usrname" type="text" placeholder="Username" class="form-control" onchange="trim(this)"/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="input-icon right">
                                                        <i class="fa fa-lock"></i>
                                                        <input id="usr_password" name="usr_password" type="password" placeholder="Password" class="form-control" onchange="trim(this)"/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="input-icon right">
                                                        <i class="fa fa-lock"></i>
                                                        <input id="confirmPassword" name="confirmPassword" type="password" placeholder="Confirm Password" class="form-control" onchange="trim(this)"/>
                                                    </div>
                                                </div>
                                                <hr />
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <input id="port" name="port" type="text" placeholder="端口号：1024~65535" class="form-control" onchange="trim(this)"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <input id="port_password" name="port_password" type="text" placeholder="端口密码" class="form-control" onchange="trim(this)"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <p>加密</p>
                                                    <select id="method" name="method" class="form-control">
                                                        <option value="null">不变</option>
                                                        <option value="none">none</option>
                                                        <option value="aes-128-ctr">aes-128-ctr</option>
                                                        <option value="aes-192-ctr">aes-192-ctr</option>
                                                        <option value="aes-256-ctr">aes-256-ctr</option>
                                                        <option value="aes-128-cfb">aes-128-cfb</option>
                                                        <option value="aes-192-cfb">aes-192-cfb</option>
                                                        <option value="aes-256-cfb">aes-256-cfb</option>
                                                        <option value="rc4">rc4</option>
                                                        <option value="rc4-md5">rc4-md5</option>
                                                        <option value="rc4-md5-6">rc4-md5-6</option>
                                                        <option value="aes-128-cfb8">aes-128-cfb8</option>
                                                        <option value="aes-192-cfb8">aes-192-cfb8</option>
                                                        <option value="aes-256-cfb8">aes-256-cfb8</option>
                                                        <option value="salsa20">salsa20</option>
                                                        <option value="chacha20">chacha20</option>
                                                        <option value="chacha20-ietf">chacha20-ietf</option>
                                                    </select></div>

                                                <div class="form-group">
                                                    <p>协议</p>
                                                    <select id="protocol" name="protocol" class="form-control">
                                                        <option value="null">不变</option>
                                                        <option value="origin">origin</option>
                                                        <option value="verify_deflate">verify_deflate</option>
                                                        <option value="auth_sha1_v4">auth_sha1_v4</option>
                                                        <option value="auth_aes128_md5">auth_aes128_md5</option>
                                                        <option value="auth_aes128_sha1">auth_aes128_sha1</option>
                                                        <option value="auth_chain_a">auth_chain_a</option>
                                                        <option value="auth_chain_b">auth_chain_b</option>
                                                    </select></div>

                                                <div class="form-group">
                                                    <p>混淆</p>
                                                    <select id="obfs" name="obfs" class="form-control">
                                                        <option value="null">不变</option>
                                                        <option value="plain">plain</option>
                                                        <option value="http_simple">http_simple</option>
                                                        <option value="http_post">http_post</option>
                                                        <option value="random_head">random_head</option>
                                                        <option value="tls1.2_ticket_auth">tls1.2_ticket_auth</option>
                                                        <option value="tls1.2_ticket_fastauth">tls1.2_ticket_fastauth</option>
                                                    </select></div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <p>协议参数</p>
                                                            <input id="protocol_param" name="protocol_param" type="text" placeholder="此参数复杂，建议不填或填null" class="form-control" onchange="trim(this)"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <p>混淆参数</p>
                                                            <input id="obfs_param" name="obfs_param" type="text" placeholder="例如：example.com" class="form-control" onchange="trim(this)"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <p>**提醒：以上两项输入“null”时，则表示该参数重置为空。</p>
                                                <p>**关于SS协议的说明：当协议设置为“origin”，混淆设置为“plain”时，为原版SS协议，但通常不建议使用SS协议。</p>
                                            </div>

                                            <div class="form-actions text-right pal">
                                                <button id="submit_btn" type="button" class="btn btn-primary">提交</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--END CONTENT-->

            <!--BEGIN FOOTER-->
            <div id="footer">
                <div class="copyright">
                    @include('vpn.public_view.footer')
                </div>
            </div>
            <!--END FOOTER-->
        </div>
        <!--END PAGE WRAPPER-->
    </div>
</div>
<script type="text/javascript" src="{{ asset('vpn/admin_dir/js/jquery-1.10.2.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vpn/admin_dir/js/jquery-migrate-1.2.1.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vpn/admin_dir/js/jquery.menu.js') }}"></script>
<script type="text/javascript" src="{{ asset('vpn/admin_dir/js/holder.js') }}"></script>
<!--CORE JAVASCRIPT-->
<script type="text/javascript" src="{{ asset('vpn/admin_dir/js/main.js') }}"></script>

<script type="text/javascript" src="{{ asset("vpn/login_dir/js/jquery.min.js") }}"></script>
{{--<script type="text/javascript" src="../../loginDir/style/js/jquery.form.js"></script>--}}
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
        $('#submit_btn').click(function(){
            // 端口的正则表达式
            var portReg = new RegExp("^(102[4-9]|10[3-9]\\d|1[1-9]\\d\\d|[2-9]\\d{3}|[1-5]\\d{4}|6[0-4]\\d{3}|65[0-4]\\d{2}|655[0-2]\\d|6553[0-5])$");
            var urlReg = new RegExp("^[-A-Za-z0-9+&@#/%?=~_|!:,.;]+[-A-Za-z0-9+&@#/%=~_|]$");
            if ($('#port').val()!='' && !portReg.test($('#port').val())){
                show_err_msg('端口非法！');
                $('#port').focus();
            } else if ($('#usr_password').val()!=$('#confirmPassword').val()) {
                show_err_msg('用户密码不一致！');
                $('#confirmPassword').focus();
            } else if ($('#obfs_param').val()!='' && !urlReg.test($('#obfs_param').val()) && $('#obfs_param').val()!='null') {
                show_err_msg('混淆参数不合法！');
                $('#obfs_param').focus();
            } else if ($('#usrname').val()!='' || $('#usr_password').val()!=''
                || $('#port').val()!='' || $('#port_password').val()!='' || $('#method').val()!='null'
                || $('#protocol').val()!='null' || $('#obfs').val()!='null'
                || $('#protocol_param').val()!='' || $('#obfs_param').val()!='') {
                var psw1 = document.getElementById("usr_password");
                if (psw1.value!="")
                    psw1.value = md5(psw1.value);
                var psw2 = document.getElementById("confirmPassword");
                if (psw2.value!="")
                    psw2.value = md5(psw2.value);

                var form = document.getElementById("updateForm");
                form.submit();
            }
        });
    });
</script>
<script type="text/javascript">
    if ('{{$msg}}' == 'succeed') {
        show_msg('更新成功，配置立即生效，请更新您的本地配置！', '');
    } else if ('{{$msg}}' == 'fail') {
        show_err_msg('更新失败，详情咨询系统管理员！\n{{ $run_exception }}');
    } else if ('{{$msg}}' == 'Bad port') {
        show_err_msg('端口非法或已被占用，请更换一个端口！');
    } else if ('{{$msg}}' == 'Bad password') {
        show_err_msg('更改登陆密码失败！');
    }
</script>

</body>
</html>
