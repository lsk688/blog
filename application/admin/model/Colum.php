<?php
namespace app\admin\model;
use think\Model;
class Colum extends Model{
	//无限分类展示
	public function coltree() {
		$search=input("get.search");		//获取get上传的数据，搜索功能
		$map['name']=array("like","%".$search."%");
		$col = $this->where($map)->order('sort desc')->select();
		return $this->sort($col);		//返回一个改造数组的方法
	}

	//改造数组
	public function sort($data,$pid=0,$level=0) {
		static $arr=array();		//定义一个静态数组
		foreach($data as $key => $value) {
			// 先把顶级分类循坏找出来，然后再继续找二级分类，如此类推；原理都是通过pid找父类
			if ($value['pid']==$pid) {
				$value['level']=$level;			//增加空格
				$arr[]=$value;
				$this->sort($data,$value['id'],$level+6);				//回调这个改造数组
			}
		}
		return $arr;
	}

	//获取子分类id
	public function getChildId($id) {
		// 先查询到要删除的数据的id,后再进行数据改造，也就是把该条数据下的pid匹配到的子类都删掉
		$col=$this->select();
		return $this->_getChildId($col,$id);
	}

	public function _getChildId($col,$id) {
		static $arr=array();
		foreach($col as $key=>$value) {
			if ($value['pid']==$id) {
				$arr[]=$value['id'];
				$this->_getChildId($col,$value['id']);		//递归式的调用获取到所有的子类ID
			}
		}
		return $arr;
	}

	//删除
	public function delcol($id) {
		if ($this::destroy($id)) {
			return true;
		}else {
			return false;
		}
	}
}