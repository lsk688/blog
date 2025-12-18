<?php
namespace app\admin\model;
use think\Model;
class AuthGroup extends Model {
	// 删除
	public function delA($id) {
		if ($this::destroy($id)) {
			return true;
		}else {
			return false;
		}
	}
}


?>