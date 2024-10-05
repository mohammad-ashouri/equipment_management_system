<?php

namespace App\Http\Controllers\DigitalEquipments;

use App\Http\Controllers\Controller;
use App\Models\DigitalEquipments\AttendanceSystem;
use Illuminate\Http\Request;

class AttendanceSystemController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست دستگاه حضور و غیاب', ['only' => ['index']]);
        $this->middleware('permission:ایجاد دستگاه حضور و غیاب', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش دستگاه حضور و غیاب', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف دستگاه حضور و غیاب', ['only' => ['destroy']]);
    }

    public function index()
    {
        $attendanceSystems = AttendanceSystem::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->paginate(50);
        return view('DigitalEquipments.AttendanceSystems.index', compact('attendanceSystems'));
    }

    public function create()
    {
        return view('DigitalEquipments.AttendanceSystems.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $attendanceSystem = AttendanceSystem::create(['model' => $request->input('model'), 'brand' => $request->input('brand'), 'adder' => $this->getMyUserId()]);

        if ($attendanceSystem) {
            return redirect()->route('AttendanceSystems.index')->with('success', 'دستگاه حضور و غیاب با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد دستگاه حضور و غیاب']);
    }

    public function edit($id)
    {
        $attendanceSystem = AttendanceSystem::findOrFail($id);

        return view('DigitalEquipments.AttendanceSystems.edit', compact('attendanceSystem'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:attendance_systems,id',
            'model' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $attendanceSystem = AttendanceSystem::findOrFail($id);
        $attendanceSystem->brand = $request->input('brand');
        $attendanceSystem->model = $request->input('model');
        $attendanceSystem->status = $request->input('status');
        $attendanceSystem->editor = $this->getMyUserId();
        $attendanceSystem->save();

        return redirect()->route('AttendanceSystems.index')->with('success', 'دستگاه حضور و غیاب با موفقیت ویرایش شد.');
    }
}
