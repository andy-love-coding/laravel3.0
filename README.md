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
### [5.3 生成话题骨架](https://learnku.com/courses/laravel-intermediate-training/6.x/generate-topic/5560)
  - 用代码生成器 生成话题骨架
    ```
    php artisan make:scaffold Topic --schema="title:string:index,body:text,user_id:bigInteger:unsigned:index,category_id:integer:unsigned:index,reply_count:integer:unsigned:default(0),view_count:integer:unsigned:default(0),last_reply_user_id:integer:unsigned:default(0),order:integer:unsigned:default(0),excerpt:text:nullable,slug:string:nullable"
    ```
    | 字段名称             | 描述                     | 字段类型         | 加索引缘由       | 其他                       |
    | -------------------- | ------------------------ | ---------------- | ---------------- | -------------------------- |
    | `title`              | 帖子标题                 | 字符串（String） | 文章搜索         | 无                         |
    | `body`               | 帖子内容                 | 文本（text）     | 不需要           | 无                         |
    | `user_id`            | 用户 ID                  | 整数（int）      | 数据关联         | `unsigned()`               |
    | `category_id`        | 分类 ID                  | 整数（int）      | 数据关联         | `unsigned()`               |
    | `reply_count`        | 回复数量                 | 整数（int）      | 文章回复数量排序 | `unsigned()`, `default(0)` |
    | `view_count`         | 查看总数                 | 整数（int）      | 文章查看数量排序 | `unsigned()`, `default(0)` |
    | `last_reply_user_id` | 最后回复的用户 ID        | 整数（int）      | 数据关联         | `unsigned()`, `default(0)` |
    | `order`              | 可用来做排序使用         | 整数（int）      | 不需要           | `default(0)`               |
    | `excerpt`            | 文章摘要，SEO 优化时使用 | 文本（text）     | 不需要           | `nullable()`               |
    | `slug`               | SEO 友好的 URI           | 字符串（String） | 不需要           | `nullable()`               |
### 5.4 填充假数据(users、topics)
  - 1.填充用户假数据
    - 用户模型工厂 database/factories/UserFactory.php
      ```
      $factory->define(App\Models\User::class, function (Faker $faker) {
          $date_time = $faker->date . ' ' . $faker->time;
          return [
              'name' => $faker->name,
              'email' => $faker->unique()->safeEmail,
              'remember_token' => Str::random(10),
              'email_verified_at' => now(),
              'password' => bcrypt('12345678'), // password
              'introduction' => $faker->sentence(),
              'created_at' => $date_time,
              'updated_at' => $date_time,
          ];
      });
      ```
    - 用户填充文件 database/seeds/UsersTableSeeder.php
      ```
      php artisan make:seed UsersTableSeeder
      ```
      ```
      public function run()
      {
          // 获取 Faker 实例
          $faker = app(Faker\Generator::class);

          // 头像假数据
          $avatars = [
              'https://cdn.learnku.com/uploads/images/201710/14/1/s5ehp11z6s.png',
              'https://cdn.learnku.com/uploads/images/201710/14/1/Lhd1SHqu86.png',
              'https://cdn.learnku.com/uploads/images/201710/14/1/LOnMrqbHJn.png',
              'https://cdn.learnku.com/uploads/images/201710/14/1/xAuDMxteQy.png',
              'https://cdn.learnku.com/uploads/images/201710/14/1/ZqM7iaP4CR.png',
              'https://cdn.learnku.com/uploads/images/201710/14/1/NDnzMutoxX.png',
          ];

          // 生成数据集合
          $users = factory(User::class)
                          ->times(10)
                          ->make()
                          ->each(function ($user, $index)
                              use ($faker, $avatars)
          {
              // 从头像数组中随机取出一个并赋值
              $user->avatar = $faker->randomElement($avatars);
          });

          // 让隐藏字段可见，并将数据集合转换为数组
          $user_array = $users->makeVisible(['password', 'remember_token'])->toArray();

          // 插入到数据库中
          User::insert($user_array);

          // 单独处理第一个用户的数据
          $user = User::find(1);
          $user->name = 'Summer';
          $user->email = 'summer@example.com';
          $user->avatar = 'https://cdn.learnku.com/uploads/images/201710/14/1/ZqM7iaP4CR.png';
          $user->save();

      }
      ```
    - 注册填充文件 database/seeds/DatabaseSeeder.php
      ```
      public function run()
      {
          $this->call(UsersTableSeeder::class);
          // $this->call(TopicsTableSeeder::class);
      }
      ```
    - 执行填充
      ```
      php artisan migrate:refresh --seed
      ```
  - 2.填充话题假数据
    - 看看话题模型 app/Models/Topic.php
      ```
      class Topic extends Model
      {
          protected $fillable = ['title', 'body', 'user_id', 'category_id', 'reply_count', 'view_count', 'last_reply_user_id', 'order', 'excerpt', 'slug'];
      }
      ```
      「生成器」已自动写入了 $fillable 允许填充的字段数组，不要再做修改
    - 话题模型工厂 database/factories/TopicFactory.php
      ```
      $factory->define(App\Models\Topic::class, function (Faker $faker) {

          $sentence = $faker->sentence();

          // 随机取一个月以内的时间
          $updated_at = $faker->dateTimeThisMonth();

          // 传参为生成最大时间不超过，因为创建时间需永远比更改时间要早
          $created_at = $faker->dateTimeThisMonth($updated_at);

          return [
              'title' => $sentence,
              'body' => $faker->text(),
              'excerpt' => $sentence,
              'created_at' => $created_at,
              'updated_at' => $updated_at,
          ];
      });
      ```
    - 话题填充文件 database/seeds/TopicsTableSeeder.php
      ```
      public function run()
      {
          // 所有用户 ID 数组，如：[1,2,3,4]
          $user_ids = User::all()->pluck('id')->toArray();

          // 所有分类 ID 数组，如：[1,2,3,4]
          $category_ids = Category::all()->pluck('id')->toArray();

          // 获取 Faker 实例
          $faker = app(Faker\Generator::class);

          $topics = factory(Topic::class)
                          ->times(100)
                          ->make()
                          ->each(function ($topic, $index)
                              use ($user_ids, $category_ids, $faker)
          {
              // 从用户 ID 数组中随机取出一个并赋值
              $topic->user_id = $faker->randomElement($user_ids);

              // 话题分类，同上
              $topic->category_id = $faker->randomElement($category_ids);
          });

          // 将数据集合转换为数组，并插入到数据库中
          Topic::insert($topics->toArray());
      }
      ```
    - 注册填充文件 database/seeds/DatabaseSeeder.php
      ```
      public function run()
      {
          $this->call(UsersTableSeeder::class);
          $this->call(TopicsTableSeeder::class);
      }
      ```
      注意：run() 方法里的顺序，我们先生成用户数据，再生出话题数据。
    - 执行填充
      ```
      php artisan migrate:refresh --seed
      ```
### 5.5 话题列表页面
  - 「话题模型』关联「用户模型」和「分类模型」 app/Models/Topic.php
    ```
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    ```
  - 话题列表视图（用appends()使分页链接继承请求参数） resources/views/topics/index.blade.php
    ```
    @extends('layouts.app')

    @section('title', '话题列表')

    @section('content')

    <div class="row mb-5">
      <div class="col-lg-9 col-md-9 topic-list">
        <div class="card ">

          <div class="card-header bg-transparent">
            <ul class="nav nav-pills">
              <li class="nav-item"><a class="nav-link active" href="#">最后回复</a></li>
              <li class="nav-item"><a class="nav-link" href="#">最新发布</a></li>
            </ul>
          </div>

          <div class="card-body">
            {{-- 话题列表 --}}
            @include('topics._topic_list', ['topics' => $topics])
            {{-- 分页 --}}
            <div class="mt-5">
              {!! $topics->appends(Request::except('page'))->render() !!}
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-3 sidebar">
        @include('topics._sidebar')
      </div>
    </div>

    @endsection
    ```
    - [分页 appends()](https://leoyang90.gitbooks.io/laravel-source-analysis/content/Laravel%20Database%E2%80%94%E2%80%94%E5%88%86%E9%A1%B5%E5%8E%9F%E7%90%86%E4%B8%8E%E6%BA%90%E7%A0%81%E5%88%86%E6%9E%90.html) 可以使用 appends 方法附加查询参数到分页链接中，使 URI 中的的请求参数得到继承
      - `$topics->appends(Request::except('page'))->render()` 的意思是：把 URI 中除了page的其余参数，都加到分页链接中去，即 URI 中的参数得到了继承 （排除 page 参数是因为，分页链接中带有 page 参数）
    - 列表子视图 resources/views/topics/_topic_list.blade.php
      ```
      @if (count($topics))
        <ul class="list-unstyled">
          @foreach ($topics as $topic)
            <li class="media">
              <div class="media-left">
                <a href="{{ route('users.show', [$topic->user_id]) }}">
                  <img class="media-object img-thumbnail mr-3" style="width: 52px; height: 52px;" src="{{ $topic->user->avatar }}" title="{{ $topic->user->name }}">
                </a>
              </div>

              <div class="media-body">

                <div class="media-heading mt-0 mb-1">
                  <a href="{{ route('topics.show', [$topic->id]) }}" title="{{ $topic->title }}">
                    {{ $topic->title }}
                  </a>
                  <a class="float-right" href="{{ route('topics.show', [$topic->id]) }}">
                    <span class="badge badge-secondary badge-pill"> {{ $topic->reply_count }} </span>
                  </a>
                </div>

                <small class="media-body meta text-secondary">

                  <a class="text-secondary" href="#" title="{{ $topic->category->name }}">
                    <i class="far fa-folder"></i>
                    {{ $topic->category->name }}
                  </a>

                  <span> • </span>
                  <a class="text-secondary" href="{{ route('users.show', [$topic->user_id]) }}" title="{{ $topic->user->name }}">
                    <i class="far fa-user"></i>
                    {{ $topic->user->name }}
                  </a>
                  <span> • </span>
                  <i class="far fa-clock"></i>
                  <span class="timeago" title="最后活跃于：{{ $topic->updated_at }}">{{ $topic->updated_at->diffForHumans() }}</span>
                </small>

              </div>
            </li>

            @if ( ! $loop->last)
              <hr>
            @endif

          @endforeach
        </ul>

      @else
        <div class="empty-block">暂无数据 ~_~ </div>
      @endif
      ```
    - 右边栏子视图 resources/views/topics/_sidebar.blade.php
      ```
      <div class="card ">
        <div class="card-body">
          右边导航栏
        </div>
      </div>
      ```
  - 样式优化 resources/sass/app.scss
    ```
    /* Topic Index Page */
    .topics-index-page {
      .topic-list {
        .nav>li>a {
          position: relative;
          display: block;
          padding: 5px 14px;
          font-size: 0.9em;
        }

        a {
          color: #444444;
        }

        .meta {
          font-size: 0.9em;
          color: #b3b3b3;

          a {
            color: #b3b3b3;
          }
        }

        .badge {
          background-color: #d8d8d8;
        }

        hr {
          margin-top: 12px;
          margin-bottom: 12px;
          border: 0;
          border-top: 1px solid #dcebf5;
        }
      }
    }

    /* Add container and footer space */
    #app > div.container {
      margin-bottom: 100px;
    }
    ```
### 5.6 性能优化 (预加载 N+1)
  - 安装 Debugbar（[版本号 ~ ^](https://jochen-z.com/articles/30/differences-between-the-composer-version-range-symbols-and)）
    ```
    composer require "barryvdh/laravel-debugbar:~3.2" --dev
    ```
    - 版本格式：主版本号。次版本号。修订号，如 `1.0.1` , `3.2.39` 。版本号递增规则如下：
      - 主版本号：当你做了不兼容的 API 修改
      - 次版本号：当你做了向下兼容的功能性新增
      - 修订号：当你做了向下兼容的问题修正。
    - `波浪号 ~`
      - `〜1.2` 代表 `1.2 <= 版本号 < 2.0.0` 
      - `〜1.2.3` 代表 `1.2.3 <= 版本号 < 1.3.0`
      - `波浪号 ~` 表示「从最后一位数字递增」
    - `插入号 ^`
      - `^1.2` 代表 `1.2 <= 版本号 < 2.0.0`
      - `^1.2.3` 代表 `1.2.3 <= 版本号 < 2.0.0`
      - `插入号 ^` 表示「从第二位数字递增」
    - `插入号 ^` 的特殊情况
      - 对于 `pre-1.0` ，它还考虑到安全性，会将 `^0.3` 视为 `0.3.0 <= 版本号 < 0.4.0`

  - 发布配置文件
    ```
    php artisan vendor:publish --provider="Barryvdh\Debugbar\ServiceProvider"
    ```
  - 修改配置文件, 打开 config/debugbar.php，将 `enabled` 的值设置为：
    ```
    'enabled' => env('APP_DEBUG', false),
    ```
    修改完以后，Debugbar 分析器的启动状态将由 .env 文件中 APP_DEBUG 值决定。
  - 刷新列表页面即可看到我们的开发者工具栏
    - 在 `Debugbar` 中可以看到数据库查询次数，为了读取 user 和 category，每次的循环都要查一下 users 和 categories 表，如果我第一次查询出来的是 N 条记录，那么最终需要执行的 SQL 语句就是 N+1 次。
  - 用 [预加载](https://learnku.com/docs/laravel/6.x/eloquent-relationships/5177#eager-loading) 解决 N+1 问题 app/Http/Controllers/TopicsController.php
    ```
    $topics = Topic::with('user', 'category')->paginate();
    ```
### 5.7 分类下的话题列表
  - 1.路由
    ```
    Route::resource('categories', 'CategoriesController', ['only' => ['show']]);
    ```
  - 2.控制器 app/Http/Controllers/CategoriesController.php
    ```
    php artisan make:controller CategoriesController
    ```
    ```
    public function show(Category $category)
    {
        // 读取分类 ID 关联的话题，并按每 20 条分页
        $topics = Topic::where('category_id', $category->id)->paginate(20);
        // 传参变量话题和分类到模板中
        return view('topics.index', compact('topics', 'category'));
    }
    ```
  - 3.局部视图中 添加 `categories.show` 路由链接 resources/views/topics/_topic_list.blade.php
    ```
    <a class="text-secondary" href="{{ route('categories.show', $topic->category_id) }}" title="{{ $topic->category->name }}">
      <i class="far fa-folder"></i>
      {{ $topic->category->name }}
    </a>
    ```
  - 4.列表视图中 显示当前分类信息 resources/views/topics/index.blade.php
    ```
    @extends('layouts.app')

    @section('title', '话题列表')

    @section('content')

    <div class="row mb-5">
      <div class="col-lg-9 col-md-9 topic-list">
        @if (isset($category))
          <div class="alert alert-info" role="alert">
            {{ $category->name }} ：{{ $category->description }}
          </div>
        @endif

        <div class="card ">
    ```
  - 5.发现分类页样式不对(路由css类名)
    - 这是因为 `app.scss` 中定义了 `路由 css 类名称` ，我们用了同一个模板，但是分类页路由名称已变为 `categories.sho`。修复方法很简单，只需要样式表中新添加选择器即可：
      ```
      /* Topic Index Page */
      .topics-index-page, .categories-show-page { 
      ```
  - 6.列表页面标题定制 resources/views/topics/index.blade.php
    ```
    @extends('layouts.app')

    @section('title', isset($category) ? $category->name : '话题列表')
    ```
  - 7.增加顶部导航(laravel-active扩展包、辅助函数) resources/views/layouts/_header.blade.php
    ```
    <!-- Left Side Of Navbar -->
    <ul class="navbar-nav mr-auto">
      <li class="nav-item {{ active_class(if_route('topics.index')) }}"><a class="nav-link" href="{{ route('topics.index') }}">话题</a></li>
      <li class="nav-item {{ category_nav_active(1) }}"><a class="nav-link" href="{{ route('categories.show', 1) }}">分享</a></li>
      <li class="nav-item {{ category_nav_active(2) }}"><a class="nav-link" href="{{ route('categories.show', 2) }}">教程</a></li>
      <li class="nav-item {{ category_nav_active(3) }}"><a class="nav-link" href="{{ route('categories.show', 3) }}">问答</a></li>
      <li class="nav-item {{ category_nav_active(4) }}"><a class="nav-link" href="{{ route('categories.show', 4) }}">公告</a></li>
    </ul>
    ```
    - [laravel-active](https://github.com/summerblue-ext-forks/active) 扩展包提供了「active_class」方法
      - 安装 `laravel-active` 扩展包
        ```
        composer require "summerblue/laravel-active:6.*"
        ```
      - 「active_class」方法：如果传参满足指定条件 ($condition) ，此函数将返回 $activeClass，否则返回 $inactiveClass
      - 此扩展包提供了一批函数让我们更方便的进行 $condition 判断：
        ```
        if_route () - 判断当前对应的路由是否是指定的路由；
        if_route_param () - 判断当前的 url 有无指定的路由参数。
        if_query () - 判断指定的 GET 变量是否符合设置的值；
        if_uri () - 判断当前的 url 是否满足指定的 url；
        if_route_pattern () - 判断当前的路由是否包含指定的字符；
        if_uri_pattern () - 判断当前的 url 是否含有指定的字符；
        ```
    - 新增一个辅助函数 category_nav_active ，在 app/helpers.php 中：
      ```
      // 为当前活跃「分类路由」，添加 active 的css类名 
      function category_nav_active($category_id)
      {
        // active_class 是 summerblue/laravel-active 扩展提供的方法
        // 如果「路由名」是 categories.show 并且 「参数」category 的值是 $category_id ，则返回 'actvie' 作为 css 类名
        return active_class((if_route('categories.show') && if_route_param('category', $category_id)));
      }
      ```
### 5.8 话题列表排序
  - 1.排序的思路
    - 我们可以通过 URI 传参 order 给控制器，控制器根据此参数来决定数据的读取逻辑。因为『分类下的话题列表』也会用到排序，并且是在不同的控制器中，所以在此处为了复用性考虑，我们将会把排序逻辑代码放置于 Topic 数据模型中。作为一个合格的程序员，编码时需时刻注意代码复用性。
    - 接下来的步骤是：
      - Topic 中编写排序逻辑；
      - TopicsController 控制器中调用；
      - CategoriesController 控制器中调用。
  - 2.编写排序逻辑(查询作用域) app/Models/Topic.php
    ```
    public function scopeWithOrder($query, $order)
    {
        // 不同的排序，使用不用的数据读取逻辑
        switch ($order) {
            case 'recent':
                $query->recent();
                break;
            
            default:
                $query->recentReplied();
                break;
        }
    }

    public function scopeRecent($query)
    {
        // 按创建时间排序
        return $query->orderBy('created_at', 'desc');
    }

    public function scopeRecentReplied($query)
    {
        // 当话题哟新回复时，我们将辨析逻辑更新话题模型的 reply_count 属性
        // 此时会自动触发框架对数据模型 updated_at 时间错的更新
        return $query->orderBy('updated_at', 'desc');
    }
    ```
    - 查询作用域：作用域总是返回一个查询构造器实例：
      - [本地作用域](https://learnku.com/docs/laravel/6.x/eloquent/5176#4330c1)
        ```
        public function scopeRecent($query) { }
        public function scopeRecentReplied($query) { }
        ```
      - [动态作用域](https://learnku.com/docs/laravel/6.x/eloquent/5176#acba4e)
        ```
        public function scopeWithOrder($query, $order) { }
        ```
      - 作用域定义时，加 `scope` 前缀，调用时不用加 `scope` 前缀
      - 可以了解下 [全局作用域](https://learnku.com/docs/laravel/6.x/eloquent/5176#858495)，全局作用域 用匿名函数的方式定义最好，省得去新建一个类。
  - 3.控制器中调用(查询作用域)
    - app/Http/Controllers/TopicsController.php
      ```
      public function index(Request $request, Topic $topic)
      {
        // $topics = Topic::with('user', 'category')->paginate();
        $topics = $topic->withOrder($request->order) // 排序
                        ->with('user', 'category')	 // 预加载防止 N+1 问题
                        ->paginate(10);
        return view('topics.index', compact('topics'));
      }
      ```
    - app/Http/Controllers/CategoriesController.php
      ```
      public function show(Category $category, Request $request, Topic $topic)
      {
          // 读取分类 ID 关联的话题，并按每 20 条分页
          // $topics = Topic::where('category_id', $category->id)->paginate(20);
          $topics = $topic->withOrder($request->order) // 排序
                          ->where('category_id', $category->id)
                          ->with('user', 'category')  // 预加载防止 N+1 问题
                          ->paginate(10);
          
          return view('topics.index', compact('topics', 'category'));
      }
      ```
  - 4.修改模板(查询参数) resources/views/topics/index.blade.php
    ```
    <ul class="nav nav-pills">
      <li class="nav-item">
        <a class="nav-link {{ active_class( ! if_query('order', 'recent')) }}" href="{{ Request::url() }}?order=default">
          最后回复
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ active_class(if_query('order', 'recent')) }}" href="{{ Request::url() }}?order=recent">
          最新发布
        </a>
      </li>
    </ul>
    ```
    - 通过 URL 中的 order 参数，先判断 active css类名是否该点亮；再通控制器调用`动态作用域` 接收 `order` 参数实现排序
### 5.9 用户发布的话题
  - 1.修改导航栏，新增个人中心的链接，并为下拉列表增加图标 resources/views/layouts/_header.blade.php
    ```
    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
      <a class="dropdown-item" href="{{ route('users.show', Auth::id()) }}">
        <i class="far fa-user mr-2"></i>
        个人中心
      </a>
      <div class="dropdown-divider"></div>
      <a class="dropdown-item" href="{{ route('users.edit', Auth::id()) }}">
        <i class="far fa-edit mr-2"></i>
        编辑资料
      </a>
      <div class="dropdown-divider"></div>
      <a class="dropdown-item" id="logout" href="#">
        <form action="{{ route('logout') }}" method="POST" onsubmit="return confirm('您确定要退出吗？');">
          {{ csrf_field() }}
          <button class="btn btn-block btn-danger" type="submit" name="button">退出</button>
        </form>
      </a>
    </div>
    ```
  - 2.新增模型关联 app/Models/User.php
    ```
    public function topics()
    {
        return $this->hasMany(Topic::class);
    }
    ```
  - 3.修改模板 resources/views/users/show.blade.php
    ```
    {{-- 用户发布的内容 --}}
    <div class="card">
      <div class="card-body">
        <ul class="nav nav-tabs">
          <li class="nav-item"><a class="nav-link active bg-transparent" href="#">Ta 的话题</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Ta 的回复</a></li>
        </ul>
        @include('users._topics', ['topics' => $user->topics()->recent()->paginate(5)])
      </div>
    </div>
    ```
    - 子模板 resources/views/users/_topics.blade.php
      ```
      @if (count($topics))

        <ul class="list-group mt-4 border-0">
          @foreach ($topics as $topic)
            <li class="list-group-item pl-2 pr-2 border-right-0 border-left-0 @if($loop->first) border-top-0 @endif">
              <a href="{{ route('topics.show', $topic->id) }}">
                {{ $topic->title }}
              </a>
              <span class="meta float-right text-secondary">
                {{ $topic->reply_count }} 回复
                <span> ⋅ </span>
                {{ $topic->created_at->diffForHumans() }}
              </span>
            </li>
          @endforeach
        </ul>

      @else
        <div class="empty-block">暂无数据 ~_~ </div>
      @endif

      {{-- 分页 --}}
      <div class="mt-4 pt-1">
        {!! $topics->render() !!}
      </div>
      ```
    - 模板中使用「查询作用域」: recent()
      ```
      @include('users._topics', ['topics' => $user->topics()->recent()->paginate(5)])
      ```   
## 帖子的CRUD
### 6.1 新建话题（观察器）
  - 1.新增入口 
    - resources/views/layouts/_header.blade.php
      ```
      <!-- Authentication Links -->
        @guest
          <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">登录</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">注册</a></li>
        @else
          <li class="nav-item">
            <a class="nav-link mt-1 mr-3 font-weight-bold" href="{{ route('topics.create') }}">
              <i class="fa fa-plus"></i>
            </a>
          </li>
          <li class="nav-item dropdown">
      ```
    - resources/views/topics/_sidebar.blade.php
      ```
      <div class="card ">
        <div class="card-body">
          <a href="{{ route('topics.create') }}" class="btn btn-success btn-block" aria-label="Left Align">
            <i class="fas fa-pencil-alt mr-2"></i>  新建帖子
          </a>
        </div>
      </div>
      ```
  - 2.数据模型 app/Models/Topic.php

    ```
    protected $fillable = [
        'title', 'body', 'category_id', 'excerpt', 'slug'
    ];
    ```
    - 以下字段将禁止用户修改：
      ```
      user_id —— 文章的作者，我们不希望文章的作者可以被随便指派；
      last_reply_user_id —— 最后回复的用户 ID，将由程序来维护；
      order —— 文章排序，将会是管理员专属的功能；
      reply_count —— 回复数量，程序维护；
      view_count —— 查看数量，程序维护；
      ```
  - 3.控制器 app/Http/Controllers/TopicsController.php
    ```
    public function create(Topic $topic)
    {
        $categories = Category::all();
        return view('topics.create_and_edit', compact('topic', 'categories'));
    }
    public function store(TopicRequest $request, Topic $topic)
    {
        $topic->fill($request->all());
        $topic->user_id = Auth::id();
        $topic->save();

        return redirect()->route('topics.show', $topic->id)->with('success', '帖子创建成功！');
    }
    ```
    - store() 方法的第二个参数，会创建一个空白的 $topic 实例；
    - $request->all() 获取所有用户的请求数据数组，如 ['title' => '标题', 'body' => '内容', ... ]；
    - $topic->fill($request->all()); **fill** 方法会将传参的键值数组填充到模型的属性中，如以上数组，$topic->title 的值为 `标题`；
  - 4.视图模板（二合一模板） resources/views/topics/create_and_edit.blade.php
    ```
    @extends('layouts.app')

    @section('content')

      <div class="container">
        <div class="col-md-10 offset-md-1">
          <div class="card ">

            <div class="card-body">
              <h2 class="">
                <i class="far fa-edit"></i>
                @if($topic->id)
                编辑话题
                @else
                新建话题
                @endif
              </h2>

              <hr>

              @if($topic->id)
                <form action="{{ route('topics.update', $topic->id) }}" method="POST" accept-charset="UTF-8">
                  <input type="hidden" name="_method" value="PUT">
              @else
                <form action="{{ route('topics.store') }}" method="POST" accept-charset="UTF-8">
              @endif

                  <input type="hidden" name="_token" value="{{ csrf_token() }}">

                  @include('shared._error')

                  <div class="form-group">
                    <input class="form-control" type="text" name="title" value="{{ old('title', $topic->title ) }}" placeholder="请填写标题" required />
                  </div>

                  <div class="form-group">
                    <select class="form-control" name="category_id" required>
                      <option value="" hidden disabled selected>请选择分类</option>
                      @foreach ($categories as $value)
                      <option value="{{ $value->id }}">{{ $value->name }}</option>
                      @endforeach
                    </select>
                  </div>

                  <div class="form-group">
                    <textarea name="body" class="form-control" id="editor" rows="6" placeholder="请填入至少三个字符的内容。" required>{{ old('body', $topic->body ) }}</textarea>
                  </div>

                  <div class="well well-sm">
                    <button type="submit" class="btn btn-primary"><i class="far fa-save mr-2" aria-hidden="true"></i> 保存</button>
                  </div>
                </form>
            </div>
          </div>
        </div>
      </div>

    @endsection
    ```
  - 5.模型观察器（监听模型 生成摘要） app/Observers/TopicObserver.php
    ```
    public function saving(Topic $topic)
    {
        $topic->excerpt = make_excerpt($topic->body);
    }
    ```
    - make_excerpt() 是我们自定义的辅助方法，在 app/helpers.php 中：
      ```
      // 根据 $topic->body 内容，去除 html 代码，去除空行及回车键，生成限制字数的摘要
      function make_excerpt($value, $length = 200)
      {
        $excerpt = trim(preg_replace('/\r\n|\r|\n+/', ' ', strip_tags($value)));
        return Str::limit($excerpt, $length);
      }
      ```
  - 6.表单验证类 app/Http/Requests/TopicRequest.php
    ```
    public function rules()
    {
        switch($this->method())
        {
            // CREATE
            case 'POST':
            // UPDATE
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'title'       => 'required|min:2',
                    'body'        => 'required|min:3',
                    'category_id' => 'required|numeric',
                ];
            }
            case 'GET':
            case 'DELETE':
            default:
            {
                return [];
            };
        }
    }

    public function messages()
    {
        return [
            'title.min' => '标题必须至少两个字符',
            'body.min' => '文章内容必须至少三个字符',
        ];
    }
    ```
### 6.2 使用 Simditor 编辑器
  - 1.下载 [Simditor](https://simditor.tower.im/)
  - 2.集成到项目中
    - 新建一下两个文件夹
      ```
      mkdir -p resources/editor/css
      mkdir -p resources/editor/js
      ```
    - `simditor.css` 放置于 `resources/editor/css`
    - `hotkeys.js`, `module.js`, `simditor.js`, `uploader.js` 四个文件放置于 `resources/editor/js`
  - 3.修改 webpack.mix.js ，使用 Mix 的 copyDirectory 方法将编辑器的 CSS 和 JS 文件复制到 public 文件夹下
    ```
    const mix = require('laravel-mix');

    mix.js('resources/js/app.js', 'public/js')
      .sass('resources/sass/app.scss', 'public/css')
      .version()
      .copyDirectory('resources/editor/js', 'public/js')
      .copyDirectory('resources/editor/css', 'public/css');
    ```
    - 执行 `npm run dev` 会看到成功复制的文件
  - 4.按需加载编辑器文件
    - Simditor 的样式和脚本文件只需要在帖子创建页面中使用，出于性能考虑，我们将只在话题创建页码中加载这些文件。
    - 首先，在布局文件中种下锚点 styles 和 scripts：resources/views/layouts/app.blade.php
      ```
      <!-- Styles -->
        <link href="{{ mix('css/app.css') }}" rel="stylesheet">

        @yield('styles')

      </head>

      <body>
      .
      .
      .

        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}"></script>

        @yield('scripts')

      </body>
      </html>
      ```
    - 然后，按需加载 resources/views/topics/create_and_edit.blade.php
      ```
      ...
      @section('styles')
        <link rel="stylesheet" type="text/css" href="{{ asset('css/simditor.css') }}">
      @stop

      @section('scripts')
        <script type="text/javascript" src="{{ asset('js/module.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/hotkeys.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/uploader.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/simditor.js') }}"></script>

        <script>
          $(document).ready(function() {
            var editor = new Simditor({
              textarea: $('#editor'),
            });
          });
        </script>
      @stop
      ```
### 6.3 Simditor 上传图片
  - 0.图片上传思路
    - 「Simditor编辑器」发起图片上传请求，「服务器」处理完请求后，返回一个 json 数据 $response 给「Simditor编辑器」
    - 图片上传的时机是：选择完图片，或者图片粘贴到编辑器后，就离开上传图片，其实是在点击”保存“之前就上传好了图片。
  - 1.设置路由 routes/web.php
    ```
    Route::post('upload_image', 'TopicsController@uploadImage')->name('topics.upload_image');
    ```
  - 2.JS脚本调用 resources/views/topics/create_and_edit.blade.php
    ```
    @section('scripts')
      <script type="text/javascript" src="{{ asset('js/module.js') }}"></script>
      <script type="text/javascript" src="{{ asset('js/hotkeys.js') }}"></script>
      <script type="text/javascript" src="{{ asset('js/uploader.js') }}"></script>
      <script type="text/javascript" src="{{ asset('js/simditor.js') }}"></script>

      <script>
        $(document).ready(function() {
          var editor = new Simditor({
            textarea: $('#editor'),
            upload: {
              url: '{{ route('topics.upload_image') }}',
              params: {
                _token: '{{ csrf_token() }}'
              },
              fileKey: 'upload_file',
              connectionCount: 3,
              leaveConfirm: '文件上传中，关闭此页面将取消上传。'
            },
            pasteImage: true,
          });
        });
      </script>
    @stop
    ```
    - 照 [Simditor编辑器上传图片文档](https://simditor.tower.im/docs/doc-config.html#anchor-upload) 进行设定
    - `pasteImag`e —— 设定是否支持图片黏贴上传，这里我们使用 true 进行开启；
    - `url` —— 处理上传图片的 URL；
    - `params` —— 表单提交的参数，Laravel 的 POST 请求必须带防止 CSRF 跨站请求伪造的 _token 参数；
    - `fileKey` —— 是服务器端获取图片的键值，我们设置为 upload_file;
    - `connectionCount` —— 最多只能同时上传 3 张图片；
    - `leaveConfirm` —— 上传过程中，用户关闭页面时的提醒。
  - 3.控制器处理图片 app/Http/Controllers/TopicsController.php
    ```
    public function uploadImage(Request $request, ImageUploadHandler $uploader)
    {

        // 初始化返回给 Simditor编辑器 的数据，默认是失败的（以下格式是 Simditor 要求的返回格式）
        $data = [
            'success'   => false,
            'msg'       => '上传失败!',
            'file_path' => ''
        ];
        // 判断是否有上传文件，并赋值给 $file
        if ($file = $request->upload_file) {
            // 保存图片到本地
            $result = $uploader->save($file, 'topics', \Auth::id(), 400);
            // 图片保存成功的话
            if ($result) {
                $data['file_path'] = $result['path'];
                $data['msg']       = "上传成功!";
                $data['success']   = true;
            }
        }
        return $data;
    }
    ```
    - 需要返回给 Simditor编辑器 的 JOSN 数据格式如下：
      ```
      {
        "success": true/false,
        "msg": "error message", # optional
        "file_path": "[real file path]"
      }
      ```
  - 4.Git 版本控制: public/uploads/images/topics/.gitignore
    ```
    *
    !.gitignore
    ```
### 6.4 显示帖子
  - 1.修改模板 resources/views/topics/show.blade.php
    ```
    @extends('layouts.app')

    @section('title', $topic->title)
    @section('description', $topic->excerpt)

    @section('content')

      <div class="row">

        <div class="col-lg-3 col-md-3 hidden-sm hidden-xs author-info">
          <div class="card ">
            <div class="card-body">
              <div class="text-center">
                作者：{{ $topic->user->name }}
              </div>
              <hr>
              <div class="media">
                <div align="center">
                  <a href="{{ route('users.show', $topic->user->id) }}">
                    <img class="thumbnail img-fluid" src="{{ $topic->user->avatar }}" width="300px" height="300px">
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 topic-content">
          <div class="card ">
            <div class="card-body">
              <h1 class="text-center mt-3 mb-3">
                {{ $topic->title }}
              </h1>

              <div class="article-meta text-center text-secondary">
                {{ $topic->created_at->diffForHumans() }}
                ⋅
                <i class="far fa-comment"></i>
                {{ $topic->reply_count }}
              </div>

              <div class="topic-body mt-4 mb-4">
                {!! $topic->body !!}
              </div>

              <div class="operate">
                <hr>
                <a href="{{ route('topics.edit', $topic->id) }}" class="btn btn-outline-secondary btn-sm" role="button">
                  <i class="far fa-edit"></i> 编辑
                </a>
                <a href="#" class="btn btn-outline-secondary btn-sm" role="button">
                  <i class="far fa-trash-alt"></i> 删除
                </a>
              </div>

            </div>
          </div>
        </div>
      </div>
    @stop
    ```
    - 话题字段 `excerpt` 是文章摘录，用作 SEO 页面描述使用，因此需要在主布局模板中新增 `description` 锚点：resources/views/layouts/app.blade.php
      ```
      <title>@yield('title', 'LaraBBS') - Laravel 进阶教程</title>
      <meta name="description" content="@yield('description', 'LaraBBS 爱好者社区')" />
      ```
  - 2.修改样式 resources/sass/app.scss
    ```
    /* Topic create and edit page */
    .simditor-body img {
      max-width: 100%;
    }

    /* Topic Show Page */
    @import "topic_body";

    .topics-show-page {
      .card {
        padding: 15px;
        h1 {
          margin: 0.4em auto 0.6em;
          font-size: 28px;
          line-height: 38px;
        }
      }
    }
    ```
    - 由于 `topic_body` 样式内容太多，所以将其放置于另一个文件中：`resources/sass/_topic_body.scss`
      - 注意，在 `resources/sass/app.scss` 中引用时 `@import "topic_body";` 没有前缀 `_`
### 6.5 XSS 安全漏洞(HTMLPurifier)
  - [XSS 安全漏洞](https://learnku.com/courses/laravel-intermediate-training/6.x/safety-problem/5572)
    - XSS 也称跨站脚本攻击 (Cross Site Scripting)，恶意攻击者往 Web 页面里插入恶意 JavaScript 代码，当用户浏览该页之时，嵌入其中 Web 里面的 JavaScript 代码会被执行，从而达到恶意攻击用户的目的。
    - 一种比较常见的 XSS 攻击是 Cookie 窃取。我们都知道网站是通过 Cookie 来辨别用户身份的，一旦恶意攻击者能在页面中执行 JavaScript 代码，他们即可通过 JavaScript 读取并窃取你的 Cookie，拿到你的 Cookie 以后即可伪造你的身份登录网站。
  - 帖子显示漏洞{!! !!}
    ```
    <div class="topic-body">
        {!! $topic->body !!}
    </div>
    ```
    - Blade 的 {!! !!} 语法是直接输出数据，不会对数据做任何处理。如果此时输出数据里有 JavaScript 代码，就很不安全。
  - 虽然 Simditor编辑器 对 $topic->body 进行了转义，但也不安全。因为用户不一定是网页上向服务器提交内容，有太多的工具可以发起操作。
  - 解决方案是：对用户提交的数据进行过滤（HTMLPurifier）
    - 安装 `HTMLPurifier`
      ```
      composer require "mews/purifier:~3.0"
      ```
    - 生成配置
      ```
      php artisan vendor:publish --provider="Mews\Purifier\PurifierServiceProvider"
      ```
    - 编辑配置 config/purifier.php
      ```
      <?php

      return [
          'encoding'      => 'UTF-8',
          'finalize'      => true,
          'cachePath'     => storage_path('app/purifier'),
          'cacheFileMode' => 0755,
          'settings'      => [
              'user_topic_body' => [
                  'HTML.Doctype'             => 'XHTML 1.0 Transitional',
                  'HTML.Allowed'             => 'div,b,strong,i,em,a[href|title],ul,ol,ol[start],li,p[style],br,span[style],img[width|height|alt|src],*[style|class],pre,hr,code,h2,h3,h4,h5,h6,blockquote,del,table,thead,tbody,tr,th,td',
                  'CSS.AllowedProperties'    => 'font,font-size,font-weight,font-style,margin,width,height,font-family,text-decoration,padding-left,color,background-color,text-align',
                  'AutoFormat.AutoParagraph' => true,
                  'AutoFormat.RemoveEmpty'   => true,
              ],
          ],
      ];
      ```
      - 配置里的 `user_topic_body` 是我们为话题内容定制的，配合 `clean()` 方法使用
        ```
        $topic->body = clean($topic->body, 'user_topic_body');
        ```
  - 在观察器中过滤 app/Observers/TopicObserver.php
    ```
    class TopicObserver
    {
        // 数据写入数据库之前
        public function saving(Topic $topic)
        {
            // 使用「HTMLPurifier扩展」的 clean() 方法过滤用户提交内容，第二个参数是 config/purifier 中的配置项
            $topic->body = clean($topic->body, 'user_topic_body');

            $topic->excerpt = make_excerpt($topic->body);
        }
    }
    ```
### 6.6 编辑帖子
  - 1.控制器(传递 categories 变量) app/Http/Controllers/TopicsController.php
    ```
    public function edit(Topic $topic)
    {
        $this->authorize('update', $topic);
        $categories = Category::all();
        return view('topics.create_and_edit', compact('topic', 'categories'));
    }

    public function update(TopicRequest $request, Topic $topic)
    {
        $this->authorize('update', $topic);
        $topic->update($request->all());

        return redirect()->route('topics.show', $topic->id)->with('success', '更新成功！');
    }
    ```
  - 2.视图 (选中正在编辑的分类) resources/views/topics/create_and_edit.blade.php
    ```
    <div class="form-group">
      <select name="category_id" class="form-control" required>
        <option value="" hidden disabled {{ $topic->id ? '' : 'selected' }}>请选择分类</option>
        @foreach ($categories as $category)
          <option value="{{ $category->id }}" {{ $topic->category_id == $category->id ? 'selected' : ''  }}>{{ $category->name }}</option>
        @endforeach
      </select>
    </div>
    ```
  - 3.授权策略(只有自己能编辑自己) app/Policies/TopicPolicy.php
    ```
    public function update(User $user, Topic $topic)
    {
        return $topic->user_id == $user->id;
    }
    ```