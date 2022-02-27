<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItemReview extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'user_id', 'item_id', 'rate', 'review',
    ];

    public function user() {
        return $this->belongsTo('App\Model\User')->with('buyer');
    }
    public function images() {
        return $this->hasMany('App\Model\ItemReviewImage', 'review_id');
    }
}