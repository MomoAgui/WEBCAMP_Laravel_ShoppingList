<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shoppinglist extends Model
{

 protected $fillable = [
        'name',
        'email',
        'password',
        'user_id',
        'shopping_list_id',
    ];
     /**
     * 複数代入不可能な属性
     */
    protected $guarded = ['id'];

    /**紐づけテーブル**/

    protected $table='shopping_lists';


}
