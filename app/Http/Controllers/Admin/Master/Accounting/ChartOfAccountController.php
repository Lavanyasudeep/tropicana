<?php

namespace App\Http\Controllers\Admin\Master\Accounting;

use App\Models\Master\Accounting\{ Level1, Level2, ChartOfAccount};

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChartOfAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $level1s = Level1::orderBy('code')->get();

        // return view('admin.master.accounting.chart-of-account.index', compact('level1s'));
        $level1s = Level1::with(['level2s' => function($q) {
                        $q->with(['accounts' => function($q2) {
                                    $q2->orderBy('account_name');
                                }]);
                            }])->get();

        return view('admin.master.accounting.chart-of-account.tree', compact('level1s'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $type = $request->input('ca_form_type');
        $level1Id = $request->input('level_1_id');
        $level2Id = $request->input('level_2_id');
        $accountId = $request->input('account_id');
        $name = $request->input('account_name');
        $code = $request->input('account_code');

        switch ($type) {
            case 'level1':
                Level1::updateOrCreate(
                    ['level_1_id' => $level1Id],
                    [
                        'company_id'      => 1,
                        'code'      => $code,
                        'description' => $name,
                    ]
                );
                break;

            case 'level2':
                Level2::updateOrCreate(
                    ['level_2_id' => $level2Id],
                    [
                        'company_id'      => 1,
                        'code'      => $code,
                        'description' => $name,
                        'level_1_id' => $level1Id
                    ]
                );
                break;

            case 'account':
                ChartOfAccount::updateOrCreate(
                    ['account_id' => $accountId],
                    [
                        'company_id'      => 1,
                        'account_name' => $name,
                        'account_code' => $code,
                        'level_2_id' => $level2Id,
                        'level_1_id' => $request->input('level1_id', 0),
                        'level_3_id' => $request->input('level_3_id', 0),
                        'level_4_id' => $request->input('level_4_id', 0)
                    ]
                );
                break;

            default:
                return response()->json(['error' => 'Invalid type'], 400);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($type, string $id)
    {
        switch ($type) {
            case 'level1':
                $item = Level1::findOrFail($id);
                return response()->json([
                    'id' => $item->level_1_id,
                    'name' => $item->description,
                    'code' => $item->code,
                    'level_1_id' => null,
                    'level_2_id' => null
                ]);
            case 'level2':
                $item = Level2::findOrFail($id);
                return response()->json([
                    'id' => $item->level_2_id,
                    'name' => $item->description,
                    'code' => $item->code,
                    'level_1_id' => $item->level_1_id,
                    'level_2_id' => null
                ]);
            case 'account':
                $item = ChartOfAccount::findOrFail($id);
                return response()->json([
                    'id' => $item->account_id,
                    'name' => $item->account_name,
                    'code' => $item->account_code,
                    'level_1_id' => $item->level_1_id,
                    'level_2_id' => $item->level_2_id
                ]);
            default:
                abort(404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function search(Request $request)
    {
        $query = $request->get('q');

        $account = DB::table('cs_chart_of_account')
            ->join('cs_level_2', 'cs_chart_of_account.level_2_id', '=', 'cs_level_2.level_2_id')
            ->join('cs_level_1', 'cs_level_2.level_1_id', '=', 'cs_level_1.level_1_id')
            ->select('cs_chart_of_account.*', 'cs_level_2.level_2_id as level2_id', 'cs_level_1.level_1_id as level1_id')
            ->where('cs_chart_of_account.account_name', 'like', '%' . $query . '%')
            ->first();

        if ($account) {
            return response()->json([
                'found' => true,
                'level1_id' => $account->level_1_id,
                'level2_id' => $account->level_2_id,
                'account_id' => $account->account_id,
                'account_name' => $account->account_name
            ]);
        }

        return response()->json(['found' => false]);
    }

    public function getLevel2(Request $request)
    { 
        $level1_id = $request->level1_id;
        $level1 = Level1::findOrFail($level1_id);
        $level2s = Level2::where('level_1_id', $level1_id)->orderBy('code')->get();

        return view('admin.master.accounting.chart-of-account.partials.level2', compact('level1','level2s'));
    }

    public function getAccounts(Request $request)
    {
        $level2_id = $request->level2_id;
        $level2 = Level2::findOrFail($level2_id);
        $accounts = ChartOfAccount::where('level_2_id', $level2_id)->orderBy('account_code')->get();

        return view('admin.master.accounting.chart-of-account.partials.accounts', compact('level2', 'accounts'));
    }


}
