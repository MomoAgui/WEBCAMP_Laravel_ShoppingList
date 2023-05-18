<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShoppingRegisterPost;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Shoppinglist as ShoppinglistModel;
use App\Models\CompletedShoppingList as CompletedShoppingListModel;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Http\Request;
use Carbon\Carbon;


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
        
        
        
            
        return view('shopping_list.list',['shopping_lists'=>$list]);
    }

 /**
     * 「買うもの」の登録
     */
    public function register(ShoppingRegisterPost $request)
    {
        // validate済みのデータの取得
        $datum = $request->validated();

         //$user=Auth::user();
         //$id=Auth::id();

         $datum['user_id'] = Auth::id();

        // テーブルへのINSERT
        try{
               ShoppinglistModel::create($datum);
           }catch(\Throwable $e){
               echo $e->getMessage();
               exit;
        }


        // 「買うもの」登録成功
        $request->session()->flash('front.shopping_list_list_success', true);

        return redirect('/shopping_list/list');
    }
      /**
     * 「単一のリスト」Modelの取得
     */
        protected function getShoppinglistModel($shopping_list_id)
    {
        // shopping_list_id_idのレコードを取得する
        $list = ShoppinglistModel::find($shopping_list_id);
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
     * 「単一のリスト」の表示
     */
    protected function singleListRender($shopping_list_id, $template_name)
    {
        // shopping_list_idのレコードを取得する
        $list = $this->getShoppinglistModel($shopping_list_id);
        if ($list === null) {
            return redirect('/shopping_list/list');
        }

        // テンプレートに「取得したレコード」の情報を渡す
        return view($template_name, ['shopping_lists' => $list]);
    }

   /**
     * 削除処理
     */
    public function delete(Request $request, $shopping_list_id)
    {
        //shopping_list_idのレコードを取得する
        $list= ShoppinglistModel::where('user_id',Auth::id());



         // 単一shopping_list_idのレコードを取得する
        $list = $this->getShoppinglistModel($shopping_list_id);
        if ($list === null) {
            return redirect('/shopping_list/list');
        }
        
        if ($list !== null) {
            $list->delete();
        
        }
        
         $request->session()->flash('front.list_delete_success', true);


        // 一覧に遷移する
        return redirect('/shopping_list/list');
    }
     /**
     * 完了
     */
    public function complete(Request $request,$shopping_list_id)
    {
        
         // shopping_list_idのレコードを取得する
             $list= ShoppinglistModel::where('user_id',Auth::id());
              $list = $this->getShoppinglistModel($shopping_list_id);


        /* タスクを完了テーブルに移動させる */
        try {
            // トランザクション開始
            DB::beginTransaction();

           
            if ($list === null) {
                // shopping_list_idが不正なのでトランザクション終了
                throw new \Exception('');
            }

            // shopping_lists側を削除する
            $list->delete();


            // completed_shopping_lists側にinsertする
            $dask_datum = $list->toArray();
            unset($dask_datum['created_at']);
            unset($dask_datum['updated_at']);
            CompletedShoppingListModel::create($dask_datum);
            if ($list === null) {
                // insertで失敗したのでトランザクション終了
                throw new \Exception('');
            }
            // トランザクション終了
            DB::commit();
            // 完了メッセージ出力
            $request->session()->flash('front.list_completed_success', true);
        } catch(\Throwable $e) {

            // トランザクション異常終了
            DB::rollBack();
            
              echo $e->getMessage();
               exit;

        }

        // 一覧に遷移する
        return redirect('/shopping_list/list');
        
}

}