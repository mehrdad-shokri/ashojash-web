<?php

	namespace App\Http\Controllers\Admin;

	use App\Feature;
	use Illuminate\Database\Eloquent\ModelNotFoundException;
	use Illuminate\Http\Request;

	use App\Http\Requests;
	use App\Http\Controllers\Controller;

	class FeaturesController extends Controller {

		public function  all()
		{
			$features = Feature::paginate(10);

			return view('content-provider.features.all', compact('features'));
		}


		public function show($id)
		{
			try
			{
				$features = Feature::findOrFail($id);

				return view('content-provider.features.show', compact('features'));
			} catch (ModelNotFoundException $e)
			{
				abort(404);
			}

		}

		public function create()
		{
			return view('content-provider.features.create');
		}

		public function store(Request $request)
		{
			$this->validate($request, [
				'name' => 'required |unique:features| max:100',
			]);
			Feature::create(['name' => $request->name,]);
			flash()->success('success', 'Feature created successfully');

			return redirect()->back();
		}

		public function delete($id)
		{
			try
			{
				Feature::destroy($id);
				flash()->success('success', 'Feature deleted successfully');

				return redirect()->action('ContentProvider\FeaturesController@all');
			} catch (ModelNotFoundException $e)
			{
				abort(404);
			}
		}

		public function update(Request $request, $id)
		{
			$this->validate($request, [
				'name' => 'required |unique:features| max:100',
			]);
			$feature = Feature::findOrFail($id);
			$feature->name = $request->name;
			$feature->save();
			flash()->success('success', 'Feature updated successfully');

			return redirect()->back();
		}
	}
