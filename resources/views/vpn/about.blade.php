<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <title>关于我 - VPN管理</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

    <!--Loading bootstrap css-->
    <link type="text/css" rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,300,700">
    <link type="text/css" rel="stylesheet" href="http://fonts.googleapis.com/css?family=Oswald:400,700,300">
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
            <nav id="sidebar" role="navigation" data-step="2" data-intro="Template has <b>many navigation styles</b>" data-position="right" class="navbar-default navbar-static-side" style="min-height: 100%;">
                <div class="sidebar-collapse menu-scroll">
                    <ul id="side-menu" class="nav">

                        <div class="clearfix"></div>
                        <li><a href="{{ route('accountUrl', $port) }}"><i class="fa fa-tachometer fa-fw">
                                    <div class="icon-bg bg-orange"></div>
                                </i><span class="menu-title">个人中心</span></a></li>

                        <li><a href="{{ route('configUrl', $port) }}"><i class="fa fa-send-o fa-fw">
                                    <div class="icon-bg bg-violet"></div>
                                </i><span class="menu-title">更改配置</span></a>

                        </li>

                        <li class="active"><a href="{{ route('aboutUrl', $port) }}"><i class="fa fa-slack fa-fw">
                                    <div class="icon-bg bg-green"></div>
                                </i><span class="menu-title">关于我</span></a></li>
                    </ul>
                </div>
            </nav>


            <div id="page-wrapper">
                <!--BEGIN TITLE & BREADCRUMB PAGE-->
                <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
                    <div class="page-header pull-left">
                        <div class="page-title">关于我</div>
                    </div>
                    <ol class="breadcrumb page-breadcrumb pull-right">
                        <li><i class="fa fa-home"></i>&nbsp;<a href="{{ route('accountUrl', $port) }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                        <li class="active">关于我</li>
                    </ol>
                    <div class="clearfix">
                    </div>
                </div>
                <!--END TITLE & BREADCRUMB PAGE-->
                <!--BEGIN CONTENT-->
                <div class="page-content">
                  <h3>关于我</h3>
                    <div class="alert alert-success"><strong>作者：</strong>Jiacy</div>
                    <div class="alert alert-info"><strong>博客：</strong><a href="https://jiacyer.com">Jiacy | 影子</a></div>
                    <div class="alert alert-danger"><strong>服务器有效期至：</strong>{{ $server_life_time }}</div>

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
    <script type="text/javascript" src="{{ asset('vpn/admin_dir/script/jquery-1.10.2.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vpn/admin_dir/script/jquery-migrate-1.2.1.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vpn/admin_dir/script/jquery.menu.js') }}"></script>
    <!--CORE JAVASCRIPT-->
    <script type="text/javascript" src="{{ asset('vpn/admin_dir/script/main.js') }}"></script>

</body>
</html>
