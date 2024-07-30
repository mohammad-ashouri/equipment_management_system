<?php

namespace App\Http\Controllers\Catalogs;

use App\Http\Controllers\Controller;
use App\Models\Catalogs\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست برند', ['only' => ['index']]);
        $this->middleware('permission:ایجاد برند', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش برند', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف برند', ['only' => ['destroy']]);
    }

    public function index()
    {
        $brands = Brand::orderBy('name', 'asc')->paginate(50);
        return view('Catalogs.Brands.index', compact('brands'));
    }

    public function create()
    {
        return view('Catalogs.Brands.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:brands,name',
        ]);

        $brand = Brand::create(['name' => $request->input('name'), 'adder' => $this->getMyUserId()]);

        if ($brand) {
            return redirect()->route('Brands.index')->with('success', 'برند با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد برند']);
    }

    public function edit($id)
    {
        $brand = Brand::find($id);

        return view('Catalogs.Brands.edit', compact('brand'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:brands,id',
        ]);

        $brands = Brand::find($id);
        $brands->name = $request->input('name');
        $brands->status = $request->input('status');
        $brands->editor = $this->getMyUserId();
        $brands->save();

        return redirect()->route('Brands.index')->with('success', 'برند با موفقیت ویرایش شد.');
    }
}
