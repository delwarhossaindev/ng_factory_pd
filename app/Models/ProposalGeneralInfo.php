<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProposalGeneralInfo extends Model
{
    use HasFactory;

    // Define the table name explicitly
    protected $table = 'ProposalGeneralInfo';

    // Define the primary key
    protected $primaryKey = 'GeneralInfoID';

    // Disable timestamps (if your table doesn't have `created_at` and `updated_at`)
    public $timestamps = false;

    // Specify the fillable attributes
    protected $fillable = [
        'ProposalID',
        'GenericName',
        'TherapeuticClass',
        'Indication',
        'LocalCompetitors',
        'OriginatorBrand',
    ];

    // Define the relationship with ProposalMaster
    public function proposal()
    {
        return $this->belongsTo(ProposalMaster::class, 'ProposalID', 'ProposalID');
    }

    public function details()
{
    return $this->hasMany(ProposalGeneralInfoDetails::class, 'GeneralInfoID', 'GeneralInfoID');
}
}
