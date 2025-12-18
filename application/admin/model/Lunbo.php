<?php
namespace app\admin\model;
use think\Model;
class Lunbo extends Model {
	// 删除取消上传的图片
	public function img_delL($data){
		// print_r($id);
		if (is_file("./static/uploads/lunbo/{$data['img']}")) {
			unlink("./static/uploads/lunbo/{$data['img']}");
		}else {
			return 1;
		}
	}

	// 删除取消上传的视频
	public function video_delL($data){
		// print_r($id);
		if (is_file("./static/uploads_video/lunbo/{$data['video']}")) {
			unlink("./static/uploads_video/lunbo/{$data['video']}");
		}else {
			return 1;
		}
	}

	// 删除
	public function delL($id){
		$data=$this->find($id);
		// print_r($id);
		if (is_file("./static/uploads/lunbo/{$data['img']}")) {
			unlink("./static/uploads/lunbo/{$data['img']}");
		}
		if (is_file("./static/uploads_video/lunbo/{$data['video']}")) {
			unlink("./static/uploads_video/lunbo/{$data['video']}");
		}
		// unlink("./static/uploads/{$data['img']}");			//删除文件的功能，单引号不解析变量
		return $this::destroy($id);
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

	// 添加
	public function addL($arr){
		if($this->save($arr)){
			return true;
		}else{
			return false;
		}
	}
}
?>