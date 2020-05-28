<?php

// 获取当前路由名称，用来作为页面的 CSS 类名称，方便真的某个页面做样式定制
function route_class()
{
  // 获取路由名 users.create 返回 users-create
  return str_replace('.', '-', Route::currentRouteName());
}