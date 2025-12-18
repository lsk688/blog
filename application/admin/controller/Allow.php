<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;
use think\Cache;
class Allow extends Controller{
	//初始化方法
	public function _initialize() {
		//判断session('name')或者session('id')是否存在
		if (!session('name') || !session('id')) {
			$this->error('请登录',url('Login/index'));
		}

		// 检查用户活跃时间
        $this->checkActiveTime();
        session('lastActiveTime', time());

        // 权限把控
        $auth = new Auth();
        // 获取当前的控制器和方法
        $request = request();
        $request = Request::instance();
        $con = $request -> controller();
        $action = $request -> action();
        // 可以获取到当前的控制器和方法
        $name = $con .'/'. $action;
        // echo $name = $con .'/'. $action;
        // 无需检测
        $noCheck = array('Index/index','Index/clear');
        if (session('id')!=1){
            // 这个页面不需要判断
            if (!in_array($name,$noCheck)) {
                // 检测当前控制器是否属于这个用户的权限
                if (!$auth->check($name,session('id'))) {
                    $this->error('没有权限',url('Index/index'));
                    // var_dump(111);
                }
            }
        }
	}


	/**
     * 检查用户活跃时间
     */
    protected function checkActiveTime()
    {
        // 获取用户上一次活跃时间
        $lastActiveTime = session('lastActiveTime');

        // 如果用户上一次活跃时间不存在，说明用户刚刚登录，直接返回
        if (!$lastActiveTime) {
            return;
        }

        // 计算距离上一次活跃的时间差
        $timeDiff = time() - $lastActiveTime;

        // 如果时间差大于Session有效期，说明用户已经超时，清除登录状态
        if ($timeDiff > config('session.expire')) {
            session(null);
            cookie(null);
            $this->redirect('Login/index'); // 跳转到登录页面
        }
    }
}


?>