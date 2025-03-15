<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProposalReferenceStatus extends Model
{
    use HasFactory;

    // Define the table name explicitly (optional if naming convention is followed)
    protected $table = 'ProposalReferenceStatus';

    // Define the primary key
    protected $primaryKey = 'ReferenceStatusID';

    // Disable timestamps (if your table doesn't have `created_at` and `updated_at`)
    public $timestamps = false;

    // Specify the fillable attributes
    protected $fillable = [
        'ProposalID',
        'ReferenceStatus',
    ];

    // Define the relationship with ProposalMaster
    public function proposal()
    {
        return $this->belongsTo(ProposalMaster::class, 'ProposalID', 'ProposalID');
    }
}
