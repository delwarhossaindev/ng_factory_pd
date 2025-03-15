<?php

use Carbon\Carbon;
use App\Models\Tag;
use App\Models\Role;
use App\Models\User;
use App\Models\Setting;
use App\Models\Website;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

if (!function_exists('settings')) {
    function settings(string $key)
    {
        $setting = Setting::where('key', $key)?->first();

        return $setting?->value;
    }
}

if (!function_exists('action_button')) {
    function action_button($buttonArrays)
    {
        $button = '';
        $button .= '<div class="d-flex align-items-center">';
        $button .= '<div class="dropdown"><a href="javascript:;" class="btn dropdown-toggle hide-arrow text-body p-0" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-dots-vertical-rounded"></i></a>';
        $button .= '<div class="dropdown-menu dropdown-menu-end" style="">';
        if (is_array($buttonArrays)) {
            foreach ($buttonArrays as $action) {
                if ($action['is_modal'] && $action['is_able_to_see']) {
                    $button .= '<button data-toggle="modal" data-target="#myDynamicModal" data-link="' . $action['route'] . '" class="dropdown-item ajax-modal-btn">' . $action['button_text'] . '</button>';
                    continue;
                }
                if (!$action['is_modal'] && $action['is_able_to_see'] && $action['button_text'] != 'Trash' && $action['button_text'] != 'Delete') {
                    $button .= '<a href="' . $action['route'] . '" class="dropdown-item">' . $action['button_text'] . '</a>';
                    continue;
                }
                if ($action['is_able_to_see']) {
                    if ($action['button_text'] == 'Trash' || $action['button_text'] == 'Delete') {
                        $button .=
                            '<form method="POST" action="' .
                            $action['route'] .
                            '">
                        ' .
                            method_field('DELETE') .
                            '
                    <input type="hidden" name="_token" id="csrf-token" value="' .
                            csrf_token() .
                            '" />
                    <button type="submit" class="dropdown-item delete-record text-danger show_confirm" data-toggle="tooltip" title="Delete">' .
                            $action['button_text'] .
                            '</button>
                    </form>';
                        continue;
                    }
                }
            }
        }

        $button .= '</div>';
        $button .= '</div>';
        $button .= '</div>';

        return $button;
    }
}

if (!function_exists('selected_theme')) {
    function selected_theme()
    {
        $theme = session('theme');
        if ($theme === 'light') {
            $css = '#layout-menu{background:#19212c!important;border-right:1px solid #d3d3d3!important}.layout-wrapper:not(.layout-horizontal) .bg-menu-theme .menu-inner .menu-item .menu-link{background:unset!important;color:lightgrey;font-weight:bold;}.layout-wrapper:not(.layout-horizontal) .bg-menu-theme .menu-inner>.menu-item.active:before{border-radius:unset}.navbar-detached{box-shadow:unset}.bg-navbar-theme{background-color:#1A85AB!important;color:unset}.app-brand .layout-menu-toggle{background-color:#1f2937}span.app-brand-text.menu-text.fw-bolder.ms-2{color:#fff}.content-wrapper{background:#ededed}a.layout-menu-toggle.menu-link.text-large.ms-auto,i.bx.bx-chevron-left.bx-sm.align-middle{display:none}a.layout-menu-toggle.menu-link.text-large.ms-auto{display:none!important}nav#layout-navbar{height:40px}.container-fluid {background: #1A85AB;}a#menudd,i.bx.bx-bell.bx-sm,i.bx.bx-menu.bx-sm{color:#fff}';

            return $css;
        }
        if ($theme === 'dark') {
            $css = 'html,iframe,img,video{filter:invert(1) hue-rotate(30deg)}.layout-navbar{background:unset!important}.navbar-detached{box-shadow:unset!important}a.layout-menu-toggle.menu-link.text-large.ms-auto,i.bx.bx-chevron-left.bx-sm.align-middle{display:none}a.layout-menu-toggle.menu-link.text-large.ms-auto{display:none!important}nav#layout-navbar{height:40px}.bg-menu-theme .menu-inner>.menu-item.active:before {background: #1A85AB;border-radius: unset !important;}.bg-menu-theme .menu-inner>.menu-item.active>.menu-link {color: #1A85AB;background-color: unset !important;}.bg-navbar-theme{background-color:#f5f5f9!important;color:unset}.bg-menu-theme .menu-item.active > .menu-link:not(.menu-toggle){background-color: unset !important}';

            return $css;
        }
        return;
    }
}

if (!function_exists('generate_table_columns')) {
    function generate_table_columns($columns)
    {
        $HTML = '';
        $HTML .= "<table class='table data-table table-striped'>";
        $HTML .= '<thead><tr><th></th>';
        foreach ($columns as $col) {
            $HTML .= '<th>' . $col . '</th>';
        }
        $HTML .= '</tr></thead>';
        $HTML .= "<tbody class='table-border-bottom-0'></tbody>";
        $HTML .= '</table>';

        echo $HTML;
    }
}

if (!function_exists('isAdministrator')) {
    function isAdministrator()
    {
        return Auth::user()->hasRole('Administrator');
    }
}

if (!function_exists('convertJsonToString')) {
    function convertJsonToString($jsonArray)
    {
        $convertedArray = [];
        if (!is_null($jsonArray)) {
            foreach (json_decode($jsonArray) as $x => $value) {
                $convertedArray[$x] = $value->value;
            }
        }

        return implode(',', $convertedArray);
    }
}

if (!function_exists('convertQueryStringToArray')) {
    function convertQueryStringToArray($request)
    {
        $filterColumns = [];
        parse_str($request->filterColumn, $filterColumns);

        return $filterColumns;
    }
}

if (!function_exists('getDateFromFilterRequest')) {
    function getDateFromFilterRequest($filterColumns)
    {
        if (isset($filterColumns['date'])) {
            $start_date = substr(strrchr($filterColumns['date'], '-'), 1);
            $end_date = strtok($filterColumns['date'], '-');

            return [Carbon::parse($start_date)->toDateString(), Carbon::parse($end_date)->toDateString()];
        }
    }
}

if (!function_exists('storage_asset_path')) {
    function storage_asset_path($file)
    {
        return asset('storage/' . $file);
    }
}

if (!function_exists('generate_table')) {
    function generate_table($items, $options = null)
    {
        $header = $atts = '';
        $header_keys = array_keys($items[0]);

        if (!is_null($options)) {
            if (array_key_exists('column', $options)) {
                $header_keys = $options['column'];
            }
            if (array_key_exists('attributes', $options)) {
                $attr = $options['attributes'];
            } else {
                $attr = ['class' => 'table table-condensed'];
            }
        } else {
            $attr = ['class' => 'table table-condensed'];
        }

        if (is_null($options) || (!isset($options['header']) || (isset($options['header']) && $options['header'] != false))) {
            $header = '<thead><tr>';
            foreach ($header_keys as $value) {
                $header .= '<th>' . ucwords(str_replace('_', ' ', $value)) . '</th>';
            }

            if (isset($options['action'])) {
                $header .= "<th style='text-align:right'>Actions</th>";
            }
            $header .= '</tr></thead>';
        }

        $tbody = '<tbody>';
        foreach ($items as $values) {
            $tbody .= '<tr>';
            foreach ($header_keys as $key) {
                $tbody .= '<td>' . $values[$key] . '</td>';
            }
            if (isset($options['action'])) {
                $action = "<td style='text-align:right'>" . View::make($options['action'], ['item' => $values]) . '</td>';
                $tbody .= "$action</tr>";
            }
        }
        $tbody .= '</tbody>';

        if (!is_null($options) && isset($options['table']) && $options['table'] == false) {
            return $tbody;
        }

        if (isset($attr)) {
            foreach ($attr as $key => $value) {
                $atts .= ' ' . $key . "='" . $value . "'";
            }
        }

        return "<table $atts>" . $header . $tbody . '</table>';
    }
}

if (!function_exists('can_do')) {
    function can_do($level): bool
    {
        return auth()->user()->Level == $level;
    }
}

if (!function_exists('webiste')) {
    function webiste()
    {
        return Website::first();
    }
}

if (!function_exists('isMo')) {
    function isMo()
    {
        return auth()->user()->Level == 'MO';
    }
}

if (!function_exists('isAH')) {
    function isAH()
    {
        return auth()->user()->Level == 'AH';
    }
}

if (!function_exists('isRSM')) {
    function isRSM()
    {
        return auth()->user()->Level == 'RSM';
    }
}

if (!function_exists('isGM')) {
    function isGM()
    {
        return auth()->user()->Level == 'GM';
    }
}

if (!function_exists('isHQ')) {
    function isHQ()
    {
        return auth()->user()->Level == 'HQ';
    }
}

if (!function_exists('userSupervisor')) {
    function userSupervisor()
    {
        return auth()->user()?->SupervisorID;
    }
}

if (!function_exists('userSupervisorLevel')) {
    function userSupervisorLevel()
    {
        $supervisorID = auth()->user()?->SupervisorID;
        $user = User::where('UserID', $supervisorID)->first();
        if ($user) {
            return $user->Level;
        }
    }
}

if (!function_exists('generate_unique_code')) {
    function generate_unique_code($modelClass)
    {
        $modelPath = <<<TEXT
        App\Models\
        TEXT;
        $model = $modelPath . $modelClass;

        switch ($modelClass) {
            case 'CreditNoteApproval':
                $code = Date('Ymd') . $model::count() + 1;
                break;
            default:
                $code = Date('Ymd') . $model::count() + 1;
                break;
        }

        return $code;
    }
}
