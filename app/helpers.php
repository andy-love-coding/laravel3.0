<?php

// 获取当前路由名称，用来作为页面的 CSS 类名称，方便真的某个页面做样式定制
function route_class()
{
  // 获取路由名 users.create 返回 users-create
  return str_replace('.', '-', Route::currentRouteName());
}

// 为当前活跃「分类路由」，添加 active 的css类名 
function category_nav_active($category_id)
{
  // active_class 是 summerblue/laravel-active 扩展提供的方法
  // 如果「路由名」是 categories.show 并且 「参数」category 的值是 $category_id ，则返回 'actvie' 作为 css 类名
  return active_class((if_route('categories.show') && if_route_param('category', $category_id)));
}

// 根据 $topic->body 内容，去除 html 代码，去除空行及回车键，生成限制字数的摘要
function make_excerpt($value, $length = 200)
{
  $excerpt = trim(preg_replace('/\r\n|\r|\n+/', ' ', strip_tags($value)));
  return Str::limit($excerpt, $length);
}