@extends('layouts.app')

@section('page_title', '| Manage App')

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class='fas fa-home text-muted'></i></a></li>
        <li class="breadcrumb-item active" aria-current="page">Manage Apps</li>
    </ol>
</nav>
<div class="row">
    <div class="col-12 col-xl-12 stretch-card">
        <div class="row flex-grow-1">
            <div class="col-md-12 stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 m-auto">
                                <div class="mb-3">
                                    <label class="form-label">{{ _lang('App') }}</label>
                                    <select class="form-control select2" name="app_unique_id" required>
                                        <option value="">{{ _lang('Select One') }}</option>
                                        @foreach (App\Models\AppModel::where('status', 1)->get() as $data)
                                            <option value="{{ $data->app_unique_id }}" {{ $data->app_unique_id == $app_unique_id ? 'selected' : '' }}>
                                                {{ $data->app_name }} - {{ $data->app_unique_id }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- row -->

@if ($app)
<div class="row mt-3">
    <div class="col-12 col-xl-12 stretch-card">
        <div class="row flex-grow-1">
            <div class="col-md-12 stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-12">
                                <ul class="nav nav-pills nav-secondary  nav-pills-no-bd nav-pills-icons justify-content-center app-tabs" id="pills-tab-with-icon" role="tablist">
                                    <li class="nav-item">
                                        <button style="border: 1px solid #6571ff" class="nav-link active me-2" id="pills-android-tab-icon" data-toggle="pill" role="tab" aria-controls="pills-android-icon" aria-selected="true">
                                            <i class="fab fa-android"></i>
                                            Android
                                        </button>
                                    </li>
                                    <li class="nav-item">
                                        <button style="border: 1px solid #6571ff" class="nav-link" id="pills-ios-tab-icon" data-toggle="pill" role="tab" aria-controls="pills-ios-icon" aria-selected="false">
                                            <i class="fab fa-apple"></i>
                                            IOS
                                        </button>
                                    </li>
                                </ul>
                            </div>

                            <div class="col-md-12">
                                <div class="tab-content mt-2 mb-3" id="pills-with-icon-tabContent">
                                    
                                    <div class="tab-pane fade show active" id="pills-android-icon" role="tabpanel" aria-labelledby="pills-android-tab-icon">

                                        <div class="card mb-3">
                                            <div class="card-body">
                                                <h3 class="mb-3 header-title card-title">{{ _lang('General Settings') }}</h3>
                                                <form method="post" class="ajax-submit2 params-card" autocomplete="off" action="{{ route('store_app_settings', [$app->id, 'android']) }}">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="mb-3">
                                                                <label class="form-label">{{ _lang('Privacy Policy') }}</label>
                                                                <input type="text" class="form-control" name="android_privacy_policy" value="{{ get_app_content('android_privacy_policy') }}" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="mb-3">
                                                                <label class="form-label">{{ _lang('Terms And Condition') }}</label>
                                                                <input type="text" class="form-control" name="android_terms_and_condition" value="{{ get_app_content('android_terms_and_condition') }}" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="mb-3">
                                                                <label class="form-label">{{ _lang('App Share Link') }}</label>
                                                                <input type="text" class="form-control" name="android_app_share_link" value="{{ get_app_content('android_app_share_link') }}" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="mb-3">
                                                                <label class="form-label">{{ _lang('App Default Page') }}</label>
                                                                <select class="form-control select2" name="android_default_page" data-selected="{{ get_app_content('android_default_page', '0') }}" required>
                                                                    <option value="0">{{ _lang('Live') }}</option>
                                                                    <option value="2">{{ _lang('Home') }}</option>
                                                                </select>
                                                            </div>
                                                        </div>
            
                                                        <div class="col-md-12">
                                                            <div class="form-group text-end">
                                                                <button type="submit" class="btn btn-primary btn-sm">
                                                                    {{ _lang('Update') }}
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                        <div class="card mb-3">
                                            <div class="card-body">
                                                <h3 class="mb-3 header-title card-title">{{ _lang('Live Control') }}</h3>
                                                <form method="post" class="ajax-submit2 params-card" autocomplete="off" action="{{ route('store_app_settings', [$app->id, 'android']) }}">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label">{{ _lang('App Publishing Control') }}</label>
                                                                <select class="form-control select2" name="android_app_publishing_control" data-selected="{{ get_app_content('android_app_publishing_control', 'on') }}" required>
                                                                    <option value="on">{{ _lang('On') }}</option>
                                                                    <option value="off">{{ _lang('Off') }}</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label">{{ _lang('Hide Live by Version Code') }}</label>
                                                                <input type="number" class="form-control" name="android_live_version_code" value="{{ get_app_content('android_live_version_code', '0') }}" min="0" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group text-end">
                                                                <button type="submit" class="btn btn-primary btn-sm">
                                                                    {{ _lang('Update') }}
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                        <div class="card mb-3">
                                            <div class="card-body">
                                                <h3 class="mb-3 header-title card-title">{{ _lang('Ads Settings') }}</h3>
                                                <form method="post" class="ajax-submit2 params-card my-2" autocomplete="off" action="{{ route('store_app_settings', [$app->id, 'android']) }}">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="mb-3">
                                                                <label class="form-label">{{ _lang('Ads Type') }}</label>
                                                                <select class="form-control select2" name="android_ads_type" data-selected="{{ get_app_content('android_ads_type', 'google') }}" required>
                                                                    <option value="google">{{ _lang('Google') }}</option>
                                                                    <option value="startapp">{{ _lang('Startapp') }}</option>
                                                                    <option value="facebook">{{ _lang('Facebook') }}</option>
                                                                    <option value="adcolony">{{ _lang('AdColony') }}</option>
                                                                    <option value="valueimpression">{{ _lang('ValueImpression') }}</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label">{{ _lang('Click Control') }}</label>
                                                                <select class="form-control select2" name="android_click_control" data-selected="{{ get_app_content('android_click_control', 'off') }}" required>
                                                                    <option value="off">{{ _lang('Off') }}</option>
                                                                    @for ($i = 1; $i <= 10; $i++)
                                                                    <option value="{{ $i }}" >{{ $i }}</option>
                                                                    @endfor
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group text-end">
                                                                <button type="submit" class="btn btn-primary btn-sm">
                                                                    {{ _lang('Update') }}
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                        <div class="card mb-3">
                                            <div class="card-body">
                                                <h3 class="mb-3 header-title card-title">{{ _lang('Google') }}</h3>
                                                <form method="post" class="ajax-submit2 params-card my-2" autocomplete="off" action="{{ route('store_app_settings', [$app->id, 'android']) }}">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label">{{ _lang('Google App Id') }}</label>
                                                                <input type="text" class="form-control" name="android_gapp_id" value="{{ get_app_content('android_gapp_id') }}" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label">{{ _lang('Google AppOpen Ads Code') }}</label>
                                                                <input type="text" class="form-control" name="android_gappopen_ads_code" value="{{ get_app_content('android_gappopen_ads_code') }}" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label">{{ _lang('Google Banner Ads Code') }}</label>
                                                                <input type="text" class="form-control" name="android_gbanner_ads_code" value="{{ get_app_content('android_gbanner_ads_code') }}" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label">{{ _lang('Google Interstitial Ads Code') }}</label>
                                                                <input type="text" class="form-control" name="android_ginterstitial_ads_code" value="{{ get_app_content('android_ginterstitial_ads_code') }}" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label">{{ _lang('Google Native Ads Code') }}</label>
                                                                <input type="text" class="form-control" name="android_gnative_ads_code" value="{{ get_app_content('android_gnative_ads_code') }}" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label">{{ _lang('Google Rewarded Ads Code') }}</label>
                                                                <input type="text" class="form-control" name="android_grewarded_ads_code" value="{{ get_app_content('android_grewarded_ads_code') }}" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group text-end">
                                                                <button type="submit" class="btn btn-primary btn-sm">
                                                                    {{ _lang('Update') }}
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                        <div class="card mb-3">
                                            <div class="card-body">
                                                <h3 class="mb-3 header-title card-title">{{ _lang('Version Control') }}</h3>
                                                <form method="post" class="ajax-submit2 params-card" autocomplete="off" action="{{ route('store_app_settings', [$app->id, 'android']) }}">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label">{{ _lang('Version Name') }}</label>
                                                                <input type="text" class="form-control" name="android_version_name" value="{{ get_app_content('android_version_name', '1.0.0') }}" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label">{{ _lang('Version Code') }}</label>
                                                                <input type="number" class="form-control" name="android_version_code" value="{{ get_app_content('android_version_code', '1') }}" min="0" required>
                                                            </div>
                                                        </div>
            
                                                        <div class="col-md-12">
                                                            <div class="mb-3">
                                                                <label class="form-label">{{ _lang('Force Update') }}</label>
                                                                <select class="form-control select2" name="android_force_update" data-selected="{{ get_app_content('android_force_update', 'no') }}" required>
                                                                    <option value="no">{{ _lang('NO') }}</option>
                                                                    <option value="yes">{{ _lang('Yes') }}</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label">{{ _lang('App Url') }}</label>
                                                                <input type="text" class="form-control" name="android_app_url" value="{{ get_app_content('android_app_url') }}" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label">{{ _lang('Button Text') }}</label>
                                                                <input type="text" class="form-control" name="android_button_text" value="{{ get_app_content('android_button_text') }}" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="mb-3">
                                                                <label class="form-label">{{ _lang('Description') }}</label>
                                                                <textarea class="form-control" name="android_description">{{ get_app_content('android_description') }}</textarea>
                                                            </div>
                                                        </div>
            
                                                        <div class="col-md-12">
                                                            <div class="form-group text-end">
                                                                <button type="submit" class="btn btn-primary btn-sm">
                                                                    {{ _lang('Update') }}
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="tab-pane fade" id="pills-ios-icon" role="tabpanel" aria-labelledby="pills-ios-tab-icon">

                                        <div class="card mb-3">
                                            <div class="card-body">
                                                <h3 class="mb-3 header-title card-title">{{ _lang('IOS Settings') }}</h3>
                                                <form method="post" class="ajax-submit2 params-card" autocomplete="off" action="{{ route('store_app_settings', [$app->id, 'ios']) }}">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label">{{ _lang('Privacy Policy') }}</label>
                                                                <input type="text" class="form-control" name="ios_privacy_policy" value="{{ get_app_content('ios_privacy_policy') }}" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="mb-3">
                                                                <label class="form-label">{{ _lang('Terms And Condition') }}</label>
                                                                <input type="text" class="form-control" name="ios_terms_and_condition" value="{{ get_app_content('ios_terms_and_condition') }}" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label">{{ _lang('App Share Link') }}</label>
                                                                <input type="text" class="form-control" name="ios_app_share_link" value="{{ get_app_content('ios_app_share_link') }}" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="mb-3">
                                                                <label class="form-label">{{ _lang('App Rating Link') }}</label>
                                                                <input type="text" class="form-control" name="ios_app_rating_link" value="{{ get_app_content('ios_app_rating_link') }}" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="mb-3">
                                                                <label class="form-label">{{ _lang('App Default Page') }}</label>
                                                                <select class="form-control select2" name="ios_default_page" data-selected="{{ get_app_content('ios_default_page', '0') }}" required>
                                                                    <option value="0">{{ _lang('Live') }}</option>
                                                                    <option value="2">{{ _lang('Home') }}</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group text-end">
                                                                <button type="submit" class="btn btn-primary btn-sm">
                                                                    {{ _lang('Update') }}
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                        <div class="card mb-3">
                                            <div class="card-body">
                                                <h3 class="mb-3 header-title card-title">{{ _lang('Live Control') }}</h3>
                                                <form method="post" class="ajax-submit2 params-card" autocomplete="off" action="{{ route('store_app_settings', [$app->id, 'ios']) }}">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label">{{ _lang('App Publishing Control') }}</label>
                                                                <select class="form-control select2" name="ios_app_publishing_control" data-selected="{{ get_app_content('ios_app_publishing_control') }}" required>
                                                                    <option value="on">{{ _lang('On') }}</option>
                                                                    <option value="off">{{ _lang('Off') }}</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label">{{ _lang('Hide Live by Version Code') }}</label>
                                                                <input type="number" class="form-control" name="ios_live_version_code" value="{{ get_app_content('ios_live_version_code') }}" min="0" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group text-end">
                                                                <button type="submit" class="btn btn-primary btn-sm">
                                                                    {{ _lang('Update') }}
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                        <div class="card mb-3">
                                            <div class="card-body">
                                                <h3 class="mb-3 header-title card-title">{{ _lang('Ads Settings') }}</h3>
                                                <form method="post" class="ajax-submit2 params-card" autocomplete="off" action="{{ route('store_app_settings', [$app->id, 'ios']) }}">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="mb-3">
                                                                <label class="form-label">{{ _lang('Ads Type') }}</label>
                                                                <select class="form-control select2" name="ios_ads_type" data-selected="{{ get_app_content('ios_ads_type', 'google') }}" required>
                                                                    <option value="google">{{ _lang('Google') }}</option>
                                                                    <option value="startapp">{{ _lang('Startapp') }}</option>
                                                                    <option value="facebook">{{ _lang('Facebook') }}</option>
                                                                    <option value="adcolony">{{ _lang('AdColony') }}</option>
                                                                    <option value="valueimpression">{{ _lang('ValueImpression') }}</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label">{{ _lang('Click Control') }}</label>
                                                                <select class="form-control select2" name="ios_click_control" data-selected="{{ get_app_content('ios_click_control', 'off') }}" required>
                                                                    <option value="off">{{ _lang('Off') }}</option>
                                                                    @for ($i = 1; $i <= 10; $i++)
                                                                    <option value="{{ $i }}" >{{ $i }}</option>
                                                                    @endfor
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group text-end">
                                                                <button type="submit" class="btn btn-primary btn-sm">
                                                                    {{ _lang('Update') }}
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                        <div class="card mb-3">
                                            <div class="card-body">
                                                <h3 class="mb-3 header-title card-title">{{ _lang('Google') }}</h3>
                                                <form method="post" class="ajax-submit2 params-card my-2" autocomplete="off" action="{{ route('store_app_settings', [$app->id, 'ios']) }}">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label">{{ _lang('Google App Id') }}</label>
                                                                <input type="text" class="form-control" name="ios_gapp_id" value="{{ get_app_content('ios_gapp_id') }}" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label">{{ _lang('Google AppOpen Ads Code') }}</label>
                                                                <input type="text" class="form-control" name="ios_gappopen_ads_code" value="{{ get_app_content('ios_gappopen_ads_code') }}" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label">{{ _lang('Google Banner Ads Code') }}</label>
                                                                <input type="text" class="form-control" name="ios_gbanner_ads_code" value="{{ get_app_content('ios_gbanner_ads_code') }}" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label">{{ _lang('Google Interstitial Ads Code') }}</label>
                                                                <input type="text" class="form-control" name="ios_ginterstitial_ads_code" value="{{ get_app_content('ios_ginterstitial_ads_code') }}" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label">{{ _lang('Google Native Ads Code') }}</label>
                                                                <input type="text" class="form-control" name="ios_gnative_ads_code" value="{{ get_app_content('ios_gnative_ads_code') }}" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label">{{ _lang('Google Rewarded Ads Code') }}</label>
                                                                <input type="text" class="form-control" name="ios_grewarded_ads_code" value="{{ get_app_content('ios_grewarded_ads_code') }}" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group text-end">
                                                                <button type="submit" class="btn btn-primary btn-sm">
                                                                    {{ _lang('Update') }}
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                        <div class="card mb-3">
                                            <div class="card-body">
                                                <h3 class="mb-3 header-title card-title">{{ _lang('Version Control') }}</h3>
                                                <form method="post" class="ajax-submit2 params-card" autocomplete="off" action="{{ route('store_app_settings', [$app->id, 'ios']) }}">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label">{{ _lang('Version Name') }}</label>
                                                                <input type="text" class="form-control" name="ios_version_name" value="{{ get_app_content('ios_version_name', '1.0.0') }}" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label">{{ _lang('Version Code') }}</label>
                                                                <input type="number" class="form-control" name="ios_version_code" value="{{ get_app_content('ios_version_code', '1') }}" min="0" required>
                                                            </div>
                                                        </div>
            
                                                        <div class="col-md-12">
                                                            <div class="mb-3">
                                                                <label class="form-label">{{ _lang('Force Update') }}</label>
                                                                <select class="form-control select2" name="ios_force_update" data-selected="{{ get_app_content('ios_force_update', 'no') }}" required>
                                                                    <option value="no">{{ _lang('NO') }}</option>
                                                                    <option value="yes">{{ _lang('Yes') }}</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label">{{ _lang('App Url') }}</label>
                                                                <input type="text" class="form-control" name="ios_app_url" value="{{ get_app_content('ios_app_url') }}" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label">{{ _lang('Button Text') }}</label>
                                                                <input type="text" class="form-control" name="ios_button_text" value="{{ get_app_content('ios_button_text') }}" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="mb-3">
                                                                <label class="form-label">{{ _lang('Description') }}</label>
                                                                <textarea class="form-control" name="ios_description">{{ get_app_content('ios_description') }}</textarea>
                                                            </div>
                                                        </div>
            
                                                        <div class="col-md-12">
                                                            <div class="form-group text-end">
                                                                <button type="submit" class="btn btn-primary btn-sm">
                                                                    {{ _lang('Update') }}
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- row -->
@endif
@endsection

@section('js-script')
<script type="text/javascript">

	$(document).on("change", "select[name='app_unique_id']", function () {
		var app_unique_id = $(this).val();
        console.log(app_unique_id);
		if (app_unique_id != '') {
			window.location.href = "{{ url('manage_app') }}/" + app_unique_id;
		}else{
			window.location.href = "{{ url('manage_app') }}/";
		}
	});

    $('button#pills-android-tab-icon').on('click', function() {

        $('div#pills-ios-icon').removeClass('show active');
        $('div#pills-android-icon').addClass('show active');
        $('button#pills-android-tab-icon').addClass('active');
        $('button#pills-ios-tab-icon').removeClass('active');

    })

    $('button#pills-ios-tab-icon').on('click', function() {

        $('div#pills-android-icon').removeClass('show active');
        $('div#pills-ios-icon').addClass('show active');
        $('button#pills-android-tab-icon').removeClass('active');
        $('button#pills-ios-tab-icon').addClass('active');

    })
</script>
@endsection