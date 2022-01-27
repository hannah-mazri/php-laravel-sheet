<?php

namespace App\Console\Commands;

use App\Models\WooCouponOrder;
use Illuminate\Console\Command;
use Google\Client;
use Google\Service\Sheets;

class ProcessCoupon extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lv:coupon';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $client = new Client();
        $client->setApplicationName('Google Sheets API PHP Quickstart');
        $client->setScopes(Sheets::SPREADSHEETS);
        $client->setAccessType('offline');
        $client->setAuthConfig(env('GOOGLE_SPREADSHEET_SERVICE'));
        $service = new Sheets($client);

        $spreadsheetId = env('GOOGLE_SPREADSHEET_ID');

        $orders = WooCouponOrder::where('status', 'new')->get();

        $orders_dummy = array(
            (object)[
                'product_id' => 3221,
                'name' => 'Barney Stinson',
                'coupon_code' => 'MD-fsdgs'
            ],
            (object)[
                'product_id' => 4183,
                'name' => 'Robin Scherbatsky',
                'coupon_code' => 'CNY-kjkhj'
            ],
            (object)[
                'product_id' => 4183,
                'name' => 'Ted Mosby',
                'coupon_code' => 'CNY-ghgfj'
            ],
            (object)[
                'product_id' => 3221,
                'name' => 'Lily Aldrin',
                'coupon_code' => 'MD-ytyr'
            ],
            (object)[
                'product_id' => 4183,
                'name' => 'Marshall Eriksen',
                'coupon_code' => 'CNY-mvnbv'
            ]
        );

        foreach ($orders as $order) {
            $product_id = $order->item_data['items']['product_id'];
            switch ($product_id) {
                case 3221:
                    $range = 'Sheet1';
                    $values = [
                        [
                            now()->toDateTimeString(),
                            $order->customer_name,
                            $order->customer_email
                        ]
                    ];
                    break;
                case 4183:
                    $range = 'Sheet2';
                    $values = [
                        [
                            now()->toDateTimeString(),
                            $order->customer_name,
                            $order->customer_email
                        ]
                    ];
                    break;
                default:
                    break;
            }

            $body = new Sheets\ValueRange([
                'values' => $values
            ]);
            $params = [
                'valueInputOption' => 'RAW'
            ];
            $result = $service->spreadsheets_values->append($spreadsheetId, $range, $body, $params);
        }
        return 0;
    }
}
