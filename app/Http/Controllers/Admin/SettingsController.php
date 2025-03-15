<?php

namespace App\Http\Controllers\Admin;

use App\Models\Website;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use App\Http\Requests\StoreSettingsRequest;
use App\Http\Requests\PasswordUpdateRequest;
use App\Http\Requests\WebsiteRequest;
use App\Models\Backup;

class SettingsController extends Controller
{
    /**
     * Summary of index
     * @param Setting $setting
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Setting $setting)
    {
        return view('admin.settings.settings', [
            'settings' => $setting->settings(),
            'backups'  => Backup::backupList(),
            'site'     => Website::getWebsiteInfo()
        ]);
    }

    /**
     * Summary of update
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $settings = Setting::select('key')->get();
        foreach ($settings as $value) {
            Setting::where('key', $value->key)->update([
                'value' => isset($request->key[$value->key])
                    ? $request->key[$value->key] : false
            ]);
        }

        return back()->withMessage('Settings details updated.');
    }

    /**
     * Summary of cache
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cache()
    {
        Artisan::call('clear:app');

        return $this->success('settings', trans('sentence.cache_cleared_message'));
    }

    /**
     * Summary of updatePasswordForm
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function updatePasswordForm()
    {
        return view('admin.settings.updatepassword');
    }

    /**
     * Summary of updatePassword
     * @param PasswordUpdateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePassword(PasswordUpdateRequest $request)
    {
        if (
            Hash::check(
                $request->old_password,
                auth()->user()->password
            )
        ) {
            if (!Hash::check(
                $request->new_password,
                auth()->user()->password
            )) {
                $request->user()->update([
                    'Password' => bcrypt($request->new_password)
                ]);
                return back()->withMessage('Password updated successfully.');
            }
            return back()->withError('New password can not be the previous password.');
        }
        return back()->withError('Previous password not matched');
    }

    /**
     * Summary of store
     * @param StoreSettingsRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreSettingsRequest $request)
    {
        for ($i = 0; $i < count($request->display_name); $i++) {
            Setting::create([
                'display_name' => $request->display_name[$i],
                'key' => $request->key[$i],
                'value' => $request->value[$i],
            ]);
        }

        return back()->withmMessage('Settings created successfully!');
    }

    /**
     * Summary of saveOrUpdateWebsiteInfo
     * @param Website $website
     * @param WebsiteRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveOrUpdateWebsiteInfo(
        Website $website,
        WebsiteRequest $request
    ) {
        $website->saveWebsiteInfo($request);

        return back()->withMessage('Website information saved!');
    }

    public function envManager(Request $request)
    {
        $path = base_path('.env');
        $data = $request->except(['_token']);

        if (file_exists($path) && count($data)) {
            foreach ($data as $key => $value) {
                $formattedValue = removeSpaceAndMakeItCamelCase($value);
                file_put_contents($path, str_replace(
                    $key . '=' . env($key),
                    $key . '=' . $formattedValue,
                    file_get_contents($path)
                ));
            }
        }

        return back()->withMessage('Configuration saved successfully');
    }
}
