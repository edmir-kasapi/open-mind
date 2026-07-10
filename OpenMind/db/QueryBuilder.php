<?php

require_once('DBConnection.php');
require_once('Models/Model.php');

class QueryBuilder
{
    private PDO $pdo;
    private string $table;
    private string $modelClass;
    private string $query = '';
    private array $bindings = [];

    public function __construct(string $modelClass)
    {
        $this -> pdo = DBConnection::getConnection();
        $this -> modelClass = $modelClass;
    }

    public function table(string $value): self
    {
        $this -> table = $value;
        return $this;
    }

    public function select(array $columns = ['*']): self
    {
        $columnList = implode(', ', $columns);
        $this -> query = "SELECT $columnList FROM {$this-> table}";
        

        return $this;
    }

    public function where(string $column, string $operator, mixed $value, bool $no_filter = false): self
    {
        if(!$no_filter) //this is for more complex operations where you want to deactivate the where for special conditions
        {
            $placeholder = ':' . str_replace('.', '_', $column);
            $this -> query .= (str_contains($this -> query, 'WHERE') ? " AND" : " WHERE") . " $column $operator $placeholder";
            $this -> bindings [ $placeholder ] = $value;
        }

        return $this;
    }

    public function orWhere(string $column, string $operator, mixed $value, bool $no_filter = false): self
    {
        if(!$no_filter) //this is for more complex operations where you want to deactivate the where for special conditions
        {
            $placeholder = ':' . str_replace('.', '_', $column);
            $this -> query .= (str_contains($this -> query, 'WHERE') ? " OR" : " WHERE") . " $column $operator $placeholder";
            $this -> bindings [ $placeholder ] = $value;
        }

        return $this;
    }

    public function join(string $table, string $column1, string $operator, string $column2): self
    {
        $this -> query .= " JOIN $table ON $column1 $operator $column2";
        
        return $this;
    }

    public function count(string $column = '*'): self
    {
        $this -> query = "SELECT COUNT($column) as value FROM {$this-> table}";
        
        return $this;
    }

    public function avg(string $column = '*'): self
    {
        $this->query = "SELECT AVG($column) as value FROM {$this->table}";

        return $this;
    }

    public function sum(string $column = '*'): self
    {
        $this->query = "SELECT SUM($column) as value FROM {$this->table}";

        return $this;
    }

    public function limit(int $count): self
    {
        $this -> query .= " LIMIT $count";

        return $this;
    }

    public function orderBy(string $column, string $option, bool $no_filter = false)
    {
        if(!$no_filter)
        {
            $this -> query .= " ORDER BY $column $option";
        }

        return $this;
    }

    public function groupBy(string $column)
    {
         $this -> query .= " GROUP BY $column";

        return $this;
    }

    public function offset(int $count): self
    {
        $this -> query .= " OFFSET $count";

        return $this;
    }

    public function insert(array $data): int
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_map(fn($col) => ":$col", array_keys($data)));
        $this -> query = "INSERT INTO {$this -> table} ($columns) VALUES ($placeholders)";
        $this -> bindings = array_combine(array_map(fn($col) => ":$col", array_keys($data)), array_values($data));

        $this -> execute();

        return $this -> pdo -> lastInsertId();
    }

    public function update(array $data): self
    {
        $set = implode(', ', array_map(fn($col) => "$col = :$col", array_keys($data)));
        $this -> query = "UPDATE {$this -> table} SET $set";
        foreach($data as $key => $value)
        {
            $this -> bindings [":$key"] = $value;
        }

        return $this;
    }

    public function delete(): self
    {
        $this -> query = "DELETE FROM {$this -> table}";

        return $this;
    }

    public function execute(): void
    {
        $pdo = DBConnection::getConnection();
        $stmnt = $pdo -> prepare($this -> query);
        $stmnt -> execute($this -> bindings);

        $this -> reset();
    }

    public function first(): array | bool
    {
        $stmnt = $this -> pdo -> prepare($this -> query);
        $stmnt -> execute($this -> bindings);

        $this -> reset();

        return $stmnt -> fetch(PDO::FETCH_ASSOC);
    }

    public function getAll(): array | bool
    {
        $stmnt =  $this -> pdo -> prepare($this -> query);
        $stmnt -> execute($this -> bindings);

        $this -> reset();
        
        return $stmnt -> fetchAll(PDO::FETCH_ASSOC);
    }

    public function firstModel(): ?Model
    {
        $stmnt = $this -> pdo -> prepare($this -> query);
        $stmnt -> execute($this -> bindings);

        $this -> reset();
       
        $result = $stmnt -> fetch(PDO::FETCH_ASSOC);

        if(!$result)
        {
            return null;
        }

        return $this-> modelClass::hydrate($result);;
    }

    public function getAllModels(): array | bool
    {
        $stmnt =  $this -> pdo -> prepare($this -> query);
        $stmnt -> execute($this -> bindings);

        //var_dump($this->query);

        $this -> reset();

        $result = $stmnt -> fetchAll(PDO::FETCH_ASSOC);

        $objects = [];

        foreach($result as $res)
        {
            $objects[] = $this -> modelClass::hydrate($res);
        }

        return $objects;
    }

    private function reset(): void
    {
        $this->query = '';
        $this->bindings = [];
    }

}

?>