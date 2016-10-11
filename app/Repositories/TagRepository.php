<?php

namespace app\Repository;


interface TagRepository {

	public function all();
	public function create ($name,$level=1);
}