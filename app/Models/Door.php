<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Door extends Model
{
    use HasFactory;

    protected $table = 'doors';
    protected $primaryKey = 'door_id';


    protected $fillable = ['door_name', 'mac_add'];
}
