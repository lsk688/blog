<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\model\AuthRule as AuthRuleModel;
class AuthRule extends Allow {
	public function index() {
		$auth=new AuthRuleModel;
		$rule = $auth->authRuleTree();
		$this->assign('rule',$rule);
		$count = $auth->count();
		$this->assign([
			'count'=>$count,
		]);
		return view();
	}

	// 添加
	public function add() {
		$auth=new AuthRuleModel;
		if (request()->isPost()) {
			parse_str(input("post.str"),$data); //获取提交过来的数据，然后转换为数组$arr
			// 查询当前数据父级的level字段值
			$plevel = db('auth_rule')->where('id',$data['pid'])->field('level')->find();
			// 如果$plevel存在的话就加1，不存在的话就是顶级分类为0
			if ($plevel) {
				$data['level'] = $plevel['level'] + 1;
			} else {
				$data['level'] = 0;
			}
			$res = db('auth_rule')->insert($data);
			if ($res) {
				echo 1;
			}else {
				echo 2;
			}
		}else {
			$rule = $auth->authRuleTree();
			$this->assign('rule',$rule);
			return view();
		}
	}

	// 删除前置操作
	protected $beforeActionList = [
		'delson' => ['only'=>'del'],
		// 'uplson' => ['only'=>'update']
	];
	public function delson() {
		$id = input('id');
		$auth = new AuthRuleModel;
		$idx = $auth->getChildId($id);
		if ($idx) {
			db('auth_rule')->delete($idx);
		}
	}

	// 不能使用前置操作，因为修改的数据没有保存就执行的该前置操作了，导致其子分类的level字段获取的还是未保存后的父级的level
	public function uplson() {
		$id = input('id');
		$auth = new AuthRuleModel;
		$idx = $auth->getChildId($id);
		// var_dump($idx);
		// 查询当前数据父级的level字段值
		foreach ($idx as $key => $value) {
			if ($value) {
				$data = db('auth_rule')->where('id',$value)->find();
				$plevel = db('auth_rule')->where('id',$data['pid'])->field('level')->find();
				// var_dump($plevel['level']);
				if ($plevel) {
					var_dump($plevel['level']);
					$data['level'] = $plevel['level'] + 1;
				} else {
					$data['level'] = 0;
				}
				db('auth_rule')->update($data,['id'=>$value]);
			}
		}
	}

	// 删除
	public function del($id) {
		$auth = new AuthRuleModel;
		$res = $auth->delcol($id);
		if ($res) {
			echo 1;
		}else {
			echo 2;
		}
	}

	// 修改
	public function update($id) {
		if (Request()->isPost()) {
			// $data = input('post.str');
			$AuthRuleModel = new AuthRuleModel;
			parse_str(input("post.str"),$data); //获取提交过来的数据，然后转换为数组$data
			// 查询当前数据父级的level字段值
			$plevel = db('auth_rule')->where('id',$data['pid'])->field('level')->find();
			// 如果$plevel存在的话就加1，不存在的话就是顶级分类为0
			if ($plevel) {
				$data['level'] = $plevel['level'] + 1;
			} else {
				$data['level'] = 0;
			}
			// 获取子分类的id
			$idx = $AuthRuleModel->getChildId($id);
			// $res=$AuthRuleModel->update($data,['id'=>$id]);
			if ($idx) {
				foreach ($idx as $key => $value) {
					// 判断修改后的父级id是否为当前分类以及该分类下的子id，成功则修改保存
					if ($data['pid']!=$value&&$data['pid']!=$id) {
						$res=$AuthRuleModel->update($data,['id'=>$id]);
						// 判断是否有子类id，有的话则把子分类下的level级别也同步修改并保存
						if ($value) {
							$data = db('auth_rule')->where('id',$value)->find();
							$plevel = db('auth_rule')->where('id',$data['pid'])->field('level')->find();
							// var_dump($plevel['level']);
							if ($plevel) {
								// var_dump($plevel['level']);
								$data['level'] = $plevel['level'] + 1;
							} else {
								$data['level'] = 0;
							}
							db('auth_rule')->update($data,['id'=>$value]);
						}
						echo 1;
					}else {
						echo 2;
					}
				}
			} else {
				$res=$AuthRuleModel->update($data,['id'=>$id]);
				if ($res) {
					echo 1;
				}else {
					echo 2;
				}
			}
			
			// var_dump($idx);
			// 查询当前数据父级的level字段值
			// foreach ($idx as $key => $value) {
			// 	// 判断修改后的父级id是否为当前分类以及该分类下的子id，成功则修改保存
			// 	// if ($data['pid']!=$value&&$data['pid']!=$id&&$data['pid']==0) {
			// 	// 	$res=$AuthRuleModel->update($data,['id'=>$id]);
			// 	// 	echo 1;
			// 	// }else {
			// 	// 	echo 2;
			// 	// }
			// 	// 判断是否有子类id，有的话则把子分类下的level级别也同步修改并保存
			// 	if ($value) {
			// 		$data = db('auth_rule')->where('id',$value)->find();
			// 		$plevel = db('auth_rule')->where('id',$data['pid'])->field('level')->find();
			// 		// var_dump($plevel['level']);
			// 		if ($plevel) {
			// 			// var_dump($plevel['level']);
			// 			$data['level'] = $plevel['level'] + 1;
			// 		} else {
			// 			$data['level'] = 0;
			// 		}
			// 		db('auth_rule')->update($data,['id'=>$value]);
			// 	}
			// }
			// if ($res) {
			// 	echo 1;
			// }else {
			// 	echo 2;
			// }
			// var_dump($data);
		} else {
			// 当前数据查询
			$auth = new AuthRuleModel;
			$res = $auth->find($id);
			$this->assign('res',$res);
			// 分类展示
			$rule = $auth->authRuleTree();
			$this->assign('rule',$rule);
			return view();
		}
	}
}


?>