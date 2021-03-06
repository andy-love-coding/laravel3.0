## 目录
- [2 舞台布置](https://github.com/andy-love-coding/laravel3.0#2-%E8%88%9E%E5%8F%B0%E5%B8%83%E7%BD%AE)
  - [2.2 安装 LaraBBS](https://github.com/andy-love-coding/laravel3.0#22-%E5%AE%89%E8%A3%85-larabbs)
  - [2.5 Github 的 Restful HTTP API 设计分解](https://github.com/andy-love-coding/laravel3.0#25-github-%E7%9A%84-restful-http-api-%E8%AE%BE%E8%AE%A1%E5%88%86%E8%A7%A3)
    - 2.正确使用 HTTP 状态码
  - [2.7. API 基础环境](https://github.com/andy-love-coding/laravel3.0#27-api-%E5%9F%BA%E7%A1%80%E7%8E%AF%E5%A2%83)
    - API 接口版本调试（prefix）
- [3 手机注册](https://github.com/andy-love-coding/laravel3.0#3-%E6%89%8B%E6%9C%BA%E6%B3%A8%E5%86%8C)
  - [3.1 手机注册流程讲解](https://github.com/andy-love-coding/laravel3.0#31-%E6%89%8B%E6%9C%BA%E6%B3%A8%E5%86%8C%E6%B5%81%E7%A8%8B%E8%AE%B2%E8%A7%A3)
  - [3.2 短信提供商](https://github.com/andy-love-coding/laravel3.0#32-%E7%9F%AD%E4%BF%A1%E6%8F%90%E4%BE%9B%E5%95%86)
    - 3.封装 ServiceProvider（easy-sms）
  - [3.3 手机注册验证码](https://github.com/andy-love-coding/laravel3.0#33-%E6%89%8B%E6%9C%BA%E6%B3%A8%E5%86%8C%E9%AA%8C%E8%AF%81%E7%A0%81)
    - 2.基类 API 控制器
  - [3.4 构建用户注册接口](https://github.com/andy-love-coding/laravel3.0#34-%E6%9E%84%E5%BB%BA%E7%94%A8%E6%88%B7%E6%B3%A8%E5%86%8C%E6%8E%A5%E5%8F%A3)
    - 3.API 资源
    - 6.Resource 去掉包裹层 data
  - [3.5 节流处理防止攻击](https://github.com/andy-love-coding/laravel3.0#35-%E8%8A%82%E6%B5%81%E5%A4%84%E7%90%86%E9%98%B2%E6%AD%A2%E6%94%BB%E5%87%BB)
  - [3.6 图片验证码](https://github.com/andy-love-coding/laravel3.0#36-%E5%9B%BE%E7%89%87%E9%AA%8C%E8%AF%81%E7%A0%81)
    - 1.安装 gregwar/captcha（composer 安装内存不够解决办法）
- [4 第三方登录](https://github.com/andy-love-coding/laravel3.0#4-%E7%AC%AC%E4%B8%89%E6%96%B9%E7%99%BB%E5%BD%95)
  - [4.1 微信登录流程讲解](https://github.com/andy-love-coding/laravel3.0#41-%E5%BE%AE%E4%BF%A1%E7%99%BB%E5%BD%95%E6%B5%81%E7%A8%8B%E8%AE%B2%E8%A7%A3)
  - [4.2 微信开发者账号申请](https://github.com/andy-love-coding/laravel3.0#42-%E5%BE%AE%E4%BF%A1%E5%BC%80%E5%8F%91%E8%80%85%E8%B4%A6%E5%8F%B7%E7%94%B3%E8%AF%B7)
  - [4.3 微信登录](https://github.com/andy-love-coding/laravel3.0#43-%E5%BE%AE%E4%BF%A1%E7%99%BB%E5%BD%95)
    - 1.安装 socialiteproviders
  - [4.4 微信登录功能开发](https://github.com/andy-love-coding/laravel3.0#44-%E5%BE%AE%E4%BF%A1%E7%99%BB%E5%BD%95%E5%8A%9F%E8%83%BD%E5%BC%80%E5%8F%91)
  - [4.5 登录 API 获取 JWT 令牌](https://github.com/andy-love-coding/laravel3.0#45-%E7%99%BB%E5%BD%95-api-%E8%8E%B7%E5%8F%96-jwt-%E4%BB%A4%E7%89%8C)
    - 2.安装 jwt-auth
    - 5.tinker 中测试生成一个 token
    - 8.刷新/删除 token
  - [4.6 artisan 生成 token](https://github.com/andy-love-coding/laravel3.0#46-artisan-%E7%94%9F%E6%88%90-token)
- [5 用户数据](https://github.com/andy-love-coding/laravel3.0#5-%E7%94%A8%E6%88%B7%E6%95%B0%E6%8D%AE)
  - [5.1 获取用户信息](https://github.com/andy-love-coding/laravel3.0#51-%E8%8E%B7%E5%8F%96%E7%94%A8%E6%88%B7%E4%BF%A1%E6%81%AF)
    - 4.屏蔽敏感信息（Resource 开关）
  - [5.2 编辑用户信息](https://github.com/andy-love-coding/laravel3.0#52-%E7%BC%96%E8%BE%91%E7%94%A8%E6%88%B7%E4%BF%A1%E6%81%AF)
    - 1.HTTP 提交数据有两种方式
    - 4.编辑个人资料接口(exists:images,id)
- [6 帖子数据](https://github.com/andy-love-coding/laravel3.0#6-%E5%B8%96%E5%AD%90%E6%95%B0%E6%8D%AE)
  - [6.1 分类列表](https://github.com/andy-love-coding/laravel3.0#61-%E5%88%86%E7%B1%BB%E5%88%97%E8%A1%A8)
    - 5.调整数据格式(增加 data 包裹层)
  - [6.2 发布话题](https://github.com/andy-love-coding/laravel3.0#62-%E5%8F%91%E5%B8%83%E8%AF%9D%E9%A2%98)
  - [6.3 修改话题](https://github.com/andy-love-coding/laravel3.0#63-%E4%BF%AE%E6%94%B9%E8%AF%9D%E9%A2%98)
  - [6.4 删除话题](https://github.com/andy-love-coding/laravel3.0#64-%E5%88%A0%E9%99%A4%E8%AF%9D%E9%A2%98)
  - [6.5 话题列表](https://github.com/andy-love-coding/laravel3.0#65-%E8%AF%9D%E9%A2%98%E5%88%97%E8%A1%A8)
    - 5.Include机制 和 搜索条件
      - 5.1 安装一个扩展包：spatie/laravel-query-builder
    - 6.查询日志（query 日志）
      - 6.1 安装 [laravel-query-logger]
      - 6.3 查看日志，有没有产生 N+1 问题
  - [6.6 话题详情](https://github.com/andy-love-coding/laravel3.0#66-%E8%AF%9D%E9%A2%98%E8%AF%A6%E6%83%85)
    - 3.不使用路由模型绑定
- [7 回复数据](https://github.com/andy-love-coding/laravel3.0#7-%E5%9B%9E%E5%A4%8D%E6%95%B0%E6%8D%AE)
  - [7.1 话题回复](https://github.com/andy-love-coding/laravel3.0#71-%E8%AF%9D%E9%A2%98%E5%9B%9E%E5%A4%8D)
  - [7.2 删除回复](https://github.com/andy-love-coding/laravel3.0#72-%E5%88%A0%E9%99%A4%E5%9B%9E%E5%A4%8D)
  - [7.3 回复列表](https://github.com/andy-love-coding/laravel3.0#73-%E5%9B%9E%E5%A4%8D%E5%88%97%E8%A1%A8)
    - 1.某个话题的回复列表
      - 1.4 [调整 Include 参数 (继承QueryBuilder)]
        - 1.4.1 新建一个 ReplyQuery（）（ReplyQuery 继承 QueryBuilder，它们都是查询构建器）
  - [7.4 消息通知列表](https://github.com/andy-love-coding/laravel3.0#74-%E6%B6%88%E6%81%AF%E9%80%9A%E7%9F%A5%E5%88%97%E8%A1%A8)
  - [7.5 未读消息统计](https://github.com/andy-love-coding/laravel3.0#75-%E6%9C%AA%E8%AF%BB%E6%B6%88%E6%81%AF%E7%BB%9F%E8%AE%A1)
  - [7.6 标记通知为已读](https://github.com/andy-love-coding/laravel3.0#76-%E6%A0%87%E8%AE%B0%E9%80%9A%E7%9F%A5%E4%B8%BA%E5%B7%B2%E8%AF%BB)
- [8 权限控制](https://github.com/andy-love-coding/laravel3.0#8-%E6%9D%83%E9%99%90%E6%8E%A7%E5%88%B6)
  - [8.2 权限列表](https://github.com/andy-love-coding/laravel3.0#82-%E6%9D%83%E9%99%90%E5%88%97%E8%A1%A8)
  - [8.3 显示用户角色](https://github.com/andy-love-coding/laravel3.0#83-%E6%98%BE%E7%A4%BA%E7%94%A8%E6%88%B7%E8%A7%92%E8%89%B2)
    - 5.提炼抽象出 TopicQuery
- [9 其他功能](https://github.com/andy-love-coding/laravel3.0#9-%E5%85%B6%E4%BB%96%E5%8A%9F%E8%83%BD)
  - [9.1 资源推荐接口](https://github.com/andy-love-coding/laravel3.0#91-%E8%B5%84%E6%BA%90%E6%8E%A8%E8%8D%90%E6%8E%A5%E5%8F%A3)
  - [9.2 活跃用户接口](https://github.com/andy-love-coding/laravel3.0#92-%E6%B4%BB%E8%B7%83%E7%94%A8%E6%88%B7%E6%8E%A5%E5%8F%A3)
  - [9.3 本地化](https://github.com/andy-love-coding/laravel3.0#93-%E6%9C%AC%E5%9C%B0%E5%8C%96)
    - 2.本地化交给客户端(响应中添加自定义 code)
    - 3.接口根据客户端语言切换错误信息
  - [9,4 消息推送](https://github.com/andy-love-coding/laravel3.0#94-%E6%B6%88%E6%81%AF%E6%8E%A8%E9%80%81)
- [10 API 测试和文档](https://github.com/andy-love-coding/laravel3.0#10-api-%E6%B5%8B%E8%AF%95%E5%92%8C%E6%96%87%E6%A1%A3)
- [11 Oauth 认证--Passport](https://github.com/andy-love-coding/laravel3.0#11-oauth-%E8%AE%A4%E8%AF%81--passport)
## 2 [舞台布置](https://github.com/andy-love-coding/laravel3.0#%E7%9B%AE%E5%BD%95)
### 2.2 [安装 LaraBBS](https://github.com/andy-love-coding/laravel3.0#%E7%9B%AE%E5%BD%95)
- 1.做好准备
  ```
  > cd ~/Homestead && vagrant up
  > vagrant ssh
  ```
  在虚拟机中进入 Code 文件夹：
  ```
  $ cd ~/Code
  ```
- 2.Composer 加速
  ```
  $ composer config -g repo.packagist composer https://mirrors.aliyun.com/composer/
  ```
- 3.安装 LaraBBS 应用
  ```
  $ git clone git@github.com:andy-love-coding/laravel2.2.git laravel3.0
  $ cd laravel3.0
  ```
  ```
  $ composer install
  $ cp .env.example .env
  ```
  - 修改 `.env` 文件
    ```
    DB_DATABASE=laravel3.0
    DB_USERNAME=homestead
    DB_PASSWORD=secret
    APP_URL=http://laravel3.0.test
    ```
- 4.修改 hosts (mac 环境下)
  ```
  > subl /etc/hosts
  ```
  添加一行
  ```
  192.168.10.10   laravel3.0.test
  ```
- 5.新增站点
  ```
  > subl ~/Homestead/Homestead.yaml
  ```
  ```
  ---
  ip: "192.168.10.10"
  memory: 2048
  cpus: 1
  provider: virtualbox

  authorize: ~/.ssh/id_rsa.pub

  keys:
      - ~/.ssh/id_rsa

  folders:
      - map: ~/Code
        to: /home/vagrant/Code

  sites:
      - map: note.test
        to: /home/vagrant/Code/note/public
      - map: laravel1.7.test
        to: /home/vagrant/Code/laravel1.7/public
      - map: laravel3.0.test
        to: /home/vagrant/Code/laravel3.0/public

  databases:
      - note
      - laravel1.7
      - laravel3.0
  ```
- 6.重启虚拟机
  ```
  > cd ~/Homestead && vagrant provision && vagrant reload
  ```
- 7.初始化命令
  ```
  $ php artisan key:generate
  $ php artisan migrate --seed
  ```
- 8.访问应用 laravel3.0.test
### 2.5 [Github 的 Restful HTTP API 设计分解](https://github.com/andy-love-coding/laravel3.0#%E7%9B%AE%E5%BD%95)
- 1.[用 HTTP 动词描述操作](https://learnku.com/courses/laravel-advance-training/6.x/follow-github-to-learn-restful-http-api-design/5697#4c69d4)

  - 幂等性，指一次和多次请求某一个资源应该具有同样的副作用，也就是一次访问与多次访问，对这个资源带来的变化是相同的。
    | 动词   | 描述                               | 是否幂等 |
    | ------ | ---------------------------------- | -------- |
    | GET    | 获取资源，单个或多个               | 是       |
    | POST   | 创建资源                           | 否       |
    | PUT    | 更新资源，客户端提供完整的资源数据 | 是       |
    | PATCH  | 更新资源，客户端提供部分的资源数据 | 否       |
    | DELETE | 删除资源                           | 是       |
    ```
    为什么 PUT 是幂等的而 PATCH 是非幂等的，因为 PUT 是根据客户端提供了完整的资源数据，客户端提交什么就替换什么，而 PATCH 有可能是根据客户端提供的参数，动态的计算出某个值，例如每次请求后资源的某个参数减 1，所以多次调用，资源会有不同的变化。
    ```
- 2.正确使用状态码  
  HTTP 提供了丰富的状态码供我们使用，正确的使用状态码可以让响应数据更具可读性。
  - 200 OK - 对成功的 GET、PUT、PATCH 或 DELETE 操作进行响应。也可以被用在不创建新资源的 POST 操作上
  - 201 Created - 对创建新资源的 POST 操作进行响应。应该带着指向新资源地址的 Location 头
  - 202 Accepted - 服务器接受了请求，但是还未处理，响应中应该包含相应的指示信息，告诉客户端该去哪里查询关于本次请求的信息
  - 204 No Content - 对不会返回响应体的成功请求进行响应（比如 DELETE 请求）
  - 304 Not Modified - HTTP 缓存 header 生效的时候用
  - 400 Bad Request - 请求异常，比如请求中的 body 无法解析
  - 401 Unauthorized - 没有进行认证或者认证非法
  - 403 Forbidden - 服务器已经理解请求，但是拒绝执行它
  - 404 Not Found - 请求一个不存在的资源
  - 405 Method Not Allowed - 所请求的 HTTP 方法不允许当前认证用户访问
  - 410 Gone - 表示当前请求的资源不再可用。当调用老版本 API 的时候很有用
  - 415 Unsupported Media Type - 如果请求中的内容类型是错误的
  - 422 Unprocessable Entity - 用来表示校验错误
  - 429 Too Many Requests - 由于请求频次达到上限而被拒绝访问
### 2.7. [API 基础环境](https://github.com/andy-love-coding/laravel3.0#%E7%9B%AE%E5%BD%95)
- 1.接口版本控制
  - 1.1 先写2个测试接口 routes/api.php
    ```
    Route::prefix('v1')->name('api.v1.')->group(function() {
        Route::get('version', function() {
            return 'this is version v1';
        })->name('version');
    });

    Route::prefix('v2')->name('api.v2.')->group(function() {
        Route::get('version', function() {
            return 'this is version v2';
        })->name('version');
    });
    ```
  - 1.2 查看路由
    ```
    $ php artisan route:list | grep 'api\.'
    ```
    或者进入 Tinker
    ```
    $ php artisan tinker
    >>> route('api.v1.version');
    => "http://laravel3.0.test/api/v1/version"
    >>> route('api.v2.version');
    => "http://laravel3.0.test/api/v2/version"
    ```
- 2.接口调试
  - 设置PostMan 环境变量为：{'host': 'laravel3.0.test'}
    这样测试的时候，请求链接就可以写成：http://{{host}}/api/v1/version
  - 如果客户端没有正确设置 Accept 头，则返回结果中会有很多额外的 html 代码。
  - 设置默认 Accept 头
    - 新建一个中间件，给所有的 API 路由设置 Accept 头
      ```
      $ php artisan make:middleware AcceptHeader
      ```
      编写中间件：app/Http/Middleware/AcceptHeader.php
      ```
      <?php

      namespace App\Http\Middleware;

      use Closure;

      class AcceptHeader
      {
          public function handle($request, Closure $next)
          {
              $request->headers->set('Accept', 'application/json');

              return $next($request);
          }
      }
      ```
      注册中间件：app/Http/Kernel.php
      ```
      protected $middlewareGroups = [
          'web' => [
            ...
          'api' => [
              \App\Http\Middleware\AcceptHeader::class,
              'throttle:60,1',
              'bindings',
          ],
      ];
      ```
- 3.删除测代码，只保留 v1 版本的路由分组
  ```
  <?php

  use Illuminate\Http\Request;

  Route::prefix('v1')->name('api.v1.')->group(function() {

  });
  ···
- 4.Git 版本控制
  ```
  $ git add .
  $ git commit -m '2.7 API 基础配置'
  ```
## 3 [手机注册](https://github.com/andy-love-coding/laravel3.0#%E7%9B%AE%E5%BD%95)
### 3.1 [手机注册流程讲解](https://github.com/andy-love-coding/laravel3.0#%E7%9B%AE%E5%BD%95)
  - 1.[手机注册流程讲解](https://learnku.com/courses/laravel-advance-training/6.x/explanation-of-mobile-registration-process/5701)
### 3.2 [短信提供商](https://github.com/andy-love-coding/laravel3.0#%E7%9B%AE%E5%BD%95)
- 1.服务商注册 [阿里云](https://www.aliyun.com/product/sms?spm=5176.10695662.1128094.1.2a6b4beefNNW54&aly_as=hYtZKQhL)
  - 选择：短信服务 》国内消息 
    - 然后： 》签名管理 》添加签名
    - 然后： 》模板管理 》添加模板
- 2.安装 easy-sms
  - [easy-sms](https://github.com/overtrue/easy-sms) 安正超写的一个短信发送组件
  - 安装 easy-sms
    ```
    $ composer require "overtrue/easy-sms"
    ```
- 3.封装 ServiceProvider
  - 由于 easy-sms 组件还没有 Laravel 的 ServiceProvider，为了方便使用，我们可以自己封装一下。
  - 3.1 首先在 config 目录中增加 easysms.php 文件
    ```
    $ touch config/easysms.php
    ```
    config/easysms.php
    ```
    <?php

    return [
        // HTTP 请求的超时时间（秒）
        'timeout' => 10.0,

        // 默认发送配置
        'default' => [
            // 网关调用策略，默认：顺序调用
            'strategy' => \Overtrue\EasySms\Strategies\OrderStrategy::class,

            // 默认可用的发送网关
            'gateways' => [
                'aliyun',
            ],
        ],
        // 可用的网关配置
        'gateways' => [
            'errorlog' => [
                'file' => '/tmp/easy-sms.log',
            ],
            'aliyun' => [
                'access_key_id' => env('SMS_ALIYUN_ACCESS_KEY_ID'),
                'access_key_secret' => env('SMS_ALIYUN_ACCESS_KEY_SECRET'),
                'sign_name' => env('SMS_ALIYUN_SIGN_NAME'),
            ],
        ],
    ];
    ```
  - 3.2 然后创建一个 ServiceProvider
    ```
    $ php artisan make:provider EasySmsServiceProvider
    ```
    app/providers/EasySmsServiceProvider.php
    ```
    <?php

    namespace App\Providers;

    use Overtrue\EasySms\EasySms;
    use Illuminate\Support\ServiceProvider;

    class EasySmsServiceProvider extends ServiceProvider
    {
        public function boot()
        {
            //
        }

        public function register()
        {
            $this->app->singleton(EasySms::class, function ($app) {
                return new EasySms(config('easysms'));
            });

            $this->app->alias(EasySms::class, 'easysms');
        }
    }
    ```
  - 3.3 最后 打开 `config/app.php` 在 providers 中增加 `App\Providers\EasySmsServiceProvider::class,`
    ```
    'providers' => [
        ...
        App\Providers\EventServiceProvider::class,
        App\Providers\RouteServiceProvider::class,

        App\Providers\EasySmsServiceProvider::class,
    ],
    ```
- 4.修改环境配置
  在 `.env` 中填入阿里云的 AccessKey
  ```
  # aliyun 短信
  SMS_ALIYUN_ACCESS_KEY_ID=LTAI4FejA****
  SMS_ALIYUN_ACCESS_KEY_SECRET=nhYplbr2kpulOU****
  SMS_ALIYUN_SIGN_NAME=ABC商城
  ```
  - 注意：此处的签名 SMS_ALIYUN_SIGN_NAME 必须与阿里云的短信签名完全一致。
  - 同时在 `.env.example` 中也加入配置示例，提交到版本库，方便以后部署
    ```
    # aliyun 短信
    SMS_ALIYUN_ACCESS_KEY_ID=
    SMS_ALIYUN_ACCESS_KEY_SECRET=
    SMS_ALIYUN_SIGN_NAME=
    ```
- 5.短信发送测试
  - 5.1 在阿里云短信后台，获取短信模板的 code
  - 5.2 进入 tinker 测试发送短信
    ```
    $ php artisan tinker
    ```
    输入
    ```
    $sms = app('easysms');
    try {
        $sms->send(13212345678, [
            'template' => 'SMS_174806102',
            'data' => [
                'code' => 1234
            ],
        ]);
    } catch (\Overtrue\EasySms\Exceptions\NoGatewayAvailableException $exception) {
        $message = $exception->getException('aliyun')->getMessage();
        dd($message);
    }
    ```
    结果如下：
    ```
    vagrant@homestead:~/Code/laravel3.0$ php artisan tinker
    Psy Shell v0.10.4 (PHP 7.3.9-1+ubuntu18.04.1+deb.sury.org+1 — cli) by Justin Hileman
    >>> $sms = app('easysms');
    => Overtrue\EasySms\EasySms {#4288}
    >>> try {
    ...     $sms->send(18502181234, [
    ...          'template' => 'SMS_21435001',
    ...          'data' => [
    ...              'code' => 1234
    ...          ],
    ...     ]);
    ... } catch (\Overtrue\EasySms\Exceptions\NoGatewayAvailableException $exception) {
    ...     $message = $exception->getException('aliyun')->getMessage();
    ...     dd($message);
    ... }
    "签名不合法(不存在或被拉黑)"
    ```
  - 5.3 如遇短信发送超时报错，修改 config/easysms.php 中的 timeout 即可
    ```
    如果你遇到报错 cURL error 28: Resolving timed out after 5519 milliseconds (see http://curl.haxx.se/libcurl/c/libcurl-errors.html) 可以将配置中的超时时间增加，修改 config/easysms.php 中的 timeout 即可。
    ```
- 6.Git 版本控制
  ```
  $ git add -A
  $ git commit -m '3.2 短信调试'
  ```
### 3.3 [手机注册验证码](https://github.com/andy-love-coding/laravel3.0#%E7%9B%AE%E5%BD%95)
- 1.用户表添加手机字段
  ```
  $ php artisan make:migration add_phone_to_users_table --table=users
  ```
  database/migrations/{your_date}_add_phone_to_users_table.php
  ```
  public function up()
  {
      Schema::table('users', function (Blueprint $table) {
          $table->string('phone')->nullable()->unique()->after('name');
          $table->string('email')->nullable()->change();
      });
  }

  public function down()
  {
      Schema::table('users', function (Blueprint $table) {
          $table->dropColumn('phone');
          $table->string('email')->nullable(false)->change();
      });
  }
  ```
  - 修改数据表字段属性，需要 `doctrine/dbal` 组件，我们先安装它：
    ```
    $ composer require doctrine/dbal
    ```
  - 然后，执行迁移，更新数据表
    ```
    $ php artisan migrate
    ```
- 2.新建控制器基类  
  创建一个基础 Controller，此类作为所有 API 请求控制器的『基类』
  ```
  $ php artisan make:controller Api/Controller
  ```
  app/Http/Controllers/Api/Controller.php
  ```
  <?php

  namespace App\Http\Controllers\Api;

  use Illuminate\Http\Request;
  use App\Http\Controllers\Controller as BaseController;

  class Controller extends BaseController
  {
      //
  }
  ```
- 3.构建短信验证控制器
  ```
  $ php artisan make:controller Api/VerificationCodesController
  ```
  app/Http/Controllers/Api/VerificationCodesController.php
  ``` 
  <?php

  namespace App\Http\Controllers\Api;

  use Illuminate\Http\Request;

  class VerificationCodesController extends Controller
  {
      public function store()
      {
          return response()->json(['test_message' => 'store verification code']);
      }
  }
  ```
- 4.新增路由 routes/api.php
  ```
  <?php

  use Illuminate\Http\Request;

  Route::prefix('v1')->namespace('Api')->name('api.v1.')->group(function () {
      // 短信验证码
      Route::post('verificationCodes', 'VerificationCodesController@store')
          ->name('verificationCodes.store');
  });
  ```
  - 控制器（如：VerificationCodesController）放在了 Api 目录中， 所以还需要调整一下统一的命名空间，使用 namespace 方法即可。
  - 这样所有 v1 版本的路由都会默认使用 Api 目录中的控制器，你还可以根据版本继续细分到 v1 ，v2 目录中。
- 5.PostMan 里测试一下
  - 测试链接：POST http://{{host}}/api/v1/verificationCodes
    - 出现：{ "test_message": "store verification code" } 则接口正常
- 6.创建 API 表单请求验证基类
  ```
  $ php artisan make:request Api/FormRequest
  ```
  app/Http/Requests/Api/FormRequest.php
  ```
  <?php

  namespace App\Http\Requests\Api;

  use Illuminate\Foundation\Http\FormRequest as BaseFormRequest;

  class FormRequest extends BaseFormRequest
  {
      public function authorize()
      {
          return true;
      }
  }
  ```
- 7.创建验证码的表单请求验证类
  ```
  $ php artisan make:request Api/VerificationCodeRequest
  ```
  app/Http/Requests/Api/VerificationCodeRequest.php
  ```
  <?php

  namespace App\Http\Requests\Api;

  class VerificationCodeRequest extends FormRequest
  {
      public function rules()
      {
          return [
              'phone' => [
                  'required',
                  'regex:/^((13[0-9])|(14[5,7])|(15[0-3,5-9])|(17[0,3,5-8])|(18[0-9])|166|198|199)\d{8}$/',
                  'unique:users'
              ]
          ];
      }
  }
  ```
- 8.增加短信模板配置  
  短信模板的 code 是一个变量，应该增加一个对应的配置，这样方便更换不同的模板。  
  config/easysms.php
  ```
  'gateways' => [
      'errorlog' => [
          'file' => '/tmp/easy-sms.log',
      ],
      'aliyun' => [
          'access_key_id' => env('SMS_ALIYUN_ACCESS_KEY_ID'),
          'access_key_secret' => env('SMS_ALIYUN_ACCESS_KEY_SECRET'),
          'sign_name' => 'Larabbs',
          'templates' => [
              'register' => env('SMS_ALIYUN_TEMPLATE_REGISTER'),
          ]
      ],
  ],
  ```
  - 然后再在 `.env` 文件中配置 SMS_ALIYUN_TEMPLATE_REGISTER
    ```
    SMS_ALIYUN_TEMPLATE_REGISTER=SMS_174806102
    ```
    同时修改 `.env.example`
    ```
    SMS_ALIYUN_TEMPLATE_REGISTER=
    ```
- 9.继续编辑控制器逻辑 app/Http/Controllers/Api/VerificationCodesController.php
  ```
  <?php

  namespace App\Http\Controllers\Api;

  use Illuminate\Support\Str;
  use Illuminate\Http\Request;
  use Overtrue\EasySms\EasySms;
  use App\Http\Requests\Api\VerificationCodeRequest;

  class VerificationCodesController extends Controller
  {
      public function store(VerificationCodeRequest $request, EasySms $easySms)
      {
          $phone = $request->phone;

          // 生成4位随机数，左侧补0
          $code = str_pad(random_int(1, 9999), 4, 0, STR_PAD_LEFT);

          try {
              $result = $easySms->send($phone, [
                  'template' => config('easysms.gateways.aliyun.templates.register'),
                  'data' => [
                      'code' => $code
                  ],
              ]);
          } catch (\Overtrue\EasySms\Exceptions\NoGatewayAvailableException $exception) {
              $message = $exception->getException('aliyun')->getMessage();
              abort(500, $message ?: '短信发送异常');
          }

          $key = 'verificationCode_'.Str::random(15);
          $expiredAt = now()->addMinutes(5);
          // 缓存验证码 5 分钟过期。
          \Cache::put($key, ['phone' => $phone, 'code' => $code], $expiredAt);

          return response()->json([
              'key' => $key,
              'expired_at' => $expiredAt->toDateTimeString(),
          ])->setStatusCode(201);
      }
  }
  ```
  > 做接口的思路与我们做网页应用不同，网站中处理验证码，通常是存入 session，注册的时候验证用户输入的验证码与 session 中的验证码是否相同。但是接口是无状态，相互独立的，处理这种相互关联，有先后调用顺序的接口时，常常是第一个接口返回一个随机的 key，利用这个 key 去调用第二个接口。
- 10.测试发送手机验证码
  - 测试链接：POST http://{{host}}/api/v1/verificationCodes
    请求体 (form-data)
    ```
    body: [
      [
        'phone', => '185....1234'
      ],
    ]
    ```
    - 输入错误手机号，报错：“422 Unprocessable Entity”
      ```
      {
          "message": "The given data was invalid.",
          "errors": {
              "phone": [
                  "电话 格式不正确。"
              ]
          }
      }
      ```
    - 输入正确手机号，返回如下
      ```
      {
          "key": "verificationCode_9OCZ9HRN8bwqt7B",
          "expired_at": "2020-07-26 09:56:03"
      }
      ```
- 11.测试环境验证码
  ```
  if (!app()->environment('production')) {
      $code = '1234';
  } else {
      // 生成4位随机数，左侧补0
      $code = str_pad(random_int(1, 9999), 4, 0, STR_PAD_LEFT);

      try {
          $result = $easySms->send($phone, [
              'template' => config('easysms.gateways.aliyun.templates.register'),
              'data' => [
                  'code' => $code
              ],
          ]);
      } catch (\Overtrue\EasySms\Exceptions\NoGatewayAvailableException $exception) {
          $message = $exception->getException('aliyun')->getMessage();
          abort(500, $message ?: '短信发送异常');
      }
  }
  ```
  - 除了正式环境外，其他环境，默认不真实发送短信，短信验证码默认为 1234。也可以考虑增加一个配置，控制是否真实发送短信。
- 12.Git 版本控制
  ```
  $ git add -A
  $ git commit -m '3.3 发送短信验证码'
  ```
### 3.4 [构建用户注册接口](https://github.com/andy-love-coding/laravel3.0#%E7%9B%AE%E5%BD%95)
- 1.新增路由 routes/api.php
  ```
  Route::prefix('v1')->namespace('Api')->name('api.v1.')->group(function () {
      // 短信验证码
      Route::post('verificationCodes', 'VerificationCodesController@store')
          ->name('verificationCodes.store');
      // 用户注册
      Route::post('users', 'UsersController@store')
          ->name('users.store');
  });
  ```
- 2.表单验证类
  ```
  $ php artisan make:request Api/UserRequest
  ```
  app/Http/Requests/Api/UserRequest.php
  ```
  <?php

  namespace App\Http\Requests\Api;

  class UserRequest extends FormRequest
  {
      public function rules()
      {
          return [
              'name' => 'required|between:3,25|regex:/^[A-Za-z0-9\-\_]+$/|unique:users,name',
              'password' => 'required|alpha_dash|min:6',
              'verification_key' => 'required|string',
              'verification_code' => 'required|string',
          ];
      }

      public function attributes()
      {
          return [
              'verification_key' => '短信验证码 key',
              'verification_code' => '短信验证码',
          ];
      }
  }
  ```
- 3.API 资源
  - 3.1 创建一个用户资源类，这里可以再看一下文档 [API 资源《Laravel 6 中文文档》](https://learnku.com/docs/laravel/6.x/eloquent-resources/5180) ：
    ```
    $ php artisan make:resource UserResource
    ```
    使用默认生成的代码即可，暂时不用修改。
- 4.控制器
  ```
  $ php artisan make:controller Api/UsersController
  ```
  app/Http/Controllers/Api/UsersController.php
  ```
  <?php

  namespace App\Http\Controllers\Api;

  use App\Models\User;
  use Illuminate\Http\Request;
  use App\Http\Resources\UserResource;
  use App\Http\Requests\Api\UserRequest;
  use Illuminate\Auth\AuthenticationException;

  class UsersController extends Controller
  {
      public function store(UserRequest $request)
      {
          $verifyData = \Cache::get($request->verification_key);

        if (!$verifyData) {
            abort(403, '验证码已失效');
          }

          if (!hash_equals($verifyData['code'], $request->verification_code)) {
              // 返回401
              throw new AuthenticationException('验证码错误');
          }

          $user = User::create([
              'name' => $request->name,
              'phone' => $verifyData['phone'],
              'password' => $request->password,
          ]);

          // 清除验证码缓存
          \Cache::forget($request->verification_key);

          return new UserResource($user);
      }
  }
  ```
  - **防止时序攻击**：hash_equals()  
    我们比对验证码是否与缓存中一致时，使用了 hash_equals 方法。
    ```
    hash_equals($verifyData['code'], $request->verification_code)
    ```
    hash_equals 是可防止时序攻击的字符串比较，那么什么是时序攻击呢？比如这段代码我们使用
    ```
    $verifyData['code'] == $request->verification_code
    ```
    - 进行比较，那么两个字符串是从第一位开始逐一进行比较的，发现不同就立即返回 false，那么通过计算返回的速度就知道了大概是哪一位开始不同的，这样就实现了电影中经常出现的按位破解密码的场景。而使用 hash_equals 比较两个字符串，无论字符串是否相等，函数的时间消耗是恒定的，这样可以有效的防止时序攻击。
- 5.修改 User 模型 app/Models/User.php
  给 fillable 设置 phone
  ```
  protected $fillable = [
      'name', 'phone', 'email', 'password', 'introduction', 'avatar',
  ];
  ```
- 6.修改返回数据格式  
  - 返回的数据中 User 资源数据被放在了 data 字段下面，这是默认的数据返回格式，当有数据嵌套时，数据嵌套的层数会特别多，所以我们选择去掉 data 这一层包裹
  - app/Providers/AppServiceProvider.php
    ```
    use Illuminate\Http\Resources\Json\Resource;
    ...
      public function boot()
      {
          ...
          Resource::withoutWrapping();
      }
    ```
- 7.postman 测试用户注册流程
  - 7.1 成验证码接口： POST http://{{host}}/api/v1/verificationCodes  
    保存此接口返回的 verification_key 值，用作用户注册接口的传参
  - 7.2 用户注册接口：POST http://{{host}}/api/v1/users  
    body（form-data）传参：
    ```
    [
      'verification_key' => 'verificationCode_YAXh5CT5ccMQNy6',
      'verificaiton_code' => '1234',
      'password' => '123456',
      'name' => 'andy',
    ]
    ```
- 8.Git 版本控制
  ```
  $ git add -A
  $ git commit -m "3.4 用户注册接口"
  ```
### 3.5 [节流处理防止攻击](https://github.com/andy-love-coding/laravel3.0#%E7%9B%AE%E5%BD%95)
- 1.[路由调用限流](https://learnku.com/docs/laravel/6.x/routing/5135#rate-limiting)
- 2.增加配置
  ```
  $ touch config/api.php
  ```
  config/api.php
  ```
  <?php

  return [
      /*
      * 接口频率限制
      */
      'rate_limits' => [
          // 访问频率限制，次数/分钟
          'access' =>  env('RATE_LIMITS', '60,1'),
          // 登录相关，次数/分钟
          'sign' =>  env('SIGN_RATE_LIMITS', '10,1'),
      ],
  ];
  ```
- 3.修改 app/Http/Kernel.php  
  - 注释掉 `'throttle:60,1',` ，否则会使上面的限制次数减半，比如 '1,1' 会变成 '0,1'(即1分钟一次也不能访问)；'10,1' 会变成 '5,1'(即 5次/分钟)
    ```
    // API ˙中间件组，应用于 routes/api.php 路由文件，
    // 在 RouteServiceProvider 中设定
    'api' => [
        // 使用别名来调用中间件
        // 请见：https://learnku.com/docs/laravel/5.7/middleware#为路由分配中间件
        \App\Http\Middleware\AcceptHeader::class,
        // 'throttle:60,1',
        'bindings',
    ],
    ```
- 4.修改路由 routes/api.php
  ```
  Route::prefix('v1')->namespace('Api')->name('api.v1.')->group(function () {

      Route::middleware('throttle:' . config('api.rate_limits.sign'))->group(function () {
          // 短信验证码
          Route::post('verificationCodes', 'VerificationCodesController@store')
              ->name('verificationCodes.store');
          // 用户注册
          Route::post('users', 'UsersController@store')
              ->name('users.store');
      });

      Route::middleware('throttle:' . config('api.rate_limits.access'))->group(function () {

      });
  });
  ```
- 5.Git 版本控制
  ```
  $ git add -A
  $ git commit -m "3.5 频率限制" 
  ```
### 3.6 [图片验证码](https://github.com/andy-love-coding/laravel3.0#%E7%9B%AE%E5%BD%95)
- 1.安装 gregwar/captcha
  ```
  $ composer require gregwar/captcha
  ```
  - 安装时报错：
    ```
    PHP Fatal error:  Allowed memory size of 1610612736 bytes exhausted (tried to allocate 4096 bytes)
    ```
  - 解决办法：
    - 输入命令 `$ php -i |grep memory` 发现限制的内存确实是 512Mb
      ```
      memory_limit => 512M => 512M
      ```
    - 输入 $ php -i | grep php.ini 找到 php.ini 位置：
      ```
      Configuration File (php.ini) Path => /etc/php5/cli
      Loaded Configuration File => /etc/php5/cli/php.ini
      ```
    - 用 vim 打开文件修改配置，$ sudo vim /etc/php5/cli/php.ini 按: 进入命令行模式 输入 /memory_limit，找到 memory_limit 修改配置为 memory_limit = 2048M
- 2.新建路由 routes/api.php
  ```
  // 图片验证码
    Route::post('captchas', 'CaptchasController@store')
        ->name('captchas.store');
  // 短信验证码
  Route::post('verificationCodes', 'VerificationCodesController@store')
      ->name('verificationCodes.store');
  ```
- 3.新建控制器和表单验证类
  ```
  $ php artisan make:controller Api/CaptchasController
  $ php artisan make:request Api/CaptchaRequest
  ```
  app/Http/Requests/Api/CaptchaRequest.php
  ```
  public function rules()
  {
      return [
          'phone' => [
              'required',
              'regex:/^((13[0-9])|(14[5,7])|(15[0-3,5-9])|(17[0,3,5-8])|(18[0-9])|166|198|199)\d{8}$/',
              'unique:users'
          ]
      ];
  }
  ```
  app/Http/Controllers/Api/CaptchasController.php
  ```
  <?php

  namespace App\Http\Controllers\Api;

  use  Illuminate\Support\Str;
  use Illuminate\Http\Request;
  use Gregwar\Captcha\CaptchaBuilder;
  use App\Http\Requests\Api\CaptchaRequest;

  class CaptchasController extends Controller
  {
      public function store(CaptchaRequest $request, CaptchaBuilder $captchaBuilder)
      {
          $key = 'captcha-'.Str::random(15);
          $phone = $request->phone;

          $captcha = $captchaBuilder->build();
          $expiredAt = now()->addMinutes(2);
          \Cache::put($key, ['phone' => $phone, 'code' => $captcha->getPhrase()], $expiredAt);

          $result = [
              'captcha_key' => $key,
              'expired_at' => $expiredAt->toDateTimeString(),
              'captcha_image_content' => $captcha->inline()
          ];

          return response()->json($result)->setStatusCode(201);
      }
  }
  ```
  - 增加了 CaptchaRequest 要求用户必须通过手机号调用图片验证码接口。
  - controller 中，注入 CaptchaBuilder，通过它的 build() 方法，创建出来验证码图片
  - 使用 getPhrase() 方法获取验证码文本，跟手机号一同存入缓存。
  - 返回 captcha_key，过期时间以及 inline() 方法获取的 base64 图片验证码
- 4.测试图片验证码
  - POST http://{{host}}/api/v1/captchas
    请求体 body (form-data)
    ```
    [
      'phone' => '13212341234'
    ]
    ```
    - 请求成功，复制 captcha_image_content 的值，到浏览器中打开
- 5.集成到短信验证码接口里
  接下来需要修改一下原来的 发送短信验证码接口，通过 captcha_key 和 captcha_code 请求该接口，修改如下：  
  app/Http/Requests/Api/VerificationCodeRequest.php
  ```
  <?php

  namespace App\Http\Requests\Api;

  class VerificationCodeRequest extends FormRequest
  {
      public function rules()
      {
          return [
              'captcha_key' => 'required|string',
              'captcha_code' => 'required|string',
          ];
      }

      public function attributes()
      {
          return [
              'captcha_key' => '图片验证码 key',
              'captcha_code' => '图片验证码',
          ];
      }
  }
  ```
  app/Http/Controllers/Api/VerificationCodesController.php
  ```
  <?php

  namespace App\Http\Controllers\Api;

  use Illuminate\Support\Str;
  use Illuminate\Http\Request;
  use Overtrue\EasySms\EasySms;
  use App\Http\Requests\Api\VerificationCodeRequest;
  use Illuminate\Auth\AuthenticationException;

  class VerificationCodesController extends Controller
  {
      public function store(VerificationCodeRequest $request, EasySms $easySms)
      {
          $captchaData = \Cache::get($request->captcha_key);

          if (!$captchaData) {
              abort(403, '图片验证码已失效');
          }

          if (!hash_equals($captchaData['code'], $request->captcha_code)) {
              // 验证错误就清除缓存
              \Cache::forget($request->captcha_key);
              throw new AuthenticationException('验证码错误');
          }

          $phone = $captchaData['phone'];

          if (!app()->environment('production')) {
              $code = '1234';
          } else {
              // 生成4位随机数，左侧补0
              $code = str_pad(random_int(1, 9999), 4, 0, STR_PAD_LEFT);

              try {
                  $result = $easySms->send($phone, [
                      'template' => config('easysms.gateways.aliyun.templates.register'),
                      'data' => [
                          'code' => $code
                      ],
                  ]);
              } catch (\Overtrue\EasySms\Exceptions\NoGatewayAvailableException $exception) {
                  $message = $exception->getException('aliyun')->getMessage();
                  abort(500, $message ?: '短信发送异常');
              }
          }

          $key = 'verificationCode_'.Str::random(15);
          $expiredAt = now()->addMinutes(5);
          // 缓存验证码 5分钟过期。
          \Cache::put($key, ['phone' => $phone, 'code' => $code], $expiredAt);
          // 清除图片验证码缓存
          \Cache::forget($request->captcha_key);

          return response()->json([
              'key' => $key,
              'expired_at' => $expiredAt->toDateTimeString(),
          ])->setStatusCode(201);
      }
  }
  ```
- 6.测试集成后的短信验证码
  - POST http://{{host}}/api/v1/verificationCodes
    请求体 body (form-body)
    ```
    [
      'captcha_key' => 'captcha-bP39YB1QL4ejiOa',
      'captcha_code' => '',
    ]
    ```
- 7.Git 版本控制
  ```
  $ git add -A
  $ git commit -m "3.6 图片验证码" 
  ```
## 4 [第三方登录](https://github.com/andy-love-coding/laravel3.0#%E7%9B%AE%E5%BD%95)
### 4.1 [微信登录流程讲解](https://github.com/andy-love-coding/laravel3.0#%E7%9B%AE%E5%BD%95)
- [OAutho 2.0 流程分析](https://learnku.com/courses/laravel-advance-training/6.x/process-explanation/5708)
### 4.2 [微信开发者账号申请](https://github.com/andy-love-coding/laravel3.0#%E7%9B%AE%E5%BD%95)
- 1.[申请微信公众平台测试账号](https://learnku.com/courses/laravel-advance-training/6.x/wechat-developer-account-application/5709#b883b5)
- 2.测试 OAuth 流程 [微信网页授权](https://developers.weixin.qq.com/doc/offiaccount/OA_Web_Apps/Wechat_webpage_authorization.html)  
  登录在微信开发者工具
  - 2.1 请求授权页面，获取code （在微信开发者工具中）
    ```
    https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxf0e81c3bee622d60&redirect_uri=http%3A%2F%2Fnba.bluewebgame.com%2Foauth_response.php&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect
    ```
  - 2.2 通过code换取网页授权access_token （在postman中)
    ```
    https://api.weixin.qq.com/sns/oauth2/access_token?appid=APPID&secret=SECRET&code=CODE&grant_type=authorization_code
    ```
  - 2.3 拉取用户信息(需scope为 snsapi_userinfo)（在postman中)
    ```
    https://api.weixin.qq.com/sns/userinfo?access_token=ACCESS_TOKEN&openid=OPENID&lang=zh_CN
    ```
- 3.Git 版本控制
  ```
  $ git add .
  $ git commit -m '4.1 4.2 微信登录开发前的准备及测试'
  ```
### 4.3 [微信登录](https://github.com/andy-love-coding/laravel3.0#%E7%9B%AE%E5%BD%95)
- 1.安装 socialiteproviders  
  [socialiteproviders](https://socialiteproviders.netlify.app/) 为 Laravel Socialite 提供了更多的第三方登录方式，基本上你需要的，都能在这里找到。  
  - 1.1 首先找到 [微信的 provider](https://socialiteproviders.netlify.app/providers/weixin.html)，一步步完成安装。
    ```
    $ composer require socialiteproviders/weixin
    ```
  - 1.2 设置 app/Providers/EventServiceProvider.php
    ```
    protected $listen = [
        \SocialiteProviders\Manager\SocialiteWasCalled::class => [
            // add your listeners (aka providers) here
            'SocialiteProviders\Weixin\WeixinExtendSocialite@handle'
        ],
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        \Illuminate\Auth\Events\Verified::class => [
            \App\Listeners\EmailVerified::class,
        ],
    ];
    ```
- 2.功能调试  
  客户端只获取授权码（code），客户端不保存 app_secret，获取到授权码 code 后就提交给服务器，服务器完成换取 access_token 及换取用户信息的流程。
  - 2.1 首先需要在服务端配置 app_id 及 app_secret，修改如下  
    config/services.php
    ```
    'weixin' => [
        'client_id' => env('WEIXIN_KEY'),
        'client_secret' => env('WEIXIN_SECRET'),
        'redirect' => env('WEIXIN_REDIRECT_URI'),  
    ], 
    ```
    .env
    ```
    # socialite weixin
    WEIXIN_KEY=wxed2d3c585******
    WEIXIN_SECRET=61155a05b9103b949ebe3********
    ```
    修改 .env.example
    ```
    # socialite weixin
    WEIXIN_KEY=
    WEIXIN_SECRET=
    ```
  - 2.2 打开 tinker 测试  
    通过 微信开发者工具 获取一个 code，执行如下代码，将 CODE 替换成你自己的
    ```
    $code = 'CODE';
    $driver = Socialite::driver('weixin');
    $response = $driver->getAccessTokenResponse($code);
    $driver->setOpenId($response['openid']);
    $oauthUser = $driver->userFromToken($response['access_token']);
    ```
    - 出于安全的考虑，授权码只能使用一次！！！请不要重复使用同一个 Code 进行调试，如果你调试中报错了，可以打印一下 $response，code been used, hints 就说明 Code 已经使用过了。
- 3.第三方登录处理流程
  - 根据用户的 openid/unionid 查找数据库中已存在的用户
  - 用户存在，返回该用户的登录凭证
  - 用户不存在，根据微信信息创建用户，返回该用户的登录凭证
- 4.Git 提交代码
  ```
  $ git add -A
  $ git commit -m "4.3 add socialiteproviders"
  ```
### 4.4 [微信登录功能开发](https://github.com/andy-love-coding/laravel3.0#%E7%9B%AE%E5%BD%95)
- 1.为 users 表增加两个字段，weixin_openid，weixin_unionid。修改 password 字段为 nullable，因为第三方登录不需要密码。
  ```
  $ php artisan make:migration add_weixin_openid_to_users_table
  ```
  databases/migrations/< your_date >_add_weixin_openid_to_users_table.php
  ```
  public function up()
  {
      Schema::table('users', function (Blueprint $table) {
          $table->string('weixin_openid')->unique()->nullable()->after('password');
          $table->string('weixin_unionid')->unique()->nullable()->after('weixin_openid');
          $table->string('password')->nullable()->change();
      });
  }

  public function down()
  {
      Schema::table('users', function (Blueprint $table) {
          $table->dropColumn('weixin_openid');
          $table->dropColumn('weixin_unionid');
          $table->string('password')->nullable(false)->change();
      });
  }
  ```
  执行迁移
  ```
  $ php artisan migrate
  ```
- 2.路由设计
  - 1.为了区分用户账号密码登录和第三方登录，我们可以设计为两个接口
    - api/authorizations —— 账号密码登录；
    - api/socials/{social_type}/authorizations —— 第三方登录。
  - 2.修改路由 routes/api.php
    ```
    // 用户注册
    Route::post('users', 'UsersController@store')
        ->name('users.store');
    // 第三方登录
    Route::post('socials/{social_type}/authorizations', 'AuthorizationsController@socialStore')
        ->where('social_type', 'weixin')
        ->name('socials.authorizations.store');
    ```
    - 注意这里的参数，我们对 social_type 进行了限制，只会匹配 weixin，如果你增加了其他的第三方登录，可以在这里增加限制，例如支持微信及微博：`->where('social_type', 'weixin|weibo')` 。
- 3.[第三方登录逻辑](https://learnku.com/courses/laravel-advance-training/6.x/wechat-token-authentication/5711#2b90cc)  
  创建 controller 和 request
  ```
  $ php artisan make:controller Api/AuthorizationsController
  $ php artisan make:request Api/SocialAuthorizationRequest
  ```
  app/Http/Requests/Api/SocialAuthorizationRequest.php
  ```
  <?php

  namespace App\Http\Requests\Api;

  class SocialAuthorizationRequest extends FormRequest
  {
      public function rules()
      {
          // 客户端要么提交授权码（code），要么提交 access_token 和 openid
          $rules = [
              'code' => 'required_without:access_token|string',
              'access_token' => 'required_without:code|string',
          ];

          if ($this->social_type == 'weixin' && !$this->code) {
              $rules['openid']  = 'required|string';
          }

          return $rules;
      }
  }
  ```
  修改用户模型 app/Models/User.php
  ```
  protected $fillable = [
      'name', 'phone', 'email', 'password', 'introduction', 'avatar',
      'weixin_openid', 'weixin_unionid'
  ];
  ```
  app/Http/Controllers/Api/AuthorizationsController.php
  ```
  <?php

  namespace App\Http\Controllers\Api;

  use App\Models\User;
  use Illuminate\Support\Arr;
  use Illuminate\Http\Request;
  use Illuminate\Auth\AuthenticationException;
  use App\Http\Requests\Api\SocialAuthorizationRequest;

  class AuthorizationsController extends Controller
  {
      public function socialStore($type, SocialAuthorizationRequest $request)
      {
          $driver = \Socialite::driver($type);

          try {
              if ($code = $request->code) {
                  $response = $driver->getAccessTokenResponse($code);
                  $token = Arr::get($response, 'access_token');
              } else {
                  $token = $request->access_token;

                  if ($type == 'weixin') {
                      $driver->setOpenId($request->openid);
                  }
              }

              $oauthUser = $driver->userFromToken($token);
          } catch (\Exception $e) {
              throw new AuthenticationException('参数错误，未获取用户信息');
          }

          switch ($type) {
          case 'weixin':
              $unionid = $oauthUser->offsetExists('unionid') ? $oauthUser->offsetGet('unionid') : null;

              if ($unionid) {
                  $user = User::where('weixin_unionid', $unionid)->first();
              } else {
                  $user = User::where('weixin_openid', $oauthUser->getId())->first();
              }

              // 没有用户，默认创建一个用户
              if (!$user) {
                  $user = User::create([
                      'name' => $oauthUser->getNickname(),
                      'avatar' => $oauthUser->getAvatar(),
                      'weixin_openid' => $oauthUser->getId(),
                      'weixin_unionid' => $unionid,
                  ]);
              }

              break;
          }

          return response()->json(['token' => $user->id]);
      }
  }
  ```
  - 只有在用户将公众号绑定到微信开放平台帐号后，才会出现 unionid 字段。这里 有相关说明。但是由于微信开放平台只有通过认证才能绑定公众号，代码做了兼容处理。
  - controller 的逻辑
    - 客户端要么提交授权码（code），要么提交 access_token 和 openid
    - 无论哪种方式，服务器都会调用微信接口，获取授权用户数据，从而确认数据的有效性。这一步很重要，客户端提交的一切都是不可信任的，切记不能客户端直接换取用户信息，提交 openid 或 unionid 以及用户数据到服务器，直接入库。
    - 根据 openid 或 unionid 去数据库查询是否该用户已经存在，如果不存在，则创建用户
    - 最后由服务器为该用户颁发授权凭证。
    - 这里暂时返回用户 id 用于测试，下一节学习了 jwt 相关的内容后，我们会替换这部分代码。
- 4.使用 PostMan 测试
  - POST http://{{host}}/api/v1/socials/:social_type/authorizations  
    Params (Path Variables)
    ```
    [ 'social_type' => 'weixin' ]
    ```
    - URL 中以冒号开头的是变量，可以在 Path Variables 中对变量进行赋值。
    Body (form-data)
    ```
    [ 'code' => '' ]
    ```
- 5.Git 版本控制
  ```
  $ git add -A
  $ git commit -m "4.4 微信登录"
  ```
### 4.5 [登录 API 获取 JWT 令牌](https://github.com/andy-love-coding/laravel3.0#%E7%9B%AE%E5%BD%95)
- 1.[什么是 JWT](https://learnku.com/courses/laravel-advance-training/6.x/mobile-login-api/5712#1d1fad)
- 2.安装 jwt-auth
  ```
  $ composer require tymon/jwt-auth:1.0.0-rc.5
  ```
  - 安装完成后，我们需要设置一下 JWT 的 secret，这个 secret 很重要，用于最后的签名，更换这个 secret 会导致之前生成的所有 token 无效。
    ```
    $ php artisan jwt:secret
    ```
    执行完后，可以看到在 .env 文件中，增加了一行 JWT_SECRET。
- 3.修改 config/auth.php，将 api guard 的 driver 改为 jwt。  
  config/auth.php
  ```
  'guards' => [
      'web' => [
          'driver' => 'session',
          'provider' => 'users',
      ],

      'api' => [
          'driver' => 'jwt',
          'provider' => 'users',
      ],
  ],
  ```
- 4.User 模型需要继承 Tymon\JWTAuth\Contracts\JWTSubject 接口，并实现接口的两个方法 getJWTIdentifier() 和 getJWTCustomClaims()
  app\Models\User.php
  ```
  use Tymon\JWTAuth\Contracts\JWTSubject;
  class User extends Authenticatable implements MustVerifyEmailContract, JWTSubject
  {
    ...
    // getJWTIdentifier 返回了 User 的 id
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    // getJWTCustomClaims 是我们需要额外在 JWT 载荷中增加的自定义内容，这里返回空数组
    public function getJWTCustomClaims()
    {
        return [];
    }
  }
  ```
- 5.tinker 中测试生成一个 token
  ```
  $ php artisan tinker
  >>> $user = User::first();
  >>>Auth::guard('api')->login($user);
  => "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sYXJhdmVsMy4wLnRlc3QiLCJpYXQiOjE1OTU4NTQxMTYsImV4cCI6MTU5NTg1NzcxNiwibmJmIjoxNTk1ODU0MTE2LCJqdGkiOiJIYVlZdnVDa3M0R2xQZGVkIiwic3ViIjoxLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.U4_uDLzQ-zpqDkUdATGrhZ-Qoz-fzV7T4uH9FGQPzL4"
  ```
  - jwt-auth 有两个重要的参数，可以在 .env 中进行设置
    - JWT_TTL 生成的 token 在多少分钟后过期，默认 60 分钟
    - JWT_REFRESH_TTL 生成的 token，在多少分钟内，可以刷新获取一个新 token，默认 20160 分钟，14 天。
- 6.账号密码登录
  - 6.1 路由 routes/api.php
    ```
    // 第三方登录
        Route::post('socials/{social_type}/authorizations', 'AuthorizationsController@socialStore')
            ->where('socail_type', 'weixin')
            ->name('socials.authorizations.store');
    // 账号密码登录
    Route::post('authorizations', 'AuthorizationsController@store')
        ->name('authorizations.store');
    ```
  - 6.2 创建账号密码登录的 request
    ```
    $ php artisan make:request Api/AuthorizationRequest
    ```
    app/Http/Requests/Api/AuthorizationRequest.php
    ```
    public function rules()
    {
        return [
            'username' => 'required|string',
            'password' => 'required|alpha_dash|min:6',
        ];
    }
    ```
  - 6.3 控制器 app/Http/Controllers/Api/AuthorizationsController.php  
    新建账号密码登录方法 store；并修改第三方登录后返回的逻辑
    ```
    <?php

    namespace App\Http\Controllers\Api;

    use App\Models\User;
    use Illuminate\Support\Arr;
    use Illuminate\Http\Request;
    use Illuminate\Auth\AuthenticationException;
    use App\Http\Requests\Api\AuthorizationRequest;
    use App\Http\Requests\Api\SocialAuthorizationRequest;

    class AuthorizationsController extends Controller
    {
        // 账号密码登录
        public function store(AuthorizationRequest $request)
        {
            $username = $request->username;

            filter_var($username, FILTER_VALIDATE_EMAIL) ?
                $credentials['email'] = $username :
                $credentials['phone'] = $username;

            $credentials['password'] = $request->password;

            if (!$token = \Auth::guard('api')->attempt($credentials)) {
                throw new AuthenticationException('用户名或密码错误');
            }

            return $this->respondWithToken($token)->setStatusCode(201);
        }

        // 第三方登录
        public function socialStore($type, SocialAuthorizationRequest $request)
        {
            $driver = \Socialite::driver($type);

            try {
                if ($code = $request->code) {
                    $response = $driver->getAccessTokenResponse($code);
                    $token = Arr::get($response, 'access_token');
                } else {
                    $token = $request->access_token;

                    if ($type == 'weixin') {
                        $driver->setOpenId($request->openid);
                    }
                }

                $oauthUser = $driver->userFromToken($token);
            } catch (\Exception $e) {
                throw new AuthenticationException('参数错误，未获取用户信息');
            }

            switch ($type) {
            case 'weixin':
                $unionid = $oauthUser->offsetExists('unionid') ? $oauthUser->offsetGet('unionid') : null;

                if ($unionid) {
                    $user = User::where('weixin_unionid', $unionid)->first();
                } else {
                    $user = User::where('weixin_openid', $oauthUser->getId())->first();
                }

                // 没有用户，默认创建一个用户
                if (!$user) {
                    $user = User::create([
                        'name' => $oauthUser->getNickname(),
                        'avatar' => $oauthUser->getAvatar(),
                        'weixin_openid' => $oauthUser->getId(),
                        'weixin_unionid' => $unionid,
                    ]);
                }

                break;
            }

            $token= auth('api')->login($user);

            return $this->respondWithToken($token)->setStatusCode(201);
        }

        protected function respondWithToken($token)
        {
            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'expires_in' => auth('api')->factory()->getTTL() * 60
            ]);
        }
    }
    ```
- 7.测试登录后，下发 token
  - 7.1 账号密码登录测试：POST http://{{host}}/api/v1/authorizations  
    传参 body (form-data)
    ```
    [ 'username' => 'summer@example.com', 'password' => '12345678' ]
    ```
  - 7.2 第三方登录测试：POST http://{{host}}/api/v1/socials/:social_type/authorizations  
    传参 Params
    ```
    [ 'social_type' => 'weixin' ]
    ```
    传参 Body (form-data)
    ```
    [ 'code' => '021kBRUI1wlXm10r5TSI1UCUUI1kBRUs' ]
    ``` 
  - 7.3 两种登录都返回如下格式的结果
    ```
    {
        "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sYXJhdmVsMy4wLnRlc3RcL2FwaVwvdjFcL2F1dGhvcml6YXRpb25zIiwiaWF0IjoxNTk1ODUzMzMyLCJleHAiOjE1OTU4NTY5MzIsIm5iZiI6MTU5NTg1MzMzMiwianRpIjoicEl5blVUQnZ3ZVRVenlKSCIsInN1YiI6MiwicHJ2IjoiMjNiZDVjODk0OWY2MDBhZGIzOWU3MDFjNDAwODcyZGI3YTU5NzZmNyJ9.NvKUxBsrF0uHxTRFkFWd5aTHDmdoJWtEegJJKw1XLJw",
        "token_type": "Bearer",
        "expires_in": 3600
    }
    ```
- 8.刷新/删除 token
  - 8.1 路由 routes/api.php
    ```
    // 刷新token
    Route::put('authorizations/current', 'AuthorizationsController@update')
        ->name('authorizations.update');
    // 删除token
    Route::delete('authorizations/current', 'AuthorizationsController@destroy')
        ->name('authorizations.destroy');
    ```
  - 8.2 控制器 app/Http/Controllers/Api/AuthorizationsController.php
    ```
    public function update()
    {
        $token = auth('api')->refresh();
        return $this->respondWithToken($token);
    }

    public function destroy()
    {
        auth('api')->logout();
        return response(null, 204);
    }
    ```
    - 这两个方法我们都需要提交当前的 token，正确的提交方式是在增加 Authorization Header。
      ```
      Authorization: Bearer {token}
      ```
      注意 Bearer 和 token 之间有一个空格
- 9 测试刷新/删除 token
  - 9.1 刷新 token 测试：PUT http://{{host}}/api/v1/authorizations/current  
    添加 Header（Authorization）
    ```
    Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sYXJhdmVsMy4wLnRlc3RcL2FwaVwvdjFcL2F1dGhvcml6YXRpb25zIiwiaWF0IjoxNTk1ODUzMzMyLCJleHAiOjE1OTU4NTY5MzIsIm5iZiI6MTU5NTg1MzMzMiwianRpIjoicEl5blVUQnZ3ZVRVenlKSCIsInN1YiI6MiwicHJ2IjoiMjNiZDVjODk0OWY2MDBhZGIzOWU3MDFjNDAwODcyZGI3YTU5NzZmNyJ9.NvKUxBsrF0uHxTRFkFWd5aTHDmdoJWtEegJJKw1XLJw
    ```
    正确的结果如下：
    ```
    {
        "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sYXJhdmVsMy4wLnRlc3RcL2FwaVwvdjFcL2F1dGhvcml6YXRpb25zXC9jdXJyZW50IiwiaWF0IjoxNTk1ODUzMzMyLCJleHAiOjE1OTU4NTY5NzYsIm5iZiI6MTU5NTg1MzM3NiwianRpIjoid25XQmlrTTRrNkN6bXpQdCIsInN1YiI6MiwicHJ2IjoiMjNiZDVjODk0OWY2MDBhZGIzOWU3MDFjNDAwODcyZGI3YTU5NzZmNyJ9.Um6izQwTRicfjVjlvzl3F638F7doroO-PwKQTP-C1iI",
        "token_type": "Bearer",
        "expires_in": 3600
    }
    ```
  - 9.2 删除 token 测试：DELETE http://{{host}}/api/v1/authorizations/current  
    添加 Header（Authorization）
    ```
    Authorization: {token}
    ```
    正确的结果为：
    ```
    204 No Content
    ```
  - 9.3 PostMan 小技巧
    - 在添加 Header（Authorization）的时候，可以直接选择 Authorization， 再选择其中的 Bearer Token，直接填写 token 即可。
- 10.Git 版本控制
  ```
  $ git add -A
  $ git commit -m "4.5 登录后，下发 JWT 令牌"
  ```
### 4.6 [artisan 生成 token](https://github.com/andy-love-coding/laravel3.0#%E7%9B%AE%E5%BD%95)
- 1.新增 command
  ```
   $ php artisan make:command GenerateToken
  ```
  app/Console/Commands/GenerateToken.php
  ```
  <?php

  namespace App\Console\Commands;

  use App\Models\User;
  use Illuminate\Console\Command;

  class GenerateToken extends Command
  {
      protected $signature = 'larabbs:generate-token';

      protected $description = '快速为用户生成 token';

      public function __construct()
      {
          parent::__construct();
      }

      public function handle()
      {
          $userId = $this->ask('输入用户 id');

          $user = User::find($userId);

          if (!$user) {
              $this->error('用户不存在');
          }

          // 一年以后过期
          $ttl = 365*24*60;
          $this->info(auth('api')->setTTL($ttl)->login($user));
      }
  }
  ```
  - 为该用户生成一个有效期为 1 年的 token
- 2.执行 Artisan 命令，生成 token
  ```
  $ php artisan larabbs:generate-token

  输入用户 id:
  > 1

  eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sYXJhdmVsMy4wLnRlc3QiLCJpYXQiOjE1OTU4NjMyNjgsImV4cCI6MTYyNzM5OTI2OCwibmJmIjoxNTk1ODYzMjY4LCJqdGkiOiJnNEtiUXlBa25zQkI2S3JSIiwic3ViIjoxLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.Z0Vp2PjL4csfmXxxwRA1eLizgUhGn5gnzOBwbzz7ryo
  ```
- 3.PostMan 增加变量
  - 3.1 创建一个 jwt_user1 的环境变量，填入刚才创建的 token
  - 3.2 然后在 Authorization 那里： Type 选择 `Bearer Token`，Token 填写 `{{jwt_user1}}`。这样就可以为 Header(Authorization)添加一个键值对，即 Authorization: Bearer {{jwt_user1}}
- 4.Git 版本控制
  ```
  $ git add -A
  $ git commit -m "4.6 用命令生成1年期的 jwt Token"
  ```
## 5 [用户数据](https://github.com/andy-love-coding/laravel3.0#%E7%9B%AE%E5%BD%95)
### 5.1 [获取用户信息](https://github.com/andy-love-coding/laravel3.0#%E7%9B%AE%E5%BD%95)
- 1.添加路由 routes/api.php
  ```
  Route::middleware('throttle:' . config('api.rate_limits.access'))->group(function() {
      // 游客可以访问的接口

      // 某个用户的详情
      Route::get('users/{user}', 'UsersController@show')
          ->name('users.show');

      // 登录后可以访问的接口
      Route::middleware('auth:api')->group(function() {
          // 当前登录用户信息
          Route::get('user', 'UsersController@me')
              ->name('user.show');
      });
  });
  ```
  - 使用 auth:api 中间件验证用户的 JWT 是否合法。这样就将接口继续分为了两类：
    - 游客可以访问的接口；
    - 登录用户才可以访问的接口。
- 2.修改控制器 app/Http/Controllers/Api/UsersController.php  
  ```
  public function show(User $user, Request $request)
  {
      return new UserResource($user);
  }

  public function me(Request $request)
  {
      return new UserResource($request->user());
  }
  ```
  - auth:api 中间件对用户身份进行了判断，JWT 不正确的用户会抛出 401，而正确登录的用户，也就是 JWT 正确的用户，可以直接通过 $request->user() 获取，最后返回 UserResource 即可。
- 3.测试获取当前登录用户信息
  - 3.1 获取当前用户信息：GET http://{{host}}/api/v1/user  
    传参 Header(Authorization)
    ```
    Authorization: Bearer {token}
    ```
  - 3.2 获取某个用户的详情：GET http://{{host}}/api/v1/users/:id  
    传参 Params
    ```
    id : 2
    ```
  - 3.3 获取的结果格式如：
    ```
    {
        "id": 1,
        "name": "Summer",
        "phone": null,
        "email": "summer@example.com",
        "email_verified_at": "2020-07-27 19:01:50",
        "weixin_openid": null,
        "weixin_unionid": null,
        "created_at": "1972-04-23 05:28:59",
        "updated_at": "2020-07-27 19:01:50",
        "avatar": "https://cdn.learnku.com/uploads/images/201710/14/1/ZqM7iaP4CR.png",
        "introduction": "Vel quia vel excepturi possimus.",
        "notification_count": 0,
        "last_actived_at": "1972-04-22T21:28:59.000000Z"
    }
    ```
- 4.屏蔽敏感信息（Resource 开关）
  - 4.1 隐藏敏感字段(weixin_openid、weixin_unionid) app/Models/User.php
    ```
    protected $hidden = [
        'password', 'remember_token', 'weixin_openid', 'weixin_unionid'
    ];
    ```
  - 4.2 修改 Resource（开关）： app/Http/Resources/UserResource.php
    ```
    <?php

    namespace App\Http\Resources;

    use Illuminate\Http\Resources\Json\JsonResource;

    class UserResource extends JsonResource
    {
        protected $showSensitiveFields = false;

        public function toArray($request)
        {
            if (!$this->showSensitiveFields) {
                $this->resource->addHidden(['phone', 'email']);
            }

            $data = parent::toArray($request);

            $data['bound_phone'] = $this->resource->phone ? true : false;
            $data['bound_wechat'] = ($this->resource->weixin_unionid || $this->resource->weixin_openid) ? true : false;

            return $data;
        }

        public function showSensitiveFields()
        {
            $this->showSensitiveFields = true;

            return $this;
        }
    }
    ```
    - 在 toArray 方法中，最后的返回数据中，增加了两个字段：
      - bound_phone 是否绑定手机；
      - bound_wechat 是否绑定微信。
    - 接着简单的设计了一个 showSensitiveFields 的开关，默认是 false，也就是默认将 phone 和 email 字段隐藏。
  - 4.3 修改控制器 app/Http/Controllers/Api/UsersController.php
    ```
    public function store(UserRequest $request)
    {
        .
        .
        .
        return (new UserResource($user))->showSensitiveFields();
    }    

    public function show(User $user, Request $request)
    {
        return new UserResource($user);
    }

    public function me(Request $request)
    {
        return (new UserResource($request->user()))->showSensitiveFields();
    }
    ```
- 5.测试屏蔽敏感信息
  - 5.1 获取当前用户信息（返回敏感信息 phone 和 email）：GET http://{{host}}/api/v1/user  
    传参 Header(Authorization)
    ```
    Authorization: Bearer {token}
    ```
    结果为：
    {
        "id": 1,
        "name": "Summer",
        "phone": null,
        "email": "summer@example.com",
        "email_verified_at": "2020-07-27 19:01:50",
        "created_at": "1972-04-23 05:28:59",
        "updated_at": "2020-07-27 19:01:50",
        "avatar": "https://cdn.learnku.com/uploads/images/201710/14/1/ZqM7iaP4CR.png",
        "introduction": "Vel quia vel excepturi possimus.",
        "notification_count": 0,
        "last_actived_at": "1972-04-22T21:28:59.000000Z",
        "bound_phone": false,
        "bound_wechat": false
    }
    ```
  - 5.2 获取某个用户的详情（不返回敏感信息 phone 和 email）：GET http://{{host}}/api/v1/users/:id  
    传参 Params
    ```
    id : 2
    ```
    结果为：
    ```
    {
        "id": 1,
        "name": "Summer",
        "email_verified_at": "2020-07-27 19:01:50",
        "created_at": "1972-04-23 05:28:59",
        "updated_at": "2020-07-27 19:01:50",
        "avatar": "https://cdn.learnku.com/uploads/images/201710/14/1/ZqM7iaP4CR.png",
        "introduction": "Vel quia vel excepturi possimus.",
        "notification_count": 0,
        "last_actived_at": "1972-04-22T21:28:59.000000Z",
        "bound_phone": false,
        "bound_wechat": false
    }
    ```
- 6.Git 版本控制
  ```
  $ git add -A
  $ git commit -m '5.1 用户信息 屏蔽敏感信息 Resource开关'
  ```
### 5.2 [编辑用户信息](https://github.com/andy-love-coding/laravel3.0#%E7%9B%AE%E5%BD%95)
- 1.HTTP 提交数据有两种方式
  ```
  - application/x-www-form-urlencoded (默认值)
  - multipart/form-data
  ```
  - form 表单提交文件的时候，需要增加 enctype="multipart/form-data"，才能正确传输文件，因为默认的 enctype 是 enctype="application/x-www-form-urlencoded"
  - 需要明确的是，只有当 POST 配合 multipart/form-data 时才能正确传输文件。
- 2.图片资源
  - 2.1 添加一个图片资源(迁移文件)
    ```
    $ php artisan make:migration create_images_table
    ```
    database/migrations/< your_date >_create_images_table.php
    ```
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->index();
            $table->string('type')->index();
            $table->string('path');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('images');
    }
    ```
    - 记录图片类型是因为不同类型的图片有不同的尺寸，以及不同的文件目录，修改个人头像所使用的 image 必须为 avatar 类型。  
    执行迁移
    ```
    php artisan migrate
    ```
  - 2.2 添加路由 routes/api.php
    ```
    // 登录后可以访问的接口
    Route::middleware('auth:api')->group(function() {
        // 当前登录用户信息
        Route::get('user', 'UsersController@me')
            ->name('user.show');
        // 上传图片
        Route::post('images', 'ImagesController@store')
            ->name('images.store');
    });
    ```
  - 2.3 创建 模型、request、resource、controller
    ```
    $ php artisan make:model Models/Image
    $ php artisan make:request Api/ImageRequest
    $ php artisan make:resource ImageResource
    $ php artisan make:controller Api/ImagesController
    ```
    app\Models\Image.php
    ```
    protected $fillable = ['type', 'path'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    ```
    app/Http/Requests/Api/ImageRequest.php
    ```
    public function rules()
    {

        $rules = [
            'type' => 'required|string|in:avatar,topic',
        ];

        if ($this->type == 'avatar') {
            $rules['image'] = 'required|mimes:jpeg,bmp,png,gif|dimensions:min_width=200,min_height=200';
        } else {
            $rules['image'] = 'required|mimes:jpeg,bmp,png,gif';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'image.dimensions' => '图片的清晰度不够，宽和高需要 200px 以上',
        ];
    }
    ```
    app/Http/Controllers/Api/ImagesController.php
    ```
    <?php

    namespace App\Http\Controllers\Api;

    use App\Models\Image;
    use Illuminate\Support\Str;
    use Illuminate\Http\Request;
    use App\Handlers\ImageUploadHandler;
    use App\Http\Resources\ImageResource;
    use App\Http\Requests\Api\ImageRequest;

    class ImagesController extends Controller
    {
        public function store(ImageRequest $request, ImageUploadHandler $uploader, Image $image)
        {
            $user = $request->user();

            $size = $request->type == 'avatar' ? 416 : 1024;
            $result = $uploader->save($request->image, Str::plural($request->type), $user->id, $size);

            $image->path = $result['path'];
            $image->type = $request->type;
            $image->user_id = $user->id;
            $image->save();

            return new ImageResource($image);
        }
    }
    ```
- 3.测试上传图片
  - 上传图片 POST http://{{host}}/api/v1/images  
    - 需登录 Header(Authorization)
    - body (form-data)
      ```
      image: imagefile
      type: avatar
      ```
    - 结果为
      ```
      {
          "path": "http://laravel3.0.test/uploads/images/avatars/202028/28/1_1595919115_0ZG8v3tRdH.jpg",
          "type": "avatar",
          "user_id": 1,
          "updated_at": "2020-07-28 14:51:55",
          "created_at": "2020-07-28 14:51:55",
          "id": 1
      }
      ```
- 4.编辑个人资料接口(exists:images,id)
  - 4.1 路由 routes/api.php  
    ```
    // 编辑登录用户信息
    Route::patch('user', 'UsersController@update')
        ->name('user.update');
    // 上传图片
    Route::post('images', 'ImagesController@store')
        ->name('images.store');
    ```
    - 注意这里使用的方法是 patch，patch 与 put 的区别为：
      - put 替换某个资源，需提供完整的资源信息；
      - patch 部分修改资源，提供部分资源信息。
  - 4.2 修改UserRequest(exists:images,id)：app/Http/Requests/Api/UserRequest.php
    ```
    <?php

    namespace App\Http\Requests\Api;

    class UserRequest extends FormRequest
    {
        public function rules()
        {
            switch($this->method()) {
            case 'POST':
                return [
                    'name' => 'required|between:3,25|regex:/^[A-Za-z0-9\-\_]+$/|unique:users,name',
                    'password' => 'required|string|min:6',
                    'verification_key' => 'required|string',
                    'verification_code' => 'required|string',
                ];
                break;
            case 'PATCH':
                $userId = auth('api')->id();

                return [
                    'name' => 'between:3,25|regex:/^[A-Za-z0-9\-\_]+$/|unique:users,name,' .$userId,
                    'email'=>'email|unique:users,email,'.$userId,
                    'introduction' => 'max:80',
                    'avatar_image_id' => 'exists:images,id,type,avatar,user_id,'.$userId,
                ];
                break;
            }
        }

        public function attributes()
        {
            return [
                'verification_key' => '短信验证码 key',
                'verification_code' => '短信验证码',
            ];
        }

        public function messages()
        {
            return [
                'name.unique' => '用户名已被占用，请重新填写',
                'name.regex' => '用户名只支持英文、数字、横杆和下划线。',
                'name.between' => '用户名必须介于 3 - 25 个字符之间。',
                'name.required' => '用户名不能为空。',
            ];
        }
    }
    ```
    - 修改头像时，我们先创建 avatar 类型的图片资源，然后提交 avatar_image_id 即可。
    - 以下代码表示：avatar_image_id 在表 images 的 id 列必须存在，同时还需满足 tpye=avatar,user_id=$userId。就是更新头像必须满足这个图片必须存在，且类型是avatar,且属于这个用户。否则就报错：avatar_image_id 不存在
      ```
      'avatar_image_id' => 'exists:images,id,type,avatar,user_id,'.$userId,
      ```
      报错
      ```
      {
          "message": "The given data was invalid.",
          "errors": {
              "avatar_image_id": [
                  "avatar image id 不存在。"
              ]
          }
      }
      ```
  - 4.3 控制器 app/Http/Controllers/Api/UsersController.php
    ```
    use App\Models\Image;
    ...
      public function update(UserRequest $request)
      {
          $user = $request->user();

          $attributes = $request->only(['name', 'email', 'introduction']);

          if ($request->avatar_image_id) {
              $image = Image::find($request->avatar_image_id);

              $attributes['avatar'] = $image->path;
          }

          $user->update($attributes);

          return (new UserResource($user))->showSensitiveFields();
      }
    ```
- 5.测试编辑个人资料
  - PUT http://{{host}}/api/v1/user
    - 需登录 Header(Authorization)
    - 传参 Body (x-www-form-urlencoded)
      ```
      name: testname
      avatar_image_id: 1
      email: test@larabbs.com
      ```
    结果为：
    ```
    {
        "id": 1,
        "name": "andy",
        "phone": null,
        "email": "test@larabbs.com",
        "email_verified_at": "2020-07-27 19:01:50",
        "created_at": "1972-04-23 05:28:59",
        "updated_at": "2020-07-28 16:15:08",
        "avatar": "http://laravel3.0.test/uploads/images/topics/202007/28/1_1595919513_7DrP0smiFX.jpg",
        "introduction": "Vel quia vel excepturi possimus.",
        "notification_count": 0,
        "last_actived_at": "2020-07-28T08:14:15.000000Z",
        "bound_phone": false,
        "bound_wechat": false
    }
    ```
- 6.Git 版本控制
  ```
  $ git add -A
  $ git commit -m '5.2 编辑用户信息'
  ```
## 6 [帖子数据](https://github.com/andy-love-coding/laravel3.0#%E7%9B%AE%E5%BD%95)
### 6.1 [分类列表](https://github.com/andy-love-coding/laravel3.0#%E7%9B%AE%E5%BD%95)
- 1.添加路由 routes/api.php
  ```
  // 游客可以访问的接口

  // 某个用户的详情
  Route::get('users/{user}', 'UsersController@show')
      ->name('users.show');
  // 分类列表
  Route::get('categories', 'CategoriesController@index')
      ->name('categories.index');
  ```
- 2.创建 CategoryResource
  ```
  $ php artisan make:resource CategoryResource
  ```
- 3.创建 CategoriesController
  ```
  $ php artisan make:controller Api/CategoriesController
  ```
  app/Http/Controllers/Api/CategoriesController.php
  ```
  use App\Models\Category;
  use App\Http\Resources\CategoryResource;
  ...
    public function index()
    {
        return CategoryResource::collection(Category::all());
    }
  ```
- 4.测试获取分类信息
  - GET http://{{host}}/api/v1/categories
    - 结果为
      ```
      [
          {
              "id": 1,
              "name": "分享",
              "description": "分享创造，分享发现",
              "post_count": 0
          },
          {
              "id": 2,
              "name": "教程",
              "description": "开发技巧、推广扩展包等",
              "post_count": 0
          },
          {
              "id": 3,
              "name": "问答",
              "description": "请保持友善，互相帮助",
              "post_count": 0
          },
          {
              "id": 4,
              "name": "公告",
              "description": "站点公告",
              "post_count": 0
          }
      ]
      ```
      - 发现：「集合资源」没有 data 包裹层。当返回一个「集合资源」时，返回数据格式是一个数组，这是因为我们已经设置了 API 资源的数据包裹 Resource::withoutWrapping()，即没有 data 包裹层。
      - 但是这样就造成了，「集合资源」和「分页资源」的响应数据不统一，而大部分情况下我们返回的集合数据都会使用分页，下面将试着使用分页获取分类数据并返回。
- 5.调整数据格式(增加 data 包裹层)
  - 5.1 试着用分页获取数据 app/Http/Controllers/Api/CategoriesController.php
    ```
    return CategoryResource::collection(Category::paginate());
    ```
    - 再次测试结果为
      ```
      {
          "data": [
              {
                  ...
              },
              {
                  ...
              },
              {
                  ...
              },
              {
                  "id": 4,
                  "name": "公告",
                  "description": "站点公告",
                  "post_count": 0
              }
          ],
          "links": {
              "first": "http://laravel3.0.test/api/v1/categories?page=1",
              "last": "http://laravel3.0.test/api/v1/categories?page=1",
              "prev": null,
              "next": null
          },
          "meta": {
              "current_page": 1,
              "from": 1,
              "last_page": 1,
              "path": "http://laravel3.0.test/api/v1/categories",
              "per_page": 15,
              "to": 4,
              "total": 4
          }
      }
      ```
      - 发现：「分页资源」有 data 包裹层。「分页资源」中默认增加了分页相关的信息，而分类的「集合数据」是放在 data 下面的，即有了 data 包裹层。
  - 5.2 增加 data 包裹层：即为了数据统一，我们让无分页的「集合资源」也放在 data 下面
    app/Http/Controllers/Api/CategoriesController.php
    ```
    public function index()
    {
        CategoryResource::wrap('data');
        return CategoryResource::collection(Category::all());
    }
    ```
    - 再次测试结果为
      ```
      {
          "data": [
              {
                  ...
              },
              {
                  ...
              },
              {
                  ...
              },
              {
                  "id": 4,
                  "name": "公告",
                  "description": "站点公告",
                  "post_count": 0
              }
          ]
      }
      ```
- 6.Git 版本控制
  ```
  $ git add -A
  $ git commit -m '6.1 分类列表'
  ```
### 6.2 [发布话题](https://github.com/andy-love-coding/laravel3.0#%E7%9B%AE%E5%BD%95)
- 1.增加路由 routes/api.php  
  ```
  // 游客可以访问的接口

  // 话题列表，详情
  Route::resource('topics', 'TopicsController')->only([
      'index', 'show'
  ]);

  // 登录后可以访问的接口

    // 发布话题
    Route::resource('topics', 'TopicsController')->only([
        'store', 'update', 'destroy'
    ]);
  ```
- 2.增加 TopicRequest
  ```
  $ php artisan make:request Api/TopicRequest
  ```
  app/Http/Requests/Api/TopicRequest.php
  ```
  public function rules()
  {
      return [
          'title' => 'required|string',
          'body' => 'required|string',
          'category_id' => 'required|exists:categories,id',
      ];
  }

  public function attributes()
  {
      return [
          'title' => '标题',
          'body' => '话题内容',
          'category_id' => '分类',
      ];
  }
  ```
- 3.增加 TopicResource
  ```
  $ php artisan make:resource TopicResource
  ```
- 4.增加 TopicsController
  ```
  $ php artisan make:controller Api/TopicsController
  ```
  app/Http/Controllers/Api/TopicsController.php
  ```
  public function store(TopicRequest $request, Topic $topic)
  {
      $topic->fill($request->all());
      $topic->user_id = $request->user()->id;
      $topic->save();

      return new TopicResource($topic);
  }
  ```
- 5.测试发布话题
  - POST http://{{host}}/api/v1/topics  
    - 需登录 Header(Authorization)
    - 传参 Body (form-data)
      ```
      title: test
      body: test_content
      category_id: 1
      ```
    - 结果为：201 Created
      ```
      {
          "title": "test",
          "body": "<p>test_content</p>",
          "category_id": "1",
          "user_id": 1,
          "excerpt": "test_content",
          "updated_at": "2020-07-28 19:44:45",
          "created_at": "2020-07-28 19:44:45",
          "id": 101
      }
      ```
- 6.Git 版本控制
  ```
  $ git add -A
  $ git commit -m '6.2 发布话题'
  ```
### 6.3 [修改话题](https://github.com/andy-love-coding/laravel3.0#%E7%9B%AE%E5%BD%95)
- 1.修改 TopicRequest  
  app/Http/Requests/Api/TopicRequest.php
  ```
  public function rules()
  {
      switch($this->method()) {
          case 'POST':
              return [
                  'title' => 'required|string',
                  'body' => 'required|string',
                  'category_id' => 'required|exists:categories,id',
              ];
              break;
          case 'PATCH':
              return [
                  'title' => 'string',
                  'body' => 'string',
                  'category_id' => 'exists:categories,id',
              ];
              break;
      }
  }
  ```
- 2.修改 TopicsController  
  app/Http/Controllers/Api/TopicsController.php
  ```
  public function update(TopicRequest $request, Topic $topic)
  {
      // 注意不要使用有 manage_contents 权限的用户，也就是 id 为 1 ，2 的用户，
      // 他们有管理内容的权限，所以可以修改任何人的话题。
      $this->authorize('update', $topic);

      $topic->update($request->all());
      return new TopicResource($topic);
  }
  ```
  - 在第二本教程中，已经添加了 topic 相关的 policy，所以这里可以直接使用 $this->authorize('update', $topic); 来判断用户是否有权限修改话题。
- 3.测试修改话题
  - PATCH http://{{host}}/api/v1/topics/:id  
    - 需登录 Header(Authorization)
    - 传参 Params
      ```
      id: 100
      ```
    - 传参 Body (x-www-form-urlencoded)
      ```
      title: title-update
      body: body-update
      category_id: 3
      ```
      - 注意 patch 需要使用 x-www-form-urlencoded
    - 正确结果为：
      ```
      {
          "id": 73,
          "title": "title-update",
          "body": "<p>body-update</p>",
          "user_id": 8,
          "category_id": "3",
          "reply_count": 0,
          "view_count": 0,
          "last_reply_user_id": 0,
          "order": 0,
          "excerpt": "body-update",
          "slug": "titleupdate11",
          "created_at": "2020-06-30 12:19:13",
          "updated_at": "2020-07-28 20:41:58"
      }
      ```
- 4.Git 版本控制
  ```
  $ git add -A
  $ git commit -m '6.3 话题修改'
  ```
### 6.4 [删除话题](https://github.com/andy-love-coding/laravel3.0#%E7%9B%AE%E5%BD%95)
- 1.修改 TopicController  
  app/Http/Controllers/Api/TopicsController.php
  ```
  public function destroy(Topic $topic)
  {
      $this->authorize('destroy', $topic);

      $topic->delete();

      return response(null, 204);
  }
  ```
- 2.测试删除话题
  - DELETE http://{{host}}/api/v1/topics/:id
    - 需登录 Header(Authorization)
    - 传参 Params
      ```
      id: 20
      ```
    - 删除自己的话题结果为：204 No Content
    - 删除别人的话题结果为：403 forbidden （删除别人的话题时，不要用有 manage_contents 权限的用户来操作）
- 3.Git 版本控制
  ```
  $ git add -A
  $ git commit -m '6.4 删除话题'
  ```
### 6.5 [话题列表](https://github.com/andy-love-coding/laravel3.0#%E7%9B%AE%E5%BD%95)
- 1.修改 TopicController  
  app/Http/Controllers/Api/TopicsController.php
  ```
  public function index(Request $request, Topic $topic)
  {
      // $query 是 Topic 模型的查询构建器
      $query = $topic->query();

      if ($categoryId = $request->category_id) {
          $query->where('category_id', $categoryId);
      }

      $topics = $query->withOrder($request->order)->paginate(20);

      return TopicResource::collection($topics);
  }
  ```
- 2.测试获取话题列表
  - GET http://{{host}}/api/v1/topics
  - 结果为：
    ```
    {
        "data": [
            {
                "id": 100,
                "title": "title-update11",
                "body": "<p>body-update</p>",
                "user_id": 4,
                "category_id": 3,
                "reply_count": 0,
                "view_count": 0,
                "last_reply_user_id": 0,
                "order": 0,
                "excerpt": "body-update",
                "slug": "aperiam-accusantium-non-consequatur-mollitia-beatae-ab-nisi-et",
                "created_at": "2020-06-30 20:27:36",
                "updated_at": "2020-07-28 20:32:24"
            },
            ...
        ],
        "links": {
            "first": "http://laravel3.0.test/api/v1/topics?page=1",
            "last": "http://laravel3.0.test/api/v1/topics?page=6",
            "prev": null,
            "next": "http://laravel3.0.test/api/v1/topics?page=2"
        },
        "meta": {
            "current_page": 1,
            "from": 1,
            "last_page": 6,
            "path": "http://laravel3.0.test/api/v1/topics",
            "per_page": 20,
            "to": 20,
            "total": 101
        }
    } 
    ```
- 3.话题中嵌套显示用户和分类数据
  - 3.1 修改 app/Http/Controllers/Api/TopicsController.php
    ```
    public function index(Request $request, Topic $topic)
    {
        // $query 是 Topic 模型的查询构建器
        $query = $topic->query();

        if ($categoryId = $request->category_id) {
            $query->where('category_id', $categoryId);
        }

        $topics = $query
                ->with('user', 'category') // 预加载
                ->withOrder($request->order)
                ->paginate(20);

        return TopicResource::collection($topics);
    }
    ```
  - 3.2 修改 app/Http/Resources/TopicResource.php
    ```
    public function toArray($request)
    {
        $data = parent::toArray($request);
        // 通过 whenLoaded 判断是否已经预加载了 user 和 category，
        // 如果有，则使用对应的 Resource 处理并返回数据。
        $data['user'] = new UserResource($this->whenLoaded('user'));
        $data['category'] = new CategoryResource($this->whenloaded('category'));

        return $data;
    }
    ```
- 4.测试话题中嵌套显示用户和分类数据
  - GET http://{{host}}/api/v1/topics
  - 结果为：
    ```
    {
        "data": [
            {
                "id": 100,
                "title": "title-update11",
                "body": "<p>body-update</p>",
                "user_id": 4,
                "category_id": 3,
                "reply_count": 0,
                "view_count": 0,
                "last_reply_user_id": 0,
                "order": 0,
                "excerpt": "body-update",
                "slug": "aperiam-accusantium-non-consequatur-mollitia-beatae-ab-nisi-et",
                "created_at": "2020-06-30 20:27:36",
                "updated_at": "2020-07-28 20:32:24",
                "user": {
                    "id": 4,
                    "name": "Mrs. Raquel Wisozk",
                    "email_verified_at": "2020-07-27 19:01:50",
                    "created_at": "1970-04-20 04:34:15",
                    "updated_at": "1970-04-20 04:34:15",
                    "avatar": "https://cdn.learnku.com/uploads/images/201710/14/1/Lhd1SHqu86.png",
                    "introduction": "Et repudiandae ducimus labore ut.",
                    "notification_count": 0,
                    "last_actived_at": "1970-04-19T20:34:15.000000Z",
                    "bound_phone": false,
                    "bound_wechat": false
                },
                "category": {
                    "id": 3,
                    "name": "问答",
                    "description": "请保持友善，互相帮助",
                    "post_count": 0
                }
            },
            ...
        ],
        "links": {
            "first": "http://laravel3.0.test/api/v1/topics?page=1",
            "last": "http://laravel3.0.test/api/v1/topics?page=6",
            "prev": null,
            "next": "http://laravel3.0.test/api/v1/topics?page=2"
        },
        "meta": {
            "current_page": 1,
            "from": 1,
            "last_page": 6,
            "path": "http://laravel3.0.test/api/v1/topics",
            "per_page": 20,
            "to": 20,
            "total": 101
        }
    }
    ```
- 5.Include机制 和 搜索条件
  - 5.1 安装一个扩展包：spatie/laravel-query-builder
    ```
    $ composer require spatie/laravel-query-builder
    ```
    - 扩展包的使用你可以在参考一下[文档](https://docs.spatie.be/laravel-query-builder/v2/introduction/)。
    - 这里有视频教程可以参考一下 —— [064. API 动态查询参数 —— spatie/laravel-query-builder](https://learnku.com/courses/laravel-package/2019/spatielaravel-query-builder/2509)
  - 5.2 修改 app/Http/Controllers/Api/TopicsController.php
    ```
    use Spatie\QueryBuilder\QueryBuilder;
    use Spatie\QueryBuilder\AllowedFilter;
    ...
      public function index(Request $request, Topic $topic)
      {
          $topics = QueryBuilder::for(Topic::class)
              ->allowedIncludes('user', 'category')
              ->allowedFilters([
                  'title',
                  AllowedFilter::exact('category_id'),
                  AllowedFilter::scope('withOrder')->default('recentReplied'),
              ])
              ->paginate();

          return TopicResource::collection($topics);
      }
    ```
    - allowedIncludes 方法传入可以被 include 的参数
    - allowedFilters 方法传入可以被搜索的条件，可以传入某个字段，例如我们这里传入了 title，这样会模糊搜索标题；如果某个字段是精确搜索需要进行指定，这里我们指定 category_id 是精确搜索的；还可以传入某个 scope，并且制定默认的参数，例如这里我们指定可以使用 withOrder 进行搜索，默认的值是 recentReplied
  - 5.3 测试 Include参数 和 搜索条件
    - 不包含 include 参数：GET http://{{host}}/api/v1/topics
      - 结果为：同第2小节(测试获取话题列表)的测试结果一样
    - 包含 include 参数：GET http://{{host}}/api/v1/topics?include=user,category
      - 结果为：同第4小节(测试话题中嵌套显示用户和分类数据)的测试结果一样
      - 也可以：/topics?include=user ，此时返回话题数据，及包含用户数据；
    - 使用搜索条件：GET http://{{host}}/api/v1/topics?filter[title]=title&filter['category_id']=1&filter[withOrder]=recent  
      传入 Params
      ```
      filter[title]: title
      filter[category_id]: 1
      filter[withOrder]: recent
      ```
      - 结果为：
        ```
        {
            "data": [
                {
                    "id": 100,
                    "title": "title-update11",
                    "body": "<p>body-update</p>",
                    "user_id": 4,
                    "category_id": 3,
                    "reply_count": 0,
                    "view_count": 0,
                    "last_reply_user_id": 0,
                    "order": 0,
                    "excerpt": "body-update",
                    "slug": "aperiam-accusantium-non-consequatur-mollitia-beatae-ab-nisi-et",
                    "created_at": "2020-06-30 20:27:36",
                    "updated_at": "2020-07-28 20:32:24"
                }
            ],
            "links": {
                "first": "http://laravel3.0.test/api/v1/topics?page=1",
                "last": "http://laravel3.0.test/api/v1/topics?page=1",
                "prev": null,
                "next": null
            },
            "meta": {
                "current_page": 1,
                "from": 1,
                "last_page": 1,
                "path": "http://laravel3.0.test/api/v1/topics",
                "per_page": 15,
                "to": 1,
                "total": 1
            }
        }
        ```
- 6.查询日志（query 日志）
  - 6.1 安装 [laravel-query-logger](https://packagist.org/packages/overtrue/laravel-query-logger)
    ```
    $ composer require overtrue/laravel-query-logger --dev
    ```
    - 你可能会发现现在的代码并没有通过 with 或者 load 预加载模型关系，那么会不会带来 N+1 问题呢。首先我们需要输出 sql 查询日志，laravel-query-logger 是一个查询日志组件，先来安装它
  - 6.2 设置：config/logging.php:
    ```
    return [
        ...
        'query' => [
            'enabled' => env('LOG_QUERY', false),
            
            // Only record queries that are slower than the following time
            // Unit: milliseconds
            'slower_than' => 0, 
        ],
    ];
    ```
    .env
    ```
    LOG_QUERY=true
    ```
  - 6.3 查看日志
    ```
    $ tail -f ./storage/logs/laravel.log
    ```
    请求接口后，在命令行中可看到查询日志
    ```
    [2020-07-29 12:21:27] local.DEBUG: [laravel3.0] [7.33ms] select count(*) as aggregate from `topics` | GET: /api/v1/topics?include=user,category  
    [2020-07-29 12:21:27] local.DEBUG: [laravel3.0] [560μs] select * from `topics` order by `updated_at` desc limit 15 offset 0 | GET: /api/v1/topics?include=user,category  
    [2020-07-29 12:21:27] local.DEBUG: [laravel3.0] [410μs] select * from `users` where `users`.`id` in (1, 3, 4, 6, 8, 9, 10) | GET: /api/v1/topics?include=user,category  
    [2020-07-29 12:21:27] local.DEBUG: [laravel3.0] [360μs] select * from `categories` where `categories`.`id` in (1, 2, 3, 4) | GET: /api/v1/topics?include=user,category 
    ```
    并没有产生 N+1 问题，QueryBuilder 扩展包已经帮助我们进行了预加载。
- 7.个人话题列表
  - 7.1 添加路由 routes/api.php
    ```
    // 分类列表
    Route::get('categories', 'CategoriesController@index')
        ->name('categories.index');
    // 某个用户发布的话题
    Route::get('users/{user}/topics', 'TopicsController@userIndex')
        ->name('users.topics.index');
    ```
  - 7.2 修改 app/Http/Controllers/Api/TopicsController.php
    ```
    use App\Models\User;
    ...
      public function userIndex(Request $request, User $user)
      {
          $query = $user->topics()->getQuery();

          $topics = QueryBuilder::for($query)
              ->allowedIncludes('user', 'category')
              ->allowedFilters([
                  'title',
                  AllowedFilter::exact('category_id'),
                  AllowedFilter::scope('withOrder')->default('recentReplied'),
              ])
              ->paginate();

          return TopicResource::collection($topics);
      }
    ```
  - 7.3 测试个人话题列表
    - GET http://{{host}}/api/v1/users/:id/topics?include=category
- 8.Git 版本控制
  ```
  git add -A
  git commit -m '6.5 话题列表 include机制 搜索条件 查询日志（query日志）'
  ```
### 6.6 [话题详情](https://github.com/andy-love-coding/laravel3.0#%E7%9B%AE%E5%BD%95)
- 1.修改 app/Http/Controllers/Api/TopicsController.php
  ```
  public function show(Topic $topic)
  {
      return new TopicResource($topic);
  }
  ```
- 2.测试话题详情
  - GET http://{{host}}/api/v1/topics/:id?include=user,category
  - 结果中不包含用户和分类数据，这是因为路由模型绑定，已经解析出了topic模型，无法再include user 和 category 了。
- 3.不使用路由模型绑定 app/Http/Controllers/Api/TopicsController.php
  ```
  public function show($topicId)
  {
      $topic = QueryBuilder::for(Topic::class)
          ->allowedIncludes('user', 'category')
          ->findOrFail($topicId);

      return new TopicResource($topic);
  }
  ```
- 4.测试「不使用路由模型绑定」的话题详情
  - GET http://{{host}}/api/v1/topics/:id?include=user,category
  - 测试结果可以 include 包含用户和分类数据：
    ```
    {
        "id": 1,
        "title": "A expedita alias eum consequuntur ducimus qui natus at.",
        "body": "Illo hic laudantium quibusdam. Culpa incidunt accusamus nemo cum id deleniti earum sunt. Laborum eos non qui nemo. Omnis pariatur suscipit non nostrum.",
        "user_id": 1,
        "category_id": 2,
        "reply_count": 0,
        "view_count": 0,
        "last_reply_user_id": 0,
        "order": 0,
        "excerpt": "A expedita alias eum consequuntur ducimus qui natus at.",
        "slug": null,
        "created_at": "2020-07-03 07:33:03",
        "updated_at": "2020-07-11 20:06:56",
        "user": {
            "id": 1,
            "name": "andy",
            "email_verified_at": "2020-07-27 19:01:50",
            "created_at": "1972-04-23 05:28:59",
            "updated_at": "2020-07-28 16:25:53",
            "avatar": "http://laravel3.0.test/uploads/images/topics/202007/28/1_1595919513_7DrP0smiFX.jpg",
            "introduction": "Vel quia vel excepturi possimus.",
            "notification_count": 0,
            "last_actived_at": "1972-04-22T21:28:59.000000Z",
            "bound_phone": false,
            "bound_wechat": false
        },
        "category": {
            "id": 2,
            "name": "教程",
            "description": "开发技巧、推广扩展包等",
            "post_count": 0
        }
    }
    ```
- 5.Git 版本控制
  ```
  git add -A
  git commit -m '6.6 话题详情 不用路由模型绑定'
  ```
## 7 [回复数据](https://github.com/andy-love-coding/laravel3.0#%E7%9B%AE%E5%BD%95)
### 7.1 [话题回复](https://github.com/andy-love-coding/laravel3.0#%E7%9B%AE%E5%BD%95)
- 1.增加路由 routes/api.php
  ```
  // 发布话题
  Route::resource('topics', 'TopicsController')->only([
      'store', 'update', 'destroy'
  ]);
  // 发布回复
  Route::post('topics/{topic}/replies', 'RepliesController@store')
      ->name('topics.replies.store');
  ```
- 2.增加 ReplyRequest
  ```
  $ php artisan make:request Api/ReplyRequest
  ```
  app/Http/Requests/Api/ReplyRequest.php
  ```
  public function rules()
  {
      return [
          'content' => 'required|min:2',
      ];
  }
  ```
- 3.增加 ReplyResource
  ```
  php artisan make:resource ReplyResource
  ```
  app/Http/Resources/ReplyResource.php
  ```
  public function toArray($request)
  {
      // return parent::toArray($request);
      return [
          'id' => $this->id,
          'user_id' => (int) $this->user_id,
          'topic_id' => (int) $this->topic_id,
          'content' => $this->content,
          'created_at' => (string) $this->created_at,
          'updated_at' => (string) $this->updated_at,
      ];
  }
  ```
- 4.增加 RepliesController
  ```
  php artisan make:controller Api/RepliesController
  ```
  app/Http/Controllers/Api/RepliesController.php
  ```
  public function store(ReplyRequest $request, Topic $topic, Reply $reply)
  {
      $reply->content = $request->content;
      $reply->topic()->associate($topic);
      $reply->user()->associate($request->user());
      $reply->save();

      return new ReplyResource($reply);
  }
  ```
- 5.测试添加回复
  - POST http://{{host}}/api/v1/topics/:id/replies
    - 需登录 Header(Authorization)
    - 传参 Body(form-data)
      ```
      content: reply
      ```
  - 当 app/Http/Resources/ReplyResource.php 为
    ```
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'user_id' => (int) $this->user_id,
            'topic_id' => (int) $this->topic_id,
            'content' => $this->content,
            'created_at' => (string) $this->created_at,
            'updated_at' => (string) $this->updated_at,
        ];
    }
    ```
    结果为：
    ```
    {
        "id": 1007,
        "user_id": 8,
        "topic_id": 1,
        "content": "<p>reply</p>",
        "created_at": "2020-07-29 14:25:20",
        "updated_at": "2020-07-29 14:25:20"
    }
    ```
  - 当 app/Http/Resources/ReplyResource.php 为
    ```
    public function toArray($request)
    {
        return parent::toArray($request);
        // return [
        //     'id' => $this->id,
        //     'user_id' => (int) $this->user_id,
        //     'topic_id' => (int) $this->topic_id,
        //     'content' => $this->content,
        //     'created_at' => (string) $this->created_at,
        //     'updated_at' => (string) $this->updated_at,
        // ];
    }
    ```
    结果为：
    ```
    {
        "content": "<p>reply112</p>",
        "topic_id": 1,
        "user_id": 8,
        "updated_at": "2020-07-29 14:27:30",
        "created_at": "2020-07-29 14:27:30",
        "id": 1009,
        "topic": {
            "id": 1,
            "title": "A expedita alias eum consequuntur ducimus qui natus at.",
            "body": "<p>Illo hic laudantium quibusdam. Culpa incidunt accusamus nemo cum id deleniti earum sunt. Laborum eos non qui nemo. Omnis pariatur suscipit non nostrum.</p>",
            "user_id": 1,
            "category_id": 2,
            "reply_count": 21,
            "view_count": 0,
            "last_reply_user_id": 0,
            "order": 0,
            "excerpt": "Illo hic laudantium quibusdam. Culpa incidunt accusamus nemo cum id deleniti earum sunt. Laborum eos non qui nemo. Omnis pariatur suscipit non nostrum.",
            "slug": "a-expedita-alias-eum-consequuntur-ducimus-qui-natus-at",
            "created_at": "2020-07-03 07:33:03",
            "updated_at": "2020-07-29 14:27:30",
            "user": {
                "id": 1,
                "name": "andy",
                "phone": null,
                "email": "test@larabbs.com",
                "email_verified_at": "2020-07-27 19:01:50",
                "created_at": "1972-04-23 05:28:59",
                "updated_at": "2020-07-29 14:26:34",
                "avatar": "http://laravel3.0.test/uploads/images/topics/202007/28/1_1595919513_7DrP0smiFX.jpg",
                "introduction": "Vel quia vel excepturi possimus.",
                "notification_count": 9,
                "last_actived_at": "1972-04-22T21:28:59.000000Z"
            }
        },
        "user": {
            "id": 8,
            "name": "TrystanLehner",
            "phone": null,
            "email": "fidel.runolfsdottir@example.net",
            "email_verified_at": "2020-07-27 19:01:50",
            "created_at": "2014-06-04 04:29:52",
            "updated_at": "2014-06-04 04:29:52",
            "avatar": "https://cdn.learnku.com/uploads/images/201710/14/1/ZqM7iaP4CR.png",
            "introduction": "Alias ab cumque in molestiae et.",
            "notification_count": 0,
            "last_actived_at": "2014-06-03T20:29:52.000000Z"
        }
    }
    ```
  - 说明：`return parent::toArray($request);` 返回的是一个数组，「数组的结构」 与 「$request（资源入参）的结构」相同。
  - 测试时注意：由于开启了「话题回复，邮件通知作者」的功能，且没有启用队列异步通知时，此时调用回复接口会报错：
    ```
    Expected response code 250 but got code \"530\", with message \"530 5.7.1 Authentication required
    ```
    - 解决办法：
      - 办法一：通知启用队列 .env
        ```
        QUEUE_CONNECTION=redis
        ```
      - 办法二：设置正常的邮件通知
      - 办法三：不进行邮件通知 app/Notifications/TopicReplied.php
        ```
        public function via($notifiable)
        {
            // 开通通知的频道
            // return ['database', 'mail'];
            return ['database'];
        }
        ```
- 6.Git 版本控制
  ```
  git add -A
  git commit -m '7.1 话题回复'
  ```
### 7.2 [删除回复](https://github.com/andy-love-coding/laravel3.0#%E7%9B%AE%E5%BD%95)
- 1.添加路由 routes/api.php
  ```
  // 发布回复
  Route::post('topics/{topic}/replies', 'RepliesController@store')
      ->name('topics.replies.store');
  // 删除回复
  Route::delete('topics/{topic}/replies/{reply}', 'RepliesController@destroy')
      ->name('topics.replies.destroy');
  ```
- 2.修改 app/Http/Controllers/Api/RepliesController.php
  ```
  public function destroy(Topic $topic, Reply $reply)
  {
      if ($reply->topic_id != $topic->id) {
          abort(404);
      }

      $this->authorize('destroy', $reply);
      $reply->delete();

      return response(null, 204);
  }
  ```
  - 这里的 destroy 使用的是已存在的 授权策略 
- 3.测试删除话题
  - DELETE http://{{host}}/api/v1/topics/:id/replies/:pid   
    - 需登录 Header(Authorization)
  - 用非管理员账号，删除一个不是自己的回复，报错：403 Forbidden
  - 删除自己的回复，返回：240 No Content
- 4.Git版本控制
  ```
  git add -A
  git commit -m '7.2 删除回复'
  ```
### 7.3 [回复列表](https://github.com/andy-love-coding/laravel3.0#%E7%9B%AE%E5%BD%95)
- 1.某个话题的回复列表
  - 1.1 添加路由 routes/api.php
    ```
    // 话题列表，详情
    Route::resource('topics', 'TopicsController')->only([
        'index', 'show'
    ]);
    // 话题回复列表
    Route::get('topics/{topic}/replies', 'RepliesController@index')
        ->name('topics.replies.index');
    ```
  - 1.2 修改 app/Http/Controllers/Api/RepliesController.php
    ```
    public function index(Topic $topic)
    {
        $replies = $topic->replies()->paginate();

        return ReplyResource::collection($replies);
    }
    ```
  - 1.3 测试某个话题的回复列表
    - GET http://{{host}}/api/v1/topics/:id/replies
    - 结果为(没有 include 参数)：
      ```
      {
          "data": [
              {
                  "id": 8,
                  "user_id": 9,
                  "topic_id": 1,
                  "content": "Quos tempora cupiditate qui voluptate incidunt esse.",
                  "created_at": "2020-06-30 02:37:43",
                  "updated_at": "2020-06-30 02:37:43"
              },
              ...
          ],
          "links": {
              "first": "http://laravel3.0.test/api/v1/topics/1/replies?page=1",
              "last": "http://laravel3.0.test/api/v1/topics/1/replies?page=2",
              "prev": null,
              "next": "http://laravel3.0.test/api/v1/topics/1/replies?page=2"
          },
          "meta": {
              "current_page": 1,
              "from": 1,
              "last_page": 2,
              "path": "http://laravel3.0.test/api/v1/topics/1/replies",
              "per_page": 15,
              "to": 15,
              "total": 24
          }
      }
      ```
  - 1.4 [调整 Include 参数 (继承QueryBuilder)](https://learnku.com/courses/laravel-advance-training/6.x/reply-list/5727#05c0f4)  
    - 1.4.1 新建一个 ReplyQuery（）
      ```
      $ touch app/Http/Queries/ReplyQuery.php
      ```
    - 1.4.2 编辑 app/Http/Queries/ReplyQuery.php
      ```
      <?php

      namespace App\Http\Queries;

      use App\Models\Reply;
      use Spatie\QueryBuilder\QueryBuilder;
      use Spatie\QueryBuilder\AllowedFilter;

      class ReplyQuery extends QueryBuilder
      {
          public function __construct()
          {
              // parent 指的是 QueryBuilder
              // Reply::query() 是 Reply 模型的查询构建器
              // 词句表示：构建了一个 Reply 模型的查询构建器
              parent::__construct(Reply::query());

              $this->allowedIncludes('user', 'topic');
          }
      }
      ```
      - Reply::query() 是 Reply 模型的查询构建器
      - ReplyQuery 继承 QueryBuilder，它们都是查询构建器。
      - `parent::__construct(Reply::query());` 其中 parent 指 QueryBuilder，执行__construct() 构造一个 Reply 的查询构建器。
      - 在 ReplyQuery 中封装QueryBuilder，在其中设置include参数
    - 1.4.3 修改控制器 app/Http/Controllers/Api/RepliesController.php
      ```
      use App\Http\Queries\ReplyQuery;
      ...
        public function index($topicId, ReplyQuery $query)
        {
            $replies = $query->where('topic_id', $topicId)->paginate();

            return ReplyResource::collection($replies);
        }
      ```
    - 1.4.4 修改 app/Http/Resources/ReplyResource.php
      ```
      public function toArray($request)
      {
          return [
              'id' => $this->id,
              'user_id' => (int) $this->user_id,
              'topic_id' => (int) $this->topic_id,
              'content' => $this->content,
              'created_at' => (string) $this->created_at,
              'updated_at' => (string) $this->updated_at,
              'user' => new UserResource($this->whenLoaded('user')),
              'topic' => new TopicResource($this->whenLoaded('topic')),
          ];
      }
      ```
  - 1.5 测试：增加 include=user 再次测试话题的回复列表
    - GET http://{{host}}/api/v1/topics/:id/replies?include=user
    - 结果为包含了用户信息：
      ```
      {
          "data": [
              {
                  "id": 8,
                  "user_id": 9,
                  "topic_id": 1,
                  "content": "Quos tempora cupiditate qui voluptate incidunt esse.",
                  "created_at": "2020-06-30 02:37:43",
                  "updated_at": "2020-06-30 02:37:43",
                  "user": {
                      "id": 9,
                      "name": "Gavin Torphy",
                      "email_verified_at": "2020-07-27 19:01:50",
                      "created_at": "1979-05-27 15:51:12",
                      "updated_at": "1979-05-27 15:51:12",
                      "avatar": "https://cdn.learnku.com/uploads/images/201710/14/1/NDnzMutoxX.png",
                      "introduction": "Est est excepturi totam facilis quae qui omnis.",
                      "notification_count": 0,
                      "last_actived_at": "1979-05-27T07:51:12.000000Z",
                      "bound_phone": false,
                      "bound_wechat": false
                  }
              },
              ...
      ``` 
- 2.某个用户的回复列表
  - 2.1 添加路由 routes/api.php 
    ```
    // 话题回复列表
    Route::get('topics/{topic}/replies', 'RepliesController@index')
        ->name('topics.replies.index');
    // 某个用户的回复列表
    Route::get('users/{user}/replies', 'RepliesController@userIndex')
        ->name('users.replies.index');
    ```
  - 2.2 修改 app/Http/Controllers/Api/RepliesController.php
    ```
    public function userIndex($userId, ReplyQuery $query)
    {
        $replies = $query->where('user_id', $userId)->paginate();

        return ReplyResource::collection($replies);
    }
    ```
  - 2.3 测试某个用户的回复列表
    - GET http://{{host}}/api/v1/users/:id/replies?include=topic
    - 结果：
      ```
      {
          "data": [
              {
                  "id": 16,
                  "user_id": 2,
                  "topic_id": 93,
                  "content": "Illo eum maiores aut recusandae fuga fugit sequi.",
                  "created_at": "2020-07-16 14:55:02",
                  "updated_at": "2020-07-16 14:55:02",
                  "topic": {
                      "id": 93,
                      "title": "Velit omnis esse atque molestias et et animi.",
                      "body": "Eius eos illo ipsam odit voluptatibus. Hic earum expedita aspernatur necessitatibus. Itaque voluptate esse nulla. Repellendus tenetur nesciunt accusamus voluptatem ut nisi excepturi.",
                      "user_id": 3,
                      "category_id": 4,
                      "reply_count": 0,
                      "view_count": 0,
                      "last_reply_user_id": 0,
                      "order": 0,
                      "excerpt": "Velit omnis esse atque molestias et et animi.",
                      "slug": null,
                      "created_at": "2020-07-02 21:34:02",
                      "updated_at": "2020-07-19 15:33:48"
                  }
              },
      ```
- 3.Git 版本控制
  ```
  git add -A
  git commit -m '7.3 回复列表'
  ```
### 7.4 [消息通知列表](https://github.com/andy-love-coding/laravel3.0#%E7%9B%AE%E5%BD%95)
- 1.增加路由 routes/api.php
  ```
  // 删除回复
  Route::delete('topics/{topic}/replies/{reply}', 'RepliesController@destroy')
      ->name('topics.replies.destroy');
  // 通知列表
  Route::get('notifications', 'NotificationsController@index')
      ->name('notifications.index');
  ```
- 2.增加 NotificationResource
  ```
  $ php artisan make:resource NotificationResource
  ```
  app/Http/Resources/NotificationResource.php
  ```
  public function toArray($request)
  {
      return[
          'id' => $this->id,
          'type' => $this->type,
          'data' => $this->data,
          'read_at' => (string) $this->read_at ?: null,
          'created_at' => (string) $this->created_at,
      ];
  }
  ```
- 3.增加 NotificationsController
  ```
  $ php artisan make:controller Api/NotificationsController
  ```
  app/Http/Controllers/Api/NotificationsController.php
  ```
  <?php

  namespace App\Http\Controllers\Api;

  use Illuminate\Http\Request;
  use App\Http\Resources\NotificationResource;

  class NotificationsController extends Controller
  {
      public function index(Request $request)
      {
          $notifications = $request->user()->notifications()->paginate();

          return NotificationResource::collection($notifications);
      }
  }
  ```
  - 用户模型的 notifications() 方法是 Notifiable Trait 为我们提供的方法，按通知创建时间倒叙排序。
- 4.测试消息通知列表
  - GET http://{{host}}/api/v1/notifications  
    - 需登录 Header(Authorization)
  - 结果为：
    ```
    {
        "data": [
            {
                "id": "e14b893c-ecaf-4ede-9a96-4e73323920f2",
                "type": "App\\Notifications\\TopicReplied",
                "notifiable_type": "App\\Models\\User",
                "notifiable_id": 1,
                "data": {
                    "reply_id": 1012,
                    "reply_content": "<p>reply113</p>",
                    "user_id": 8,
                    "user_name": "TrystanLehner",
                    "user_avatar": "https://cdn.learnku.com/uploads/images/201710/14/1/ZqM7iaP4CR.png",
                    "topic_link": "http://laravel3.0.test/topics/1/a-expedita-alias-eum-consequuntur-ducimus-qui-natus-at?#reply1012",
                    "topic_id": 1,
                    "topic_title": "A expedita alias eum consequuntur ducimus qui natus at."
                },
                "read_at": null,
                "created_at": "2020-07-29 14:48:45",
                "updated_at": "2020-07-29 14:48:45"
            },
            ...
        ],
        "links": {
            "first": "http://laravel3.0.test/api/v1/notifications?page=1",
            "last": "http://laravel3.0.test/api/v1/notifications?page=1",
            "prev": null,
            "next": null
        },
        "meta": {
            "current_page": 1,
            "from": 1,
            "last_page": 1,
            "path": "http://laravel3.0.test/api/v1/notifications",
            "per_page": 15,
            "to": 11,
            "total": 11
        }
    }
    ```
- 5.Git 版本控制
  ```
  git add -A
  git commit -m '7.4 消息通知列表'
  ```
### 7.5 [未读消息统计](https://github.com/andy-love-coding/laravel3.0#%E7%9B%AE%E5%BD%95)
- 1.增加路由 routes/api.php
  ```
  // 通知列表
  Route::get('notifications', 'NotificationsController@index')
      ->name('notifications.index');
  // 通知统计
  Route::get('notifications/stats', 'NotificationsController@stats')
      ->name('notifications.stats');
  ```
  - stats 是 statistics 的缩写，意思是统计
- 2.修改 app/Http/Controllers/Api/NotificationsController.php
  ```
  public function stats(Request $request)
  {
      return response()->json([
          'unread_count' => $request->user()->notification_count,
      ]);
  }
  ```
  - User 模型中 notify() 方法会将 notification_count 进行 +1。所以 $this->user()->notification_count; 就是用户未读消息数。
- 3.测试未读消息统计
  - GET http://{{host}}/api/v1/notifications/stats  
    - 需登录 Header(Authorization)
  - 结果为：200 OK
    ```
    {
        "unread_count": 12
    }
    ```
- 4.Git 版本控制
  ```
  git add -A
  git commit -m '7.5 消息通知统计'
  ```
### 7.6 [标记通知为已读](https://github.com/andy-love-coding/laravel3.0#%E7%9B%AE%E5%BD%95)
- 1.增加路由 routes/api.php
  ```
  // 通知统计
  Route::get('notifications/stats', 'NotificationsController@stats')
      ->name('notifications.stats');
  // 标记消息通知为已读
  Route::patch('user/read/notifications', 'NotificationsController@read')
      ->name('user.notifications.read');
  ```
- 2.修改 app/Http/Controllers/Api/NotificationsController.php
  ```
  public function read(Request $request)
  {
      $request->user()->markAsRead();

      return response(null, 204);
  }
  ```
  - markAsRead() 在 app\Models\User.php 中有定义：
    ```
    public function markAsRead()
    {
        $this->notification_count = 0;
        $this->save();
        $this->unreadNotifications->markAsRead();
    }
    ```
- 3.测试：将用户所有消息标记为已读
  - PATCH http://{{host}}/api/v1/user/read/notifications
    - 需登录 Header(Authorization)
  - 结果为：204 No Content
- 4.Git 版本控制
  ```
  git add -A
  git commit -m '7.6 标记消息为已读'
  ```
## 8 [权限控制](https://github.com/andy-love-coding/laravel3.0#%E7%9B%AE%E5%BD%95)
### 8.2 [权限列表](https://github.com/andy-love-coding/laravel3.0#%E7%9B%AE%E5%BD%95)
- 0.权限列表
  - 客户端可以在用户登录成功之后，请求 权限列表接口，缓存在本地，渲染页面的时候，根据用户权限，以及用户与资源的关系，来完成对页面显示的控制。
  - 将用户权限请求后缓存在本地会不会引入安全问题呢？
    - 我们知道客户端的一切都是可以通过某种途径修改的，例如反编译 APP 后，修改代码，将某个用户权限修改为站长拥有的所有权限。这样是不是就代表用户可以修改或删除所有的话题了呢？
    - 其实不是的，客户端缓存的权限列表，只是用于控制界面显示。数据的操作权限是在服务器端，接口服务器在执行某个操作时，始终会判断用户权限。例如 TopicsController 中的代码：
      ```
      public function update(TopicRequest $request, Topic $topic)
      {
          $this->authorize('update', $topic);

          $topic->update($request->all());
          return new TopicResource($topic);
      }
      ```
      authorize() 会找到 app/Policies/TopicPolicy.php
      ```
      public function update(User $user, Topic $topic)
      {
          return $user->isAuthorOf($topic);
      }
      ```
      并且在这之前，还好判断基类授权策略：app/Policies/Policy.php
      ```
      public function before($user, $ability)
      {
            // 如果用户拥有管理内容权限的话，即授权通过
            if ($user->can('manage_contents')) {
                return true;
            }
      }
      ```
      所以：只要调用了 authorize() 授权策略，都会在服务端判断用户是否有权限；并不会接收客户端传过来的权限，客户端缓存的权限只用作客户端页面显示而已。
- 1.添加路由 routes/api.php
  ```
  // 标记消息通知为已读
  Route::patch('user/read/notifications', 'NotificationsController@read')
      ->name('user.notifications.read');
  // 当前登录用户权限
  Route::get('user/permissions', 'PermissionsController@index')
      ->name('user.permissions.index');
  ```
- 2.增加 PermissionResource
  ```
  $ php artisan make:resource PermissionResource
  ```
  app/Http/Resources/PermissionResource.php
  ```
  public function toArray($request)
  {
      return [
          'id' => $this->id,
          'name' => $this->name,
      ];
  }
  ```
- 3.增加 PermissionsController
  ```
  $ php artisan make:controller Api/PermissionsController
  ```
  app/Http/Controllers/Api/PermissionsController.php
  ```
  public function index(Request $request)
  {
      $permissions = $request->user()->getAllPermissions();

      PermissionResource::wrap('data');
      return PermissionResource::collection($permissions);
  }
  ```
- 4.测试权限列表
  - GET http://{{host}}/api/v1/user/permissions
    - 需登录 Header(Authorization)
  - 结果为：
    ```
    {
        "data": [
            {
                "id": 1,
                "name": "manage_contents"
            },
            {
                "id": 2,
                "name": "manage_users"
            },
            {
                "id": 3,
                "name": "edit_settings"
            }
        ]
    }
    ```
- 5.Git 版本控制
  ```
  git add -A
  git commit -m '8.2 用户权限列表'
  ```
### 8.3 [显示用户角色](https://github.com/andy-love-coding/laravel3.0#%E7%9B%AE%E5%BD%95)
- 1.增加 RoleResource
  ```
  $ php artisan make:resource RoleResource
  ```
  app/Http/Resources/RoleResource.php
  ```
  public function toArray($request)
  {
      return [
          'id' => $this->id,
          'name' => $this->name,
      ];
  }
  ```
- 2.修改 UserResource  
  app/Http/Resources/UserResource.php
  ```
  public function toArray($request)
  {
      if (!$this->showSensitiveFields) {
          $this->resource->addHidden(['phone', 'email']);
      }

      $data = parent::toArray($request);

      $data['bound_phone'] = $this->resource->phone ? true : false;
      $data['bound_wechat'] = ($this->resource->weixin_unionid || $this->resource->weixin_openid) ? true : false;
      $data['roles'] = RoleResource::collection($this->whenloaded('roles'));
      // dd($this); // 可得知 $this->resource 就是一个 User 模型实例

      return $data;
  }
  ```
- 3.修改 UsersController，时 users.show 包含角色
  app/Http/Controller/Api/UsersController.php
  ```
  // public function show(User $user, Request $request)
  public function show($userId, Request $request)
  {
      // return new UserResource($suer);
      $user = QueryBuilder::for(User::class)
          ->allowedIncludes('roles')
          ->findOrFail($userId);
      return new UserResource($user);
  }
  ```
- 4.测试某个用户信息包含角色
  - GET http://{{host}}/api/v1/users/:id?include=roles
  - 结果为：
    ```
    {
        "id": 1,
        "name": "andy",
        "email_verified_at": "2020-07-27 19:01:50",
        "created_at": "1972-04-23 05:28:59",
        "updated_at": "2020-07-29 20:59:00",
        "avatar": "http://laravel3.0.test/uploads/images/topics/202007/28/1_1595919513_7DrP0smiFX.jpg",
        "introduction": "Vel quia vel excepturi possimus.",
        "notification_count": 0,
        "last_actived_at": "1972-04-22T21:28:59.000000Z",
        "roles": [
            {
                "id": 1,
                "name": "Founder"
            }
        ],
        "bound_phone": false,
        "bound_wechat": false
    }
    ```
- 5.提炼抽象出 TopicQuery
  - 5.1 新建封装TopicQuery
    ```
    touch app/Http/Queries/TopicQuery.php
    ```
    app/Http/Queries/TopicQuery.php
    ```
    <?php

    namespace App\Http\Queries;

    use App\Models\Topic;
    use Spatie\QueryBuilder\QueryBuilder;
    use Spatie\QueryBuilder\AllowedFilter;

    class TopicQuery extends QueryBuilder
    {
        public function __construct()
        {
          parent::__construct(Topic::query());

          $this->allowedIncludes('user', 'user.roles', 'category')
                ->allowedFilters([
                    'title',
                    AllowedFilter::exact('category_id'),
                    AllowedFilter::scope('withOrder')->default('recentReplied'),
                ]);
        }
    }
    ```
    - TopicQuery 继承了 QueryBuilder，并设置好了 include 和 filter 参数
  - 5.2 修改 app/Http/Controllers/Api/TopicsController.php
    ```
    public function index(Request $request, Topic $topic, TopicQuery $query)
    {
        // $query 是 Topic 模型的查询构建器
        // $query = $topic->query();

        // if ($categoryId = $request->category_id) {
        //     $query->where('category_id', $categoryId);
        // }

        // $topics = $query
        //         ->with('user', 'category') // 预加载
        //         ->withOrder($request->order)
        //         ->paginate(20);

        // $topics = QueryBuilder::for(Topic::class)
        //     ->allowedIncludes('user', 'user.roles','category')
        //     ->allowedFilters([
        //         'title',
        //         AllowedFilter::exact('category_id'),
        //         AllowedFilter::scope('withOrder')->default('recentReplied'),
        //     ])
        //     ->paginate();

        $topics = $query->paginate();
        
        return TopicResource::collection($topics);
    }

    public function userIndex(Request $request, User $user, TopicQuery $query)
    {
        // $query = $user->topics()->getQuery();

        // $topics = QueryBuilder::for($query)
        //     ->allowedIncludes('user','user.roles', 'category')
        //     ->allowedFilters([
        //         'title',
        //         AllowedFilter::exact('category_id'),
        //         AllowedFilter::scope('withOrder')->default('recentReplied'),
        //     ])
        //     ->paginate();
        
        $topics = $query->where('user_id', $user->id)->paginate();

        return TopicResource::collection($topics);
    }

    public function show($topicId, TopicQuery $query)
    {
        // $topic = QueryBuilder::for(Topic::class)
        //     ->allowedIncludes('user', 'category')
        //     ->findOrFail($topicId);

        $topic = $query->findOrFail($topicId);
        return new TopicResource($topic);
    }
    ```
- 6.测试：话题嵌套用户，用户嵌套角色
  - 话题列表：GET http://{{host}}/api/v1/topics?include=user.roles,category
  - 个人话题列表：GET http://{{host}}/api/v1/users/:id/topics?include=user.roles,category
  - 话题详情：GET http://{{host}}/api/v1/topics/:id?include=user.roles,category
  - 其结果都包含角色信息（话题-用户-角色：三级嵌套）
    ```
    {
        "id": 1,
        "title": "A expedita alias eum consequuntur ducimus qui natus at.",
        "body": "<p>Illo hic laudantium quibusdam. Culpa incidunt accusamus nemo cum id deleniti earum sunt. Laborum eos non qui nemo. Omnis pariatur suscipit non nostrum.</p>",
        "user_id": 1,
        "category_id": 2,
        "reply_count": 24,
        "view_count": 0,
        "last_reply_user_id": 0,
        "order": 0,
        "excerpt": "Illo hic laudantium quibusdam. Culpa incidunt accusamus nemo cum id deleniti earum sunt. Laborum eos non qui nemo. Omnis pariatur suscipit non nostrum.",
        "slug": "a-expedita-alias-eum-consequuntur-ducimus-qui-natus-at",
        "created_at": "2020-07-03 07:33:03",
        "updated_at": "2020-07-29 14:48:44",
        "user": {
            "id": 1,
            "name": "andy",
            "email_verified_at": "2020-07-27 19:01:50",
            "created_at": "1972-04-23 05:28:59",
            "updated_at": "2020-07-29 20:59:00",
            "avatar": "http://laravel3.0.test/uploads/images/topics/202007/28/1_1595919513_7DrP0smiFX.jpg",
            "introduction": "Vel quia vel excepturi possimus.",
            "notification_count": 0,
            "last_actived_at": "1972-04-22T21:28:59.000000Z",
            "roles": [
                {
                    "id": 1,
                    "name": "Founder"
                }
            ],
            "bound_phone": false,
            "bound_wechat": false
        },
        "category": {
            "id": 2,
            "name": "教程",
            "description": "开发技巧、推广扩展包等",
            "post_count": 0
        }
    }
    ```
- 7.Git 版本控制
  ```
  $ git add -A
  $ git commit -m '8.3 显示用户角色 封装TopicQuery'
  ```
## 9 [其他功能](https://github.com/andy-love-coding/laravel3.0#%E7%9B%AE%E5%BD%95)
### 9.1 [资源推荐接口](https://github.com/andy-love-coding/laravel3.0#%E7%9B%AE%E5%BD%95)
- 1.添加路由(游客可访问) routes/api.php
  ```
  // 某个用户的回复列表
  Route::get('users/{user}/replies', 'RepliesController@userIndex')
      ->name('users.replies.index');
  // 资源推荐
  Route::get('links', 'LinksController@index')
      ->name('links.index');
  ```
- 2.添加 LinkResource
  ```
  $ php artisan make:resource LinkResource
  ```
  app/Http/Resources/LinkResource.php
  ```
  public function toArray($request)
  {
      return [
          'id' => $this->id,
          'title' => $this->title,
          'link' => $this->link,
      ];
  }
  ```
- 3.添加 LinksController
  ```
  $ php artisan make:controller Api/LinksController
  ```
  app/Http/Controllers/Api/LinksController.php
  ```
  public function index(Link $link)
  {
      $links = $link->getAllCached();

      LinkResource::wrap('data');
      return LinkResource::collection($links);
  }
  ```
- 4.测试获取资源推荐列表
  - GET http://{{host}}/api/v1/links
- 5.Git 版本控制
  ```
  git add -A
  git commit -m "9.1 推荐资源列表"
  ```
### 9.2 [活跃用户接口](https://github.com/andy-love-coding/laravel3.0#%E7%9B%AE%E5%BD%95)
- 1.添加路由(游客可访问) routes/api.php
  ```
  // 资源推荐
  Route::get('links', 'LinksController@index')
      ->name('links.index');
  // 活跃用户
  Route::get('actived/users', 'UsersController@activedIndex')
      ->name('actived.users.index');
  ```
- 2.修改 app/Http/Controllers/Api/UsersController.php
  ```
  public function activedIndex(User $user)
  {
      UserResource::wrap('data');
      return UserResource::collection($user->getActiveUsers());
  }
  ```
- 3.测试：活跃用户列表
  - GET http://{{host}}/api/v1/actived/users
- 4.Git版本控制
  ```
  $ git add -A
  $ git commit -m '9.2 活跃用户'
  ```
### 9.3 [本地化](https://github.com/andy-love-coding/laravel3.0#%E7%9B%AE%E5%BD%95)
- 1.什么是本地化
  - 这一节我们来实现接口的本地化。本地化主要的是客户端的工作，切换语言后，客户端显示不同的界面，例如下面就是微信 中文 和 英文 语言下的界面。
- 2.本地化交给客户端(响应中添加自定义 code)
  - 2.1 错误响应增加 code 参数
    - 原来的 convertExceptionToArray() 方法中没有 code(即自定义错误码)，代码如下：  
      vendor/laravel/framework/src/Illuminate/Foundation/Exceptions/Handler.php
      ```
      protected function convertExceptionToArray(Exception $e)
      {
          return config('app.debug') ? [
              'message' => $e->getMessage(),
              'exception' => get_class($e),
              'file' => $e->getFile(),
              'line' => $e->getLine(),
              'trace' => collect($e->getTrace())->map(function ($trace) {
                  return Arr::except($trace, ['args']);
              })->all(),
          ] : [
              'message' => $this->isHttpException($e) ? $e->getMessage() : 'Server Error',
          ];
      }
      ```
    - 现在，在 app/Exceptions/Handler.php 中重写 convertExceptionToArray 方法，加入 code 参数  
      app/Exceptions/Handler.php
      ```
      use Illuminate\Support\Arr;
      ...
        protected function convertExceptionToArray(Exception $e)
        {
            return config('app.debug') ? [
                'message' => $e->getMessage(),
                'code' => $e->getCode(), // 加入 code 参数
                'exception' => get_class($e),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => collect($e->getTrace())->map(function ($trace) {
                    return Arr::except($trace, ['args']);
                })->all(),
            ] : [
                'message' => $this->isHttpException($e) ? $e->getMessage() : 'Server Error',
                'code' => $e->getCode(),
            ];
        }
      ```
  - 2.2 进行封装（基类控制器中封装带 code 的异常的响应方法 errorResponse()）
    - 在 API 的基类控制器中：抛出异常，并且增加 code ，响应中就会自动增加 code。  
      app/Http/Controllers/Api/Controller.php
      ```
      <?php

      namespace App\Http\Controllers\Api;

      use Illuminate\Http\Request;
      use App\Http\Controllers\Controller as BaseController;
      use Symfony\Component\HttpKernel\Exception\HttpException;

      class Controller extends BaseController
      {
          public function errorResponse($statusCode, $message=null, $code=0)
          {
              throw new HttpException($statusCode, $message, null, [], $code);
          }
      }
      ```
      - 现在任意 API 控制器中直接使用 $this->errorResponse 抛出异常即可。
  - 2.3 添加测试代码
    - 测试代码：在 `发布话题` 接口的代码中增加下面的测试代码:  
      app/Http/Controllers/Api/TopicsController.php
      ```
      public function store(TopicRequest $request, Topic $topic)
      {
          return $this->errorResponse(403, '您还没有通过认证', 1003);
      ```
    - PostMan 请求：POST http://{{host}}/api/v1/topics
      - 需登录 Header(Authorization)
      - Body (form-data)
        ```
        title: title-test
        body: body-test
        category_id: 1
        ```
      - 结果为：
        ```
        {
            "message": "您还没有通过认证",
            "code": 1003,
            "exception": "Symfony\\Component\\HttpKernel\\Exception\\HttpException",
            "file": "/home/vagrant/Code/laravel3.0/app/Http/Controllers/Api/Controller.php",
            "line": 13,
            "trace":[]
        }
        ```
    - 测试完，还原测试代码
      ```
      $ git checkout app/Http/Controllers/Api/TopicsController.php
      ```
- 3.接口根据客户端语言切换错误信息
  - 3.0 客户端需要在每次请求接口的时候增加参数，告诉接口支持的语言，可以利用 HTTP 的 Accept-Language 头信息。
    - Accept-Language zh-CN —— 简体中文
    - Accept-Language en —— 英文
  - 3.1 增加中间件 middleware
    ```
    $ php artisan make:middleware ChangeLocale
    ```
    app/Http/Middleware/ChangeLocale.php
    ```
    public function handle($request, Closure $next)
    {
        $language = $request->header('accept-language');
        if ($language) {
            \App::setLocale($language);
        }

        return $next($request);
    }
    ```
  - 3.2 注册中间件 app/Http/Kernel.php
    ```
    protected $routeMiddleware = [
        ...
        // 接口语言设置中间件
        'change-locale' => \App\Http\Middleware\ChangeLocale::class,
    ];
    ```
  - 3.3 给所有 API 路由用上中间件
    ```
    Route::prefix('v1')
        ->namespace('Api')
        ->middleware('change-locale')
        ->name('api.v1.')
        ->group(function () {
    ```
  - 3.4 测试
    - 默认语言是简体中文：config/app.php 中设置了默认的语言为'locale' => 'zh-CN'
    - 请求登录接口：http://{{host}}/api/v1/authorizations
      - 情况一：不要 `accept-language` ，头密码只填3位，结果为 422 Unprocessable Entity
        ```
        {
            "message": "The given data was invalid.",
            "errors": {
                "password": [
                    "密码 至少为 6 个字符。"
                ]
            }
        }
        ```
      - 情况二：增加 `accept-language` 头，值为 `en` ，密码只填3位，结果为 422 Unprocessable Entity
        ```
        {
            "message": "The given data was invalid.",
            "errors": {
                "password": [
                    "The password must be at least 6 characters."
                ]
            }
        }
        ```
      - 情况三：增加 `accept-language` 头，值为 `en` ，密码只填错误的6位，结果为 401 Unauthorized
        ```
        {
            "message": "用户名或密码错误"
        }
        ```
  - 3.5.使用 trans() 方法
    - 3.5.1 发现：测试的情况三，增加了 `accept-language` 头，值为 `en`，但没有被本地化，原因看一下代码：  
      app/Http/Controllers/Api/AuthorizationsController.php
      ```
      if (!$token = \Auth::guard('api')->attempt($credentials)) {
          throw new AuthenticationException('用户名或密码错误');
      }
      ```
      因为直接使用了中文错误信息，可以用 trans() 方法
      ```
      if (!$token = \Auth::guard('api')->attempt($credentials)) {
          throw new AuthenticationException(trans('auth.failed'));
      }
      ```
    - 3.5.2 接着 3.4 小节再测试
      - 情况四：增加 `accept-language` 头，值为 `en` ，密码只填错误的6位，结果为 401 Unauthorized
        ```
        {
            "message": "These credentials do not match our records."
        }
        ```
      - 情况五：不要 `accept-language` 头，密码只填错误的6位，结果为 401 Unauthorized
        ```
        {
            "message": "用户名或密码错误"
        }
        ```
- 4.Git 版本控制
  ```
  $ git add -A
  $ git commit -m '9.3 本地化 trans()方法'
  ```
### 9,4 [消息推送](https://github.com/andy-love-coding/laravel3.0#%E7%9B%AE%E5%BD%95)
- 1.[极光推送](https://learnku.com/courses/laravel-advance-training/6.x/message-push/5739#bc4e8c)
## 10 [API 测试和文档](https://github.com/andy-love-coding/laravel3.0#%E7%9B%AE%E5%BD%95)
### 10.1 API 自动化测试介绍
- 1.[自动化测试介绍](https://learnku.com/courses/laravel-advance-training/6.x/introduction-of-api-automation-test/5741)
### 10.2 Laravel API 集成测试
- 1.[API 集成测试(PHPUnit)](https://learnku.com/courses/laravel-advance-training/6.x/laravel-api-integration-test/5742)
### 10.3 第三方黑盒测试
- 1.[第三方黑盒测试（PostMan）](https://learnku.com/courses/laravel-advance-training/6.x/third-party-black-box-test/5743)
### 10.4 API 文档工具
- 1.[PostMan、Apizza](https://learnku.com/courses/laravel-advance-training/6.x/api-document/5744)
## 11 [Oauth 认证--Passport](https://github.com/andy-love-coding/laravel3.0#%E7%9B%AE%E5%BD%95)
- 1.[Oatuh2.0认证：Passport实现](https://learnku.com/courses/laravel-advance-training/6.x/passport-introduction/5746)