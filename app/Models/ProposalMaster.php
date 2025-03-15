<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProposalMaster extends Model
{
    use HasFactory;

    // Define the table name explicitly (optional if naming convention is followed)
    protected $table = 'ProposalMaster';

    // Define the primary key
    protected $primaryKey = 'ProposalID';

    // Disable timestamps (if your table doesn't have `created_at` and `updated_at`)
    public $timestamps = false;

    // Specify the fillable attributes
    protected $fillable = [
        'PresentDesk',
        'ProductCategory',
        'CreatedBy',
        'CreatedDate',
        'EditedBy',
        'EditedDate',
        'EvaluatedBy',
        'RecommendedBy',
        'StatusID',
        'EvaluatedStatus',
        'RecommendedStatus',
    ];

    // If 'CreatedDate' and 'EditedDate' should be treated as datetime
    protected $casts = [
        'CreatedDate' => 'datetime',
        'EditedDate' => 'datetime',
    ];

    public function referenceStatuses()
{
    return $this->hasMany(ProposalReferenceStatus::class, 'ProposalID', 'ProposalID');
}

public function generalInfo()
{
    return $this->hasOne(ProposalGeneralInfo::class, 'ProposalID', 'ProposalID');
}

public function generalInfoDetails()
{
    return $this->hasMany(ProposalGeneralInfoDetails::class, 'ProposalID', 'ProposalID');
}

public function forecasts()
{
    return $this->hasMany(ProposalForecast::class, 'ProposalID', 'ProposalID');
}

}
