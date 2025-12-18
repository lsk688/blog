<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\model\Conf as ConfModel;
class Conf extends Allow {
	// 配置列表
	public function index() {
		$model = new ConfModel;
		$data = db('Conf')->paginate(10);
		$page = $data->render();
		$count = $model->count();
		$this->assign('data',$data);
		$this->assign('page',$page);
		$this->assign('count',$count);
		return view();
	}

	// 配置项
	public function list() {
		if (Request()->isPost()) {
			$data = input('post.');
			// echo "<pre>";
			// print_r($data);
			// echo "</pre>";
			$conf = db('Conf')->select();
			// 获取Conf表中的ename字段值有哪些
			$ConfEname = array();
			foreach ($conf as $key => $value) {
				$ConfEname[] = $value['ename'];
			}
			// 判断数组中的键是否存在
			// if (!isset($data['code'])) {
			// 	// var_dump("555");
			// 	$data['code'] = '否';
			// }
			// 提交过来的键，也就是Conf表中的ename字段值有哪些
			$Ename = array();
			foreach ($data as $key => $value) {
				$Ename[] = $key;
				ConfModel::where(['ename'=>$key])->update(['val'=>$value]);
			}
			// 如果你需要比较两个数组，找出它们非包含的部分（即数组中独有的元素），可以使用array_diff函数。
			// 判断conf表中的ename字段值与提交过来的字段值比较，可以得出表中没有的字段值出来
			$diff = array_diff($ConfEname, $Ename);	// 找出$ConfEname独有的元素
			// var_dump($diff1);
			if ($diff) {
				foreach ($diff as $key => $value) {
					ConfModel::where(['ename'=>$value])->update(['val'=>'']);
				}
			}
			$this->success('修改成功',url('List'));
		} else {
			$data = db('Conf')->select();
			$this->assign('data',$data);
			return view();
		}
	}

	// 添加
	public function add() {
		if (Request()->isPost()) {
			$data = input('post.');
			// echo "<pre>";
			// print_r($data);
			// echo "</pre>";
			$model = new ConfModel;
			if ($data['vals']) {
				$data['vals'] = str_replace("，",",",$data['vals']);
			}
			$res = $model->save($data);
			if ($res) {
				$this->success("添加成功",url('index'));
			} else {
				$this->error("添加失败");
			}
			
		} else {
			return view();
		}
	}

	// 删除
	public function del($id) {
		$model = new ConfModel;
		$res = $model->delC($id);
		if ($res) {
			$this->success("删除成功",url('index'));
		} else {
			$this->error("删除失败");
		}
	}

	// 修改
	public function update($id) {
		if (Request()->isPost()) {
			$model = new ConfModel;
			$data = input('post.');
			if ($data['vals']) {
				$data['vals'] = str_replace("，",",",$data['vals']);
			}
			$res = $model->update($data,['id'=>$id]);
			if ($res) {
				$this->success("修改成功",url('index'));
			} else {
				$this->error("修改失败");
			}
		} else {
			$data = db('Conf')->find($id);
			$this->assign('data',$data);
			return view();
		}
	}
}


?>