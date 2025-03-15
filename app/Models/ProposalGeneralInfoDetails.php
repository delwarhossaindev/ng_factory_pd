<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProposalGeneralInfoDetails extends Model
{
    use HasFactory;

    // Define the table name explicitly
    protected $table = 'ProposalGeneralInfoDetails';

    // Define the primary key
    protected $primaryKey = 'GeneralInfoDetailsID';

    // Disable timestamps (if your table doesn't have `created_at` and `updated_at`)
    public $timestamps = false;

    // Specify the fillable attributes
    protected $fillable = [
        'GeneralInfoID',
        'ProposalID',
        'StrengthDosageForm',
        'PackSize',
        'PrimaryPack',
        'MRPUnit',
        'MRPPack',
        'TP',
        'DCCNumber',
        'Availability',
    ];

    // Define relationships
    public function proposal()
    {
        return $this->belongsTo(ProposalMaster::class, 'ProposalID', 'ProposalID');
    }

    public function generalInfo()
    {
        return $this->belongsTo(ProposalGeneralInfo::class, 'GeneralInfoID', 'GeneralInfoID');
    }
}
