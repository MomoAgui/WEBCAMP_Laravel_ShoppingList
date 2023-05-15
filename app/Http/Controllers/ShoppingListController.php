<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShoppingRegisterPost;
use Illuminate\Support\Facades\Auth;
use App\Models\Shoppinglist as ShoppinglistModel;

use Illuminate\Http\Request;


class ShoppingListController extends Controller
{

    /**
     *「買うもの」ページ を表示する
     *
     * @return \Illuminate\View\View
     */
    public function list()
    {



        // 一覧の取得
        $list=ShoppinglistModel::get();

         // 1Page辺りの表示アイテム数を設定
        $per_page = 3;

        $list = ShoppinglistModel::where('user_id',Auth::id())->paginate($per_page);

        //shopping_listsの情報をlistに渡す
        return view('shopping_list.list', ['shopping_lists' => $list]);
    }

 /**
     * 「買うもの」の登録
     */
    public function register(ShoppingRegisterPost $request)
    {
        // validate済みのデータの取得
        $datum = $request->validated();
        //$user = Auth::user();
        //$id = Auth::id();
        //var_dump($datum, $user, $id); exit;

        // user_id の追加
        $datum['user_id'] = Auth::id();
        // テーブルへのINSERT
        try {
             ShoppinglistModel::create($datum);
        } catch(\Throwable $e) {
            // XXX 本当はログに書く等の処理をする。今回は一端「出力する」だけ
            echo $e->getMessage();
            exit;
        }



        // 「買うもの」登録成功
        $request->session()->flash('front.shopping_list_list_success', true);

        return redirect('/shopping_list/list');
    }
    /**
     * 「単一のタスク」Modelの取得
     */
    protected function getShoppinglistModel($list_id)
    {
        // list_idのレコードを取得する
        $list = ShoppinglistModel::find($list_id);
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
    protected function singleTaskRender($list_id, $template_name)
    {
        // list_idのレコードを取得する
        $list = $this->getTaskModel($list_id);
        if ($list === null) {
            return redirect('/shopping_list/list');
        }

        // テンプレートに「取得したレコード」の情報を渡す
        return view($template_name, ['shopping_lists' => $list]);
    }

}