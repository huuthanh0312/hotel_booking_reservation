<?php

namespace App\Http\Controllers\Backend;

use App\Exports\PermissionExport;
use App\Http\Controllers\Controller;
use App\Imports\PermissionImport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\User;
use DB;
class RoleController extends Controller
{
    // Permission

    public function AllPermission(){
        $permissions = Permission::latest()->get();
        return view('backend.pages.permission.all_permission', compact('permissions'));
    }
    
    public function AddPermission(){
        
        return view('backend.pages.permission.add_permission');
    }

    public function StorePermission(Request $request){
        $permission = Permission::create([
            'name' => $request->name,
            'group_name' => $request->group_name,
            'created_at' => Carbon::now(),

        ]);
        $notification = array(
            'message'=> 'Role Permission Inserted  Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('permission.all')->with($notification);
    }
    
    public function EditPermission($id){
        $permission = Permission::latest()->find($id);
        return view('backend.pages.permission.edit_permission', compact('permission'));
    }

    public function UpdatePermission(Request $request){
        $permission = Permission::find($request->id);
        $permission->name = $request->name;
        $permission->group_name = $request->group_name;
        $permission->save();
        $notification = array(
            'message'=> 'Role Permission Updated  Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('permission.all')->with($notification);
    }

    public function DeletePermission($id){
        $permissions = Permission::find($id)->delete();
        $notification = array(
            'message'=> 'Role Permission Deleted  Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('permission.all')->with($notification);
        
    }



    /////// Import And Export Methods

    public function ImportPermission(){

        return view('backend.pages.permission.import_permission');
    }

    public function Export(){

        return Excel::download(new PermissionExport, 'permission.xlsx');
    }

    public function Import(Request $request){

        Excel::import(new PermissionImport, $request->file('import_file'));
        $notification = array(
            'message'=> 'Role Permission Import Data  Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('permission.all')->with($notification);
    }


    /////////////// Roles Methods ////////////////////////
    public function AllRoles(){
        $roles = Role::latest()->get();
        return view('backend.pages.roles.all_roles', compact('roles'));
    }
    
    public function AddRoles(){
        
        return view('backend.pages.roles.add_roles');
    }

    public function StoreRoles(Request $request){
        $role = Role::create([
            'name' => $request->name,
            'created_at' => Carbon::now(),

        ]);
        $notification = array(
            'message'=> 'Roles Inserted  Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('roles.all')->with($notification);
    }
    
    public function EditRoles($id){
        $roles = Role::latest()->find($id);
        return view('backend.pages.roles.edit_roles', compact('roles'));
    }

    public function UpdateRoles(Request $request){
        
        $roles = Role::find($request->id);
        $roles->name = $request->name;
        $roles->save();
        $notification = array(
            'message'=> 'Roles Updated  Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('roles.all')->with($notification);
    }

    public function DeleteRoles($id){
        $permissions = Role::find($id)->delete();
        $notification = array(
            'message'=> 'Roles Deleted  Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('roles.all')->with($notification);
        
    }///// End methods roles

    //////////////  Role In Permission
    public function AddRolePermission(){
        $roles = Role::all();
        $permissions = Permission::all();
        $permission_groups = User::getPermissionGroups();
        return view('backend.pages.rolesetup.add_roles_permission', compact('roles', 'permissions', 'permission_groups'));


    }


    public function StoreRolePermission(Request $request){
        $data = array();
        $permissions = $request->permission;
    
        foreach ($permissions as $permission){
            $data['role_id'] = $request->role_id;
            $data['permission_id'] = $permission;
            DB::table('role_has_permissions')->insert($data);
        } // end foreach

        $notification = array(
            'message'=> 'Roles Permission Added  Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('role.permission.all')->with($notification);
        
    }

    public function AllRolePermission(){
        $roles = Role::all();
       
        return view('backend.pages.rolesetup.all_roles_permission', compact('roles'));
    }


    ///////////////// Admin Edit And Delete roles  //////////////////////////////////

    public function AdminEditRole($id){
         $role = Role::find($id);
        $permissions = Permission::all();
        $permission_groups = User::getPermissionGroups();
        return view('backend.pages.rolesetup.edit_roles_permission', compact('role', 'permissions', 'permission_groups'));

    }

    public function AdminUpdateRole(Request $request, $id){
        $role = Role::find($id);
       
        // $permissions = $request->permission;
        // dd($permissions);
        // if(!empty($permissions)){
        //     $role->syncPermissions($permissions);
        // }
        $permissions = $request->input('permission');

        $permissions = array_map(function ($item) {
        return (int)$item;
        }, $permissions);
        // dd($permissions);
        
        if (!empty($permissions)){
        $role->syncPermissions($permissions);
        }
        $notification = array(
            'message'=> 'Roles Admin Updated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('role.permission.all')->with($notification);

   }

    public function AdminDeleteRole($id){
        $role = Role::find($id);
        if(!is_null($role)){
            $role->delete();
        }
        $notification = array(
            'message'=> 'Roles Admin Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('role.permission.all')->with($notification);
    }
}
