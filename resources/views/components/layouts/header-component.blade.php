<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
<title>@yield('title')</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="icon" href="{{ webiste()?->favicon ? storage_asset_path(webiste()->favicon) : asset('admin/assets/img/icon/favicon.jpg') }}" />
<link rel="stylesheet" href="{{ asset('admin/assets/icons/boxicons.css') }}" />
<link rel="stylesheet" href="{{ asset('css/template.css') }}" />
<link rel="stylesheet" href="{{ asset('css/style.css') }}" />
<style>
{!! selected_theme() !!}
</style>
