<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\AppContent;
use App\Models\AppModel;
use App\Models\Highlight;
use App\Models\HighlightStreamingSource;
use App\Models\LiveMatch;
use App\Models\PopularSeries;
use App\Models\SportsType;
use App\Models\StreamingSource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    public function sports_type()
	{
        $status = false;
		$base_url = url('/');

		$sports_types = Cache::rememberForever('sports_types', function () use ($base_url){
			return SportsType::select('*', DB::raw("CONCAT('$base_url/public/uploads/images/spots_types/', sports_skq, '.jpg') AS sports_image"))
								->where('status', 1)
								->get()
                                ->makeHidden(['status', 'created_at', 'updated_at']);
		});
		
		$status = true;
		return response()->json(['status' => $status, 'data' => $sports_types]);
    }

	public function live_matches(Request $request, $app_unique_id) 
    {
		$base_url = url('/');
        $status = true;
        $live_matches = Cache::rememberForever('live_matches_' . $app_unique_id, function () use($base_url, $app_unique_id) {
                return LiveMatch::select('live_matches.*', DB::raw("CASE WHEN team_one_image_type = 'url' THEN team_one_url WHEN team_one_image_type = 'image' THEN CONCAT('$base_url/', team_one_image) ELSE '$base_url/public/default/default-team.png' END AS team_one_image"), DB::raw("CASE WHEN team_two_image_type = 'url' THEN team_two_url WHEN team_two_image_type = 'image' THEN CONCAT('$base_url/', team_two_image) ELSE '$base_url/public/default/default-team.png' END AS team_two_image"), DB::raw("CASE WHEN cover_image_type = 'url' THEN cover_url WHEN cover_image_type = 'image' THEN CONCAT('$base_url/', cover_image) ELSE '$base_url/public/default/default-team.png' END AS cover_image"))
                        ->join('live_match_apps', 'live_match_apps.match_id', 'live_matches.id')
                        ->join('apps', 'apps.id', 'live_match_apps.app_id')
                        ->where('apps.app_unique_id', $app_unique_id)
                        ->orderBy('position', 'ASC')
                        ->get()
                        ->makeHidden(['status', 'created_at', 'updated_at']);
        });

        $data = array();
        $ip = $request->ip();
        $i = 0;

        foreach ($live_matches as $key => $value) {

            $data[$i] = $value->makeHidden(['sports_type_id', 'team_one_image_type', 'team_one_url', 'team_two_image_type', 'team_two_url']);
            
            $streaming_sources = array();
            $streamingSources = Cache::rememberForever('streamingSources_' . $value->id, function () use ($value){
            	return StreamingSource::where('match_id', $value->id)->orderBy('position', 'ASC')->get();
            });
            foreach ($streamingSources as $key2 => $source) {
                if ($source->stream_type == 'root_stream') {
                    $source->stream_url = getGeneratedToken($source->stream_url, $source->stream_key, $ip);
					
                    $streaming_sources[] = $source->makeHidden(['block_country', 'is_block_them', 'created_at', 'updated_at']);
                }else{
					if($request->platform == 'android' && $source->stream_type == 'restricted'){
						$headers = array();
						$i2 = 0;
						foreach(json_decode($source->headers, true) AS $key => $value){

							if($key != 'User-Agent'){
								$headers[$i2]['name'] = $key;
								$headers[$i2]['value'] = $value;
								$i2 ++;
							}else{
								$source->$key = $value;
							}
						}
						$source->headers = $headers;
					}
                    $streaming_sources[] = $source->makeHidden(['block_country', 'is_block_them', 'created_at', 'updated_at']);
                }
            }
            $data[$i]['streaming_sources'] = $streaming_sources;

            $i++;
        }
        return response()->json(['status' => $status, 'data' => $data]);
    }

	public function live_matches_by_type(Request $request, $app_unique_id)
	{
		$base_url = url('/');
        $status = true;

        $data = Cache::rememberForever('sports_types', function () use ($base_url){
			return SportsType::select('*', DB::raw("CONCAT('$base_url/public/uploads/sports_images/', sports_skq, '.png') AS sports_image"))->get();
		});

        if($request->skq != '' && $request->skq != 'all'){
        	$types = $data->where('sports_skq', $request->skq)->pluck('id')->toArray();
        }else{
        	$types = $data->pluck('id')->toArray();
        }
			
        $live_matches = Cache::rememberForever('live_matches_' . $app_unique_id, function () use($base_url, $app_unique_id) {
                return LiveMatch::select('live_matches.*', DB::raw("CASE WHEN team_one_image_type = 'url' THEN team_one_url WHEN team_one_image_type = 'image' THEN CONCAT('$base_url/', team_one_image) ELSE '$base_url/public/default/default-team.png' END AS team_one_image"), DB::raw("CASE WHEN team_two_image_type = 'url' THEN team_two_url WHEN team_two_image_type = 'image' THEN CONCAT('$base_url/', team_two_image) ELSE '$base_url/public/default/default-team.png' END AS team_two_image"), DB::raw("CASE WHEN cover_image_type = 'url' THEN cover_url WHEN cover_image_type = 'image' THEN CONCAT('$base_url/', cover_image) ELSE '$base_url/public/default/default-team.png' END AS cover_image"))
                        ->join('live_match_apps', 'live_match_apps.match_id', 'live_matches.id')
                        ->join('apps', 'apps.id', 'live_match_apps.app_id')
                        ->where('apps.app_unique_id', $app_unique_id)
                        ->orderBy('position', 'ASC')
                        ->get()
                        ->makeHidden(['status', 'created_at', 'updated_at']);
        });

        $live_matches = $live_matches->whereIn('sports_type_id', $types);

        $data = array();
        $ip = $request->ip();
        $i = 0;

        foreach ($live_matches as $key => $value) {

            $data[$i] = $value->makeHidden(['sports_type_id', 'team_one_image_type', 'team_one_url', 'team_two_image_type', 'team_two_url']);
            
            $streaming_sources = array();
            $streamingSources = Cache::rememberForever('streamingSources_' . $value->id, function () use ($value){
            	return StreamingSource::where('match_id', $value->id)->orderBy('position', 'ASC')->get();
            });
            foreach ($streamingSources as $key2 => $source) {
                if ($source->stream_type == 'root_stream') {
                    $source->stream_url = getGeneratedToken($source->stream_url, $source->stream_key, $ip);
					
                    $streaming_sources[] = $source->makeHidden(['block_country', 'is_block_them', 'created_at', 'updated_at']);
                }else{
					if($request->platform == 'android' && $source->stream_type == 'restricted'){
						$headers = array();
						$i2 = 0;
						foreach(json_decode($source->headers, true) AS $key => $value){

							if($key != 'User-Agent'){
								$headers[$i2]['name'] = $key;
								$headers[$i2]['value'] = $value;
								$i2 ++;
							}else{
								$source->$key = $value;
							}
						}
						$source->headers = $headers;
					}
                    $streaming_sources[] = $source->makeHidden(['block_country', 'is_block_them', 'created_at', 'updated_at']);
                }
            }
            $data[$i]['streaming_sources'] = $streaming_sources;

            $i++;
        }
        return response()->json(['status' => $status, 'data' => $data]);
	}

	public function streaming_sources(Request $request, $app_unique_id, $match_id) 
    {
		$base_url = url('/');
        $status = true;
        $live_match = Cache::rememberForever('live_match_' . $match_id, function () use ($match_id, $app_unique_id){
            return LiveMatch::select('live_matches.*')
                        ->join('live_match_apps', 'live_match_apps.match_id', 'live_matches.id')
                        ->join('apps', 'apps.id', 'live_match_apps.app_id')
						->where('live_matches.id', $match_id)
                        ->where('apps.app_unique_id', $app_unique_id)
                        ->orderBy('id', 'DESC')
                        ->first();
        });
		
		if(!$live_match)
			return response()->json(['status' => false, 'message' => 'No matches found.']);

        $ip = $request->ip_address ?? $request->getClientIp(true);
		
        $streaming_sources = array();
        $streamingSources = Cache::rememberForever('streamingSources_' . $live_match->id, function () use ($live_match){
        	return StreamingSource::where('match_id', $live_match->id)->orderBy('position', 'ASC')->get();
        });

        foreach ($streamingSources as $key2 => $source) 
		{
			if ($source->stream_type == 'root_stream') 
			{
				$source->stream_url = getGeneratedToken($source->stream_url, $source->stream_key, $ip);
				$streaming_sources[] = $source->makeHidden(['block_country', 'is_block_them', 'created_at', 'updated_at']);
			}
			else
			{
				if($request->platform == 'android' && $source->stream_type == 'restricted')
				{
					$headers = array();
					$i2 = 0;
					foreach(json_decode($source->headers, true) AS $key => $value)
					{
						if($key != 'User-Agent')
						{
							$headers[$i2]['name'] = $key;
							$headers[$i2]['value'] = $value;
							$i2 ++;
						}
						else
							$source->$key = $value;
						
					}
					$source->headers = $headers;
				}

				if($request->platform == 'ios' && $source->stream_type == 'restricted')
					$source->headers = json_decode($source->headers, true);

				$streaming_sources[] = $source->makeHidden(['status', 'block_country', 'is_block_them', 'created_at', 'updated_at']);
			}
        }
        return response()->json(['status' => $status, 'data' => $streaming_sources]);
    }

	public function highlights(Request $request, $app_unique_id) 
    {
		$base_url = url('/');
        $status = true;
        $highlights = Cache::rememberForever('highlights_' . $app_unique_id, function () use($base_url, $app_unique_id) {
                return Highlight::select('highlights.*', DB::raw("CASE WHEN team_one_image_type = 'url' THEN team_one_url WHEN team_one_image_type = 'image' THEN CONCAT('$base_url/', team_one_image) ELSE '$base_url/public/default/default-team.png' END AS team_one_image"), DB::raw("CASE WHEN team_two_image_type = 'url' THEN team_two_url WHEN team_two_image_type = 'image' THEN CONCAT('$base_url/', team_two_image) ELSE '$base_url/public/default/default-team.png' END AS team_two_image"), DB::raw("CASE WHEN cover_image_type = 'url' THEN cover_url WHEN cover_image_type = 'image' THEN CONCAT('$base_url/', cover_image) ELSE '$base_url/public/default/default-team.png' END AS cover_image"))
                        ->join('highlight_apps', 'highlight_apps.highlight_id', 'highlights.id')
                        ->join('apps', 'apps.id', 'highlight_apps.app_id')
                        ->where('apps.app_unique_id', $app_unique_id)
                        ->orderBy('id', 'DESC')
                        ->get()
                        ->makeHidden(['status', 'created_at', 'updated_at']);
        });

        $data = array();
        $ip = $request->ip();
        $i = 0;

        foreach ($highlights as $key => $value) {

            $data[$i] = $value->makeHidden(['sports_type_id', 'team_one_image_type', 'team_one_url', 'team_two_image_type', 'team_two_url']);
            
            $streaming_sources = array();
            $streamingSources = Cache::rememberForever('highlightStreamingSources_' . $value->id, function () use ($value){
            	return HighlightStreamingSource::where('highlight_id', $value->id)->get();
            });

            foreach ($streamingSources as $key2 => $source) 
			{

                if ($source->stream_type == 'root_stream') {
                    $source->stream_url = getGeneratedToken($source->stream_url, $source->stream_key, $ip);
					
                    $streaming_sources[] = $source->makeHidden(['block_country', 'is_block_them', 'created_at', 'updated_at']);
                }
				else
				{
					if($request->platform == 'android' && $source->stream_type == 'restricted'){
						$headers = array();
						$i2 = 0;
						foreach(json_decode($source->headers, true) AS $key => $value){

							if($key != 'User-Agent'){
								$headers[$i2]['name'] = $key;
								$headers[$i2]['value'] = $value;
								$i2 ++;
							}else{
								$source->$key = $value;
							}
						}
						$source->headers = $headers;
					}
                    $streaming_sources[] = $source->makeHidden(['block_country', 'is_block_them', 'created_at', 'updated_at']);
                }
            }
            $data[$i]['streaming_sources'] = $streaming_sources;
            $i++;
        }
        return response()->json(['status' => $status, 'data' => $data]);
    }

	public function popular_series($app_unique_id) 
	{
        $status = false;
		$app = Cache::rememberForever('app_' . $app_unique_id, function () use ($app_unique_id){
			return AppModel::where('app_unique_id', $app_unique_id)->first();
		});
		
		$popularSeries = Cache::rememberForever('popular_series_' . $app_unique_id, function (){
			return PopularSeries::where('status', 1)->orderBy('id', 'DESC')->get();
		});
		
		$popular_series = [];

        foreach ($popularSeries as $key => $series) 
		{
            if(in_array($app->id, json_decode($series->apps) ?? ['n/a'])){
                $popular_series[] = $series->makeHidden(['apps', 'created_at', 'updated_at', 'status']);
            }
        }
        $status = true;
        return response()->json(['status' => $status, 'data' => $popular_series]);
    }

	public function settings($app_unique_id, $platform = '') 
	{
        $status = false;

        $app = Cache::rememberForever('app_' . $app_unique_id, function () use ($app_unique_id){
			return AppModel::where('app_unique_id', $app_unique_id)->first();
		});
		if($app){
			if ($platform) {
				$settings = Cache::rememberForever('settings_' . $app->id, function () use ($platform, $app){
                	return AppContent::where('platform', $platform)
								->where('app_id', $app->id)
								->pluck('value', 'name')
								->toArray();
                });
			}else{
			    $settings = Cache::rememberForever('settings_' . $app->id, function () use ($app){
                	return AppContent::where('app_id', $app->id)
								->pluck('value', 'name')
								->toArray();
                });
			}

            $settings['ip'] = get_option('server');
			$status = true;
        	return response()->json(['status' => $status, 'data' => $settings]);
		}
		abort(404);
    }

}
