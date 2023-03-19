<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class CreateVendor extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:vendor';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new vendor';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->ask('What is your name?');
        $email = $this->ask('What is your email?');
        $password = $this->ask('What is your password','password');
        $confirmation = $this->ask('Please confirm your password','password');
        if ($password !== $confirmation) {
            $this->error('Passwords do not match');
            return Command::FAILURE;
        }
        if (User::where('email', $email)->exists()) {
            $this->error('Email already exists. Please use another email');
            return Command::FAILURE;
        }
        if (file('.env') == false){
            $this->error('File .env not found. Please create it first');
            return Command::FAILURE;
        }
        $user = new User();
        $user->name = $name;
        $user->email = $email;
        $user->password = Hash::make($password);
        $user->address = fake()->address;
        $user->role = 2;
        $user->save();
        $this->info('Vendor created successfully');
        return Command::SUCCESS;
    }
}
