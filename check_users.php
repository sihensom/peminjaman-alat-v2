<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

echo "--- User Check ---\n";
$users = User::all();
echo "Count: " . $users->count() . "\n";
foreach ($users as $user) {
    echo "ID: {$user->id} | Email: {$user->email} | Role: {$user->role} | Password Check: " . (Hash::check('password', $user->password) ? 'OK' : 'FAIL') . "\n";
}
