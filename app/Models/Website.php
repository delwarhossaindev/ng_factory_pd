<?php

namespace App\Models;

use Intervention\Image\Facades\Image;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Website extends Model implements Auditable
{
    use HasFactory, AuditableTrait;

    protected $fillable = [
        'title',
        'slogan',
        'logo',
        'favicon'
    ];

    /**
     * Summary of saveWebsiteInfo
     * @param mixed $request
     * @return mixed
     */
    public function saveWebsiteInfo($request)
    {
        $path = storage_path('app/public/');
        !is_dir($path) && mkdir($path, 0775, true);

        if ($request->logo) {
            $logo = time() . '._logo_.' . $request->logo->extension();
            Image::make($request->logo)->resize(200, 200)->save($path . $logo);
        }

        if ($request->favicon) {
            $favicon = time() . '._favicon_.' . $request->favicon->extension();
            Image::make($request->favicon)->resize(80, 80)->save($path . $favicon);
        }

        if (!$this::count()) {
            $this::create([
                'title'   => $request->title,
                'slogan'  => $request->slogan ?: '',
                'logo'    => isset($logo) ? $logo : '',
                'favicon' => isset($favicon) ? $favicon : ''
            ]);

            return $this;
        }

        $website = $this::first();
        $website->title = $request->title;
        $website->slogan = $request->slogan;
        $website->logo  = $request->logo ? $logo : $website->logo;
        $website->favicon  = $request->favicon ? $favicon : $website->favicon;
        $website->save();

        return $website;
    }

    /**
     * Summary of getWebsiteInfo
     * @return mixed
     */
    public static function getWebsiteInfo(): mixed
    {
        return self::first() ?? NULL;
    }
}
