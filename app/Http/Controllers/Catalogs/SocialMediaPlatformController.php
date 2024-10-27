<?php

namespace App\Http\Controllers\Catalogs;

use App\Http\Controllers\Controller;
use App\Models\Catalogs\SocialMediaPlatform;
use Illuminate\Http\Request;

class SocialMediaPlatformController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست شبکه اجتماعی', ['only' => ['index']]);
        $this->middleware('permission:ایجاد شبکه اجتماعی', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش شبکه اجتماعی', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف شبکه اجتماعی', ['only' => ['destroy']]);
    }

    public function index()
    {
        $socialMediaPlatforms = SocialMediaPlatform::orderBy('name', 'asc')->paginate(10);
        return view('Catalogs.SocialMediaPlatforms.index', compact('socialMediaPlatforms'));
    }

    public function create()
    {
        return view('Catalogs.SocialMediaPlatforms.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:social_media_platforms,name',
            'main_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $path = $request->file('main_image')->store('public/uploads/Catalogs/SocialMediaPlatforms/' . rand(1251, 5412358));

        $socialMediaPlatform = SocialMediaPlatform::create(['name' => $request->input('name'), 'icon_src' => $path, 'adder' => $this->getMyUserId()]);

        $socialMediaPlatform->icon_src = $path;
        $socialMediaPlatform->save();
        if ($socialMediaPlatform) {
            return redirect()->route('SocialMediaPlatforms.index')->with('success', 'شبکه اجتماعی با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد شبکه اجتماعی']);
    }

    public function edit($id)
    {
        $socialMediaPlatform = SocialMediaPlatform::with('mainImage')->find($id);

        return view('Catalogs.SocialMediaPlatforms.edit', compact('socialMediaPlatform'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:social_media_platforms,id',
        ]);

        $socialMediaPlatform = SocialMediaPlatform::find($id);
        if ($request->hasFile('main_image')) {
            $path = $request->file('main_image')->store('public/uploads/Catalogs/SocialMediaPlatforms/' . rand(1251, 5412358));
            $socialMediaPlatform->icon_src = $path;
        }
        $socialMediaPlatform->name = $request->input('name');
        $socialMediaPlatform->status = $request->input('status');
        $socialMediaPlatform->editor = $this->getMyUserId();
        $socialMediaPlatform->save();

        return redirect()->route('SocialMediaPlatforms.index')->with('success', 'شبکه اجتماعی با موفقیت ویرایش شد.');
    }

    public function show($id)
    {
        $socialMediaPlatform = SocialMediaPlatform::with('mainImage')->find($id);
        if (!$socialMediaPlatform) {
            return response()->json('مدرس پیدا نشد!', 404);
        }
        return response()->json([
            'socialMediaPlatform' => $socialMediaPlatform,
            'image_url' => asset($socialMediaPlatform->mainImage->src) // Adjust the path accordingly
        ]);
    }
}
