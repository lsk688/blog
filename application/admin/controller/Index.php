<?php
namespace app\admin\Controller;
use think\Controller;
use app\admin\Model\User as UserModel;
use think\Db;
class Index extends Allow {
    //首页
    public function index(){
    	return view();
    }

    // 清除缓存
    public function clear() {
        $res = $this->dDir("../runtime");
        if ($res) {
            $this->success("清除缓存成功！",url('Index'));
        } else {
            $this->error("清除缓存失败！");
        }
        
    }

    // 删除目录
    public function dDir($dir) {
        // 首先判断这个文件是否存在
        if (!file_exists($dir)) {
            return false;   //说明文件不存在
        }
        // scandir()用于获取指定目录下的文件和子目录列表
        $arr = scandir($dir);
        // var_dump($arr); array(6) { [0]=> string(1) "." [1]=> string(2) ".." [2]=> string(10) ".gitignore" [3]=> string(5) "cache" [4]=> string(3) "log" [5]=> string(4) "temp" }
        foreach ($arr as $key => $value) {
            // 任何东西文件夹下面都有".",".."，这俩个字符，所以需要一个判断把俩个值排除
            if ($key>1) {
                $path = $dir.'/'.$value;
                // 判断这个路径是否是目录
                if (is_dir($path)) {
                    // 如果是目录的话需要递归式的调用dDir这个函数
                    $this->dDir($path);
                }
                // 判断如果直接是文件的话就删除
                if (is_file($path)) {
                    unlink($path);
                }
            }
        }
        // if (is_dir($dir)) {
        //     rmdir($dir);
        // }
        // rmdir($dir);
        return true;
    }

    public function welcome(){
        $time = date("Y-m-d H:i:s");
        $this->assign('time',$time);
        return view();
    }

    public function welcome1(){
        return view();
    }

    //用户列表页
    public function memberList(){
        //搜索提交过来的数据
        
        $model = new UserModel;
        $search = input('get.');
        // var_dump($search);
        if (!empty($search)) {
            $start = $search['start'];
            $end = $search['end'];
            $username = $search['username'];
            if ($start != "" && $end == "" && $username == "") {
            $data = db('User')->where("lastlogin",">",$search['start'])->order(['id'=>'asc'])->paginate();
            }elseif($start != "" && $end != "" && $username == "") {
                $data = $model->where('lastlogin','>',$start)->where('lastlogin','<',$end)->order(['id'=>'asc'])->paginate();
            }elseif($start != "" && $end != "" && $username != "") {
                $data = $model->where('lastlogin','>',$start)->where('lastlogin','<',$end)->where('username','like','%'.$username.'%')->order(['id'=>'asc'])->paginate();
            }elseif($start == "" && $end != "" && $username == "") {
                $data = $model->where('lastlogin','<',$end)->order(['id'=>'asc'])->paginate();
            }elseif($start == "" && $end != "" && $username != "") {
                $data = $model->where('lastlogin','<',$end)->where('username','like','%'.$username.'%')->order(['id'=>'asc'])->paginate();
            }elseif($start == "" && $end == "" && $username != "") {
                $data = $model->where('username','like','%'.$username.'%')->order(['id'=>'asc'])->paginate();
            }elseif($start != "" && $end == "" && $username != "") {
                $data = $model->where('lastlogin','>',$start)->where('username','like','%'.$username.'%')->order(['id'=>'asc'])->paginate();
            }else{
                //查询user表中的所有数据
                $data = db('User')->order(['id'=>'asc'])->paginate();
            }
        }else {
            $data = db('User')->order(['id'=>'asc'])->paginate();
        }
        // var_dump($data);
        // echo Db::getLastSql();
        // $data['lastlogin'] = date('Y-m-d H:i:s',time());
        $page = $data->render();
        //把查询到的数据分配到前端页面
        $this->assign([
            'data' => $data,
            'page' => $page,
        ]);
        return view();
    }

    //编辑用户页面
    public function memberedit($id){
        $model = new UserModel;
        $data = $model->find($id);
        // var_dump($data);
        // echo Db::getLastSql();
        $this->assign([
            'data' => $data,
        ]);
        return view();
    }


    //修改用户密码页面
    public function memberpassword($id){
        $model = new UserModel;
        $data = $model->find($id);
        // var_dump($data);
        // echo Db::getLastSql();
        $this->assign([
            'data' => $data,
        ]);
        return view();
    }

    //用户编辑
    public function ajax_update() {
        parse_str(input("post.str"),$arr); //获取提交过来的数据，然后转换为数组
        // var_dump($arr);
        $model=new UserModel;
        if ($arr['password']) {
            $data=$model->find($arr['id']);
            $password=$data['password'];
            if (md5($arr['password'])==$password) {
                return $arr=['error'=>"新密码与旧密码一致，请修改",'code'=>1];
            }
        }
        $validate=\think\Loader::validate('UserEdit');
        if (!$validate->scene('edit2')->check($arr)) {
            return $arr=['error'=>$validate->getError(),'code'=>1];
        }
        if ($arr['password'] != $arr['repass'] && $arr['repass'] != "") {
            return $arr=['error'=>"两次密码不一致",'code'=>1];
        }
        $res=$model->editM($arr);
        if ($res) {
            echo 1;
        }else {
            echo 2;
        }
    }

    // public function ajax_update() {
    //     // parse_str(input("post.str"),$arr); //获取提交过来的数据，然后转换为数组
    //     $arr['id'] = $_POST['id'];
    //     $arr['status'] = $_POST['status'];
    //     $arr['username'] = $_POST['username'];
    //     $arr['password'] = $_POST['password'];
    //     // var_dump($arr);
    //     $model=new UserModel;
    //     $validate=\think\Loader::validate('User');
    //     if (!$validate->scene('edit1')->check($arr)) {
    //         return $arr=['error'=>$validate->getError(),'code'=>1];
    //     }
    //     $res=$model->editM($arr);
    //     if ($res) {
    //         echo 1;
    //     }else {
    //         echo 2;
    //     }
    // }

    //用户密码修改
    public function ajax_update_password() {
        // parse_str(input("post.str"),$arr); //获取提交过来的数据，然后转换为数组
        $arr['id'] = $_POST['id'];
        $arr['status'] = $_POST['status'];
        $arr['oldpass'] = $_POST['oldpass'];
        $arr['username'] = $_POST['username'];
        $arr['password'] = $_POST['password'];
        $arr['repass'] = $_POST['repass'];
        // var_dump($arr);
        $model=new UserModel;
        if ($arr['oldpass']) {
            $data=$model->find($arr['id']);
            $password=$data['password'];
            if (md5($arr['oldpass'])!=$password) {
                return $arr=['error'=>"旧密码不正确",'code'=>1];
            }
            if ($arr['password'] == $arr['oldpass']) {
                return $arr=['error'=>"新密码与旧密码一致，请修改",'code'=>1];
            }
        }
        if ($arr['password'] != $arr['repass'] && $arr['repass'] != "") {
            return $arr=['error'=>"两次密码不一致",'code'=>1];
        }
        $validate=\think\Loader::validate('UserEdit');
        if (!$validate->scene('edit1')->check($arr)) {
            return $arr=['error'=>$validate->getError(),'code'=>1];
        }
        unset($arr['oldpass']);
        unset($arr['repass']);
        $res=$model->passwordeditM($arr);
        if ($res) {
            echo 1;
        }else {
            echo 2;
        }
    }

    //管理员禁用和启用状态的改变
    public function ajax_status() {
        $data=input("post.");
        // print_r($data);
        $res=db("User")->where("id",$data['id'])->update(["status"=>$data['status']]);           //通过助手函数更新数据
        // $model=new MangerModel;
        // $res=$model->editM($arr);            //通过模型去修改
        if ($res) {
            echo 1;
        }else {
            echo 2;
        }
    }

    //用户添加页面
    public function memberadd() {
        return view();
    }

    // 用户添加
    public function ajax_add() {
        parse_str(input("post.str"),$arr); //获取提交过来的数据，然后转换为数组$arr
        //验证
        $validate = \think\Loader::validate('User');  //通过加载把验证类拿过来
        // //判断$arr添加时候的验证场景，自定义验证规则
        if (!$validate->scene('add')->check($arr)) {
            return $arr=['error'=>$validate->getError(),'code'=>1];
        }else if($arr['password'] != $arr['repass'] && $arr['repass'] != "") {
            return $arr=['error'=>'两次密码不一致','code'=>1];
        }
        $model = new UserModel;   //实例化MangerModel模型
        unset($arr['repass']);
        $res=$model->addM($arr);
        if ($res) {
            echo 1;
        }else {
            echo 2;
        }
    }

    //用户删除
    public function ajax_del() {
        $id = input('post.id'); //获取提交过来的id
        $model = new UserModel;   //实例化MangerModel模型
        $res=$model->delM($id);
        if ($res) {
            echo 1;
        }else {
            echo 2;
        }
    }

    //批量删除
    public function ajax_delAll() {
        // var_dump(input('post.id'));
        $model = new UserModel;
        $res = $model->delM(input('post.id'));
        return $res;
    }
}