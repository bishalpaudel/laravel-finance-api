<?php

Route::get('/', function()
{
	return 'hello finance api';
});

Route::get('asset-info', array('uses' => 'Controllers\AssetInfo\AssetInfo@show'), function($response)
{
    return Response::json($response);
});