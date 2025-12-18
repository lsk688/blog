<?php
namespace app\admin\model;
use think\Model;
class User extends Model{
	//添加
	public function addM($arr){
		//判断是否输入密码
		$arr['password'] = md5($arr['password']);
		//判断是否保存成功，成功返回true，失败返回false
		if ($this->save($arr)) {
			return true;
		}else {
			return false;
		}
	}

	// 修改
	public function editM($arr)
	{
		if ($arr['password']) {
			$arr['password']=md5($arr['password']);
		}else {
			$data=$this->find($arr['id']);
			$arr['password']=$data['password'];
		}
		$res=$this::update(["username"=>$arr['username'],"password"=>$arr['password'],"status"=>$arr['status'],"id"=>$arr['id']]);
		return $res;		//返回结果
	}

	// 修改
	public function passwordeditM($arr)
	{
		if ($arr['password']) {
			$arr['password']=md5($arr['password']);
		}else {
			$data=$this->find($arr['id']);
			$arr['password']=$data['password'];
		}
		$res=$this::update(["password"=>$arr['password'],"id"=>$arr['id']]);
		return $res;		//返回结果
	}

	// 删除
	public function delM($id)
	{
		return $this::destroy($id); 		//tp5里面的删除,$id可以接受多个id的
	}

	//登录验证
	public function login($data) {
		//getByName通过用户名检测
		$admin = User::getByusername($data['username']);		//去数据库查询该username的数据，tp5中的内置验证方法
		$status = $admin['status'];
		// var_dump($admin);
		//判断该数据库中是否有这条数据
		if ($admin) {
			$id = $admin['id'];
			$user = $admin['username'];
			$pass = $admin['password'];
			//判断提交过来的密码是否等于数据库中的密码
			if($pass==md5($data['password'])){
				if ($status==1) {
					//密码正确，用户名正确
					//开启session
					session('name',$user);		//登录的用户名
					session('id',$id);			//拿到用户的id
					return 1;
				}else{
					//该用户被禁用了
					return 4;
				}
			}else {
				//密码不正确
				return 2;
			}
		} else {
			//用户不存在
			return 3;
		}
		
	}
}

?>