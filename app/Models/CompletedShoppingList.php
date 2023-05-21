<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompletedShoppingList extends Model
{
    use HasFactory;


     /**
     * 複数代入不可能な属性
     */
    protected $guarded = [];

    protected $fillable = [
        'name',
        'user_id',
        'id',
        'created_at',
        'updated_at',
        ];


    /**紐づけテーブル**/

    protected $table='completed_shopping_lists';

     protected $list=[
    'created_at',
    'updated_at'];



}
