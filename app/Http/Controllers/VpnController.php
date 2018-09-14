<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class VpnController extends Controller
{
    public function registerPage() {
        return view('vpn/signup', ['ret'=>'']);
    }

    public function registerPost(Request $request) {
        $code = $request->input('code');
        $ret = DB::select('SELECT * FROM invitation_code WHERE invitation_code=?', [$code]);

        if (sizeof($ret)!=0) {
            // 存在该邀请码
            $server = array_column($ret, 'server')[0];
            $username = $request->input('username');
            $email = $request->input('email');
            $password = $request->input('password');
            $confirmPassword = $request->input('confirmPassword');
            $port_password = $request->input('port_password');
            if (strcmp($password, $confirmPassword)==0) {
                // 两次密码输入正确
                do {
                    $port = rand(1024, 65535); // 随机生成端口号
                    $ret = DB::select('SELECT account FROM account_info WHERE account=?', [$port]);
                    if (sizeof($ret)==0)
                        break; // 不存在该端口号
                } while(true);
                
                // 经过两次后端hash，总三次hash
                $password = md5(md5($password));

                DB::insert('INSERT INTO account_info (account, usr_name, password) VALUES (?,?,?)',
                    [$port, $username, $port_password]);
                DB::insert('INSERT INTO account_config (account, method, protocol, protocol_param, 
                    obfs, obfs_param, server) VALUES (?,?,?,?,?,?,?)', [$port, 'chacha20', 'auth_aes128_md5', null,
                    'tls1.2_ticket_auth', 'cloudflare.com', $server]);
                DB::insert('INSERT INTO login_info (email, md5passwd, account) VALUES (?,?,?)',
                    [$email, $password, $port]);
                DB::delete('DELETE FROM invitation_code WHERE invitation_code=?', [$code]);

                // 重启VPN
                $this->updateVpnSystem(null, $port);
                system('./vpn/admin_dir/restartVPN');
                ob_clean();

                return view('vpn/signup', ['ret'=>'good register']);
            }
        }
        return view('vpn/signup', ['ret'=>'bad register']);
    }

    public function loginPage() {
        return view('vpn/login', ['email_ret'=>'','password_ret'=>'']);
    }

    public function loginPost(Request $request) {
        $email = $request->input('email');
        $password = $request->input('password');
        $ret = DB::select('SELECT * FROM login_info WHERE email=?', [$email]);

        if (sizeof($ret)!=0) {
            // 帐号正确
            $md5password = array_column($ret, 'md5passwd')[0];
            $password = md5($password);

            if (strcmp($password, $md5password)==0) {
                // 密码正确
                $port = array_column($ret, 'account')[0];
                $ip = $request->getClientIp();
                $time = time();
                $token = md5($port.$md5password.$ip.$time);
                DB::delete('DELETE FROM login_status WHERE account=?', [$port]);
                $bool = DB::insert('INSERT INTO login_status (account, token, ip) VALUES (?,?,?)',
                    [$port, $token, $ip]);

                if ($bool) {
                    $cookie = cookie('vpn', $token, 0, '/vpn/');
                    $ret = DB::select('SELECT * FROM account_info, account_config 
                    WHERE account_info.account=? AND account_config.account=?', [$port, $port]);
                    $usr_name = array_column($ret, 'usr_name')[0];
                    $port_password = array_column($ret, 'password')[0];
                    $method = array_column($ret, 'method')[0];
                    $protocol = array_column($ret, 'protocol')[0];
                    $protocol_param = array_column($ret, 'protocol_param')[0];
                    $obfs = array_column($ret, 'obfs')[0];
                    $obfs_param = array_column($ret, 'obfs_param')[0];
                    $server = array_column($ret, 'server')[0];

                    $qr_string = $this->generate_ssr_url($port, $port_password, $server, $method, $protocol, $obfs, $obfs_param);

                    return response()->view('vpn/account', compact('usr_name','port',
                        'port_password', 'method', 'server', 'protocol', 'protocol_param',
                        'obfs', 'obfs_param', 'qr_string'))->withCookie($cookie);
//                    return Redirect()->to('vpn/AccountInfo/'.$port)->withCookie($cookie);
                }
                else
                    return Redirect()->to('vpn/login');
            } else {
                // 密码错误
                return view('vpn/login', ['email_ret'=>$email, 'password_ret'=>'bad password']);
            }

        } else {
            // 帐号错误
            return view('vpn/login', ['email_ret'=>'bad email', 'password_ret'=>'bad password']);
        }
    }

    public function accountPage(Request $request, $port) {
        $ip = $request->getClientIp();
        $ret = DB::select('SELECT token FROM login_status WHERE account=? AND ip=?', [$port, $ip]);
        $cookie = $request->cookie('vpn');
        if (sizeof($ret)==0)    // IP错误
            return Redirect()->to('vpn/login');

        $t = array_column($ret, 'token')[0];
        if (strcmp($t, $cookie)==0) {
            // IP和token正确
            $ret = DB::select('SELECT * FROM account_info, account_config 
                    WHERE account_info.account=? AND account_config.account=?', [$port, $port]);
            $usr_name = array_column($ret, 'usr_name')[0];
            $port_password = array_column($ret, 'password')[0];
            $method = array_column($ret, 'method')[0];
            $protocol = array_column($ret, 'protocol')[0];
            $protocol_param = array_column($ret, 'protocol_param')[0];
            $obfs = array_column($ret, 'obfs')[0];
            $obfs_param = array_column($ret, 'obfs_param')[0];
            $server = array_column($ret, 'server')[0];

            $qr_string = $this->generate_ssr_url($port, $port_password, $server, $method, $protocol, $obfs, $obfs_param);

            return response()->view('vpn/account', compact('usr_name','port',
                'port_password', 'method', 'server', 'protocol', 'protocol_param',
                'obfs', 'obfs_param', 'qr_string'))->withCookie($cookie);
        } else {
            // token错误
            return Redirect()->to('vpn/login');
        }
    }

    public function configPage(Request $request, $port) {
        $ip = $request->getClientIp();
        $cookie = $request->cookie('vpn');
        $ret = DB::select('SELECT token FROM login_status WHERE account=? AND ip=?', [$port, $ip]);
        $msg = '';
        if (sizeof($ret)==0)    // IP错误
            return Redirect()->to('vpn/login');

        $t = array_column($ret, 'token')[0];
        if (strcmp($t, $cookie)==0) {
            // IP和token正确
            $ret = DB::select('SELECT usr_name FROM account_info WHERE account=?', [$port]);
            $usr_name = array_column($ret, 'usr_name')[0];
            $ret = DB::select('SELECT email FROM login_info WHERE account=?', [$port]);
            $email = array_column($ret, 'email')[0];
            $run_exception = '';

            return response()->view('vpn/Config', compact('port', 'usr_name', 'msg', 'email', 'run_exception'))
                ->withCookie($cookie);
        } else {
            // token错误
            return Redirect()->to('vpn/login');
        }
    }

    public function aboutPage(Request $request, $port) {
        $ip = $request->getClientIp();
        $ret = DB::select('SELECT token FROM login_status WHERE account=? AND ip=?', [$port, $ip]);
        $cookie = $request->cookie('vpn');
        if (sizeof($ret)==0)    // IP错误
            return Redirect()->to('vpn/login');

        $t = array_column($ret, 'token')[0];
        if (strcmp($t, $cookie)==0) {
            // IP和token正确
            $ret = DB::select('SELECT usr_name FROM account_info WHERE account=?', [$port]);
            $usr_name = array_column($ret, 'usr_name')[0];
            $server = 'node.jiacyer.com';
            $ret = DB::select('SELECT life FROM server_info WHERE server=?', [$server]);
            $server_life_time = array_column($ret, 'life')[0];

            return response()->view('vpn/about', compact('port','usr_name', 'server_life_time'))
                ->withCookie($cookie);
        } else {
            // token错误
            return Redirect()->to('vpn/login');
        }
    }

    public function updatePost(Request $request, $port) {
        $usrname = $request->input('usrname');
        $email = $request->input('email');
        $usr_password = $request->input('usr_password');
        $confirm_password = $request->input('confirmPassword');
        $port_s = $request->input('port');
        $port_password = $request->input('port_password');
        $method = $request->input('method');
        $protocol = $request->input('protocol');
        $obfs = $request->input('obfs');
        $protocol_param = $request->input('protocol_param');
        $obfs_param = $request->input('obfs_param');
        $run_exception = '';

//        $ret = DB::select('SELECT * FROM login_info WHERE email=?', [$email]);
        $old_port = $port;
        if ($port_s!='') {
            // 更新端口
            $new_port = intval($port_s);

            $ret_port = DB::select('SELECT * FROM account_info WHERE account=?', [$new_port]);
            if ($new_port<1024 || $new_port>65535 || sizeof($ret_port)!=0) {
                // 端口不符合要求或者已被占用
                $ret = DB::select('SELECT usr_name FROM account_info WHERE account=?', [$port]);
                $usr_name = array_column($ret, 'usr_name')[0];
                $msg = 'Bad port';
                return view('vpn/Config', compact('port', 'usr_name', 'msg', 'email', 'run_exception'));
            } else {
                // 端口合法
                DB::update('UPDATE account_info SET account=? WHERE account=?', [$new_port, $port]);
                $port = $new_port;
            }
        }

        if ($usrname!='') {
            // 更新用户名
            DB::update('UPDATE account_info SET usr_name=? WHERE account=?', [$usrname, $port]);
            $usr_name = $usrname;
        } else {
            $ret = DB::select('SELECT usr_name FROM account_info WHERE account=?', [$port]);
            $usr_name = array_column($ret, 'usr_name')[0];
        }

        if ($usr_password!='' && $confirm_password!='') {
            // 更新密码
            if ($usr_password == $confirm_password) {
                // 更新成功
                DB::update('UPDATE login_info SET md5passwd=? WHERE account=?', [$usr_password, $port]);
            } else {
                // 更新失败
                $ret = DB::select('SELECT usr_name FROM account_info WHERE account=?', [$port]);
                $usr_name = array_column($ret, 'usr_name')[0];
                $msg = 'Bad password';
                return view('vpn/Config', compact('port', 'usr_name', 'msg', 'email', 'run_exception'));
            }
        }

        if ($port_password!='') {
            // 更新端口密码
            DB::update('UPDATE account_info SET password=? WHERE account=?', [$port_password, $port]);
        }

        if ($method!='null') {
            // 更新加密
            DB::update('UPDATE account_config SET method=? WHERE account=?', [$method, $port]);
        }

        if ($protocol!='null') {
            // 更新协议
            DB::update('UPDATE account_config SET protocol=? WHERE account=?', [$protocol, $port]);
        }

        if ($obfs!='null') {
            // 更新混淆
            DB::update('UPDATE account_config SET obfs=? WHERE account=?', [$obfs, $port]);
        }

        if ($protocol_param!='') {
            // 更新协议参数
            if ($protocol_param=='null' || $protocol=='origin') {
                DB::update('UPDATE account_config SET protocol_param=NULL WHERE account=?', [$port]);
            } else {
                DB::update('UPDATE account_config SET protocol_param=? WHERE account=?', [$protocol_param, $port]);
            }
        }

        if ($obfs_param!='') {
            // 更新混淆参数
            if ($obfs_param=='null' || $obfs=='plain') {
                DB::update('UPDATE account_config SET obfs_param=NULL WHERE account=?', [$port]);
            } else {
                DB::update('UPDATE account_config SET obfs_param=? WHERE account=?', [$obfs_param, $port]);
            }
        }

        $bool1 = $this->updateVpnSystem($old_port, $port);
        $run_exception = system('./vpn/admin_dir/restartVPN', $bool2);
        ob_clean();

        if ($bool1 && !$bool2) {
//        if ($bool1) {
            $msg = 'succeed';
//            $run_exception = ''.$bool1;
            return view('vpn/Config', compact('port', 'usr_name', 'msg', 'email', 'run_exception'));
        } else {
            $msg = 'fail';
            $run_exception = $run_exception;
            return view('vpn/Config', compact('port', 'usr_name', 'msg', 'email', 'run_exception'));
        }
    }

    private function updateVpnSystem($old_port, $new_port) {
        $file_name = 'shadowsocks.json';

        if (Storage::disk('vpn_files')->exists($file_name)) {
            // 文件存在时
            $contents = Storage::disk('vpn_files')->get($file_name);
            $array = json_decode($contents, true);
            $port_password_array = $array['port_password'];

            // 老端口配置
            if ($old_port!=null)
                $old_port_config = $port_password_array[$old_port];

            // 公共参数
            $method = $array['method'];
            $protocol = $array['protocol'];
            $protocol_param = $array['protocol_param'];
            $obfs = $array['obfs'];
            $obfs_param = $array['obfs_param'];

            if ($old_port !=null && $old_port != $new_port) {
                // 改变端口号时，先更改端口号
                foreach ($port_password_array as $key=>$value) {
                    if ($key == $old_port)
                        unset($port_password_array[$key]);
                }
                $port_password_array[$new_port] = $old_port_config;
            }

//            $old_port_config = $port_password_array[$new_port];
            unset($port_password_array[$new_port]);

            $ret = DB::select('SELECT * FROM account_info, account_config WHERE account_info.account=?
                              AND account_info.account=account_config.account', [$new_port]);
            $new_method = array_column($ret, 'method')[0];
            $new_protocol = array_column($ret, 'protocol')[0];
            $new_protocol_param = array_column($ret, 'protocol_param')[0];
            $new_obfs = array_column($ret, 'obfs')[0];
            $new_obfs_param = array_column($ret, 'obfs_param')[0];
            $new_password = array_column($ret, 'password')[0];

            if ($new_method==$method && $new_protocol==$protocol && $new_obfs_param == $obfs_param &&
            $new_protocol_param == $protocol_param && $new_obfs==$obfs) {
                // 与公共配置一致时
                $port_password_array[$new_port] = $new_password;
            } else {
                // 独有配置
                $new_port_config = array();
                $new_port_config['password'] = $new_password;
                if (sizeof($new_method)!=0 && $new_method!=$method)
                    $new_port_config['method'] = $new_method;
                if (sizeof($new_protocol)!=0 && $new_protocol!=$protocol)
                    $new_port_config['protocol'] = $new_protocol;
                if (sizeof($new_protocol_param)!=0 && $new_protocol_param!=$protocol_param)
                    $new_port_config['protocol_param'] = $new_protocol_param;
                if (sizeof($new_obfs)!=0 && $new_obfs!=$obfs)
                    $new_port_config['obfs'] = $new_obfs;
                if (sizeof($new_obfs_param)!=0 && $new_obfs_param!=$obfs_param)
                    $new_port_config['obfs_param'] = $new_obfs_param;
                $port_password_array[$new_port] = $new_port_config;
            }

            unset($array['port_password']);
            $array['port_password'] = $port_password_array;
        } else {
            // 文件不存在时
            return false;
        }

        $array = $this->resort_shadowsocks_json($array);
        $json = json_encode($array, JSON_PRETTY_PRINT);
        $bool = Storage::disk('vpn_files')->put($file_name, $json);
        return $bool;
    }

    private function resort_shadowsocks_json($array) {
        $keys = array('server', 'server_ipv6', 'local_address', 'local_port', 'port_password',
            'timeout', 'method', 'protocol', 'protocol_param', 'obfs', 'obfs_param', 'redirect',
            'dns_ipv6', 'fast_open', 'workers');

        foreach ($keys as $k=>$v) {
            $t = $array[$v];
            unset($array[$v]);
            $array[$v] = $t;
        }

        return $array;
    }

    /**
     * @param $port 端口
     * @param $port_password 端口密码
     * @param $obfs_param 混淆参数
     * @param $server 服务器IP
     * @param $protocol 协议
     * @param $method 加密
     * @param $obfs 混淆
     * @return string SSR专属URL
     */
    private function generate_ssr_url($port, $port_password, $server, $method, $protocol, $obfs, $obfs_param): string
    {
        $password_base64 = base64_encode($port_password);
        $password_base64 = str_replace('=', '', $password_base64);
        $obfs_param_base64 = base64_encode($obfs_param);
        $obfs_param_base64 = str_replace('=', '', $obfs_param_base64);
        $remarks = base64_encode("Welcome");
        $remarks = str_replace('=', '', $remarks);
        $group = base64_encode("Jiacyer.com");
        $group = str_replace('=', '', $group);
        $config_string = $server . ":" . $port;
        if ($protocol != null)
            $config_string = $config_string . ":" . $protocol;
        $config_string = $config_string . ":" . $method;
        if ($obfs != null)
            $config_string = $config_string . ":" . $obfs;
        $config_string = $config_string . ":" . $password_base64 . "/?";
        if ($obfs_param != null)
            $config_string = $config_string . "obfsparam=" . $obfs_param_base64 . "&";
        $config_string = $config_string . "remarks=" . $remarks . "&group=" . $group;
        $base64_string = base64_encode($config_string);
        $base64_string = str_replace('=', '', $base64_string);
        $qr_string = "ssr://" . $base64_string;
        return $qr_string;
    }

}
