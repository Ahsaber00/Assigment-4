<?php




class Db{
    public $connnection;
    public $query;
    public $sql;

    public function __construct()
    {
        $this->connnection = mysqli_connect("localhost","root","","pms");
    }

    public function select($table,$column){
        $this->sql = "SELECT $column FROM `$table` ";
        return $this;
    }

    public function where($column,$compair,$value){
        $this->sql .= " WHERE `$column` $compair '$value'";
        return $this;
    }

    public function andWhere($column,$compair,$value){
        $this->sql .= " AND  `$column` $compair '$value'";
        return $this;
    }

    public function orWhere($column,$compair,$value){
        $this->sql .= " OR  `$column` $compair '$value'";
        return $this;
    }

    public function getAll(){
        
        $this->query();
        while($row = mysqli_fetch_assoc($this->query)){
            $data[] = $row;
        }
        return $data;
    }

    public function getRow(){
          $this->query();
        $row = mysqli_fetch_assoc($this->query);
        return $row;
    }

    public function insert($table,$data){
        
        $row = $this->preparData($data);
        $this->sql = "INSERT INTO `$table` SET $row";
        // echo $this->sql;die;
        return $this;
    }

    public function update($table,$data){
    
        $row = $this->preparData($data);
        $this->sql = "UPDATE `$table` SET $row";
        return $this;
    }

    public function delete($table){
        $this->sql = "DELETE FROM `$table` ";
        return $this;
    }

    public function excu(){
        $this->query();
        if(mysqli_affected_rows($this->connnection) > 0){
            return true;
        }
    }

    public function preparData($data){
        // print_r($data);die;
        $row = "";
        foreach($data as $key => $value){
            $row .= " `$key` = ".((gettype($value) == 'string') ? "'$value'" : "$value").",";
        }
        $row = rtrim($row,",");
        // echo $row;die;
        return  $row;
    }


    public function query(){
        $this->query =  mysqli_query($this->connnection,$this->sql);
    }

       
    public function __destruct()
    {
        mysqli_close($this->connnection);
    }
}




class Validation
{
    function requiredVal($input)
{
    if(empty($this->$input))
    {
        return false;
    }
    else
    {
        return true;
    }
}
function minVal($input,$length)
{
    if(strlen($this->$input)< $this->$length)
    {
        return false;
    }
    else
    {
        return true;
    }
}
function maxVal($input,$length)
{
    if(strlen($this->$input)>$this->$length)
    {
        return false;
    }
    else
    {
        return true;
    }
}
}






?>