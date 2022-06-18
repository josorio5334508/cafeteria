<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Sale extends Model
{
    use HasFactory;

    protected $connection='mysql';

    protected $table = 'ventas';

    protected $db;

    public function __construct(){
        $this->db= DB::connection($this->connection);
    }

    /**
     * It inserts a new row into the database table
     * 
     * @param data The data to be inserted into the table.
     * 
     * @return The id of the inserted row.
     */
    public function saleRegister($data){
        return $this->db->table($this->table)->insertGetId($data);
    }

    public function registerDetail($data){
        return $this->db->table('detalle_venta')->insert($data);
    }

}
