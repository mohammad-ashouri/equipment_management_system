<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SiteSettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:لیست تنظیمات سایت', ['only' => ['index']]);
        $this->middleware('permission:ویرایش تنظیمات سایت', ['only' => ['update']]);
    }

    public function index()
    {
        $settings = SiteSetting::with('editorInfo')->get();
        return view('Catalogs.SiteSettings', compact('settings'));
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|integer|exists:site_settings,id',
            'option' => 'required|string',
        ]);

        $siteSetting = SiteSetting::find($request->id);
        $siteSetting->value = $request->option;
        $siteSetting->editor = $this->getMyUserId();
        $siteSetting->save();

        return redirect()->route('SiteSettings.index')->with('success', "تنظیمات با موفقیت ذخیره شد.");

    }
}
