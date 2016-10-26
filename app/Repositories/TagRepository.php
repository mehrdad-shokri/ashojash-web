<?php

namespace app\Repository;


use App\Tag;
use App\Venue;

interface TagRepository {

	public function all();

	public function create($name, $level = 1);

	public function findByIdOrFail($id);

	public function findByNameOrFail($name);

	public function search($query);

	public function addTag(Venue $venue, $weight, Tag $tag);
}