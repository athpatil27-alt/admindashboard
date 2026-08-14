<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Video extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'video_url',
        'teacher_name',
        'thumbnail_path',
    ];

    /**
     * Video belongs to a User (Teacher/Creator).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the display name of the teacher/creator
     */
    public function getTeacherDisplayNameAttribute(): string
    {
        if ($this->user) {
            return $this->user->name;
        }

        return $this->teacher_name ?? 'Unassigned';
    }

    /**
     * Get clean embed iframe URL from video_url column
     */
    public function getEmbedUrlAttribute(): string
    {
        $input = trim($this->video_url ?? '');

        if (empty($input)) {
            return '';
        }

        // If it contains an iframe src attribute, extract it
        if (preg_match('/src=["\']([^"\']+)["\']/', $input, $matches)) {
            return $matches[1];
        }

        // If it's a direct Vimeo ID or URL
        if (preg_match('/vimeo\.com\/(?:channels\/(?:\w+\/)?|groups\/[^\/]*\/videos\/|album\/\d+\/video\/|video\/|)(\d+)/', $input, $matches)) {
            return 'https://player.vimeo.com/video/' . $matches[1] . '?autoplay=1';
        }

        // If it's Youtube URL
        if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/', $input, $matches)) {
            return 'https://www.youtube.com/embed/' . $matches[1] . '?autoplay=1';
        }

        // If already a valid URL, return it
        if (filter_var($input, FILTER_VALIDATE_URL)) {
            return $input;
        }

        return $input;
    }

    /**
     * Get thumbnail full URL or fallback
     */
    public function getThumbnailUrlAttribute(): string
    {
        if ($this->thumbnail_path) {
            if (filter_var($this->thumbnail_path, FILTER_VALIDATE_URL)) {
                return $this->thumbnail_path;
            }
            return asset('storage/' . $this->thumbnail_path);
        }
        return 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=500&auto=format&fit=crop&q=60';
    }
}
