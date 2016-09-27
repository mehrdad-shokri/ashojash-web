<?php

	namespace App\Http\Controllers\Admin;

	use App\Commands\CreateRoleCommand;
	use App\Http\Controllers\Controller;
	use App\Http\Requests;
	use App\Http\Requests\CreateRoleRequest;
	use App\Role;
	use Illuminate\Database\Eloquent\ModelNotFoundException;
	use Illuminate\Http\Request;

	class RolesController extends Controller {

		public function all()
		{
			$roles = Role::paginate(5);

			return view('admin.roles.all', compact('roles'));
		}

		public function create()
		{
			return view('admin.roles.create');
		}

		public function store(CreateRoleRequest $request)
		{
			$role = $this->dispatch(new CreateRoleCommand($request));
			flash()->success('Success!', 'Role created successfully');

			return redirect()->action('Owner\RolesController@show', $role->id);

		}

		public function show($id)
		{
			try
			{
				$role = Role::findOrFail($id);
				$perms = $role->perms;

				return view('admin.roles.show', compact('role', 'perms'));
			} catch (ModelNotFoundException $e)
			{
				abort(404);
			}
		}

		public function delete($id)
		{
			try
			{
				Role::destroy($id);
				flash()->success('success', 'Role deleted successfully');

				return redirect()->action('Owner\RolesController@all');
			} catch (ModelNotFoundException $e)
			{
				abort(404);
			}
		}

		public function update(Request $request, $id)
		{
			$this->validate($request, [
				'name'         => 'required |unique:roles| max:100',
				'display-name' => 'required|max:100',
				'description'  => 'required'
			]);
			$role = Role::findOrFail($id);
			$role->name = $request->get('name');
			$role->display_name = $request->get('display-name');
			$role->description = $request->get('description');
			$role->save();
			flash()->success('success', 'Role updated successfully');

			return redirect()->back();
		}
	}
