<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\model\Colum as ColumModel;
use app\admin\Model\Article as ArticleModel;
use think\Db;
class Article extends Allow {
	public function index() {
		$search=input("get.search");		//获取get上传的数据，搜索功能
		$map['title']=array("like","%".$search."%");
		//多表查询，alias表别名，join左连接，field查询的字段，paginete每页条数
		$data = db('article')->alias('a')->join('colum b','a.columid=b.id')->field('a.*,b.name bname')->where($map)->order('id desc')->paginate(10);
		//分配数据，分页显示
		$page=$data->render();
		$this->assign('page',$page);
		$this->assign('data',$data);
		return view();
	}

	//添加
	public function add() {
		if (Request()->isPost()) {
			parse_str(input("post.str"),$data); //获取提交过来的数据，然后转换为数组$arr
			$ArticleModel=new ArticleModel;
			$res=$ArticleModel->save($data);
			if ($res) {
				echo 1;
			}else {
				echo 2;
			}
		}else{
			$time = date('Y-m-d H:i:s',time());
			$colum=new ColumModel;
			$col=$colum->coltree();
			// $author=db('author')->select();
			$this->assign([
				'col'=>$col,
				// 'author'=>$author,
			]);
			$this->assign('time',$time);
			return view();
		}
	}

	//图片上传
	public function ajax_upload()
	{
		// var_dump($_FILES['file']);
		$response = array();
		//图片上传
		if ( isset( $_FILES['file'] ) && $_FILES['file']['error'] == 0 ) {
			$file = request()->file('file');
			$picture = $file->rule('date')->validate( ['ext'=>'jpg,png,gif','size'=>400000,] )->move('./static/uploads/article');
		}
		// var_dump($picture);
		if ($picture==false) {
			$response['file'] = false;
			$response['site'] = $file->getError();
			echo json_encode($response);
		}else{
			$filePaths = $picture->getSaveName();
			$response['file'] = true;
			$response['site'] = str_ireplace("\\", "/", $filePaths);
			// $response['site'] = str_ireplace("\\", "/", $response['site']);
			echo json_encode($response);
		}

		// if ( isset( $picture ) ) {
		// 	$filePaths = $picture->getSaveName();
		// 	$response['file'] = true;
		// 	$response['site'] = str_ireplace("\\", "/", $filePaths);
		// 	// $response['site'] = str_ireplace("\\", "/", $response['site']);
		// 	echo json_encode($response);
		// }else{
		// 	$response['file'] = false;
		// 	$response['site'] = $file->getError();
		// 	echo json_encode($response);
		// }
	}

	//删除取消上传的图片
	public function ajax_upload_del() {
		$data = input("post.");
		// print_r($data);
		$Model = new ArticleModel;
		$res = $Model->img_delL($data);
		if ($res) {
			echo 1;		//删除失败
		}else {
			echo 2;		//删除成功
		}
	}

	//视频上传
	public function ajax_upload_video()
	{
		// var_dump($_FILES['file']);

		$response = array();
		//视频上传
		// if ( isset( $_FILES['file'] ) && $_FILES['file']['error'] == 0 ) {
		// 	$file = request()->file('file');
		// 	$picture = $file->rule('date')->validate( ['ext'=>'mp4'] )->move('./static/uploads_video/lunbo');
		// }
		// if ( isset( $picture ) ) {
		// 	$filePaths = $picture->getSaveName();
		// 	$response['file'] = true;
		// 	$response['site'] = str_ireplace("\\", "/", $filePaths);
		// 	// $response['site'] = str_ireplace("\\", "/", $response['site']);
		// 	echo json_encode($response);
		// }

		//视频上传
		if ( isset( $_FILES['file'] ) && $_FILES['file']['error'] == 0 ) {
			$file = request()->file('file');
			$picture = $file->rule('date')->validate( ['ext'=>'mp4','size'=>20000000] )->move('./static/uploads_video/article');
		}
		// var_dump($picture);
		if ($picture==false) {
			$response['file'] = false;
			$response['site'] = $file->getError();
			echo json_encode($response);
		}else{
			$filePaths = $picture->getSaveName();
			$response['file'] = true;
			$response['site'] = str_ireplace("\\", "/", $filePaths);
			// $response['site'] = str_ireplace("\\", "/", $response['site']);
			echo json_encode($response);
		}
	}

	//删除取消上传的图片
	public function ajax_upload_video_del() {
		$data = input("post.");
		// print_r($data);
		$Model = new ArticleModel;
		$res = $Model->video_delL($data);
		if ($res) {
			echo 1;		//删除失败
		}else {
			echo 2;		//删除成功
		}
	}

	//取消添加
	public function ajax_quxiao() {
		$data = input("post.");
		var_dump($data);
	}

	// 修改
	public function edit($id) {
		$model=new ArticleModel;
		if (Request()->isPost()) {
			// $data=input('post.str');
			// var_dump($data);
			parse_str(input("post.str"),$data); //获取提交过来的数据，然后转换为数组$arr
			$data['time'] = date('Y-m-d H:i:s',time());
			// var_dump($data);
			$res=$model->save($data,['id'=>$id]);
			if ($res) {
				echo 1;
			}else {
				echo 2;
			}
		}else{
			$fdata=db('article')->find($id);
			$colum=new ColumModel;
			$col=$colum->coltree();
			// $author=db('author')->select();
			$this->assign([
				'col'=>$col,
				'data'=>$fdata,
				// 'author'=>$author,
			]);
			$time = $fdata['time'];
			$this->assign('time',$time);
			return view();
		}
	}

	// 删除
	// public function ajax_del() {
	// 	$data = input("post.");
	// 	var_dump($data);
	// }

	//删除数据
	// 其中$id是参数绑定
	public function ajax_del() {
		$id = input('post.id');
		$Model = new ArticleModel;
		$res = $Model->delL($id);
		if ($res) {
			echo 1;
		}else {
			echo 2;
		}
	}

	//禁用和启用状态的改变
    public function ajax_status() {
    	$model=new ArticleModel;
        $data=input("post.");
        $res=$model->update(["status"=>$data['status'],"id"=>$data['id']]);
        // echo Db::getLastSql();        //通过助手函数更新数据
        // $model=new MangerModel;
        // $res=$model->editM($arr);            //通过模型去修改
        // var_dump($res);
        if ($res) {
            echo 1;
        }else {
            echo 2;
        }
    }
}

?>