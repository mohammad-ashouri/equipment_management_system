<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class DocumentClass extends Model
{
    use  SoftDeletes, Sluggable, SluggableScopeHelpers;

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
                'onUpdate' => true,
                'unique' => true,
                'method' => function ($string, $separator) {
                    return $this->slugify($string, $separator);
                }
            ]
        ];
    }

    /**
     * Convert the given string to a slug, preserving Persian characters.
     *
     * @param string $string
     * @param string $separator
     * @return string
     */
    protected function slugify($string, $separator = '-')
    {
        // Remove any characters that are not letters or numbers (unicode safe)
        $string = preg_replace('/[^\pL\pN\s]+/u', '', $string);

        // Replace spaces with the separator
        $string = preg_replace('/[\s]+/u', $separator, $string);

        // Trim any separator characters from the beginning or end
        return trim($string, $separator);
    }

    /**
     * Boot the model and add a creating event to generate the slug.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $slug = $model->slugify($model->title, '-');
            $originalSlug = $slug;
            $count = 1;

            // Check if the slug already exists
            while (static::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $count;
                $count++;
            }

            $model->slug = $slug;
        });
    }

    public $table = 'document_classes';
    protected $fillable = [
        'slug',
        'title',
        'short_title',
        'class_time',
        'about_class',
        'topics',
        'teacher',
        'chosen',
        'status',
        'adder',
        'editor',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function mainImage()
    {
        return $this->belongsTo(Picture::class, 'id', 'post_id')->where('post_type', 'document_class')->where('image_type', 'picture_main');
    }

    public function mainVideo()
    {
        return $this->belongsTo(Video::class, 'id', 'post_id')->where('post_type', 'document_class')->where('video_type', 'video_main');
    }

    public function adderInfo()
    {
        return $this->belongsTo(User::class, 'adder', 'id');
    }

    public function editorInfo()
    {
        return $this->belongsTo(User::class, 'editor', 'id');
    }

    public function sliderImage()
    {
        return $this->belongsTo(Picture::class, 'id', 'post_id')->where('post_type', 'documentclass')->where('image_type', 'slider');
    }
}
