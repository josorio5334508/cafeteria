<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Product extends Model
{
    use HasFactory;

    protected $connection='mysql';

    protected $table = 'products';

    protected $db;

    public function __construct(){
        $this->db= DB::connection($this->connection);
    }

    /**
     * > This function returns all the rows from the table
     * 
     * @return The result of the query.
     */
    public function get(){
        return $this->db->select('SELECT * FROM '.$this->table);
    }


    /**
     * It inserts a new row into the database table
     * 
     * @param data The data to be inserted into the table.
     * 
     * @return The id of the inserted row.
     */
    public function create($data){
        return $this->db->table($this->table)->insert($data);
    }

    public function updateById($data){
        return $this->db->table($this->table)
                        ->where('id', $data['id'])
                        ->update($data);
    }

    public function deleteById($id){
        return $this->db->table($this->table)
                            ->where('id', '=', $id)
                            ->delete();
    }

}
