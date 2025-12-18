<?php
namespace app\index\controller;
use think\Controller;
use app\index\model\Colum as ColumModel;
class Common extends Controller {
	public function _initialize() {
		// 初始化
		$data = db('Conf')->select();
		$conf = array();
		foreach ($data as $key => $value) {
			$conf[$value['ename']] = $value['val'];
		}
		$this->assign('conf',$conf);
		// var_dump($conf);
		// 双重循环无限分类
		// 栏目获取
		$colum = new ColumModel;
		$data = db('Colum')->select();
		$colum = $colum->getClass($data);
		$this->assign('colum',$colum);
	}
}


?>