<?php
namespace app\index\model;
use think\Model;
class Colum extends Model {
	public function getClass($data,$pid=0) {
		// pid与id的关系
		$newArray = array();
		foreach ($data as $key => $value) {
			// 首先获取一下顶级分类的数据
			if ($value['pid']==$pid) {
				$newArray[$value['id']] = $value;
				$newArray[$value['id']]['child'] = $this->getClass($data,$value['id']);
			}
		}
		return $newArray;
	}
}

// array(
// 	[9]=>顶级分类的数据
// 		 ['child']=>array(
// 		 	[11]=>array(子分类的数据)
// 		 )		
// )

?>