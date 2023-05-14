<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShoppingRegisterPost;
use Illuminate\Support\Facades\Auth;
use App\Models\Shoppinglist as ShoppinglistModel;
use Illuminate\Support\Facades\DB;
use App\Models\CompletedTask as CompletedTaskModel;
use Symfony\Component\HttpFoundation\StreamedResponse;

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

        //
        return view('shopping_list.list');
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
        $request->session()->flash('front.shopping_list_register_success', true);

        return redirect('/shopping_list/list');
    }

}