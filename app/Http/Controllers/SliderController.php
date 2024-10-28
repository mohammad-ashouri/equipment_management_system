<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:لیست اسلایدر', ['only' => ['index']]);
        $this->middleware('permission:ویرایش اسلایدر', ['only' => ['update']]);
        $this->middleware('permission:حذف اسلایدر', ['only' => ['destroy']]);
    }

    public function index()
    {
        $sliders = Slider::with(['adderInfo', 'editorInfo'])->paginate(50);
        return view('Sliders.index', compact('sliders'));
    }

    public function edit($id)
    {
        $slider = Slider::findOrFail($id);
        switch ($slider->status) {
            case 0:
                $slider->status = 1;
                break;
            case 1:
                $slider->status = 0;
                break;
        }
        $slider->save();
        return redirect()->route('Sliders.index')->with('success', 'اسلایدر با موفقیت تغییر وضعیت داده شد.');
    }

    public function destroy($id)
    {
        Slider::findOrFail($id)->delete();
        return redirect()->route('Sliders.index')->with('success', 'اسلایدر با موفقیت حذف شد.');
    }
}
