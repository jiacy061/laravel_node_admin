<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <title>个人中心 - VPN管理</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

    <!--Loading bootstrap css-->
    <link type="text/css" rel="stylesheet"
          href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,300,700">
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
        <nav id="topbar" role="navigation" style="margin-bottom: 0;" data-step="3"
             class="navbar navbar-default navbar-static-top">
            <div class="navbar-header">
                <button type="button" data-toggle="collapse" data-target=".sidebar-collapse" class="navbar-toggle"><span
                            class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span
                            class="icon-bar"></span><span class="icon-bar"></span></button>
                <a id="logo" href="{{ route('accountUrl', $port) }}" class="navbar-brand"><span
                            class="fa fa-rocket"></span><span class="logo-text">VPN管理界面</span><span
                            style="display: none" class="logo-text-icon">µ</span></a></div>
            <div class="topbar-main"><a id="menu-toggle" href="#" class="hidden-xs"><i class="fa fa-bars"></i></a>

                <ul class="nav navbar navbar-top-links navbar-right mbn">
                    <li class="dropdown topbar-user"><a data-hover="dropdown" href="#"
                                                        class="dropdown-toggle">&nbsp;<span class="hidden-xs">{{$usr_name}}
                                ，你好！</span>&nbsp;</a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
    <!--END TOPBAR-->
    <div id="wrapper">
        <!--BEGIN SIDEBAR MENU-->
        <nav id="sidebar" role="navigation" data-step="2" data-intro="Template has <b>many navigation styles</b>"
             data-position="right" class="navbar-default navbar-static-side" style="min-height: 100%;">
            <div class="sidebar-collapse menu-scroll">
                <ul id="side-menu" class="nav">

                    <div class="clearfix"></div>
                    <li class="active"><a href="{{ route('accountUrl', $port) }}"><i class="fa fa-tachometer fa-fw">
                                <div class="icon-bg bg-orange"></div>
                            </i><span class="menu-title">个人中心</span></a></li>

                    <li><a href="{{ route('configUrl', $port) }}"><i class="fa fa-send-o fa-fw">
                                <div class="icon-bg bg-violet"></div>
                            </i><span class="menu-title">更改配置</span></a>

                    </li>

                    <li><a href="{{ route('aboutUrl', $port) }}"><i class="fa fa-slack fa-fw">
                                <div class="icon-bg bg-green"></div>
                            </i><span class="menu-title">关于我</span></a></li>
                </ul>
            </div>
        </nav>


        <div id="page-wrapper">
            <!--BEGIN TITLE & BREADCRUMB PAGE-->
            <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
                <div class="page-header pull-left">
                    <div class="page-title">个人中心</div>
                </div>
                <ol class="breadcrumb page-breadcrumb pull-right">
                    <li><i class="fa fa-home"></i>&nbsp;<a
                                href="{{ route('accountUrl', $port) }}">Home</a>&nbsp;&nbsp;<i
                                class="fa fa-angle-right"></i>&nbsp;&nbsp;
                    </li>
                    <li class="active">个人中心</li>
                </ol>
                <div class="clearfix">
                </div>
            </div>
            <!--END TITLE & BREADCRUMB PAGE-->
            <!--BEGIN CONTENT-->
            <div class="page-content">
                <div id="generalTabContent" class="tab-content responsive">
                    <div id="alert-tab" class="tab-pane fade in active">
                        <div class="row">
                            <div class="col-lg-6"><h3>SS/SSR基本配置</h3>

                                <div class="alert alert-success"><strong>端口号：</strong>{{ $port }}</div>
                                <div class="alert alert-info"><strong>密码：</strong>{{ $port_password }}</div>
                                <div class="alert alert-warning"><strong>加密：</strong>{{ $method }}</div>
                                <div class="alert alert-danger"><strong>服务器IP：</strong>{{ $server }}</div>
                                <div class="mbxl"></div>

                            </div>
                            <div class="col-lg-6">
                                <h3>SSR独享额外配置</h3>
                                <div class="alert alert-success"><strong>协议：</strong>{{ $protocol }}</div>
                                <div class="alert alert-info"><strong>协议参数：</strong>{{ $protocol_param }}</div>
                                <div class="alert alert-warning"><strong>混淆：</strong>{{ $obfs }}</div>
                                <div class="alert alert-danger"><strong>混淆参数：</strong>{{ $obfs_param }}</div>
                            </div>
                        </div>
                        <div class="row">
                            <h3 style="padding-left: 1%">二维码一键配置</h3>
                            <div class="col-lg-6">
                                <div id="ss_content" class="alert alert-success alert-dismissable">
                                    <h5><strong id="ss_tip_text"><br>点击此处展开 SS 配置二维码</strong></h5>
                                    <div id = "qrcodeDivOfSS" style="display:none">
                                        <div id="qrcodeCanvasOfSS" style="width: 38%"></div>
                                        <h5><strong><br>使用 SS 需要将协议设置为“origin”，混淆设置为“plain”。</strong></h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div id="ssr_content" class="alert alert-success alert-dismissable">
                                    <h5><strong id="ssr_tip_text"><br>点击此处展开 SSR 配置二维码</strong></h5>
                                    <div id="qrcodeDivOfSSR" style="display:none">
                                        <div id="qrcodeCanvasOfSSR" style="width: 38%"></div>
                                        <h5><strong><br>推荐使用 SSR，并将协议设置为“auth_aes128_md5”，混淆设置为“tls1.2_ticket_auth”。</strong></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <h3>SS/SSR软件推荐</h3>
                                <div class="alert alert-danger alert-dismissable">
                                    <strong>IOS: </strong>FirstWingy、SsrConnectPro<br>
                                    <strong>Android: </strong><a href="https://downloads.jiacyer.com/ShadowsocksR.apk">ShadowSocksR</a><br>
                                    <strong>Windows: </strong><a href="https://downloads.jiacyer.com/ShadowsocksR.zip">ShadowSocksR</a><br>
                                    <strong>多平台原版SS: </strong><a href="https://shadowsocks.org/en/download/clients.html">shadowsocks.org</a>
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
<!--CORE JAVASCRIPT-->
<script type="text/javascript" src="{{ asset('vpn/admin_dir/js/main.js') }}"></script>
<!-- QRCODE generate -->
<script type="text/javascript" src="{{ asset('vpn/admin_dir/js/jquery.qrcode.js') }}"></script>
<script type="text/javascript" src="{{ asset('vpn/admin_dir/js/qrcode.js') }}"></script>
<script>
    //jQuery('#qrcode').qrcode("this plugin is great");
    jQuery('#qrcodeCanvasOfSS').qrcode({
        text: "{{ $qr_string_ss }}"
    });
    jQuery('#qrcodeCanvasOfSSR').qrcode({
        text: "{{ $qr_string_ssr }}"
    });
</script>
<script>
    var ssDiv = $('#ss_content');
    var ssrDiv = $('#ssr_content');
    var qrcodeDivOfSS = $('#qrcodeDivOfSS');
    var qrcodeDivOfSSR = $('#qrcodeDivOfSSR');
    var ssText = $('#ss_tip_text');
    var ssrText = $('#ssr_tip_text');
    ssDiv.click(function () {
        qrcodeDivOfSS.slideToggle();
        ssText.slideToggle();
    });
    ssrDiv.click(function () {
        qrcodeDivOfSSR.slideToggle();
        ssrText.slideToggle();
    })
</script>

</body>
</html>
