<?php

namespace App\Http\Controllers\Catalogs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست دسترسی ها', ['only' => ['index']]);
        $this->middleware('permission:ایجاد دسترسی', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش دسترسی', ['only' => ['update']]);
        $this->middleware('permission:نمایش جزئیات دسترسی', ['only' => ['edit']]);
        $this->middleware('permission:حذف دسترسی', ['only' => ['destroy']]);
    }

    public function index(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $permissions = Permission::orderBy('name', 'asc')->paginate(50);
        return view('Catalogs.Permissions.index', compact('permissions'));
    }

    public function create(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('Catalogs.Permissions.create');
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required|unique:permissions,name',
        ]);

        $role = Permission::create(['name' => $request->input('name')]);

        return redirect()->route('Permissions.index')
            ->with('success', 'دسترسی جدید با موفقیت ایجاد شد.');
    }

    public function show($id): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $role = Role::find($id);
        $rolePermissions = Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")
            ->where("role_has_permissions.role_id", $id)
            ->get();

        return view('Catalogs.Roles.show', compact('role', 'rolePermissions'));
    }

    public function edit($id): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $permission = Permission::find($id);

        return view('Catalogs.Permissions.edit', compact( 'permission'));
    }

    public function update(Request $request, $id): \Illuminate\Http\RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required|unique:permissions,name',
        ]);

        $permission = Permission::find($id);
        $permission->name = $request->input('name');
        $permission->save();

        return redirect()->route('Permissions.index')
            ->with('success', 'نقش کاربری با موفقیت ویرایش شد.');
    }
}
