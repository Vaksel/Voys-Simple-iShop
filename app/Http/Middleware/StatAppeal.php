<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\StatVisit as StatVisitModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class StatAppeal
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
//        ddd(Cache::get($_SERVER['REMOTE_ADDR'] . '_user'));

        if(!Cache::store('file')->has($_SERVER['REMOTE_ADDR'] . '_user_appeal'))
        {
            if(Cache::store('file')->has('location_error'))
            {
                return $next($request);
            }
            else
            {
                Cache::store('file')->put($_SERVER['REMOTE_ADDR'] . '_user_appeal', 1, $seconds = 600);

                $location = StatVisitModel::getLocation(true);

                Log::write('debug', 'location', ['location' => $location]);

                Log::write('debug', 'serverCookie', ['cookie' => $_COOKIE]);

                if(!empty($location))
                {
                    $statVisit = StatVisitModel::where(['city_name' => $location['regionName'] . ',' . $location['city'], 'request_type' => 'appeal'])
                        ->whereDate('created_at', date('Y-m-d'))->first();

                    if($location === 'error, HTTP code 429 Too Many Requests')
                    {
                        Cache::store('file')->put('location_error', 1, $seconds = 60);
                    }
                    else
                    {
                        if(!empty($statVisit))
                        {
                            $statVisit->user_qty = $statVisit->user_qty + 1;
                        }
                        else
                        {
                            $statVisit = new StatVisitModel();
                            $statVisit->city_name = $location['regionName'] . ',' . $location['city'];
                            $statVisit->request_type = 'appeal';
                        }

                        $statVisit->save();
                    }
                }
            }
        }


        return $next($request);
    }
}
