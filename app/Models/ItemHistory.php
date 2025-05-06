<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'changed_from',
        'changed_to',
        'action',
        'changed_by',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
