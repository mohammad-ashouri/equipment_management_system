<?php

namespace App\Http\Controllers;

use App\Models\ContactUs;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:لیست ارتباط با ما', ['only' => ['index', 'getContactUsHeadersInfo']]);
        $this->middleware('permission:ارتباط با ما - تغییر وضعیت', ['only' => ['update']]);
        $this->middleware('permission:ارتباط با ما - حذف', ['only' => ['destroy']]);
    }

    public function index()
    {
        $contactUs = ContactUs::with(['editorInfo'])->orderBy('is_read')->orderBy('is_spam')->paginate(50);
        return view('ContactUs.index', compact('contactUs'));
    }

    public function update(Request $request, $id)
    {
        $contactUs = ContactUs::findOrFail($id);
        switch ($request->edit_command) {
            case 'read':
                $contactUs->is_read = true;
                $contactUs->save();
                return redirect()->route('ContactUs.index')->with('success', 'پیام با موفقیت به وضعیت خوانده شده تغییر پیدا کرد.');
            case 'spam':
                $contactUs->is_read = true;
                $contactUs->is_spam = true;
                $contactUs->save();
                return redirect()->route('ContactUs.index')->with('success', 'پیام با موفقیت به پوشه اسپم انتقال داده شد.');
            default:
                abort(422);
        }

    }

    public function getContactUsHeadersInfo($id)
    {
        $contactUs = ContactUs::findOrFail($id)->value('headers');
        return response()->json(json_decode($contactUs,true),200);
    }

    public function destroy($id)
    {
        ContactUs::findOrFail($id)->delete();
        return redirect()->route('ContactUs.index')->with('success', 'پیام با موفقیت حذف شد.');
    }
}
