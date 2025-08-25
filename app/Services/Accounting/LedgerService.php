<?php
namespace App\Services\Accounting;

use App\Models\Inventory\Stock;
use App\Models\Accounting\GeneralLedger;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class LedgerService
{
    public static function post(array $header, array $lines)
    {
        DB::transaction(function () use ($header, $lines) {

            foreach ($lines as $line) {
                GeneralLedger::create([
                    ...$header,
                    'account_code' => $line['account_code'],
                    'tran_type' => $line['tran_type'],
                    'amount' => $line['amount'],
                    'other_type' => $line['other_type'] ?? null,
                    'record_id' => $line['record_id'] ?? null,
                    'analytical_code' => $line['analytical_code'] ?? null,
                    'narration' => $line['narration'] ?? null,
                ]);
            }

            //return 1;
        });
    }
}

