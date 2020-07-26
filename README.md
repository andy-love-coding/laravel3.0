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
## 手机注册
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
        'key' => 'phone',
        'value' => '185....1234',
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