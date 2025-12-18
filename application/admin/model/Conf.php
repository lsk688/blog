<?php
namespace app\admin\model;
use think\Model;
class Conf extends Model {
	// 删除
	public function delC($id)
	{
		return $this::destroy($id); 		//tp5里面的删除,$id可以接受多个id的
	}
}

?>