<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\model\AuthRule as AuthRuleModel;
use app\admin\model\AuthGroup as AuthGroupModel;
use think\Db;
class AuthGroup extends Allow {
	public function index() {
		$model = new AuthGroupModel;
		// $data = db('AuthGroup')->select();
		// 多表查询，需要查找出username
		$data = db('AuthGroup')->alias('a')->join('user b','a.title=b.id')->field('a.*,b.username')->select();
		$count = $model->count();
		$this->assign([
			'data' => $data,
			'count' => $count
		]);
		return view();
	}

	// 添加
	public function add() {
		if (Request()->isPost()) {
			// echo '<pre>';
			// print_r(input('post.'));
			// echo '</pre>';
			$data = input('post.');
			// if ($data['rules']) {
			// 	$data['rules']=implode(',', $data['rules']);	//数组转换为以逗号连接的字符串
			// }
			if (!empty($data['rules'])) {
				$data['rules']=implode(',', $data['rules']);	//数组转换为以逗号连接的字符串
			}else {
				$this->error('修改失败，规则要必选！');
			}
			// $res = db('AuthGroup')->insert($data);
			$model = new AuthGroupModel;
			$res = $model->save($data);
			if ($res) {
				$data1['uid']=$data['title'];
				// 获取最后一次插入的数据id
				// $data1['group_id']=db('AuthGroup')->getLastInsID();	//旧版本用不了，已弃用
				// $data1['group_id']=Db::name('AuthGroup')->getLastInsID();	//旧版本用不了，已弃用
				$data1['group_id']=$model->id;
				// var_dump($data1);
				// exit;
				// 插入数据表AuthGroupAccess中
				db('AuthGroupAccess')->insert($data1);
				// exit;
				return $this->success('添加成功',url('index'));
			}else {
				$this->error('添加失败');
			}
		} else {
			// 管理员名称查询
			$data = db('User')->select();
			$AuthGroupModel = new AuthRuleModel;
			$tree = $AuthGroupModel->authRuleTree();
			$this->assign([
				'data' => $data,
				'tree' => $tree,
			]);
			return view();
		}
	}

	// 修改
	public function update($id) {
		if (Request()->isPost()) {
			$data = input('post.');
			// echo '<pre>';
			// print_r(input('post.'));
			// echo '</pre>';
			if (!empty($data['rules'])) {
				$data['rules']=implode(',', $data['rules']);	//数组转换为以逗号连接的字符串
			}else {
				$this->error('修改失败，规则要必选！');
			}
			// 查询当前要修改的数据信息
			$AuthGroup = db('AuthGroup')->find($id);
			// 判断当前获取的数据与提交过来的数据是否一致，一致的话则提示，无权限、规则、状态修改
			if ($data['title']==$AuthGroup['title']&&$data['rules']==$AuthGroup['rules']&&$data['status']==$AuthGroup['status']) {
				$this->error('修改失败，无权限、规则、状态的修改');
			} else {
				$res = db('AuthGroup')->update($data,['id'=>$data['id']]);
				if ($res) {
					$data1 = db('AuthGroupAccess') -> where(['group_id'=>$data['id']])->select();
					if ($data1) {
						$data2['group_id']=$data['id'];
						$data2['uid']=$data['title'];
						// var_dump($data2);
						// 插入数据表AuthGroupAccess中,其中这个字段要设置为主键
						db('AuthGroupAccess')->update($data2,['group_id'=>$data['id']]);
					}
					// $data1['uid']=$data['title'];
					// 获取最后一次插入的数据id
					// $data1['group_id']=db('AuthGroup')->getLastInsID();	//旧版本用不了，已弃用
					// $data1['group_id']=Db::name('AuthGroup')->getLastInsID();	//旧版本用不了，已弃用
					// $data1['group_id']=$data['id'];
					// exit;
					// 插入数据表AuthGroupAccess中
					// db('AuthGroupAccess')->update($data1);
					return $this->success('修改成功',url('index'));
				}else {
					$this->error('修改失败');
				}
			}
		} else {
			// 管理员名称查询
			$data = db('User')->select();
			$AuthGroupModel = new AuthRuleModel;
			$AuthGroup = db('AuthGroup')->find($id);
			//规则显示
			$tree = $AuthGroupModel->authRuleTree();
			$this->assign([
				'data' => $data,
				'AuthGroup' => $AuthGroup,
				'tree' => $tree,
			]);
			return view();
		}
	}

	// 删除
	public function del($id) {
		$model = new AuthGroupModel;
		// $res = $model->delA($id);
		// 获取到当前删除的数据信息
		$AuthGroup = db('AuthGroup')->find($id);
		// 查询当前表AuthGroupAccess中是否有这个规则数据，有的话则删除
		$data = db('AuthGroupAccess') -> where(['uid'=>$AuthGroup['title'],'group_id'=>$AuthGroup['id']])->select();
		if ($data) {
			// 插入数据表AuthGroupAccess中,其中这个字段要设置为主键
			db('AuthGroupAccess')->where(['uid'=>$AuthGroup['title'],'group_id'=>$AuthGroup['id']])->delete();
		}
		// var_dump($AuthGroup);
		// exit;
		$res = $model->delA($id);
		// $res = db('AuthGroup')->delete($id);
		if ($res) {
			return $this->success('删除成功',url('index'));
		}else {
			$this->error('删除失败');
		}
	}
}


?>