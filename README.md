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
### 3.3 注册验证码
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
### 3.5 邮箱认证
  - 1.修改模型位置 app/Models
    ```
    mkdir app/Models
    mv app/User.php app/Models/User.php
    ```
    修改 app/Models/User.php 的命名空间
    ```
    namespace App\Models;
    ```
    - 编辑器全局搜索 App\User 替换为 App\Models\User (共有3个文件4处替换)
    - 提交 `git add .` `git commit -m '移动 User 模型到 app/models 目录'`  `git push`
  - 2.修改模型 (实现契约 使用Trait) app/Models/User.php
    ```
    <?php

    namespace App\Models;

    use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
    use Illuminate\Foundation\Auth\User as Authenticatable;
    use Illuminate\Notifications\Notifiable;
    use Illuminate\Auth\MustVerifyEmail as MustVerifyEmailTrait;

    class User extends Authenticatable implements MustVerifyEmailContract
    {
        use Notifiable, MustVerifyEmailTrait;

        protected $fillable = [
            'name', 'email', 'password',
        ];

        protected $hidden = [
            'password', 'remember_token',
        ];

        protected $casts = [
            'email_verified_at' => 'datetime',
        ];
    }
    ```
    - 使用Trait `use Notifiable, MustVerifyEmailTrait;`
      - 加载使用 MustVerifyEmail trait，打开 vendor/laravel/framework/src/Illuminate/Auth/MustVerifyEmail.php 文件，可以看到以下四个方法：
        - hasVerifiedEmail() 检测用户 Email 是否已认证；
        - markEmailAsVerified() 将用户标示为已认证；
        - sendEmailVerificationNotification() 发送 Email 认证的消息通知，触发邮件的发送；
        - getEmailForVerification() 获取发送邮件地址，提供这个接口允许你自定义邮箱字段。
    - 实现契约 `class User extends Authenticatable implements MustVerifyEmailContract`
      - 可以打开 vendor/laravel/framework/src/Illuminate/Contracts/Auth/MustVerifyEmail.php ，可以看到此文件为 PHP 的接口类，继承此类将确保 User 遵守契约，拥有上面提到的四个方法。
  - 3.发送认证邮件(源码阅读)
      - 认证是通过 `app/Http/Controllers/Auth/RegisterController` 实现的，其使用了 `Illuminate\Foundation\Auth\RegistersUsers` trait，查看此 trait 中的 `register()` 方法
        ```
        public function register(Request $request)
        {
            // 检验用户提交的数据是否有误
            $this->validator($request->all())->validate();

            // 创建用户同时触发用户注册成功的事件，并将用户传参
            event(new Registered($user = $this->create($request->all())));

            // 登录用户
            $this->guard()->login($user);

            // 调用钩子方法 `registered()` 
            return $this->registered($request, $user)
                            ?: redirect($this->redirectPath());
        }
        ```
        - 此方法处理了用户提交表单后的逻辑，我们把重点放在 event(new Registered($user = $this->create($request->all())));，这里使用了 Laravel 的事件系统，触发了 Registered 事件。
        - 打开 `app/Providers/EventServiceProvider.php`文件，此文件的 $listen 属性里我们可以看到注册了 Registered 事件的监听器：
          ```
          protected $listen = [
              Registered::class => [
                  SendEmailVerificationNotification::class,
              ],
          ];
          ```
          - 打开 `SendEmailVerificationNotification` 类，阅读其源码：vendor/laravel/framework/src/Illuminate/Auth/Listeners/SendEmailVerificationNotification.php
            ```
            <?php

            namespace Illuminate\Auth\Listeners;

            use Illuminate\Auth\Events\Registered;
            use Illuminate\Contracts\Auth\MustVerifyEmail;

            class SendEmailVerificationNotification
            {
                public function handle(Registered $event)
                {
                    // 如果 user 是继承于 MustVerifyEmail 并且还未激活的话
                    if ($event->user instanceof MustVerifyEmail && ! $event->user->hasVerifiedEmail()) {
                        // 发送邮件认证消息通知（认证邮件）
                        $event->user->sendEmailVerificationNotification();
                    }
                }
            }
            ```
  - 4.设置邮箱驱动 开始测试 .env
    ```
    MAIL_DRIVER=log
    ```
  - 5.强制邮箱认证（中间件）
    - 1.新建一个中间件
      ```
      php artisan make:middleware EnsureEmailIsVerified
      ``` 
      ```
      <?php

      namespace App\Http\Middleware;

      use Closure;

      class EnsureEmailIsVerified
      {
          public function handle($request, Closure $next)
          {
              // 三个判断：
              // 1. 如果用户已经登录
              // 2. 并且还未认证 Email
              // 3. 并且访问的不是 email 验证相关 URL 或者退出的 URL。
              if ($request->user() &&
                  ! $request->user()->hasVerifiedEmail() &&
                  ! $request->is('email/*', 'logout')) {

                  // 根据客户端要求返回对应的内容，如果客户端是ajax要求返回json，则abort()返回json数据，否则跳转「邮件认证提醒页面」
                  return $request->expectsJson()
                              ? abort(403, 'Your email address is not verified.')
                              : redirect()->route('verification.notice');
              }

              return $next($request);
          }
      }
      ```
      - 中间件作用：所有web请求，如果用户未认证（3个判断），则提示用户认证，或者跳转「邮件认证提醒页面」；否则放行
    - 2.注册中间，注册的时机确保在 StartSession 后面即可。app/Http/Kernel.php
      ```
      protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \App\Http\Middleware\EnsureEmailIsVerified::class,      // <<--- 只需添加这一行
        ],
        ...
      ]
      ```
### 3.6 认证后的提示
  - 1.认证路由入口
    ```
    Route::get('email/verify/{id}/{hash}', 'Auth\VerificationController@verify')->name('verification.verify')
    ```
  - 2.认证控制器**触发「Verified事件」** app/Http/Controllers/Auth/VerificationController.php
    ```
    use Illuminate\Foundation\Auth\VerifiesEmails;

    use VerifiesEmails;
    public function __construct()
    {
        $this->middleware('auth'); // 所有认证动作必须登录
        $this->middleware('signed')->only('verify'); // 对认证动作的URL进行「URL签名」
        $this->middleware('throttle:6,1')->only('verify', 'resend'); // 每分钟限制6次请求
    }
    ```
    - VerifiesEmails Trait `vendor/laravel/framework/src/Illuminate/Foundation/Auth/VerifiesEmails.php`
      ```
      /**
      * 显示认证邮件提醒页面
      */
      public function show(Request $request)
      {
          return $request->user()->hasVerifiedEmail()
                          ? redirect($this->redirectPath())
                          : view('auth.verify');
      }

      /**
      * 处理认证成功后的业务逻辑，请注意签名认证发生在 `signed` 中间件里，
      * 在 VerificationController 的 __construct 方法里做了设定
      */
      public function verify(Request $request)
      {
          if (! hash_equals((string) $request->route('id'), (string) $request->user()->getKey())) {
              throw new AuthorizationException;
          }

          if (! hash_equals((string) $request->route('hash'), sha1($request->user()->getEmailForVerification()))) {
              throw new AuthorizationException;
          }

          if ($request->user()->hasVerifiedEmail()) {
              return redirect($this->redirectPath());
          }

          if ($request->user()->markEmailAsVerified()) {
              event(new Verified($request->user())); // 如果成功设置为已认证的话，触发「Verified事件」并将用户传参
          }

          return redirect($this->redirectPath())->with('verified', true);
      }

      /**
      * 重新发送用户认证邮件
      */
      public function resend(Request $request)
      {
          if ($request->user()->hasVerifiedEmail()) {
              return redirect($this->redirectPath());
          }

          $request->user()->sendEmailVerificationNotification();

          return back()->with('resent', true);
      }
      ```
  - 3.用`监听器` **监听「Verified事件」**
    - 注册`Verified事件`的`监听器` app/Providers/EventServiceProvider.php
      ```
      protected $listen = [
        ...
          \Illuminate\Auth\Events\Verified::class => [
              \App\Listeners\EmailVerified::class,
          ],
      ];
      ```
    - 生成`EmailVerified监听器`
      ```
      php artisan event:generate
      ```
    - 编写`EmailVerified监听器` app/Listeners/EmailVerified.php
      ```
      public function handle(Verified $event)
      {
          // 会话里闪存认证成功后的消息提醒
          session()->flash('success', '邮箱验证成功 ^_^');
      }
      ```    
### 3.7 重置密码
  - 1.重置密码路由(已有)
    ```
    Auth::routes(['verify' => true]);
    // 密码重置相关路由
    // Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    // Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    // Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
    // Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');
    ```
  - 2.查看 `ResetsPasswords` Trait 源码 vendor/laravel/framework/src/Illuminate/Foundation/Auth/ResetsPasswords.php
    ```
    trait ResetsPasswords
    {
        .
        .
        .
        // 处理 重设密码的逻辑
        public function reset(Request $request)
        {
            // 验证用户提交的表单内容
            $request->validate($this->rules(), $this->validationErrorMessages());

            // 尝试重置用户的密码，成功的话会更新数据库里的密码，否则会
            // 解析并将错误返回。
            $response = $this->broker()->reset(
                $this->credentials($request), function ($user, $password) {
                    $this->resetPassword($user, $password);
                }
            );

            // 如果重置成功，我们会调用 sendResetResponse 方法重定向到程序主页上，
            // 失败的话调用 sendResetFailedResponse 返回并附带错误信息
            return $response == Password::PASSWORD_RESET
                        ? $this->sendResetResponse($request, $response)
                        : $this->sendResetFailedResponse($request, $response);
        }
        .
        .
        .
        protected function sendResetResponse(Request $request, $response)
        {
            return redirect($this->redirectPath())
                                ->with('status', trans($response));
        }
        .
        .
        .
    }
    ```
  - 3.控制器中重写 `sendResetResponse()` 方法 app/Http/Controllers/Auth/ResetPasswordController.php
    ```
    protected function sendResetResponse(Request $request, $response)
    {
        session()->flash('success', '密码更新成功，您已成功登录！');
        return redirect($this->redirectPath());
    }
    ```
## 4 用户相关
### 4.1 个人页面
  - 路由 routes/web.php
    ```
    Route::resource('users', 'UsersController', ['only' => ['show', 'edit', 'update']]);
    ```
  - 控制器
    ```
    php artisan make:controller UsersController
    ```
    ```
    Use App\Models\User;
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }
    ```
  - 视图 resources/views/users/show.blade.php
    ```
    @extends('layouts.app')

    @section('title', $user->name . ' 的个人中心')

    @section('content')

    <div class="row">

      <div class="col-lg-3 col-md-3 hidden-sm hidden-xs user-info">
        <div class="card ">
          <img class="card-img-top" src="https://cdn.learnku.com/uploads/images/201709/20/1/PtDKbASVcz.png?imageView2/1/w/600/h/600" alt="{{ $user->name }}">
          <div class="card-body">
                <h5><strong>个人简介</strong></h5>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. </p>
                <hr>
                <h5><strong>注册于</strong></h5>
                <p>January 01 1901</p>
          </div>
        </div>
      </div>
      <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
        <div class="card ">
          <div class="card-body">
              <h1 class="mb-0" style="font-size:22px;">{{ $user->name }} <small>{{ $user->email }}</small></h1>
          </div>
        </div>
        <hr>

        {{-- 用户发布的内容 --}}
        <div class="card ">
          <div class="card-body">
            暂无数据 ~_~
          </div>
        </div>

      </div>
    </div>
    @stop
    ```
### 4.2 编辑个人资料 (FormRequest)
  - 1.新增字段 `avatar` `introduction`
    ```
    php artisan make:migration add_avatar_and_introduction_to_users_table --table=users
    ```
    ```
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('avatar')->nullable();
            $table->string('introduction')->nullable();
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('avatar');
            $table->dropColumn('introduction');
        });
    }
    ```
    ```
    php artisan migrate
    ```
  - 2.新增入口 resources/views/layouts/_header.blade.php
    ```
    <a class="dropdown-item" href="{{ route('users.show', Auth::id()) }}">个人中心</a>
    <a class="dropdown-item" href="{{ route('users.edit', Auth::id()) }}">编辑资料</a>
    ```
  - 3.控制器方法(表单验证FormRequest) app/Http/Controllers/UsersController.php
    ```
    use App\Http\Requests\UserRequest;
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }
    public function update(UserRequest $request, User $user)
    {
        $user->update($request->all());
        return redirect()->route('users.show', $user->id)->with('success', '个人资料更新成功！');
    }
    ```
    - [表单验证(FormRequest)](https://learnku.com/docs/laravel/6.x/validation/5144#16877a)
      - 顶部引入了 `use App\Http\Requests\UserRequest;`, UserRequest 就是User模型的表单验证
      - 表单请求验证（FormRequest） 是 Laravel 框架提供的用户表单数据验证方案，此方案相比手工调用 validator 来说，能处理更为复杂的验证逻辑，更加适用于大型程序。
    - 创建 `UserRequest` 表单验证
      ```
      php artisan make:request UserRequest
      ```
    - 编写 `UserRequest` 表单验证 app/Http/Requests/UserRequest.php
      ```
      class UserRequest extends FormRequest
      {
          // authorize() 方法是表单验证自带的另一个功能 —— 权限验证
          public function authorize()
          {
              return true; // 此处我们 return true; ，意味所有权限都通过即可
          }

          /**
          * Get the validation rules that apply to the request.
          *
          * @return array
          */
          public function rules()
          {
              return [
                  'name' => 'required|between:3,25|regex:/^[A-Za-z0-9]+$/|unique:users,name,' . Auth::id() . 'id',
                  'email' => 'required|email',
                  'introducton' => 'max:80',
              ];
          }

          // 自定义错误消息
          public function messages()
          {
              return [
                  'name.unique' => '用户名已被占用，请重新填写',
                  'name.regex' => '用户名只支持英文、数字、横杠和下划线。',
                  'name.between' => '用户名必须介于 3 - 25 个字符之间。',
                  'name.required' => '用户名不能为空。',
              ];
          }

          // 自定义验证属性
          // public function attributes()
          // {
          //     return [
          //         'name' => '用户名',
          //     ];
          // }
      }
      ```
  - 4.编辑视图(错误消息) resources/views/users/edit.blade.php
    ```
    @extends('layouts.app')

    @section('content')
    <div class="container">
      <div class="col-md-8 offset-md-2">

        <div class="card">
          <div class="card-header">
            <h4>
              <i class="glyphicon glyphicon-edit"></i> 编辑个人资料
            </h4>
          </div>

          <div class="card-body">
            <form action="{{ route('users.update', $user->id) }}" method="post" accept-charset="UTF-8">
              <input type="hidden" name="_method" value="PUT">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">

              @include('shared._errors')

              <div class="form-group">
                <label for="name-field">用户名</label>
                <input type="text" id="name-field" name="name" class="form-control" value="{{ old('name', $user->name) }}">
              </div>

              <div class="form-group">
                <label for="email-field">邮 箱</label>
                <input type="text" id="email-field" name="email" class="form-control" value="{{ old('email', $user->email) }}">
              </div>

              <div class="form-group">
                <label for="introduction-field">个人简介</label>
                <textarea name="introduction" id="introduction-field" rows="3" class="form-control">{{ old('introduction', $user->introduction) }}</textarea>
              </div>

              <div class="well well-sm">
                <button type="submit" class="btn btn-primary">保存</button>
              </div>
            </form>
          </div>
        </div>

      </div>
    </div>
    @stop
    ```
    - **错误消息** 的局部视图 resources/views/shared/_errors.blade.php
      ```
      @if ($errors->count() > 0)
      <div class="alert alert-danger">
        <div class="mt-2"><b>有错误发生：</b></div>
        <ul class="mt-2 mb-2">
          @foreach ($errors->all() as $error)
            <li><i class="glyphicon glyphicon-remove"></i> {{ $error }}</li>
          @endforeach
        </ul>
      </div>
      @endif
      ```
### 4.3 显示个人资料
  - 1.修改视图 resources/views/users/show.blade.php
    ```
    <div class="card-body">
      <h5><strong>个人简介</strong></h5>
      <p>{{ $user->introduction }}</p>
      <hr>
      <h5><strong>注册于</strong></h5>
      <p>{{ $user->created_at->diffForHumans() }}</p>
    </div>
    ```
  - 2.修改模型 $fillable    
    ```
    protected $fillable = [
        'name', 'email', 'password', 'introduction', 
    ];
    ```
    - $fillable 属性的作用是防止用户随意修改模型数据，只有在此属性里定义的字段，才允许修改，否则更新时会被忽略。
  - 3.[Carbon](https://github.com/briannesbitt/Carbon) 是 PHP 知名的日期和时间操作扩展，Laravel 框架中使用此扩展来处理时间、日期相关的操作。diffForHumans 是 Carbon 对象提供的方法，提供了可读性越佳的日期展示形式。
### 4.4 上传图像
  - 1.修改模型(添加avatar为修改) app/Models/User.php
    ```
    protected $fillable = [
        'name', 'email', 'password', 'introduction', 'avatar'
    ];
    ```
  - 2.上传表单([通过Request获取上传文件](https://learnku.com/docs/laravel/6.x/requests/5139#retrieving-uploaded-files)) resources/views/users/edit.blade.php
    ```
    <div class="form-group">
      <label for="introduction-field">个人简介</label>
      <textarea name="introduction" id="introduction-field" class="form-control" rows="3">{{ old('introduction', $user->introduction) }}</textarea>
    </div>

    <div class="form-group mb-4">
      <label for="" class="avatar-label">用户头像</label>
      <input type="file" name="avatar" class="form-control-file">

      @if($user->avatar)
        <br>
        <img class="thumbnail img-responsive" src="{{ $user->avatar }}" width="200" />
      @endif
    </div>
    ```
    - 在 Laravel 中，我们可直接通过 [请求对象（Request）](https://learnku.com/docs/laravel/6.x/requests/5139#retrieving-uploaded-files) 来获取用户上传的文件，如以下两种方法
      ```
      // 第一种方法
      $file = $request->file('avatar');

      // 第二种方法，可读性更高
      $file = $request->avatar;
      ```
  - 3.上传表单添加`enctype="multipart/form-data"`声明 resources/views/users/edit.blade.php
    ```
    <form action="{{ route('users.update', $user->id) }}" method="POST" 
          accept-charset="UTF-8" 
          enctype="multipart/form-data">
    ```
    - 请记住，在图片或者文件上传时，为表单添加此句声明是必须的
  - 4.新建上传图像「工具类」ImageUploadHandler：app/Handlers/ImageUploadHandler.php
    ```
    <?php

    namespace App\Handlers;

    use  Illuminate\Support\Str;

    class ImageUploadHandler
    {
        // 只允许以下后缀名的图片文件上传
        protected $allowed_ext = ["png", "jpg", "gif", 'jpeg'];

        public function save($file, $folder, $file_prefix)
        {
            // 构建存储的文件夹规则，值如：uploads/images/avatars/201709/21/
            // 文件夹切割能让查找效率更高。
            $folder_name = "uploads/images/$folder/" . date("Ym/d", time());

            // 文件具体存储的物理路径，`public_path()` 获取的是 `public` 文件夹的物理路径。
            // 值如：/home/vagrant/Code/larabbs/public/uploads/images/avatars/201709/21/
            $upload_path = public_path() . '/' . $folder_name;

            // 获取文件的后缀名，因图片从剪贴板里黏贴时后缀名为空，所以此处确保后缀一直存在
            $extension = strtolower($file->getClientOriginalExtension()) ?: 'png';

            // 拼接文件名，加前缀是为了增加辨析度，前缀可以是相关数据模型的 ID 
            // 值如：1_1493521050_7BVc9v9ujP.png
            $filename = $file_prefix . '_' . time() . '_' . Str::random(10) . '.' . $extension;

            // 如果上传的不是图片将终止操作
            if ( ! in_array($extension, $this->allowed_ext)) {
                return false;
            }

            // 将图片移动到我们的目标存储路径中
            $file->move($upload_path, $filename);

            return [
                'path' => config('app.url') . "/$folder_name/$filename"
            ];
        }
    }
    ```
    - 我们将使用 app/Handlers 文件夹来存放本项目的工具类，『工具类（utility class）』是指一些跟业务逻辑相关性不强的类，Handlers 意为 **处理器** ，ImageUploadHandler 意为图片上传处理器，简单易懂。
    - Laravel 的『用户上传文件对象』底层使用了 Symfony 框架的 [UploadedFile](https://github.com/symfony/symfony/blob/3.0/src/Symfony/Component/HttpFoundation/File/UploadedFile.php) 对象进行渲染，为我们提供了便捷的文件读取和管理接口
  - 5.控制器中调用「图片上传工具类」UsersController： app/Http/Controllers/UsersController.php
    ```
    use App\Handlers\ImageUploadHandler;

    class UsersController extends Controller
    {
        ...

        public function update(UserRequest $request, ImageUploadHandler $uploader, User $user)
        {
            $data = $request->all();

            // 如果上传了图像
            if ($request->avatar) {
                $result = $uploader->save($request->avatar, 'avatars', $user->id);
                if ($result) {
                    $data['avatar'] = $result['path'];
                }
            }

            $user->update($data);
            return redirect()->route('users.show', $user->id)->with('success', '个人资料更新成功！');
        }
    }
    ```
  - 6.Git 版本控制(让某个文件夹不纳入git的版本)
    - 添加文件 public/uploads/images/avatars/.gitignore
      ```
      *
      !.gitignore
      ```
      - 上面的两行代码意为：当前文件夹下，忽略所有文件，除了 .gitignore。
  - 7.显示头像
    - 个人页面左侧头像：resources/views/users/show.blade.php
      ```
      <div class="card ">
        <img class="card-img-top" src="{{ $user->avatar }}" alt="{{ $user->name }}">
        <div class="card-body">
      ```
    - 导航栏图像：resources/views/layouts/_header.blade.php
      ```
      <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <img src="{{ Auth::user()->avatar }}" class="img-responsive img-circle" width="30px" height="30px">
        {{ Auth::user()->name }}
      </a>
      ```
### 4.6 图片验证（用 FormRequest表单验证 来限制头像类型和分辨率)
  - app/Http/Requests/UserRequest.php
    ```
     public function rules()
    {
        return [
            'name' => 'required|between:3,25|regex:/^[A-Za-z0-9]+$/|unique:users,name,' . Auth::id() . 'id',
            'email' => 'required|email',
            'introducton' => 'max:80',
            'avatar' => 'mimes:jpeg,bmp,png,gif|dimensions:min_width=208,min_height=208',
        ];
    }

    // 自定义错误消息
    public function messages()
    {
        return [
            'avatar.mimes' =>'头像必须是 jpeg, bmp, png, gif 格式的图片',
            'avatar.dimensions' => '图片的清晰度不够，宽和高需要 208px 以上',
            'name.unique' => '用户名已被占用，请重新填写',
            'name.regex' => '用户名只支持英文、数字、横杠和下划线。',
            'name.between' => '用户名必须介于 3 - 25 个字符之间。',
            'name.required' => '用户名不能为空。',
        ];
    }

    // 自定义验证属性
    // public function attributes()
    // {
    //     return [
    //         'name' => '用户名',
    //     ];
    // }
    ```
### 4.7 裁剪头像
  - 0.视网膜屏幕
    - 而我们个人空间里显示区域最大也就 208px，即使要兼容 视网膜屏幕（Retina Screen） 的话，最多也就需要 208px * 2 = 416px 
  - 1.图像裁剪扩展包([intervention/image](https://github.com/Intervention/image))
    - 1.安装扩展包(intervention/image)
      ```
      composer require intervention/image
      ```
    - 2.发布配置信息
      ```
      php artisan vendor:publish --provider="Intervention\Image\ImageServiceProviderLaravelRecent"
      ```
      - 打开 config/image.php 文件可以看到只有一个驱动器的选项，支持的值有 GD 库 和 ImageMagic
        - 注：此处我们使用默认的 gd 即可，如果将要开发的项目需要较专业的图片，请考虑 ImageMagic。
  - 2.编写裁剪规则 app/Handlers/ImageUploadHandler.php
    ```
    <?php

    namespace App\Handlers;

    use Image;
    use Str;

    class ImageUploadHandler
    {
        protected $allowed_ext = ["png", "jpg", "gif", 'jpeg'];

        public function save($file, $folder, $file_prefix, $max_width = false)
        {
            // 构建存储的文件夹规则，值如：uploads/images/avatars/201709/21/
            // 文件夹切割能让查找效率更高。
            $folder_name = "uploads/images/$folder/" . date("Ym/d", time());

            // 文件具体存储的物理路径，`public_path()` 获取的是 `public` 文件夹的物理路径。
            // 值如：/home/vagrant/Code/larabbs/public/uploads/images/avatars/201709/21/
            $upload_path = public_path() . '/' . $folder_name;

            // 获取文件的后缀名，因图片从剪贴板里黏贴时后缀名为空，所以此处确保后缀一直存在
            $extension = strtolower($file->getClientOriginalExtension()) ?: 'png';

            // 拼接文件名，加前缀是为了增加辨析度，前缀可以是相关数据模型的 ID
            // 值如：1_1493521050_7BVc9v9ujP.png
            $filename = $file_prefix . '_' . time() . '_' . Str::random(10) . '.' . $extension;

            // 如果上传的不是图片将终止操作
            if ( ! in_array($extension, $this->allowed_ext)) {
                return false;
            }

            // 将图片移动到我们的目标存储路径中
            $file->move($upload_path, $filename);

            // 如果限制了图片宽度，就进行裁剪
            if ($max_width && $extension != 'gif') {

                // 此类中封装的函数，用于裁剪图片
                $this->reduceSize($upload_path . '/' . $filename, $max_width);
            }

            return [
                'path' => config('app.url') . "/$folder_name/$filename"
            ];
        }

        public function reduceSize($file_path, $max_width)
        {
            // 先实例化，传参是文件的磁盘物理路径
            $image = Image::make($file_path);

            // 进行大小调整的操作
            $image->resize($max_width, null, function ($constraint) {

                // 设定宽度是 $max_width，高度等比例缩放
                $constraint->aspectRatio();

                // 防止裁图时图片尺寸变大
                $constraint->upsize();
            });

            // 对图片修改后进行保存
            $image->save();
        }
    }
    ```
  - 3.修改 UsersController 中的 ImageUploadHandler 调用 
    ```
    // 如果上传了图像
    if ($request->avatar) {
        $result = $uploader->save($request->avatar, 'avatars', $user->id, 416);
        if ($result) {
            $data['avatar'] = $result['path'];
        }
    }
    ```
### 4.8 授权访问
  - 1.必须登录（auth中间件） app/Http/Controllers/UsersController.php
    ```
    public function __construct()
    {
        // except 黑名单排除不需要登录的，其余都需要登录
        $this->middleware('auth', ['except' => ['show']]);
    }
    ```
  - 2.只有自己能编辑自己（授权策略）
    - 新建「授权策略」文件
      ```
      php artisan make:policy UserPolicy
      ```
    - 编写「授权策略」 app/Policies/UserPolicy.php
      ```
      class UserPolicy
      {
          use HandlesAuthorization;

          // update 方法接收两个参数，第一个参数默认为当前登录用户实例，第二个参数则为要进行授权的用户实例
          // 使用授权策略时，我们 不需要 传递当前登录用户至该方法内，因为框架会自动加载当前登录用户，即不用传递 $currentUser
          public function update(User $currentUser, User $user)
          {
              // 只有自己能编辑自己
              return $currentUser->id === $user->id;
          }
      }
      ```
    - 在控制器中调用「授权策略」 app/Http/Controllers/UsersController.php
      ```
      public function edit(User $user)
      {
          $this->authorize('update', $user);
          return view('users.edit', compact('user'));
      }
      public function update(UserRequest $request, ImageUploadHandler $uploader, User $user)
      {
          $this->authorize('update', $user);
          ...
      }
      ```
## 5 帖子列表
### 5.1 帖子分类
  - 1.创建分类「模型」和「迁移文件」
    ```
    php artisan make:model Models/Category -m
    ```
    - `-m` 选项意为顺便创建数据库迁移文件（Migration
  - 2.编写「分类迁移文件」 {timestamp}_create_categories_table.php
    ```
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->index()->comment('名称');
            $table->text('description')->nullable()->comment('描述');
            $table->integer('post_count')->default(0)->comment('帖子数');
        });
    }

    public function down()
    {
        Schema::dropIfExists('categories');
    }
    ```
    - name —— 分类的名称，为字符串类型，index() 方法是加上索引，为 MySQL 下的搜索优化，comment() 方法能为表结构注释；
    - 注意这里因业务逻辑使然，我们不需要为分类添加时间戳 $table->timestamps();
  - 3.执行迁移 生成分类表
    ```
    php artisan migrate
    ```
  - 4.修改分类模型 app/Models/Category.php
    ```
    class Category extends Model
    {
        // 因为我们数据库表结构里未生成时间戳，这里需要使用 public $timestamps = false; 
        // 进行设置，告知 Laravel 此模型在创建和更新时不需维护 created_at 和 updated_at 这两个字段。
        public $timestamps = false;

        protected $fillable = [
            'name', 'description',
        ];
    }
    ```
  - 5.用迁移文件初始化分类数据
    - 用迁移文件初始化分类数据的原因
      - 我们想要 LaraBBS 论坛软件在安装的时，就初始化本文最前面提到的四个分类。
      - 面对数据库内容填充的需求，一般情况下我们会使用 Laravel 的 『数据填充 Seed』 。可是在当下场景中，我们无法使用此功能。此一般是用来生成假数据，而现在我们需要生成的是项目的 初始化数据，这些数据是项目运行的一部分，在生产环境下也会使用到，而数据填充只能在开发时使用。
      - 虽然 Laravel 没有自带此类解决方案，不过数据迁移功能倒是比较不错的替代方案。在功能定位上，数据迁移也是项目的一部分，执行的时机刚好是在项目安装时。并且区分执行先后顺序，这确保了初始化数据发生在数据表结构创建完成后。
    - 接下来用「迁移文件来」 **初始化数据**，我们定义命名规范为 seed_(数据库表名称)_data ：
      ```
      php artisan make:migration seed_categories_data
      ```
    - 编写该「迁移文件」：
      ```
      class SeedCategoriesData extends Migration
      {
          public function up()
          {
              $categories = [
                  [
                      'name'        => '分享',
                      'description' => '分享创造，分享发现',
                  ],
                  [
                      'name'        => '教程',
                      'description' => '开发技巧、推荐扩展包等',
                  ],
                  [
                      'name'        => '问答',
                      'description' => '请保持友善，互帮互助',
                  ],
                  [
                      'name'        => '公告',
                      'description' => '站点公告',
                  ],
              ];

              DB::table('categories')->insert($categories);
          }

          public function down()
          {
              DB::table('categories')->truncate();
          }
      }
      ```
    - 执行该 「迁移文件」，初始化分类数据
      ```
      php artisan migrate
      ```
### 5.2 [代码生成器(Laravel 5.x Scaffold Generator)](https://learnku.com/courses/laravel-intermediate-training/6.x/code-generator/5559)
  - 安装
    ```
    composer require "summerblue/generator:6.*" --dev
    ```
  - 版本标记（方便后面测试后，回滚到这里）
    ```
    git add -A
    git commit -m "新增 generator 扩展"
    ```
  - 测试运行(**回滚**)
    ```
    php artisan make:scaffold Projects --schema="name:string:index,description:text:nullable,subscriber_count:integer:unsigned:default(0)"
    ```
    - 运行完了，会发现修改了一些文件配置，生成很多新文件，执行了迁移文件。对这些做**回滚**：
      ```
      php artisan migrate:rollback // 先还还原数据库
      git checkout .      // 还原修改文件到原始状态，只是还原之前就已经存在的文件。（将修改内容从 暂存区 → 工作区）
      git status          // 若前面操作时有新增文件，此时会看到有未跟踪的文件 Untracded files
      git clean -f -d     // clean 作用是清理项目，-f 是强制清理文件的设置，-d 选项命令连文件夹一并清除。
      git status          // 再看时，发现：nothing to commit, working directory clean
      ```
      或者这样**回滚**
      ```
      php artisan migrate:rollback // 先还还原数据库
      git add -A                   // 添加所有 (将新文件 从 工作区 → 暂存区)
      git checkout -f              // 放弃本地修改，强制检出代码（将修改内容，包括新老文件，从 暂存区 → 工作区）
      ```
    



