<?php namespace App\Http\Controllers\admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use View;
use App\Models\User;
use Flash;
use DB;
use Auth;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Role;

class UserController extends Controller {

    //get /admin/user
    public function index(User $userModel) {
        if(auth()->user()->hasRole('superadmin')) $users = $userModel->all();
        else $users = $userModel->whereNotIn('id', [1])->get();

        return View::make('admin.user.index', compact('users'));
    }

    //get /admin/user/create
    public function create() {
        return view('admin.user.create');
    }

    //post /admin/user
    public function store(Request $request, User $userModel) {
        $data = $request->except(['_token']);

        $this->validate($request, [
            'login' => 'required|unique:users|max:255',
            'email' => 'required|unique:users|email',
            'password'  => 'required|confirmed|min:4',
        ]);

        $userModel->fill($data);
        $id = $userModel->register();

        //set active is register in admin panel
        $user = User::find($id);
        //$user->activationCode = '';
        $user->verified = true;
        $user->save();

        Flash::success('User was added');
        return redirect()->route('admin.user.index');
    }

    //get /admin/user/{$id}/edit
    public function edit(Role $roleModels, $id) {
        $user = User::find($id);

        if(auth()->user()->hasRole('superadmin')) $roles = $roleModels->all()->pluck('name', 'id');
        else $roles = $roleModels->where('name', '!=' ,'superadmin')->get()->pluck('name', 'id');

        return View::make('admin.user.edit', compact('user', 'roles'));
    }

    //post - /admin/user/{$id}
    public function update(User $userModel, Request $request, $id) {
        $user = $userModel->getUser($id);
        $data = $request->except(['_token', 'password']);

        if($request->get('password')) {
            $this->validate($request, [
                'password'  => 'required|confirmed|min:4',
            ]);

            $user->password = \Hash::make($request->get('password'));
            $user->save();
        }

        $this->validate($request, [
            'login' => 'required|max:255',
            //'email' => 'required|email',
        ]);
        $user->fill($data);
        $user->save();

        //сохраняем роль
        $role_id = $request->input('role');
        $roles = $user->roles->pluck('id')->all();
        if($role_id != 0) {
            $user->roles()->sync([$role_id]);
        }

        if($request->input('comment') != '') {
            Comment::add([
                'title'=>'Cообщение от '.Auth::getUser()->name,
                'body'=>$request->input('comment'),
                'from_user_id'=>Auth::id(),
                'user_to_arr'=>[$id],
                'status'=>'personal_messages',
                'item'=>$user
            ]);
        }

        Flash::success('The user status has been updated');
        return \Redirect::back();
    }

    //destroy /admin/user/{$id}
    public function destroy($id) {
        $user = User::findOrFail($id);
        $user->delete();

        Flash::success('User was removed');
        return \Redirect::back();
    }

    public function myProfile(Role $roleModels) {
        $user = Auth::user();
        if(auth()->user()->hasRole('superadmin')) $roles = $roleModels->all()->pluck('name', 'id');
        else $roles = $roleModels->where('name', '!=' ,'superadmin')->get()->pluck('name', 'id');

        return View::make('admin.user.edit', compact('user', 'roles'));
    }

    //зайти как юзер
    public function loginAs(Request $request, $id) {
        Session::put( 'orig_user', Auth::id() );
        Auth::loginUsingId($id);

        if($request->get('route')) {
            return \Redirect::route($request->get('route'));
        }
        else {
            return \Redirect::home();
        }
    }

    //вернуться из "зайти как юзер"
    public function logOutAs()
    {
        $id = Session::pull( 'orig_user' );
        Auth::loginUsingId($id);

        return redirect()->route('admin.index');
    }
}
