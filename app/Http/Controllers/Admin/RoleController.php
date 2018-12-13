<?php namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use View;
use Flash;
use App\Models\Role;
use App\Models\Permission;

class RoleController extends Controller {

	public function index(Role $roleModels)	{
        if(auth()->user()->hasRole('superadmin')) $roles = $roleModels->all();
        else $roles = $roleModels->where('name', '!=' ,'superadmin')->get();

		return View::make('admin/role/main', compact('roles'));
	}

	public function create() {
		return view('admin/role/create');
	}

	public function store(Request $request, Role $roleModels) {
		$data = $request->except(['_token']);

		//$data['slug'] = str_slug($request->input('name'));
		$roleModels->firstOrCreate($data);

		Flash::success('Роль добавлена успешно');
		return redirect()->route('admin.role.index');
	}

	public function show($id) 	{
		//
	}

	public function edit(Permission $permissionModels, $id) {
		$role = Role::findOrFail($id);

        if(auth()->user()->hasRole('superadmin')) $permissions = $permissionModels->all();
        else $permissions = $permissionModels->whereNotIn('id', [5])->get();

		return view('admin/role/edit', compact('role','permissions'));
	}

	public function update(Request $request, Role $roleModels, $id) {
		$data = $request->except(['_token']);

		$permissions = $request->input('permissions');
		$role = Role::findOrFail($id);

        $role->permissions()->sync($permissions ? $permissions : []);

		$roleModels->find($id)->update($data);

		Flash::success('Сохранено успешно');
		return \Redirect::back();
	}

	public function destroy($id) {
		$role = Role::findOrFail($id);
        $role->delete();

        Flash::success('Элемент удален');
		return \Redirect::back();
	}

}
