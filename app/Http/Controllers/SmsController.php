<?php

namespace App\Http\Controllers;

use App\Models\Sms;
use App\Models\User;
use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\New_;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Route;
use Morilog\Jalali\Jalalian;
use Illuminate\Support\Facades\DB;
use App\Jobs\FetchSmsJob;
use Illuminate\Support\Facades\Http;

class SmsController extends Controller
{

    public function login(Request $request)
    {
        $secretKey = Cookie::get('secret_key');
        if ($secretKey) {
            $user = User::where('secret_key', $secretKey)->first();
        } elseif ($request->input('secret_key') != null) {
            $secretKey = $request->input('secret_key');
            $user = User::where('secret_key', $secretKey)->first();
        } else {
            return view('login');
        }
        if (!$user) {
            return view('login', [
                'error' => 'کاربر پیدا نشد!'
            ]);
        }
        if ($user->isadmin == 1) {
            Auth::login($user);
            Cookie::queue('secret_key', $secretKey, 60 * 24 * 999999);
            return redirect('admin');
        }


        Auth::login($user);
        Cookie::queue('secret_key', $user->secret_key, 60 * 24 * 999999);
        return redirect("dashboard");
    }


    public function dashboard(Request $request)
    {
        $secretKey = Cookie::get('secret_key');

        if (isset($request->startDate, $request->endDate)) {
            $startdate = Jalalian::fromFormat('Y/m/d', $request->startDate)->toCarbon();
            $enddate = Jalalian::fromFormat('Y/m/d', $request->endDate)->toCarbon();
        }
        if ($secretKey) {
            $user = User::query()
                ->select('id', 'fname', 'balance')
                ->where('secret_key', $secretKey)
                ->first();
            $cost = DB::table('const')->where('name', 'cost')->value('value');
            $sms = Sms::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->when(
                    $request->filled(['startDate', 'endDate']),
                    fn($q) => $q->whereBetween('created_at', [$startdate, $enddate])
                )->get();
            return view('dashbord', [
                'data' => $user,
                'cost' => $cost,
                'smslist' => $sms
            ]);
        }
        return redirect('login')->with('error', 'شما وارد نشده اید');
    }

    public function addBalance(Request $request)
    {
        $secretKey = $request->cookie('secret_key');
        if ($secretKey) {
            $user = User::query()
                ->select('id', 'fname', 'balance')
                ->where('secret_key', $secretKey)->first();
            $user->balance += $request->amount;
            $user->save();

            return redirect("dashboard")->with([
                'message' => 'پرداخت انجام شد'
            ]);
        } else {
            $user = User::query()
                ->select('id', 'fname', 'balance')
                ->where('secret_key', $request->secret_key)->first();
            if (!$user) {

                return view('login', [
                    'error' => 'شما وارد نشده اید'
                ]);
            }
        }
        $user = User::query()
            ->select('id', 'fname', 'balance')
            ->where('secret_key', $secretKey)->first();

        $user->balance += $request->amount;
        $user->save();

        return view('dashbord', [
            'message' => 'پرداخت انجام شد'
        ]);
    }

    public function smsCreate(Request $request)
    {

        $id = $request->input('id');
        $cost = DB::table('const')->where('name', 'cost')->value('value');
        $count = random_int(1, 10);
        $user = User::query()
            ->select('id', 'fname', 'balance')
            ->where('id', $id)->first();
        $user->balance -= $cost * $count;
        $user->save();

        $sms = new Sms();
        $sms->user_id = $id;
        $sms->number = $request->input('phone');
        $sms->sms = $request->input('text');
        //we can masure coun of sms in any other way, this is just a test
        $sms->count = $count;
        $sms->save();

        return redirect("dashboard")->with([
            'message' => 'پیام شما ثبت شد.'
        ]);
    }

    public function smsCreateApi(Request $request)
    {
        $secretKey = $request->header('secret_key');
        if ($secretKey) {
            function SmsPrice($sms)
            {
                $charCount = mb_strlen($sms, "UTF-8");
                $isPersian = preg_match('/[آ-ی]/u', $sms);
                $isEnglish = preg_match('/[a-zA-Z]/u', $sms);
                $limit = ($isPersian && !$isEnglish) ? [70, 64, 67] : [160, 146, 153];
                $smsCount = ceil($charCount / $limit[0]);
                if ($isEnglish) {
                    $smsCount *= 2;
                }
                return $smsCount;
            }


            $count = SmsPrice($request->text);

            $cost = DB::table('const')->where('name', 'cost')->first();
            $user = User::query()
                ->select('id', 'fname', 'balance')
                ->where('secret_key', $secretKey)->first();


            $paneluser = config('0098data.user');
            $panelerrors = config('0098errors.errors');
            // send to sms provider panel with http request 
            $response = Http::get('http://www.0098sms.com/sendsmslink.aspx', [
                'FROM' => $paneluser['sender'],
                'TO' => $request->phone,
                'TEXT' => trim($request->text),
                'USERNAME' => $paneluser['username'],
                'PASSWORD' => $paneluser['password'],
                'DOMAIN' => '0098',
            ]);

            //get error from 0098
            if (preg_match('/\d+/', $response, $matches)) {
                $errornumber = $matches[0];
            }
            $err = $panelerrors[$errornumber];
            if ($errornumber == 0) {
                $user->balance -= $cost->value * $count;
                $user->save();

                $sms = new Sms();
                $sms->user_id = $user->id;
                $sms->number = $request->phone;
                $sms->sms = $request->text;
                //we can masure count of sms in any other way, this is just a test
                $sms->count = $count;
                $sms->api = 1;
                $sms->save();
                return response("پیام شما ثبت شد.");
            } else {
                return response($err ?? "خطای ناشناخته");
            }



            //send to sms provider panel with curl request
            // $data = [
            //     'FROM' => $user,//number of user can be get from database
            //     'TO' => $request->header('phone'),
            //     'TEXT' => trim($request->header('text')),
            //     'USERNAME' => $user,//username of user can be save and user in database
            //     'PASSWORD' => $user,//password of user can be save and user in database
            //     'DOMAIN' => '0098',
            // ];
            // $url = 'http://www.0098sms.com/sendsmslink.aspx?';//.http_build_query($data);
            // $curl = curl_init($url);
            // curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            // $response = curl_exec($curl);
            // $statuscode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            // curl_close($curl);


        }

        return response()->json('user not found', 401);
    }

    public function admin(Request $request)
    {
        //        FetchSmsJob::dispatch();
        $cost = DB::table('const')->where('name', 'cost')->value('value');
        $admin = User::query()
            ->select('fname', 'isadmin')
            ->where('secret_key', $request->cookie('secret_key'))
            ->first();
        if ($admin->isadmin == 1) {
            $users = User::query()
                ->select('fname', 'lname', 'id')
                ->get();

            $sms_count = Sms::select('user_id', DB::raw('SUM(count) as total'))
                ->groupBy('user_id')
                ->pluck('total', 'user_id');
            return view('admin', [
                'admin' => $admin,
                'users' => $users,
                'sms_count' => $sms_count,
                'cost' => $cost

            ]);
        } else
            abort(404);
    }

    public function userdashboard(Request $request, $id)
    {
        if (isset($request->startDate, $request->endDate)) {
            $startdate = Jalalian::fromFormat('Y/m/d', $request->startDate)->toCarbon();
            $enddate = Jalalian::fromFormat('Y/m/d', $request->endDate)->toCarbon();
        }
        $cost = DB::table('const')->where('name', 'cost')->value('value');
        $admin = User::query()
            ->select('fname')
            ->where('secret_key', Cookie::get('secret_key'))
            ->first();
        $user = User::query()
            ->select('id', 'fname', 'lname', 'balance')
            ->where('id', $id)
            ->first();

        $sms = Sms::query()
            // ->select('number','sms','count')
            ->where('user_id', $id)
            ->orderBy('created_at', 'desc')
            ->when(
                $request->filled(['startDate', 'endDate']),
                fn($q) => $q->whereBetween('created_at', [$startdate, $enddate])
            )
            ->get();
        $sum = Sms::query()
            ->where('user_id', $id)
            ->when(
                $request->filled(['startDate', 'endDate']),
                fn($q) => $q->whereBetween('created_at', [$startdate, $enddate])
            )
            ->sum('count');
        $total = $sum * $cost;
        return view('userprofile', [
            'admin' => $admin,
            'data' => $user,
            'smslist' => $sms,
            'total' => $total,
            'cost' => $cost,
            'sum' => $sum
        ]);
    }

    public function logout()
    {
        Auth::logout();
        Cookie::queue(Cookie::forget('secret_key'));
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/');
    }
}
