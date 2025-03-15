<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CreditNoteApproval extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table      = 'CreditNoteApproval';
    protected $primaryKey = 'CodeNo';
    protected $keyType    = 'string';
    public $timestamps    = false;

    /**
     * Summary of getCreditNoteApprovalQuery
     * @param mixed $request
     * @return mixed
     */
    public function getCreditNoteApprovalQuery($request)
    {
        $filterColumns = convertQueryStringToArray($request);

        return $this::query()
            ->when(
                isset($filterColumns['date']),
                function (Builder $builder) use ($filterColumns) {
                    $builder->whereBetween(
                        'created_at',
                        [
                            getDateFromFilterRequest($filterColumns)[1],
                            getDateFromFilterRequest($filterColumns)[0]
                        ]
                    );
                }
            )
            ->when(
                isMO() || isAH() || isRSM(),
                function (Builder $builder) use ($filterColumns) {
                    $builder->where(
                        'CreatedBy',
                        auth()->id()
                    );
                }
            );
    }

    /**
     * Summary of creditCountInformation
     * @return object
     */
    public static function creditCountInformation()
    {
        $yesterday = Carbon::yesterday()->toDateString();

        return (object) [
            'all' => self::count(),
            'today' => self::where('created_at', date('Y-m-d'))->count(),
            'yesterday' => self::where('created_at', $yesterday)->count(),
        ];
    }
}
