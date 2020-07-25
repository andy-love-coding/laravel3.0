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