<?php

namespace App\Models;

use App\Helpers\Watcher;
use App\Helpers\Addressable;
use App\Helpers\ImageResizeable;
use Laravel\Sanctum\HasApiTokens;
use App\Helpers\HasConfirmationOtp;
use Illuminate\Support\Facades\URL;
use Laratrust\Contracts\LaratrustUser;
use Illuminate\Notifications\Notifiable;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Builder;
use Laratrust\Traits\HasRolesAndPermissions;
use Laragear\TwoFactor\TwoFactorAuthentication;
use OwenIt\Auditing\Auditable as AuditableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laragear\TwoFactor\Contracts\TwoFactorAuthenticatable;

class User extends Authenticatable implements Auditable, LaratrustUser, TwoFactorAuthenticatable
{
    use HasApiTokens,
        HasFactory,
        Notifiable,
        HasRolesAndPermissions,
        AuditableTrait,
        Addressable,
        Watcher,
        ImageResizeable,
        HasConfirmationOtp,
        TwoFactorAuthentication;

        protected $connection = 'sqlsrv';
    protected $table      = 'UserManager';
    protected $primaryKey = 'UserID';
    protected $keyType    = 'string';
    public $timestamps    = true;

    protected $fillable = [
        'UserID',
        'UserName ',
        'Password',
        'SupervisorID',
        'Level',
        'SignaturePath',
        'ProfilePath'

    ];

    /**
     * Summary of permalink
     * @return object
     */
    public function permalink()
    {
        return (object) [
            'edit'         => URL::route('user.edit', $this->UserID),
            'update'       => URL::route('user.update', $this->UserID),
            'restore'      => URL::route('user.restore', $this->UserID),
            'force_delete' => URL::route('user.force_delete', $this->UserID)
        ];
    }

    /**
     * Summary of getId
     * @return string
     */
    public function getAuthId()
    {
        return $this->UserID;
    }

    /**
     * Summary of storeUser
     * @param mixed $request
     * @return User
     */
    public function storeUser($request)
    {

        $this->UserID     = $request->UserID;
        $this->UserName = $request->UserName;
        $this->Password    = bcrypt($request->Password);;
        $this->SupervisorID = $request->SupervisorID;
        $this->Level    = $request->Level;
        $this->save();

        if ($request->has('image')) {
            $this->saveImage($request, 300, 300);
        }

        return $this;
    }

    /**
     * Summary of updateUser
     * @param mixed $user
     * @param mixed $request
     * @return User
     */
    public function updateUser($user, $request): User
    {
        $user->UserName = $request->UserName;
        $user->SupervisorID = $request->SupervisorID;
        $user->Level = $request->Level;
        $user->save();

        $request->has('image') && $user->saveImage($request, 300, 300);

        return $user;
    }

    /**
     * Summary of userList
     * @param mixed $request
     * @return mixed
     */
    public function userList($request)
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
            );
    }

    /**
     * Summary of userCountInformation
     * @return object
     */
    public static function userCountInformation()
    {
        return (object) [
            'all_user'      => self::count(),
            'user_active'   => self::where('Level', 'MO')->count(),
            'user_inactive' => self::where('Level', 'RSM')->count(),
            'trash_user'    => self::where('Level', 'AH')->count(),
        ];
    }
}
