<?php
namespace app\admin\Controller;
use think\Controller;
use app\admin\model\User as UserModel;
class Login extends Controller {
    //登录
    public function index(){
        //判断是否为post提交
        if(Request()->isPost()){
            $data = input("post.");
            // 先查找是否配置项是否开启验证码验证
            $conf = db('Conf')->where(['ename'=>'code'])->find();
            if ($conf['val']=='是') {
                //判断验证码是否正确
                if ($this->check($data['yzm'])) {
                    // 去User模型中进行验证码验证
                    $model = new UserModel;
                    $num = $model->login($data);
                    // var_dump($num);
                    if ($num == 1) {
                        // 登录成功后插入登录时间和登录次数加1
                        $loginId = session('id');
                        $time = date('Y-m-d H:i:s',time());
                        $User = db('User')->find($loginId);
                        $Unum = $User['num']+1;
                        db('User')->update(['id'=>$loginId,'lastlogin'=>$time,'num'=>$Unum]);
                        $this->success('登录成功！',url('Index/index'));
                    }
                    if ($num == 2) {
                        $this->error('密码不正确！');
                    }
                    if ($num == 3) {
                        $this->error('用户名不存在！');
                    }
                    if ($num == 4) {
                        $this->error('该用户被禁用了！');
                    }
                }else {
                    $this->error('验证码不正确！');
                }
            } else {
                // 去User模型中进行验证码验证
                $model = new UserModel;
                $num = $model->login($data);
                // var_dump($num);
                if ($num == 1) {
                    // 登录成功后插入登录时间和登录次数加1
                    $loginId = session('id');
                    $time = date('Y-m-d H:i:s',time());
                    $User = db('User')->find($loginId);
                    $Unum = $User['num']+1;
                    db('User')->update(['id'=>$loginId,'lastlogin'=>$time,'num'=>$Unum]);
                    $this->success('登录成功！',url('Index/index'));
                }
                if ($num == 2) {
                    $this->error('密码不正确！');
                }
                if ($num == 3) {
                    $this->error('用户名不存在！');
                }
                if ($num == 4) {
                    $this->error('该用户被禁用了！');
                }
            }
            
            //判断验证码是否正确
            // if ($this->check($data['yzm'])) {
            //     // 去User模型中进行验证码验证
            //     $model = new UserModel;
            //     $num = $model->login($data);
            //     // var_dump($num);
            //     if ($num == 1) {
            //         // 登录成功后插入登录时间和登录次数加1
            //         $loginId = session('id');
            //         $time = date('Y-m-d H:i:s',time());
            //         $User = db('User')->find($loginId);
            //         $Unum = $User['num']+1;
            //         db('User')->update(['id'=>$loginId,'lastlogin'=>$time,'num'=>$Unum]);
            //         $this->success('登录成功！',url('Index/index'));
            //     }
            //     if ($num == 2) {
            //         $this->error('密码不正确！');
            //     }
            //     if ($num == 3) {
            //         $this->error('用户名不存在！');
            //     }
            //     if ($num == 4) {
            //         $this->error('该用户被禁用了！');
            //     }
            // }else {
            //     $this->error('验证码不正确！');
            // }
        }else {
            $data = db('Conf')->where(['ename'=>'code'])->find();
            // echo "<pre>";
            // print_r($data);
            // echo "</pre>";
            if ($data) {
                $this->assign('data',$data);
            }
            return view();
        }
    }

    //验证码
    public function check($code="") {
        // 实例化一下验证码规则，验证码规则是在\think\captcha\下
        $captcha = new \think\captcha\Captcha();
        //验证码检测
        if(!$captcha->check($code)){
            return false;
        }else {
            return true;
        }
    }

    //退出
    public function logout() {
        session(null);  //清空session
        $this->success('退出成功！',url('index'));
    }
}