<?php

namespace App\Http\Controllers\Catalogs;

use App\Http\Controllers\Controller;
use App\Models\Catalogs\PersonAdjective;
use Illuminate\Http\Request;

class PersonAdjectiveController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست صفت افراد', ['only' => ['index']]);
        $this->middleware('permission:ایجاد صفت افراد', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش صفت افراد', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف صفت افراد', ['only' => ['destroy']]);
    }

    public function index()
    {
        $personAdjectives = PersonAdjective::orderBy('name', 'asc')->paginate(10);
        return view('Catalogs.PersonAdjectives.index', compact('personAdjectives'));
    }

    public function create()
    {
        return view('Catalogs.PersonAdjectives.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:person_adjectives,name',
        ]);

        $personAdjective = PersonAdjective::create(['name' => $request->input('name'), 'adder' => $this->getMyUserId()]);

        if ($personAdjective) {
            return redirect()->route('PersonAdjectives.index')->with('success', 'صفت افراد با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد صفت افراد']);
    }

    public function edit($id)
    {
        $personAdjective = PersonAdjective::find($id);

        return view('Catalogs.PersonAdjectives.edit', compact('personAdjective'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'status' => 'required|integer|in:0,1',
        ]);

        $role = PersonAdjective::find($id);
        $role->name = $request->input('name');
        $role->status = $request->input('status');
        $role->editor = $this->getMyUserId();
        $role->save();

        return redirect()->route('PersonAdjectives.index')->with('success', 'صفت افراد با موفقیت ویرایش شد.');
    }
}
