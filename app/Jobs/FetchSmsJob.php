<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\Sms;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use function Termwind\render;

class FetchSmsJob implements ShouldQueue
{
    use Queueable, Dispatchable, InteractsWithQueue, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $apis = config('sms.apis');
        $client = new \GuzzleHttp\Client();

        for ($i = 1; $i < count($apis); $i++) {
            try {
                $response = $client->request('GET', $apis[$i]['url'], [
                    'headers' => [
                        'sicrtToken' => $apis[$i]['token'],
                        'Content-Type' => 'application/json'
                    ],
                    'body' => json_encode([
                        "startDate" => "2021-08-30 05:59:07",
                        "endDate" => "2028-08-30 05:59:07"
                    ])
                ]);
            }catch (\GuzzleHttp\Exception\RequestException $e) {
                \Log::error("API {$apis[$i]['url']} failed: " . $e->getMessage());
                

            }


            $data = json_decode($response->getBody(), true);


            if ($data == null) {
                continue;
            } else {
                foreach ($data as $item) {
                    $exists = Sms::where('number', $item['receiver'] ?? null)
                        ->where('sms', $item['sms'] ?? null)
                        ->where('status', $item['sts'] ?? null)
                        ->where('platforms', $item['platforms'] ?? null)
                        ->where('count', $item['price'] ?? null)
                        ->where('user_id', $apis[$i]['user_id'])
                        ->exists();

                    if (!$exists) {
                        $sms = Sms::create([
                            'number' => $item['receiver'] ?? null,
                            'sms' => $item['sms'] ?? null,
                            'tel_id' => $item['tel_id'] ?? null,
                            'status' => $item['sts'] ?? null,
                            'platforms' => $item['platforms'] ?? null,
                            'count' => $item['price'] ?? null,
                            'user_id' => $apis[$i]['user_id'],
                            'created_at' => $item['created_at'] ?? now(),
                            'updated_at' => $item['updated_at'] ?? now(),
                            'deleted_at' => $item['deleted_at'] ?? null,
                        ]);
                        $sms->save();
                    }
                }
            }
        }
    }
}