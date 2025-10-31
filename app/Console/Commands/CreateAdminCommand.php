<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateAdminCommand extends Command
{
    protected $signature = 'admin:create';
    protected $description = 'Create admin user if not exists';

    public function handle()
    {
        $this->call('db:seed', ['--class' => 'AdminUserSeeder']);
    }
}
