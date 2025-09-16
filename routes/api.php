<?php

use App\Http\Controllers\SmsController;
use App\Models\Sms;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Http\Request as req;
use Illuminate\Support\Facades\DB;


Route::post('/createsms', [SmsController::class, 'smsCreateApi']);

Route::post('/newuser', function (req $request) {
    $secretKey = $request->header('secret_key');
    // dd($request);
    if ($secretKey) {
        $uuid = Str::uuid()->toString();
        $user = new User();
        $user->fname = $request->name;
        $user->secret_key = $uuid;
        $user->isadmin = $request->isadmin;
        $user->save();
        return response('user added succsesfully');
    }
    return response('invalid data!!');
});
