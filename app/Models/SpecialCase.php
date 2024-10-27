<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SpecialCase extends Model
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

    public $table = 'special_cases';
    protected $fillable = [
        'slug',
        'title',
        'note_title',
        'note_body',
        'interview_title',
        'interview_body',
        'movies',
        'audios',
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

    public function noteImage()
    {
        return $this->belongsTo(Picture::class, 'id', 'post_id')->where('post_type', 'special_case_note')->where('image_type', 'picture_main');
    }

    public function interviewImage()
    {
        return $this->belongsTo(Picture::class, 'id', 'post_id')->where('post_type', 'special_case_interview')->where('image_type', 'picture_main');
    }

    public function imagesGallery()
    {
        return $this->hasMany(Picture::class, 'post_id')->where('post_type', 'special_case_image_gallery')->where('image_type', 'picture_main');
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
        return $this->belongsTo(Picture::class, 'id', 'post_id')->where('post_type', 'specialcase')->where('image_type', 'slider');
    }
}
