<?php
namespace App\Api\Transformer;


use App\Permission;
use League\Fractal\TransformerAbstract;

class PermissionTransformer extends TransformerAbstract {

	public function transform(Permission $permission)
	{
		return ['name'=>$permission->name];
	}
}