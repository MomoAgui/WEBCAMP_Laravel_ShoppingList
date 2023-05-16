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
    public function list()      /** $task_idの時のみ引数()に入れる**/

    {
        $list=CompletedShoppingListModel::get();  /**完了したテーブル全レコードを取得**/

        // 1Page辺りの表示アイテム数を設定
        $per_page = 3;

        // 一覧の取得
        $list =CompletedShoppingListModel::where('user_id',Auth::id())->paginate($per_page);


        return view('completed_shopping_list.list',['list'=>$completed_shopping_lists]);  /**Complted_tasksの情報をlistに渡す**/

    }
    /**
     * 「単一のタスク」Modelの取得
     */
    protected function getCompletedTaskModel($list_id)
    {
        // list_idのレコードを取得する
        $list = CompetedTaskModel::find($list_id);
        if ($list === null) {
            return null;
        }
        // 本人以外のタスクならNGとする
        if ($list->user_id !== Auth::id()) {
            return null;
        }
        //
        return $list;
    }

    /**
     * 「単一のタスク」の表示
     */
    protected function singleListRender($list_id, $template_name)
    {
        // list_idのレコードを取得する
        $list = $this->getCompletedShoppingListModel($list_id);
        if ($list === null) {
            return redirect('/completed_shopping_list/list');
        }

        // テンプレートに「取得したレコード」の情報を渡す
        return view($template_name, ['completed_shopping_lists' => $list]);
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