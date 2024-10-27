<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Catalogs\Category;
use App\Models\Catalogs\DocumentType;
use App\Models\Catalogs\PersonAdjective;
use App\Models\Catalogs\PostType;
use App\Models\Catalogs\SocialMediaPlatform;
use App\Models\Picture;
use App\Models\Slider;
use App\Models\Video;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Str;
use Jenssegers\Agent\Agent;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function logActivity($activity, $ip_address, $user_agent, $user_id = null): void
    {
        $agent = new Agent();
        ActivityLog::create([
            'user_id' => $user_id,
            'activity' => json_encode([$activity], true),
            'ip_address' => $ip_address,
            'user_agent' => $user_agent,
            'device' => $agent->device(),
        ]);
    }

    public function alerts($state, $errorVariable, $errorText): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'success' => $state,
            'errors' => [
                $errorVariable => [$errorText]
            ]
        ]);
    }

    public function success($state, $messageVariable, $messageText): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'success' => $state,
            'message' => [
                $messageVariable => [$messageText]
            ]
        ]);
    }

    public function getMyUserId()
    {
        if (auth()->user()->id) {
            return auth()->user()->id;
        }
        if (session('id')) {
            return session('id');
        }
        abort(403, 'User id not found!');
    }

    public function getAllNonPostCategories()
    {
        return Category::with('childes')->where('category_type', 'non-post')->where('parent', 0)->get();
    }

    public function getAllPostCategories()
    {
        return Category::with('childes')->where('category_type', 'post')->where('parent', 0)->get();
    }

    public function jsonEncodeArrays($array)
    {
        if (is_null($array)) {
            return null;
        }
        $keywordsArray = array_map('trim', explode(',', $array));
        return json_encode($keywordsArray);
    }

    public function savePictures($postId, $postType, $imageType, $src, $description = null)
    {
        $mainPicture = new Picture();
        $mainPicture->post_id = $postId;
        $mainPicture->post_type = $postType;
        $mainPicture->image_type = $imageType;
        $mainPicture->src = $src;
        $mainPicture->description = $description;
        $mainPicture->adder = $this->getMyUserId();
        $mainPicture->save();
        return $mainPicture;
    }

    public function removePicture($postId, $postType, $imageType)
    {
        $picture = Picture::where('id', $postId)->where('post_type', $postType)->where('image_type', $imageType)->first();
        if (!empty($picture)) {
            $picture->delete();
        }
    }

    public function saveVideos($postId, $postType, $videoType, $src)
    {
        $video = new Video();
        $video->post_id = $postId;
        $video->post_type = $postType;
        $video->video_type = $videoType;
        $video->src = $src;
        $video->adder = $this->getMyUserId();
        $video->save();
    }

    public function getAllSocialMediaPlatforms()
    {
        return SocialMediaPlatform::where('status', 1)->orderBy('name', 'asc')->get();
    }

    public function getAllPersonAdjectives()
    {
        return PersonAdjective::where('status', 1)->orderBy('name', 'asc')->get();
    }

    public function getAllDocumentTypes()
    {
        return DocumentType::where('status', 1)->orderBy('name', 'asc')->get();
    }

    public function getAllPostTypes()
    {
        return PostType::orderBy('title', 'asc')->get();
    }

    public function saveRelatedItems($relatedItems = [], $postTypes = [], $links = [])
    {
        if (empty($relatedItems)) {
            return null;
        }

        $items = [];
        foreach ($relatedItems as $index => $related_item) {
            $items[] = [
                'related_item' => $related_item,
                'post_type' => $postTypes[$index] ?? null,
                'link' => $links[$index] ?? null
            ];
        }

        return json_encode($items, true);
    }

    public function sliderManagement($status, $model, $modelId, $sliderImage = null)
    {
        Picture::where('post_type', Str::lower($model))->where('image_type', 'slider')->where('post_id', $modelId)->delete();
        switch ((integer)$status) {
            case 0:
                Slider::whereModel($model)->whereModelId($modelId)->delete();
                break;
            case 1:
                $path = $sliderImage->store('public/uploads/Sliders/');
                $this->savePictures($modelId, Str::lower($model), 'slider', str_replace('public', '/storage', $path));

                Slider::whereModel($model)->whereModelId($modelId)->firstOrCreate([
                    'model' => $model,
                    'model_id' => $modelId,
                    'adder' => $this->getMyUserId(),
                ]);
                break;
        }
    }

    public function deleteSliderAfterDeletePost($table, $postId)
    {
        Slider::where('model', $table)->where('model_id', $postId)->delete();
    }

    public function searchControl($request)
    {
        $this->validate($request, [
            'postType' => 'required|string',
            'id' => 'nullable|integer',
            'title' => 'nullable|string',
            'slug' => 'nullable|string',
            'status' => 'nullable|integer|between:0,2',
            'adder' => 'nullable|integer|exists:users,id',
            'editor' => 'nullable|integer|exists:users,id',
        ]);
        $modelClass = app("App\\Models\\" . Str::studly($request->postType));
        $posts = $modelClass::with('adderInfo', 'editorInfo')
            ->when(!empty($request->id), function ($query) use ($request) {
                return $query->whereId($request->id);
            })
            ->when(!empty($request->title), function ($query) use ($request) {
                return $query->where('title', 'LIKE', "%$request->title%");
            })
            ->when(!empty($request->slug), function ($query) use ($request) {
                return $query->where('slug', 'LIKE', "%$request->slug%");
            })
            ->when(!empty($request->status), function ($query) use ($request) {
                return $query->whereStatus($request->status);
            })
            ->when(!empty($request->adder), function ($query) use ($request) {
                return $query->whereAdder($request->adder);
            })
            ->when(!empty($request->editor), function ($query) use ($request) {
                return $query->whereEditor($request->editor);
            })
            ->orderByDesc('id')
            ->paginate(50);

        return $posts;
    }

    public function makeTokenForDraft($table)
    {
        do {
            $token = Str::random(32);
            $model = "\\App\\Models\\" . Str::studly(rtrim($table, 's'));
            $hashExists = $model::where('draft_token', $token)->exists();
        } while ($hashExists);

        return $token;
    }
}
