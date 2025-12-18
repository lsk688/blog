<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\Model\Lunbo as LunboModel;
class Lunbo extends Allow {
	public function index() {
		$model = new LunboModel;
		$search=input("get.title");
		$map['title'] = array("like","%".$search."%");
		// var_dump($search);
		if ($search!="") {
			$data = $model->where($map)->order(['sort'=>'desc','id'=>'asc'])->paginate();
		}else {
			$data = $model->where($map)->order(['sort'=>'desc','id'=>'asc'])->paginate(2);
		}
		// $data = $model->where($map)->order(['sort'=>'desc','id'=>'asc'])->paginate(2);
		$page = $data->render();
		$this->assign('data',$data);
		$this->assign([
			'page' => $page,
		]);
		return view('index');
	}

	//禁用和启用状态的改变
    public function ajax_status() {
        $data=input("post.");
        // print_r($data);
        $res=db("Lunbo")->where("id",$data['id'])->update(["status"=>$data['status']]);           //通过助手函数更新数据
        // $model=new MangerModel;
        // $res=$model->editM($arr);            //通过模型去修改
        if ($res) {
            echo 1;
        }else {
            echo 2;
        }
    }

    //排序
	public function sort() {
		$data = input('post.');
		$Model = new LunboModel;
		$res = $Model->save($data,['id'=>$data['id']]);
		if ($res) {
			echo 1;
		}else {
			echo 2;
		}
	}

	//添加
	public function memberadd()
	{
		return view();
	}

	//修改
	public function memberedit($id)
	{
		$Model = new LunboModel;
		$data = $Model->find($id);
		$this->assign('data',$data);
		return view();
	}

	//添加提交
	public function add() {
		// echo "<pre>";
		// print_r(input('post.'));
		// echo "</pre>";
		$Model = new LunboModel;
		// //验证
		// $validate=\think\Loader::validate('Lunbo');
		// // scene('add')这个是应用场景
		// if (!$validate->scene('add')->check(input('post.'))) {
		// 	$this->error($validate->getError());
		// }
		parse_str(input('post.str'),$data);		//转换成数组
		if ($data['title']=="") {
            return $arr=['error'=>"标题不能为空",'code'=>1];
        }
		$res = $Model->addL($data);
		if ($res) {
			echo 1;
		}else {
			echo 2;
		}
	}

	//提交修改
	public function update() {
		parse_str(input('post.str'),$data);
		$id = $data['id'];
		if (request()->isPost()) {
			if ($data['img']!=$data['oldimg']) {
				if (is_file("./static/uploads/lunbo/{$data['oldimg']}")) {
					unlink("./static/uploads/lunbo/{$data['oldimg']}");
				}else {
					$data['img']=$data['img'];
				}
				
			}
			if ($data['video']!=$data['oldvideo']) {
				if (is_file("./static/uploads_video/lunbo/{$data['oldvideo']}")) {
					unlink("./static/uploads_video/lunbo/{$data['oldvideo']}");
				}else {
					$data['video']=$data['video'];
				}
				
			}
			if ($data['title']=="") {
	            return $arr=['error'=>"标题不能为空",'code'=>1];
	        }
			// var_dump($data);
			unset($data['id']);
			unset($data['oldimg']);
			unset($data['oldvideo']);
			$Model = new LunboModel;
			$res = $Model->save($data,['id'=>$id]);
			if ($res) {
				echo 1;
			}else {
				echo 2;
			}
		}else {
			$data = db('Lunbo')->find($id);
			$this->assign('data',$data);
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
			$picture = $file->rule('date')->validate( ['ext'=>'jpg,png,gif','size'=>400000,] )->move('./static/uploads/lunbo');
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
		$Model = new LunboModel;
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
			$picture = $file->rule('date')->validate( ['ext'=>'mp4'] )->move('./static/uploads_video/lunbo');
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
		$Model = new LunboModel;
		$res = $Model->video_delL($data);
		if ($res) {
			echo 1;		//删除失败
		}else {
			echo 2;		//删除成功
		}
	}

	//删除数据
	// 其中$id是参数绑定
	public function ajax_del() {
		$id = input('post.id');
		$Model = new LunboModel;
		$res = $Model->delL($id);
		if ($res) {
			echo 1;
		}else {
			echo 2;
		}
	}

	// 批量删除
	public function delAll($id){
		$data=$this->select($id);
		// print_r($data);
		foreach($data as $keys => $value){
			if (is_file("./static/uploads/lunbo/{$value['img']}")) {
				unlink("./static/uploads/lunbo/{$value['img']}");
			}
			if (is_file("./static/uploads_video/lunbo/{$value['video']}")) {
				unlink("./static/uploads_video/lunbo/{$value['video']}");
			}
			// unlink("./static/uploads/{$data['img']}");			//删除文件的功能，单引号不解析变量
		}
		return $this::destroy($id);
	}

	// 批量删除
    public function ajax_delAll() {
        // echo "<pre>";
        // print_r(input('post.str'));
        // echo "<pre>";
        $model=new LunboModel;
        $res=$model->delAll(input("post.id"));
        // // echo $res;          //返回的是删除的记录条数
        return $res;
    }

}
?>