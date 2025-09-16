<?php

namespace App\Console\Commands;

use App\Models\Sms;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class getSmsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-sms-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $apis = config('sms.apis');
        $client = new \GuzzleHttp\Client();

        for ($i = 0; $i < count($apis); $i++) {
            try {
                $response = $client->request('GET', $apis[$i]['url'], [
                    'headers' => [
                        'sicrtToken' => $apis[$i]['token'],
                        'Content-Type' => 'application/json'
                    ],
                    'body' => json_encode([
                        // "startDate" => "2021-08-30 05:59:07",//گرفتن همه دیتا های موجود
                        // "endDate" => "2028-08-30 05:59:07"
                    ])
                ]);
            } catch (\GuzzleHttp\Exception\RequestException $e) {
                \Log::error("API {$apis[$i]['url']} failed: " . $e->getMessage());
            }


            $data = json_decode($response->getBody(), true);


            if ($data == null) {
                continue;
            } else {
                foreach ($data as $item) {
                    $exists = DB::table('sms')->where('sms_id', $item['id'])->exists();
                    
                    if (!$exists) {
                        
                        $sms = Sms::query()->create([
                            'number' => $item['receiver'] ?? null,
                            'sms' => $item['sms'] ?? null,
                            'sms_id'=>$item['id'],
                            'tel_id' => $item['tel_id'] ?? null,
                            'status' => $item['sts'] ?? null,
                            'platforms' => $item['platforms'] ?? null,
                            'count' => $item['price'] ?? null,
                            'user_id' => $apis[$i]['user_id'],
                            'created_at' => $item['created_at'] ?? now(),
                            'updated_at' => $item['updated_at'] ?? now(),
                            'deleted_at' => $item['deleted_at'] ?? null,
                        ]);
                        
                        // $sms = new Sms();
                        
                        // $sms->sms_id = $item['id'] ?? null;
                        // $sms->number = $item['receiver'] ?? null;
                        // $sms->sms = $item['sms'] ?? null;
                        // $sms->tel_id = $item['tel_id'] ?? null;
                        // $sms->status = $item['sts'] ?? null;
                        // $sms->platforms = $item['platforms'] ?? null;
                        // $sms->count = $item['price'] ?? null;
                        // $sms->user_id = $apis[$i]['user_id'];
                        // $sms->created_at = $item['created_at'] ?? null;
                        // $sms->updated_at = $item['updated_at'] ?? null;
                        // $sms->deleted_at = $item['deleted_at'] ?? null;

                        $sms->save();
                    }
                }
            }
        }
    }
}
