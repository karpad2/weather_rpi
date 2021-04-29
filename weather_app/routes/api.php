<?php

use App\Models\Temperature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('save',function (Request $request){
    Temperature::create(['temperature'=>$request->temperature,'humidity'=>$request->humidity,'sense_date'=>now()]);
    return 'ok';
});
Route::get('get',function (Request $request){
    $query=DB::table('temperatures')->select(DB::raw('AVG(temperature) as temperature'), DB::raw('AVG(humidity) as humidity'), DB::raw('HOUR(created_at) as hours'))
    ->groupby('hours')
    ->where(DB::raw('DAY(created_at)'),DB::raw('DAY(NOW())'))->get();
        return $query;
});

