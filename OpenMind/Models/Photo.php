<?php 

require_once('Model.php');

class Photo extends Model
{
    protected static string $table = 'photos';
    protected static string $primaryKey = 'photo_id';
    //protected array $attributes = [];
    protected static array $fillable = [
        'photo_hash_name',
        'photo_original_name',
        'photo_extension',
        'photo_size',
        'photo_type',
    ];
}

?>