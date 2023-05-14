<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginPostRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * トップページ を表示する
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('index');
    }

    /**
     * ログイン処理
     *
     */
    public function login(LoginPostRequest $request)
    {
        $datum=$request->validated();
        return view('/shopping_list/list',['datum'=>$datum]);

        if(Auth::attempt($datum)===false){
            return back()
            ->withInput()
            ->withErrors(['auth'=>'emailかパスワードに誤りがあります'],);
        }
        $request->sesstion()->regenerate();
        return redirect()->intendes('/shopping_list/list');

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