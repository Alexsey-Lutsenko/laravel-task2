<?php

namespace App\Http\Controllers\User\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;

class CreateAdminController extends Controller
{
    public function __invoke()
    {
        $isNotAdmin = isset(User::where('email', 'admin@admin.com')->get()[0]->name) == false;

        if($isNotAdmin) {
            Artisan::call('db:seed --class=AdminSeeder');
        }

        $user = User::where('email', 'admin@admin.com')->get();

        return response()->json(['data'=> ['email' => $user[0]->email, 'password' => 'password', 'id' => $user[0]->id]], 200);
    }
}
