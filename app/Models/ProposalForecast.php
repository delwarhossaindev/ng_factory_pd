<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProposalForecast extends Model
{
    use HasFactory;

    // Define the table name explicitly
    protected $table = 'ProposalForecast';

    // Define the primary key
    protected $primaryKey = 'ForecastID';

    // Disable timestamps (if your table doesn't have `created_at` and `updated_at`)
    public $timestamps = false;

    // Specify the fillable attributes
    protected $fillable = [
        'ProposalID',
        'StrengthDosageForm',
        'Year1Unit',
        'Year1Value',
        'Year2Unit',
        'Year2Value',
        'Year3Unit',
        'Year3Value',
        'LaunchingMonth',
    ];

    // Define relationship with ProposalMaster
    public function proposal()
    {
        return $this->belongsTo(ProposalMaster::class, 'ProposalID', 'ProposalID');
    }
}
