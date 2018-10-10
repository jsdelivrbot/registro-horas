<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Category extends Model {

    protected $table= "categories";
    protected $primarykey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','name', 'status','category_image','created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    
}
