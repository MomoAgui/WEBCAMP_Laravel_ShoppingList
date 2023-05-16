<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginPostRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\CompletedShoppingList as CompletedShoppingListModel;

class CompletedShoppingListController extends Controller
{

    /**
     * 完了タスク一覧 を表示する
     *
     * @return \Illuminate\View\View
     */
    public function list()

    {
        $list=CompletedShoppingListModel::get();  /**完了したテーブル全レコードを取得**/

        // 1Page辺りの表示アイテム数を設定
        $per_page = 3;

        // 一覧の取得
        $list =CompletedShoppingListModel::where('user_id',Auth::id())->paginate($per_page);


        return view('completed_shopping_list.list',['completed_shopping_lists'=>$list]);
    }




    /**
     * ログアウト処理
     *
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->regenerateToken();  // CSRFトークンの再生成
        $request->session()->regenerate();  // セッションIDの再生成
        return redirect(route('front.index'));
    }
}