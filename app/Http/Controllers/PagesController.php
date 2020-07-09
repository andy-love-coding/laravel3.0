<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    // 展示首页
    public function root()
    {
        return view('pages.root');
    }

    public function permissionDenied()
    {
        // 如果当前用户有权限访问后台，直接跳转访问
        // 这个判断的必要性：未登录时(无权)→登录后(有权)->跳转访问
        if (config('administrator.permission')()) {
            return redirect(url(config('administrator.uri')), 302);
        }

        // 否则使用「拒绝」视图
        return view('pages.permission-denied');
    }
}
