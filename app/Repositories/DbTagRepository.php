<?php

namespace app\Repository;

use App\Tag;
use App\Venue;

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

	public function findByNameOrFail($name)
	{
		return Tag::where('name', $name)->firstOrFail();
	}

	public function search($query)
	{
		return Tag::search($query)->get();
	}

	public function addTag(Venue $venue, $weight, Tag $tag)
	{
		$venue->tags()->sync([$tag->getKey() => ['weight' => $weight]], false);
	}

}