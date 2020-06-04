<?php

namespace App\Observers;

use App\Models\Topic;
// use App\Handlers\SlugTranslateHandler;
use App\Jobs\TranslateSlug;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class TopicObserver
{
    // 数据写入数据库之前
    public function saving(Topic $topic)
    {
        // XSS过滤：使用「HTMLPurifier扩展」的 clean() 方法过滤用户提交内容，第二个参数是 config/purifier 中的配置项
        $topic->body = clean($topic->body, 'user_topic_body');

        // 生成话题摘录
        $topic->excerpt = make_excerpt($topic->body);
        
    }

    public function saved(Topic $topic)
    {
        // 如 slug 字段无内容，即使用翻译器对 title 进行翻译
        if ( ! $topic->slug) {
            // $topic->slug = app(SlugTranslateHandler::class)->translate($topic->title);

            // 模型观察器 分发任务 到队列。
            // 模型观察器分发任务，任务handle()中不能再有模型操作，否则又会触发模型观察器分发任务，从而进入死循环
            dispatch(new TranslateSlug($topic));
        }
    }
}