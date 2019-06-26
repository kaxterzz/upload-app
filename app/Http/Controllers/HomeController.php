<?php

namespace App\Http\Controllers;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // $admin = Role::create(['name' => 'admin']);
        // $u = Role::create(['name' => 'user']);
        //$ru = Permission::create(['name' => 'remove content']);
        //$ru->assignRole('admin');
        // $rs = Permission::create(['name' => 'delete users']);
        // auth()->user()->givePermissionTo($ru);
        // auth()->user()->givePermissionTo($rs);
        // $ru->assignRole('admin');
        // $rs->assignRole('admin');
        //auth()->user()->removeRole('user');
        // $uc = Permission::create(['name' => 'upload content']);
        // $vc = Permission::create(['name' => 'view content']);
        // $admin->givePermissionTo($ru);
        // $admin->givePermissionTo($uc);
        // $admin->givePermissionTo($vc);
        // $u->givePermissionTo($vc);
        $permissions = auth()->user()->getPermissionsViaRoles();
        //return auth()->user()->getPermissionsViaRoles();
        //auth()->user()->assignRole('admin');
        // auth()->user()->givePermissionTo('register user');
        // auth()->user()->givePermissionTo('upload content');
        // auth()->user()->givePermissionTo('view content');
        return view('home', ['permissions' => $permissions]);
        //return view('home');
    }
}
