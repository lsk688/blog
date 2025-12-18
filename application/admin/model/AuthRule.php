<?php
namespace app\admin\model;
use think\Model;
class AuthRule extends Model{
	// 无限分类展示
	public function authRuleTree() {
		// 首先查询一下当前的所有数据
		$AuthRule = $this->order('sort desc')->select();
		return $this->sort($AuthRule);
	}

	// 改造数组
	// 查询出pid等于0的顶级分类，然后再查询顶级分类下的下一级分类
	public function sort($data,$pid=0) {
		static $arr = array();
		foreach ($data as $key => $value) {
			if ($value['pid']==$pid) {
				$value['dataid'] = $this->getParentid($value['id']);	//在改造的数组里面添加一个字段来显示父类的id，用来查找父类id	首先先把子类的id传进去。例如42
				$arr[] = $value;
				$this->sort($data,$value['id']);
			}
		}
		// var_dump($arr);
		return $arr;
	}

	// 获取父分类id
	public function getParentid($did) {
		$AuthRule = $this->select();	//查询规则表的所有数据出来
		return $this->_getParentid($AuthRule,$did,true);		//把查询到的所有数据传过去，包括上面传过来的子分类id 42,true的作用是清空一次Arr数组
	}

	public function _getParentid($AuthRule,$did,$clear=false) {
		static $arr = array();
		// 判断是否为true,无则清空数组
		if ($clear) {
			$arr = array();
		}
		// 把所有数据遍历一遍
		foreach ($AuthRule as $key => $value) {
			// 判断查询到的数据跟要查找的数据id(42)是否一致,如果一致则把当前的id（42）存入$arr数组中，然后再递归式的调用查询父类的id
			if ($value['id']==$did) {
				$arr[] = $value['id'];
				// 递归式调用_getParentid函数，传入所有数据以及当前id(42)这条数据中的一个父类id（38）进行一个递归式查询，然后下一次的$arr()数组中就有了id为42,38，以此类推，直到查到父id为0
				$this->_getParentid($AuthRule,$value['pid']);
			}
		}
		// 由于$arr()里面的数据是一个数组形式(42,38),此时的数据还不是我们想要的数据，所以需要拼接一下变成（38-42）
		// array_reverse($arr,false);
		// asort($arr);		//数组倒序
		$reversedArray = [];
		for ($i = count($arr) - 1; $i >= 0; $i--) {
		    $reversedArray[] = $arr[$i];
		}
		// array_reverse($arr);
		$str = implode('-',$reversedArray);
		// $str = implode('-', $arr).'<br>';
		// echo $str;
		return $str;
	}

	// 获取子分类的id
	public function getChildId($id) {
		$col = $this->select();
		return $this->_getChildId($col,$id);
	}

	public function _getChildId($col,$id) {
		static $arr = array();
		foreach ($col as $key => $value) {
			if ($value['pid']==$id) {
				$arr[] = $value['id'];
				$this->_getChildId($col,$value['id']);
			}
		}
		return $arr;
	}

	public function delcol($id) {
		if ($this::destroy($id)) {
			return true;
		} else {
			return false;
		}
	}
}