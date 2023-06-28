<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MetaTag extends Model
{
    protected $table = 'meta_tags';
    protected $fillable = ['title', 'page_slug', 'description', 'keywords'];
}
