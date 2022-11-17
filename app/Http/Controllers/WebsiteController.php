<?php

namespace App\Http\Controllers;

use App\Models\AppModel;
use App\Models\LiveMatch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class WebsiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function server_cache_clear()
    {
        $apps = AppModel::orderBy('id', 'DESC')->get();

        foreach ($apps as $key => $app) {
            Cache::forget("settings_" . $app->id);
            Cache::forget("live_matches_" . $app->app_unique_id);
            Cache::forget("highlights_" . $app->app_unique_id);
            Cache::forget("fixures");
            Cache::forget("sports_types");
            Cache::forget("subscriptions_{$app->app_unique_id}_android");
            Cache::forget("subscriptions_{$app->app_unique_id}_ios");
            Cache::forget("subscriptions_{$app->app_unique_id}_");

            $live_matches = LiveMatch::select('live_matches.*')
                            ->join('live_match_apps', 'live_match_apps.match_id', 'live_matches.id')
                            ->join('apps', 'apps.id', 'live_match_apps.app_id')
                            ->where('apps.app_unique_id', $app->app_unique_id)
                            ->orderBy('id', 'DESC')
                            ->get();

            foreach ($live_matches as $key => $value) {
                Cache::forget('streamingSources_' . $value->id);
            }
        }

        return $apps->count();
    }
}
