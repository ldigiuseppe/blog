<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Post extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'post';

    protected $fillable = [
    	'title', 'body', 'created_at', 'updated_at', 'created_by'
    ];
}


