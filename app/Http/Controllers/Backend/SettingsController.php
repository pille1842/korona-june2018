<?php

namespace Korona\Http\Controllers\Backend;

use Illuminate\Http\Request;

use Korona\Country;
use Korona\Http\Controllers\Controller;
use Korona\Http\Requests;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:backend.manage.settings');
    }

    public function index()
    {
        $countries = Country::all()->pluck('name', 'id');
        $settings = json_decode(file_get_contents(resource_path('settings.json')), true);

        return view('backend.settings.index', compact('countries', 'settings'));
    }

    public function save(Request $request)
    {
        $settings = json_decode(file_get_contents(resource_path('settings.json')), true);
        $rules = [];

        foreach ($settings['system'] as $group) {
            $prefix = $group['name'] . '_';

            foreach ($group['settings'] as $setting) {
                $key = $prefix . $setting['name'];

                if (isset($setting['validation'])) {
                    $rules['settings_'.$key] = $setting['validation'];
                }
            }
        }

        $this->validate($request, $rules);

        foreach ($settings['system'] as $group) {
            $prefix = $group['name'] . '.';
            $requestPrefix = $group['name'] . '_';

            foreach ($group['settings'] as $setting) {
                $requestKey = $requestPrefix . $setting['name'];
                $key = $prefix . $setting['name'];
                if ($setting['type'] != 'boolean') {
                    $value = trim($request->input('settings_'.$requestKey));
                    if ($setting['type'] == 'csv') {
                        $value = array_map('trim', explode(',', $value));
                    }
                } else {
                    $value = $request->has('settings_'.$requestKey);
                }
                settings([
                    $key => $value
                ]);
            }
        }

        return redirect()->route('backend.settings.index')
               ->with('success', trans('backend.saved'));
    }
}
