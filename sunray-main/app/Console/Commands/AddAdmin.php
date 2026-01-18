<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Admin;

class AddAdmin extends Command
{
    protected $signature = 'admin:add {name} {email} {password}'; // Bắt đầu với các tham số
    protected $description = 'Thêm một admin mới vào cơ sở dữ liệu';

    public function handle()
    {
        $name = $this->argument('name');
        $email = $this->argument('email');
        $password = bcrypt($this->argument('password'));

        Admin::create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ]);
        
        $this->info('Admin đã được thêm thành công!');
    }
}