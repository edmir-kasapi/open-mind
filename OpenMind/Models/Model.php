<?php

//require_once('db/DBConnection.php');
require_once('db/QueryBuilder.php');

abstract class Model{

    protected static string $table;
    protected static string $primaryKey;
    protected static array $fillable = [];
    protected array $attributes = [];
    

    private function fill(array $data): static
    {
        foreach($this -> fillable as $field)
        {
            if(array_key_exists($field, $data))
                {
                    $this -> attributes[$field] = $data[$field];
                }
        }

        return $this;
    }

    public static function all(): ?array
    {
        $result = static::query()
            -> select()
            -> getAllModels();

        return $result;
    }

    public static function find(int $id): ?static
    {
        $result =  static::query()
            -> select()
            -> where(static::$primaryKey, '=', $id)
            -> firstModel();

        return $result; //static::hydrate($result);
    }

    public static function store(array $data): int
    {
        return static::query()
            ->insert($data);
    }

    public static function where(string $column, string $operator, mixed $value)
    {
        return static::query()
            ->select()
            -> where($column, $operator, $value); 
    }

    public static function update(array $data)
    {
        return static::query()
            -> update($data);
    }

    public static function destroy($id) //deletes an item from the database
    {
        static::query()
            -> delete()
            -> where(static::$primaryKey, '=', $id)
            -> execute();
    }

    public static function count(string $column)
    {
        return static::query()
            ->count($column);
    }

    /* 
    public static function first() //returns only one record, which is the first record found
    {
        return static::query()
            -> first(); //uses the method get of the QueryBuilder
    }

    
    public static function get() //returns all records found
    {
        return static::query()
            -> getAll(); //uses the method getAll of the QueryBuilder
    }
    */

    public static function hydrate(array $data): static
    {
        $model = new static();
        
        foreach($data as $key => $value)
        {
            $model -> attributes[$key] = $value; 
        }

        return $model;
    }

    protected static function query() : QueryBuilder
    {
        $builder = new QueryBuilder(static::class);

        return ($builder->table(static::$table));
    }

    public function __get($key)
    {
        return $this -> attributes[$key] ?? null;
    }

    public function __set($attribute, $value)
    {
        $this -> attributes[$attribute] = $value;
    }

}

?>