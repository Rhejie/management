<?php

namespace App\Imports;

use App\Models\Employee;
use App\Models\Site;
use App\Models\Campaign;

use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
// use App\Rules\CampaignNameRule;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProponentsImport implements 
    ToModel,
    WithValidation,
    SkipsOnFailure,
    WithHeadingRow,
    WithBatchInserts
{
    use Importable, SkipsFailures;

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        try {
            $site = Site::with('campaigns')->where('name', $row['site'])->first();

            $campaign = $site->campaigns->where('name', $row['campaign'])->first();

            return Employee::create(
            [
                'name' => $row['name'],
                'employee_number' => $row['employee_number'],
                'site_id' => $site->id,
                'campaign_id' => $campaign->id,
            ]);
        } catch (\Throwable $th) {
            return null;
        }
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'employee_number' => 'required|alpha_dash|max:255',
            'site' => 'required|exists:sites,name',
            'campaign' => 'required|exists:campaigns,name',
            'email' => 'required|email|max:255|unique:employees',
        ];
    }

    public function batchSize(): int
    {
        return 20;
    }
}
