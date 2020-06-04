<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Models\Topic;
use App\Handlers\SlugTranslateHandler;

class TranslateSlug implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $topic;

    // 构造函数用来接收 类初始化时的参数，这个参数可有可无，视业务需要而定
    public function __construct(Topic $topic)
    {        
        // 如果这个参数是 Eloquent 模型，SerializesModels 将会只序列化模型的 ID，执行job的时候，再根据 ID 从数据库检查出模型实例
        $this->topic = $topic;
    }

    // handle 方法会在队列任务执行时被调用，调用方法如：dispatch(new TranslateSlug($topic));
    public function handle()
    {
        // 请求百度 API 接口进行翻译
        $slug = app(SlugTranslateHandler::class)->translate($this->topic->title);

        // 如果将来是在模型观察器中「分发job任务」
        // 为了避免模型监控器「死循环调用」，任务里不能再有模型的操作，我们使用 DB 类直接对数据库进行操作
        // 否则会陷入调用死循环 —— 模型监控器分发任务，任务触发模型监控器，模型监控器再次分发任务，任务再次触发模型监控器…. 死循环
        \DB::table('topics')->where('id', $this->topic->id)->update(['slug' => $slug]);       
    }
}
