<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\Model\Colum as ColumModel;
use app\admin\Model\Article as ArticleModel;
use think\Db;
class Colum extends Allow {
	//首页
	public function index() {
		$model=new ColumModel;
		if (Request()->isPost()) {
			$data=input('post.');
			foreach($data as $key => $value){
				db('colum')->update(['id'=>$key,'sort'=>$value]);
			}
			$this->success('排序更新成功！',url('index'));
		}else{
			$search=input("get.search");		//获取get上传的数据，搜索功能
			//栏目分类展示
			$map['name']=array("like","%".$search."%");
			$data=$model->coltree();
			// $page = $model->where('pid',0)->order(['sort'=>'desc','id'=>'asc'])->paginate(3)->render();
			$count=$model->where($map)->order(['sort'=>'desc','id'=>'asc'])->count();
			// echo '<pre>';
			// print_r($data);
			// echo '</pre>';
			// var_dump($page);
			$this->assign('data',$data);
			// $this->assign('page',$page);
			return view();
		}
	}

	//禁用和启用状态的改变
    public function ajax_status() {
    	$model=new ColumModel;
        $data=input("post.");
        // print_r($data);
        $idx=$model->getChildId($data['id']);
        array_push($idx,$data['id']);
        $ids = '';
        foreach($idx as $k => $v){
        	$ids .= $v.',';
        }
        $ids = rtrim($ids,",");
        // var_dump($ids);
        $res=$model->where("id","in",($ids))->update(["status"=>$data['status']]);
        // echo Db::getLastSql();
        // $res=db("Colum")->where("id",$data['id'])->update(["status"=>$data['status']]);           //通过助手函数更新数据
        // $model=new MangerModel;
        // $res=$model->editM($arr);            //通过模型去修改
        // var_dump($res);
        if ($res) {
            echo 1;
        }else {
            echo 2;
        }
    }

    //排序
	public function sort() {
		$data = input('post.str');
		$id_sort = explode(',',$data);
		// parse_str(input('post.str'),$data);		//转换成数组
		foreach ($id_sort as $k => $v){
			$v_id = explode('--',$v);
			$id = $v_id[0];
			$sort = $v_id[1];
			$res = db('colum')->update(['id'=>$id,'sort'=>$sort]);
		}
		// $Model = new LunboModel;
		// $res = $Model->save($data,['id'=>$data['id']]);
		if ($res) {
			echo 1;
		}else {
			echo 2;
		}
	}

	//添加
	public function add() {
		$model=new ColumModel;
		if (Request()->isPost()) {
			parse_str(input("post.str"),$data); //获取提交过来的数据，然后转换为数组$arr
			// var_dump($data);
			$validate=\think\Loader::validate('Colum');		//Colum是要验证的模型
			if (!$validate->scene('add')->check($data)) {
				 return $arr=['error'=>$validate->getError(),'code'=>1];
			}
			$res = $model->save($data);
			if ($res) {
				echo 1;
			}else {
				echo 2;
			}
		}else {
			//栏目分类展示
			$model=new ColumModel;
			$data=$model->coltree();
			$this->assign('data',$data);
			return view();
		}
	}

	//添加子栏目
	public function add_zhi($id) {
		$model=new ColumModel;
		if (Request()->isPost()) {
			parse_str(input("post.str"),$data); //获取提交过来的数据，然后转换为数组$arr
			// var_dump($arr);
			$validate=\think\Loader::validate('Colum');
			if (!$validate->scene('add')->check($data)) {
				 return $arr=['error'=>$validate->getError(),'code'=>1];
			}
			// var_dump($data);
			$res = $model->save($data);
			if ($res) {
				echo 1;
			}else {
				echo 2;
			}
		}else {
			//栏目分类展示
			$fdata=db('colum')->find($id);
			$this->assign('fdata',$fdata);
			$model=new ColumModel;
			$data=$model->coltree();
			$this->assign('data',$data);
			return view();
		}
	}


	//修改
	public function edit($id) {
		$model=new ColumModel;
		//用Request()助手函数判断一下是什么提交方式，如果是post提交则修改数据，否则数据返回页面
		if (Request()->isPost()) {
			// $data=input('post.');
			parse_str(input("post.str"),$data); //获取提交过来的数据，然后转换为数组$arr
			$validate=\think\Loader::validate('Colum');
			if (!$validate->scene('add')->check($data)) {
				 return $arr=['error'=>$validate->getError(),'code'=>1];
			}
			$res=$model->save($data,['id'=>$id]);
			if ($res) {
				echo 1;
			}else {
				echo 2;
			}
			// if ($res) {
			// 	$this->success('修改成功！',url('index'));
			// }else{
			// 	$this->error('修改失败！');
			// }
		}else{
			$fdata=db('colum')->find($id);
			$this->assign('fdata',$fdata);
			$data=$model->coltree();
			$this->assign('data',$data);
			return view();
		}
	}

	//删除的前置操作,tp5提供的
	// 删除时的前置操作
	protected $beforeActionList=[
		'delson'=>['only'=>'del'],
	];

	public function delson() {
		$id=input('id');
		$model = new ColumModel;
		$idx=$model->getChildId($id);
		// print_r($idx);
		if ($idx) {
			db('colum')->delete($idx);
		}
	}

	//删除栏目时把该栏目下面的文章删除的前置操作
	// public function Adelson() {
	// 	$id=input('id');
	// 	$model = new ArticleModel;
	// 	$idx=$model->getChildId($id);
	// 	// print_r($idx);
	// 	if ($idx) {
	// 		db('colum')->delete($idx);
	// 	}
	// }

	//删除
	//删除时要先执行tp5框架自带的一个前置操作
	public function del($id) {
		$model = new ColumModel;
		$res=$model->delcol($id);
		// $Articlemodel = new ArticleModel;
		// $Ares= $Articlemodel->where('columid','==',$id)->
		if ($res) {
			echo 1;
		}else {
			echo 2;
		}
	}

	//批量删除
    public function ajax_delAll($id) {
        $id = input('post.id');
        if (empty($id)) {
        	echo 2;
        	die;
        }
        $con = explode(',',$id);
        $num = count($con);
        // var_dump(count($con));
        $model = new ColumModel;
        if (count($con)>1) {
        	$size = sizeof($con);
       		for ($i=0; $i < $size; $i++) { 
       			// $id = $con[$i];
       			$idx=$model->getChildId($con[$i]);
       			if ($idx) {
					db('colum')->delete($idx);
				}
				// $res=$model->delcol($id);
       		}
        }else{
        	$idx=$model->getChildId($id);
   			if ($idx) {
				db('colum')->delete($idx);
			}
			// $res=$model->delcol($id);
        }
        $res=$model->delcol($id);
        #$res = $model->where('id','in',$con)->delete();
        if ($res) {
			return $num;
		}else {
			echo 2;
		}
    }
}