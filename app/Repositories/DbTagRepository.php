<?php

namespace app\Repository;

use App\Tag;

class DbTagRepository implements TagRepository {

	public function all()
	{
		return Tag::orderBy("created_at", "DESC")->get();
	}

	public function create($name, $level = 1)
	{
		return Tag::create(['name' => $name, $level]);
	}

	public function findByIdOrFail($id)
	{
		return Tag::findOrFail($id);
	}

}