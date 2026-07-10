<?php 

require_once('Model.php');

class User extends Model
{
    protected static string $table = 'users';
    protected static string $primaryKey = 'user_id';
    //protected array $attributes = [];
    protected static array $fillable = [
        'user_name',
        'user_email',
        'user_password'
    ];

    public static function find(int $id): ?static
    {
        $result =  static::query()
            -> select()
            -> join('roles', 'roles.role_id', '=', 'users.role_id')
            -> where(static::$primaryKey, '=', $id)
            -> firstModel();

        
        if(!$result)
        {
            return null;
        }

        return  $result; //static::hydrate($result);
    }

    public static function searchLoginCredentials($email, $password)
    {
        return static::query()
            ->select()
            ->where('user_email', '=', $email) 
            ->where('user_password', '=', md5($password))
            ->first();
    }
}

?>