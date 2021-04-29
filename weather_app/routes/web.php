<?php

use App\Models\Temperature;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $query=DB::table('temperatures')->select(DB::raw('AVG(temperature) as temperature'), DB::raw('AVG(humidity) as humidity'), DB::raw('HOUR(sensing_date) as hours'))
    ->groupby('hours')
    ->where(DB::raw('DAY(created_at)'),DB::raw('DAY(NOW())'))->get();
        //return $query;
    return Inertia::render('Welcome', [
        'init_temperatures'=>$query,
        ]);
});


require __DIR__.'/auth.php';
