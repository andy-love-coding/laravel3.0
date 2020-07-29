## 2 舞台布置
### 2.2 安装 LaraBBS
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
### 2.5 Github 的 Restful HTTP API 设计分解
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
### 2.7. API 基础环境
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
## 3 手机注册
### 3.1 手机注册流程讲解
  - 1.[手机注册流程讲解](https://learnku.com/courses/laravel-advance-training/6.x/explanation-of-mobile-registration-process/5701)
### 3.2 短信提供商
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
### 3.3 手机注册验证码
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
### 3.4 构建用户注册接口
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
### 3.5 节流处理防止攻击
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
### 3.6 图片验证码
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
## 4 第三方登录
### 4.1 微信登录流程讲解
- [OAutho 2.0 流程分析](https://learnku.com/courses/laravel-advance-training/6.x/process-explanation/5708)
### 4.2 微信开发者账号申请
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
### 4.3 微信登录
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
### 4.4 微信登录功能开发
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
### 4.5 登录 API 获取 JWT 令牌
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
### 4.6 artisan 生成 token
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
## 5 用户数据
### 5.1 获取用户信息
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
### 5.2 编辑用户信息
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
## 6 帖子数据
### 6.1 分类列表
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
### 6.2 发布话题
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
### 6.3 修改话题
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
### 6.4 删除话题
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
### 6.5 话题列表
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
### 6.6 话题详情
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
- 4.测试「不适用路由模型绑定」的话题详情
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
## 7 回复数据
### 7.1 话题回复
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
