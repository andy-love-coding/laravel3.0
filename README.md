## 2 舞台布置
### 2.3 创建应用
  - 1.composer 加速
    ```
    composer config -g repo.packagist composer https://mirrors.aliyun.com/composer/
    ```
  - 2.创建应用
    ```
    composer create-project laravel/laravel laravel2.2 --prefer-dist "6.*"
    ```
  - 3.修改 hosts（subl /etc/hosts）
    ```
    192.168.10.10   larabbs.test
    ```
  - 4.新增站点（subl ~/Homestead/Homestead.yaml）
    ```
    sites:
    - map: laravel2.2.test
      to: /home/vagrant/CodeTest/laravel2.2/public

    databases:
    - laravel1.5
    - laravel2.2
    ```
  - 5.重启虚拟机，生成站点和数据库
    ```
    cd ~/Homestead && vagrant provision && vagrant reload
    ```
  - 6.统一代码风格 `.editorconfig`
    ```
    root = true

    [*]
    charset = utf-8
    end_of_line = lf
    insert_final_newline = true
    indent_style = space
    indent_size = 4
    trim_trailing_whitespace = true

    [*.md]
    trim_trailing_whitespace = false

    [*.{yml,yaml}]
    indent_size = 2

    [*.{js,html,blade.php,css,scss}]
    indent_style = space
    indent_size = 2
    ```
### 2.4 配置信息
  - 配置文件，在config文件夹下
    | 文件名称         | 配置类型                             |
    | ---------------- | ------------------------------------ |
    | app.php          | 应用相关，如项目名称、时区、语言等   |
    | auth.php         | 用户授权，如用户登录、密码重置等     |
    | broadcasting.php | 事件广播系统相关配置                 |
    | cache.php        | 缓存相关配置                         |
    | database.php     | 数据库相关配置，包括 MySQL、Redis 等 |
    | filesystems.php  | 文件存储相关配置                     |
    | hashing.php      | 加密算法相关设置                     |
    | logging.php      | 日志记录相关的配置                   |
    | mail.php         | 邮箱发送相关的配置                   |
    | queue.php        | 队列系统相关配置                     |
    | services.php     | 放置第三方服务配置                   |
    | session.php      | 用户会话相关配置                     |
    | view.php         | 视图存储路径相关配置                 |
  - 访问配置文件
    ```
    $value = config('app.timezone');
    ```
  - 要在运行时设置配置值，传递一个数组给 config 函数
    ```
    config(['app.timezone' => 'America/Chicago']);
    ```
  - 调整几个应用配置信息
    - 应用名称 和 应用链接 `.env`
      ```
      APP_NAME=LaraBBS // 应用名称，通过 'name' => env('APP_NAME', 'Laravel'), 获取
      APP_URL=http://laravel2.2.test // 应用链接，'url' => env('APP_URL', 'http://localhost'),
      ```
    - 时区 和 默认语言 `config/app.php`
      ```
      timezone' => 'Asia/Shanghai',
      'locale' => 'zh-CN',
      ```
### 2.5 自定义辅助函数
  - 1.新建帮助文件（我们把所有的『自定义辅助函数』都存放于 app/helpers.php 文件中）
    ```
    touch app/helpers.php
    ```
  - 2.自动加载帮助文件：在 composer.json 中的 autoload 中加入："files": ["app/helper.php"]
    ```
    "autoload": {
        "psr-4": {
            "App\\": "app/"
        },
        "classmap": [
            "database/seeds",
            "database/factories"
        ],
        "files": [
            "app/helpers.php"
        ]
    }
    ```
  - 3.运行以下命令进行重新加载文件即可
    ```
    composer dump-autoload
    ```
### 2.6 基础布局
  - 1.主布局文件 resources/views/layouts/app.blade.php
    ```
    <!DOCTYPE html>
    <html lang="{{ app()->getLocale() }}">

    <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">

      <!-- CSRF Token -->
      <meta name="csrf-token" content="{{ csrf_token() }}">

      <title>@yield('title', 'LaraBBS') - Laravel 进阶教程</title>

      <!-- Styles -->
      <link href="{{ mix('css/app.css') }}" rel="stylesheet">

    </head>

    <body>
      <div id="app" class="{{ route_class() }}-page">

        @include('layouts._header')

        <div class="container">

          @include('shared._messages')

          @yield('content')

        </div>

        @include('layouts._footer')
      </div>

      <!-- Scripts -->
      <script src="{{ mix('js/app.js') }}"></script>
    </body>

    </html>
    ```
    - **在视图页获取配置信息：** `app()->getLocale()`  获取的是 config/app.php 中的 locale 选项
    - `<meta name="csrf-token" content="{{ csrf_token() }}">` 标签是为了方便前端的 JavaScript 脚本获取 CSRF 令牌。
    - `<div id="app" class="{{ route_class() }}-page">` route_class() 是我们**自定义的辅助函数** 
      - app/helpers.php
        ```
        <?php

        // 获取当前路由名称，用来作为页面的 CSS 类名称，方便真的某个页面做样式定制
        function route_class()
        {
          // 获取路由名 users.create 返回 users-create
          return str_replace('.', '-', Route::currentRouteName());
        }
        ```
  - 2.顶部导航 resources/views/layouts/_header.blade.php
    ```
    <nav class="navbar navbar-expand-lg navbar-light bg-light navbar-static-top">
      <div class="container">
        <!-- Branding Image -->
        <a class="navbar-brand " href="{{ url('/') }}">
          LaraBBS
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <!-- Left Side Of Navbar -->
          <ul class="navbar-nav mr-auto">

          </ul>

          <!-- Right Side Of Navbar -->
          <ul class="navbar-nav navbar-right">
            <!-- Authentication Links -->
            <li class="nav-item"><a class="nav-link" href="#">登录</a></li>
            <li class="nav-item"><a class="nav-link" href="#">注册</a></li>
          </ul>
        </div>
      </div>
    </nav>
    ```
  - 3.底部导航 resources/views/layouts/_footer.blade.php
    ```
    <footer class="footer">
      <div class="container">
        <p class="float-left">
          由 <a href="http://weibo.com/u/1837553744?is_hot=1" target="_blank">Summer</a> 设计和编码 <span style="color: #e27575;font-size: 14px;">❤</span>
        </p>

        <p class="float-right"><a href="mailto:name@email.com">联系我们</a></p>
      </div>
    </footer>
    ```
  - 4.消息提醒
    ```
    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
      @if(session()->has($msg))
        <div class="flash-message">
          <p class="alert alert-{{ $msg }}">
            {{ session()->get($msg) }}
          </p>
        </div>
      @endif
    @endforeach
    ```
  - 5.控制器
    ```
    php artisan make:controller PagesController
    ```
    ```
    // 展示首页
    public function root()
    {
        return view('pages.root');
    }
    ```
  - 6.首页视图 resources/views/pages/root.blade.php
    ```
    @extends('layouts.app')
    @section('title', '首页')

    @section('content')
      <h1>这里是首页</h1>
    @stop
    ```
    ```
    rm resources/views/welcome.blade.php
    ```
  - 7.路由 routes/web.php
    ```
    Route::get('/', 'PagesController@root')->name('root');
    ```
  - 8.集成 Bootstrap
    - composer require laravel/ui:^1.0 --dev
    - php artisan ui bootstrap
    - npm config set registry=https://registry.npm.taobao.org
    - yarn config set registry 'https://registry.npm.taobao.org'
    - yarn install --no-bin-links
    - yarn add cross-env@6.0.3 (7.0.2版本需要更高的node版本匹配，所以用下低版本的cross-env)
    - npm run dev
  - 9.优化首页样式
    ```
    // Variables
    @import 'variables';

    // Bootstrap
    @import '~bootstrap/scss/bootstrap';

    /* universal */

    body {
      font-family: Helvetica, "Microsoft YaHei", Arial, sans-serif;
      font-size: 14px;
    }

    /* header */

    .navbar-static-top {
      border-color: #e7e7e7;
      background-color: #fff;
      box-shadow: 0px 1px 11px 2px rgba(42, 42, 42, 0.1);
      border-top: 4px solid #00b5ad;
      border-bottom: 1px solid #e8e8e8;
      margin-bottom: 40px;
      margin-top: 0px;
    }

    /* Sticky footer styles */
    html {
      position: relative;
      min-height: 100%;
    }

    body {
      /* Margin bottom by footer height */
      margin-bottom: 60px;
    }

    .footer {
      position: absolute;
      bottom: 0;
      width: 100%;
      /* Set the fixed height of the footer here */
      height: 60px;
      background-color: #000;

      .container {
        padding-right: 15px;
        padding-left: 15px;

        p {
          margin: 19px 0;
          color: #c1c1c1;

          a {
            color: inherit;
          }
        }
      }
    }
    ```
  - 10.静态文件浏览器缓存问题
    - webpack.mis.js 中加入.version()，然后 layouts/app.blade.php 中引用css和js时用mix()函数
    - 然后执行编译 npm run dev
### 2.8 安装 fontawesome 字体
  - 1.安装
    ```
    yarn add @fortawesome/fontawesome-free
    ```
  - 2.载入 resources/sass/app.scss
    ```
    // Variables
    @import 'variables';

    // Bootstrap
    @import '~bootstrap/scss/bootstrap';

    // Fontawesome
    @import '~@fortawesome/fontawesome-free/scss/fontawesome';
    @import '~@fortawesome/fontawesome-free/scss/regular';
    @import '~@fortawesome/fontawesome-free/scss/solid';
    @import '~@fortawesome/fontawesome-free/scss/brands';
    ```
## 3 注册登录
### 3.1 用户认证脚手架
  - 1.用户认证脚手架
    ```
    php artisan ui:auth
    ```
    - 命令 ui:auth 会询问我们是否要覆盖 app.blade.php，因为我们在前面章节中已经自定义了『主要布局文件』—— app.blade.php，所以此处输入 no
    - 该命令修改了路由 routes/web.php 
      ```
      // 通过用户认证脚手架(php artisan ui:auth) 会生成 Auth::routes();
      Auth::routes();

      // Auth::routes();是Laravel的认证路由，可以在 vendor/laravel/framework/src/Illuminate/Routing/Router.php 中搜 LoginController 即可找到定义的地方，以上等同于：
      // 用户身份验证相关的路由
      // Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
      // Route::post('login', 'Auth\LoginController@login');
      // Route::post('logout', 'Auth\LoginController@logout')->name('logout');

      // 用户注册相关路由
      // Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
      // Route::post('register', 'Auth\RegisterController@register');

      // 密码重置相关路由
      // Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
      // Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
      // Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
      // Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

      // Email 认证相关路由
      // Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
      // Route::get('email/verify/{id}/{hash}', 'Auth\VerificationController@verify')->name('verification.verify');
      // Route::post('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');
      ```
    - 生成的视图
      | 视图名称                  | 说明                   |
      | ------------------------- | ---------------------- |
      | register.blade.php        | 注册页面视图           |
      | login.blade.php           | 登录页面视图           |
      | verify.blade.php          | 邮箱认证视图           |
      | passwords/email.blade.php | 提交邮箱发送邮件的视图 |
      | passwords/reset.blade.php | 重置密码的页面视图     |
    - 移除无用页面
      ```
      rm app/Http/Controllers/HomeController.php
      rm resources/views/home.blade.php
      ```
  - 2.顶部导航加上链接 resources/views/layouts/_header.blade.php
    ```
    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">登录</a></li>
    <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">注册</a></li>
    ```
  - 3.本地化（添加语言包）
    - 安装语言包
      ```
      composer require "overtrue/laravel-lang:~3.0"
      ```
    - 在 config/app.php 中将：
      ```
      Overtrue\LaravelLang\TranslationServiceProvider::class,
      ```
      替换为：
      ```
      Overtrue\LaravelLang\TranslationServiceProvider::class,
      ```
    - 在 config/app.php 中，将项目语言设置为中文
      ```
      'locale' => 'zh-CN',
      ```
    - 如果你想修改扩展包提供的语言文件，可以使用以下命令发布语言文件到项目里：
      ```
      php artisan lang:publish zh-CN
      ```
      发布后的语言文件存放于 resources/lang/zh-CN 文件夹。
### 3.2 用户注册
  - 执行迁移
    ```
    php artisan migrate
    ```
  - 默认跳转路由修改 app/Providers/RouteServiceProvider.php
    ```
    // public const HOME = '/home';
    public const HOME = '/'; // 改成这样的
    ```
  - 导航栏加上登录状态
    ```
    <ul class="navbar-nav navbar-right">
      <!-- Authentication Links -->
      @guest
      <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">登录</a></li>
      <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">注册</a></li>
      @else
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <img src="https://cdn.learnku.com/uploads/images/201709/20/1/PtDKbASVcz.png?imageView2/1/w/60/h/60" class="img-responsive img-circle" width="30px" height="30px">
          {{ Auth::user()->name }}
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a href="#" class="dropdown-item">个人中心</a>
          <a href="#" class="dropdown-item">编辑资料</a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item" id="logout">
            <form action="{{ route('logout') }}" method="post">
              @csrf
              <button class="btn btn-block btn-danger" type="submit" name="button">退出</button>
            </form>
          </a>
        </div>
        
      </li>
      @endguest
    </ul>
    ```
### 注册验证码
  - 1.安装验证码 [captcha](https://github.com/mewebstudio/captcha)
    ```
    composer require "mews/captcha:~3.0"
    ```
  - 2.发布「验证码」配置文件，以便自定义设置「验证码」配置
    ```
    php artisan vendor:publish --provider='Mews\Captcha\CaptchaServiceProvider'
    ```
  - 3.前端展示「验证码」 resources/views/auth/register.blade.php
    ```
    <div class="form-group row">
        <label for="captcha" class="col-md-4 col-form-label text-md-right">验证码</label>

        <div class="col-md-6">
            <input type="text" id="captcha" class="form-control @error('captcha') is-invalid @enderror" name="captcha" required>
            <img src="{{ captcha_src('flat') }}"  class="thumbnail captcha mt-3 mb-2" onclick="this.src='/captcha/flat?' + Math.random()" title="点击重新获取验证码">

            @error('captcha')
                <span class="invalid-feedback" role="alert">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    ```
    验证码样式
    ```
    /* User register page */
    .register-page {
      img.captcha {
        cursor: pointer;
        border: 1px solid #ced4da;
        border-radius: 4px;
        padding: 3px;
      }
    }
    ```
  - 4.后端验证 app/Http/Controllers/Auth/RegisterController.php
      ```
      protected function validator(array $data)
      {
          return Validator::make($data, [
              'name' => ['required', 'string', 'max:255'],
              'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
              'password' => ['required', 'string', 'min:6', 'confirmed'],
              'captcha' => ['required', 'captcha'],
          ], [
              'captcha.required' => '验证码不能为空',
              'captcha.captcha' => '请输入正确的验证码',
          ]);
      }
      ```