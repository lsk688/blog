<?php 
namespace app\admin\validate;
use think\validate;
class Colum extends validate{
	//验证规则
	protected $rule=[
		'name'=>'unique:Colum|require',
	];
	// 验证消息
	protected $message=[
		'name:require'=>'栏目名称不能为空',
		'name:unique'=>'栏目名称不能重复',
	];
	// 验证场景
	protected $scene=[
		'add'=>['name'],
	];
}