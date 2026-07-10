<?php

require_once('Model.php');

class Post extends Model
{
    protected static string $table = 'posts';
    protected static string $primaryKey = 'post_id';
    //protected array $attributes = [];
    protected static array $fillable = [
        'post_content',
    ];

}

?>