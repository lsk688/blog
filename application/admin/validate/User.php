<?php
namespace app\admin\validate;
use think\Validate;
class User extends Validate{
	//验证规则
	// 受保护的
	protected $rule=[
				//   唯一            必填    最大长度
		'username'=>'unique:User|require|max:10',
		'password'=>'require|max:12|min:5',
		'repass'  =>'require',
	];
	// 验证消息
	protected $message=[
		'username:unique'=>'用户名不能重复',
		'username:require'=>'用户名不能为空',
		'username:max'=>'用户名长度不能大于10位',
		'password:require'=>'用户密码不能为空',
		'password:max'=>'密码长度不能大于12位',
		'password:min'=>'密码长度不能小于5位',
		'repass:require'=>'确认密码不能为空',
	];
	// 验证场景
	protected $scene=[
		'add'=>['username','password','repass'],			//验证的是添加时候的用户名跟密码
		'edit'=>['username'],					//验证的是编辑时候的用户名
	];
}
?>