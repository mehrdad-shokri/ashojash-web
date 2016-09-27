<?php

	namespace App\Http\Controllers\Admin;

	use App\Http\Controllers\Controller;
	use App\Http\Requests;
	use App\Tag;
	use Illuminate\Database\Eloquent\ModelNotFoundException;
	use Illuminate\Http\Request;

	class TagsController extends Controller {

		public function  all()
		{
			$tags = Tag::paginate(10);

			return view('content-provider.tags.all', compact('tags'));
		}


		public function show($id)
		{
			try
			{
				$tags = Tag::findOrFail($id);

				return view('content-provider.tags.show', compact('tags'));
			} catch (ModelNotFoundException $e)
			{
				abort(404);
			}

		}

		public function create()
		{
			return view('content-provider.tags.create');
		}

		public function store(Request $request)
		{
			$this->validate($request, [
				'name' => 'required |unique:tags| max:100',
			]);
			Tag::create(['name' => $request->name,]);
			flash()->success('success', 'Tag created successfully');

			return redirect()->back();
		}

		public function delete($id)
		{
			try
			{
				Tag::destroy($id);
				flash()->success('success', 'Tag deleted successfully');

				return redirect()->action('ContentProvider\TagsController@all');
			} catch (ModelNotFoundException $e)
			{
				abort(404);
			}
		}

		public function update(Request $request, $id)
		{
			$this->validate($request, [
				'name' => 'required |unique:tags| max:100',
			]);
			$tag = Tag::findOrFail($id);
			$tag->name = $request->get('name');
			$tag->save();
			flash()->success('success', 'Tag updated successfully');

			return redirect()->back();
		}
	}


