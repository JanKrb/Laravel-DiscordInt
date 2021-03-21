<?php

namespace App\Http\Controllers;

use App\Http\Requests\PermissionAddRequest;
use App\Http\Requests\PermissionDeleteRequest;
use App\Http\Requests\PermissionEditRequest;
use App\Http\Requests\RoleAddRequest;
use App\Http\Requests\RoleDeleteRequest;
use App\Http\Requests\RoleEditRequest;
use App\Models\Role;
use App\Models\RolePermission;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Http\FormRequest;

class RoleController extends Controller
{
    /**
     * View Roles page
     * @return Application|Factory|View
     */
    public function view() {
        if (!auth()->user()->hasPermission('i_roles_view')) {
            abort(404);
        } else {
            $data = array();

            $roles = Role::all();
            foreach ($roles as $role) {
                $role['member_count'] = User::where('role_id', $role->id)->count();
            }

            $data['roles'] = $roles;

            return view('pages.roles.view', $data);
        }
    }

    /**
     * @param $roleid
     * @return Application|Factory|View
     */
    public function viewPermissions($roleid) {
        if (!auth()->user()->hasPermission('i_roles_view_permissions')) {
            abort(404);
        }

        $data = array();

        $data['role'] = $role = Role::where('id', $roleid)->first();
        $data['permissions'] = $permissions = RolePermission::where('role_id', $roleid)->get();

        return view('pages.roles.view_perms', $data);
    }

    /**
     * @param RoleAddRequest $request
     * @param $roleid
     * @return Application|Factory|View
     */
    public function addRole(RoleAddRequest $request) {
        if (!auth()->user()->hasPermission('i_roles_create')) {
            abort(403);
        }

        Role::create([
            'name' => $request->input('role-name'),
            'color' => $request->input('role-color'),
            'discord_id' => $request->input('role-discord'),
        ]);

        return $this->view();
    }

    /**
     * @param RoleEditRequest $request
     * @param $roleid
     */
    public function editRoles(RoleEditRequest $request) {
        if (!auth()->user()->hasPermission('i_roles_edit')) {
            abort(403);
        }

        $role = Role::where('id', $request->input('role-id'))->first();

        $role->name = $request->input('role-name');
        $role->color = $request->input('role-color');
        $role->discord_id = $request->input('role-discord');
        $role->updated_at = now();

        $role->save();

        return $this->view();
    }

    /**
     * @param RoleDeleteRequest $request
     * @param $roleid
     * @return Application|Factory|View
     */
    public function deleteRoles(RoleDeleteRequest $request) {
        if (!auth()->user()->hasPermission('i_roles_edit')) {
            abort(403);
        }

        $role = Role::where('id', $request->input('role-id'))->first();
        $role->delete();

        return $this->view();
    }

    /**
     * @param PermissionAddRequest $request
     * @param $roleid
     * @return Application|Factory|View
     */
    public function addPermissions(PermissionAddRequest $request, $roleid) {
        if (!auth()->user()->hasPermission('i_roles_add_permissions')) {
            abort(403);
        }

        RolePermission::create([
            'role_id' => $roleid,
            'name' => $request->input('perm-name'),
            'value' => $request->input('perm-value')
        ]);

        return $this->viewPermissions($roleid);
    }

    /**
     * @param PermissionEditRequest $request
     * @param $roleid
     */
    public function editPermissions(PermissionEditRequest $request, $roleid) {
        if (!auth()->user()->hasPermission('i_roles_edit_permissions')) {
            abort(403);
        }

        $perm = RolePermission::where('id', $request->input('perm-id'))->first();

        $perm->name = $request->input('perm-name');
        $perm->value = $request->input('perm-value');
        $perm->updated_at = now();

        $perm->save();

        return $this->viewPermissions($roleid);
    }

    /**
     * @param PermissionDeleteRequest $request
     * @param $roleid
     * @return Application|Factory|View
     */
    public function deletePermissions(PermissionDeleteRequest $request, $roleid) {
        if (!auth()->user()->hasPermission('i_roles_edit_permissions')) {
            abort(403);
        }

        $perm = RolePermission::where('id', $request->input('perm-id'))->first();
        $perm->delete();

        return $this->viewPermissions($roleid);
    }
}
