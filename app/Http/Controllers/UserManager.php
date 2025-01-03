<?php

namespace App\Http\Controllers;

use App\Models\Catalogs\Building;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class UserManager extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست کاربران', ['only' => ['index']]);
        $this->middleware('permission:ایجاد کاربر', ['only' => ['newUser']]);
        $this->middleware('permission:ویرایش کاربر', ['only' => ['editUser']]);
        $this->middleware('permission:تغییر وضعیت کاربر', ['only' => ['ChangeUserActivationStatus']]);
        $this->middleware('permission:تغییر وضعیت نیازمند به تغییر رمز عبور', ['only' => ['ChangeUserNTCP']]);
        $this->middleware('permission:بازنشانی رمز عبور کاربر', ['only' => ['ResetPassword']]);
    }

    public function index(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $userList = User::with('buildingInfo')->orderBy('id', 'asc')->paginate(10);
        $allRoles = Role::get();
        $buildings= Building::whereStatus(1)->get();
        return view('UserManager', compact('userList', 'allRoles','buildings'));
    }

    public function ChangeUserActivationStatus(Request $request): \Illuminate\Http\JsonResponse
    {
        $username = $request->input('username');
        $user = User::where('username', $username)->first();
        if ($username and $user) {
            $userStatus = User::where('username', $username)->value('active');
            if ($userStatus == 1) {
                $status = 0;
                $subject = 'Deactivated';
                $subject2 = 'غیرفعال';
            } elseif ($userStatus == 0) {
                $status = 1;
                $subject = 'Activated';
                $subject2 = 'فعال';
            }

            $user->active = $status;
            $user->save();
            return $this->success(true, 'changedUserActivation', 'کاربر با موفقیت ' . $subject2 . ' شد.');
        } else {
            return $this->alerts(false, 'changedUserActivationFailed', 'خطا در انجام عملیات');
        }
    }

    public function ChangeUserNTCP(Request $request): \Illuminate\Http\JsonResponse
    {

        $username = $request->input('username');
        $user = User::where('username', $username)->first();
        if ($username and $user) {
            $userNTCP = User::where('username', $username)->value('ntcp');
            if ($userNTCP == 1) {
                $status = 0;
            } elseif ($userNTCP == 0) {
                $status = 1;
            }

            $user->ntcp = $status;
            $user->save();
            return $this->success(true, 'changedUserNTCP', 'عملیات با موفقیت انجام شد.');
        } else {
            return $this->alerts(false, 'changedUserNTCPFailed', 'خطا در انجام عملیات');
        }
    }

    public function ResetPassword(Request $request): \Illuminate\Http\JsonResponse
    {
        $username = $request->input('username');
        $user = User::where('username', $username)->first();
        if ($username and $user) {
            $user->password = bcrypt(12345678);
            $user->ntcp = 1;
            $user->save();
            $subject = 'Password Resetted';
            return $this->success(true, 'passwordResetted', 'عملیات با موفقیت انجام شد.');
        } else {
            return $this->alerts(false, 'resetPasswordFailed', 'خطا در انجام عملیات');
        }
    }

    public function newUser(Request $request): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255|unique:users',
            'type' => 'required|exists:roles,id',
            'building' => 'required|exists:buildings,id',
        ]);
        if ($validator->fails()) {
            return $this->alerts(false, 'userFounded', 'نام کاربری تکراری وارد شده است.');
        }
        $name = $request->input('name');
        $family = $request->input('family');
        $username = $request->input('username');
        $password = $request->input('password');
        $type = $request->input('type');
        $building = $request->input('building');
        $roomNumber = $request->input('roomNumber');

        $user = new User();
        $user->name = $name;
        $user->family = $family;
        $user->username = $username;
        $user->password = bcrypt($password);
        $user->type = $type;
        $user->building = $building;
        $user->room_number = $roomNumber;
        $user->subject = Role::findById($type)->name;
        $user->save();
        $user->assignRole(Role::findById($type)->name);
        return $this->success(true, 'userAdded', 'کاربر با موفقیت تعریف شد. برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }

    public function editUser(Request $request): \Illuminate\Http\JsonResponse
    {
        $userID = $request->input('userIdForEdit');
        $name = $request->input('editedName');
        $family = $request->input('editedFamily');
        $type = $request->input('editedType');
        $building = $request->input('editedBuilding');
        $roomNumber = $request->input('editedRoomNumber');
        $user = User::findOrFail($userID);
        if ($user) {
            $user->name = $name;
            $user->family = $family;
            $user->type = $type;
            $user->building = $building;
            $user->room_number = $roomNumber;
            $user->subject = Role::findById($type)->name;
        }
        $user->syncRoles(Role::findById($type)->name);
        $user->save();
        return $this->success(true, 'userEdited', 'کاربر با موفقیت ویرایش شد. برای نمایش اطلاعات ویرایش شده، صفحه را رفرش نمایید.');
    }

    public function getUserInfo(Request $request)
    {
        $user = User::findOrFail($request->userID);
        return $user;
    }
}
