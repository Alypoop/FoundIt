<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'photo_img',
        'lost_date',
        'category_id',
        'item_type_id',
        'location',
        'markings',
        'status',
        'bin',
        'issued_by',
        'issued_date',
        'received_by',
        'received_date',
        'user_id',
        'claimed_by'
    ];

    protected $casts = [
        'lost_date' => 'date',
        'issued_date' => 'date',
        'received_date' => 'date',
    ];

    public function toSearchableArray()
    {
        return [
            'title' => $this->title,
            'category' => $this->category ? $this->category->name : null,
            'item_type' => $this->itemType ? $this->itemType->name : null,
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function itemType()
    {
        return $this->belongsTo(ItemType::class);
    }

    public function histories()
    {
        return $this->hasMany(ItemHistory::class);
    }

    public function getPhotoImgAttribute($value)
    {
        return $value ?: 'photo_img/question-mark.jpg';
    }
}