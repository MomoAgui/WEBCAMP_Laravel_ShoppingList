<?php
declare(strict_types=1);
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;

class AdminHomeController extends Controller
{
    /**
     * トップページ を表示する
     *
     * @return \Illuminate\View\View
     */
    public function top()
    {
        return view('admin.top');
    }
}