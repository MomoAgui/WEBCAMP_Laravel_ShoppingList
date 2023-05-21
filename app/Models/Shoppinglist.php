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
        'created_at',
        'updated_at',
        'shopping_list_id',
        'completed_shopping_list_id'
    ];
     /**
     * 複数代入不可能な属性
     */
    protected $guarded = [];

    /**紐づけテーブル**/

    protected $table='shopping_lists';

   protected $list=[
    'created_at',
    'updated_at'];



}
