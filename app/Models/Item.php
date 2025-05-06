<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'photo_img',
        'lost_date',
        'category',
        'loc_seen',
        'markings',
        'status',
        'bin',
        'issued_by',
        'issued_date',
        'received_by',
        'received_date',
        'user_id',
        'postedby',
        'location',
        'claimed_by'
    ];

    public function toSearchableArray()
    {
        return [
            'title' => $this->title,
            'category' => $this->category,
            // Add other fields you want to search
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function histories()
    {
        return $this->hasMany(ItemHistory::class);
    }

    // If you want to define an accessor for photo_img, you can use the following approach
    public function getPhotoImgAttribute($value)
    {
        return $value ? $value : 'photo_img/question-mark.jpg'; 
    }
}
