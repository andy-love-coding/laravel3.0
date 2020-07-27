<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class GenerateToken extends Command
{

    protected $signature = 'larabbs:generate-token';

    protected $description = '快速生成用户 token';

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

        // 一年后过期
        $ttl = 60 * 24 * 365;
        $this->info(auth('api')->setTTL($ttl)->login($user));
    }
}
