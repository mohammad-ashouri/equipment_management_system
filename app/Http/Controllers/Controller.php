<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Catalogs\Category;
use App\Models\Catalogs\DocumentType;
use App\Models\Catalogs\PersonAdjective;
use App\Models\Catalogs\PostType;
use App\Models\Catalogs\SocialMediaPlatform;
use App\Models\EquipmentLog;
use App\Models\Picture;
use App\Models\Video;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
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
        $keywordsArray = array_map('trim', explode(',', $array));
        return json_encode($keywordsArray);
    }

    public function savePictures($postId, $postType, $imageType, $src)
    {
        $mainPicture = new Picture();
        $mainPicture->post_id = $postId;
        $mainPicture->post_type = $postType;
        $mainPicture->image_type = $imageType;
        $mainPicture->src = $src;
        $mainPicture->adder = $this->getMyUserId();
        $mainPicture->save();
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
}
