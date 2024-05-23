<?php

namespace App\Console\Commands;

use App\Models\Admin;
use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UpdateAdminPassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:update-password {email} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the password of the admin user';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $email = $this->argument('email');
        $password = $this->argument('password');

        $admin = Admin::where('email', $email)->first();

        if ($admin) {
            $admin->password = Hash::make($password);
            $admin->save();
            $this->info('Password updated successfully.');
        } else {
            $this->error('Admin user not found.');
        }

        return 0;
    }
}
