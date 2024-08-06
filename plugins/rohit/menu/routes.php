<?php

use Illuminate\Http\Request;
use Rohit\Menu\Models\Menu;
use Response;
use File;


Route::get('api/getAllMenus', function () {
    $menu = Menu::all();
    
    
    return response()->json($menu)
            ->header('Content-Type', 'application/json')
            ->header('Access-Control-Allow-Origin', '*');
});

