<?php
declare(strict_types=1);
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User as UserModel;
use Illuminate\Support\Facades\DB;

class AdminUserController extends Controller
{
    /**
     * ユーザの一覧 を表示する
     *
     * @return \Illuminate\View\View
     */
     public function list()
    {
          
        $group_by_column = ['users.id', 'users.name','completed_shopping_lists.name'];
        $list = UserModel::select($group_by_column)
                         ->selectRaw('count(completed_shopping_lists.name) AS completed_shopping_list_num')
                         ->leftJoin('shopping_lists', 'users.id', '=', 'shopping_lists.user_id')
                         ->groupBy($group_by_column)
                         ->get();

        return view('admin.user.list', ['users' => $list]);
    }
}