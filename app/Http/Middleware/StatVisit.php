<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cookie;
use App\Models\StatVisit as StatVisitModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class StatVisit
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
        if(!Cache::store('file')->has($_SERVER['REMOTE_ADDR'] . '_user'))
        {
            if(Cache::store('file')->has('location_error'))
            {
                return $next($request);
            }
            else
            {
                $location = StatVisitModel::getLocation();

                if(!empty($location['city']))
                {
                    Cache::store('file')->put($_SERVER['REMOTE_ADDR'] . '_user', $request->path(), $seconds = 600);

                    if($location === 'error, HTTP code 429 Too Many Requests')
                    {
                        Cache::store('file')->put('location_error', 1, $seconds = 60);
                    }
                    else
                    {
                        $statVisit = StatVisitModel::where(['city_name' => $location['regionName'] . ',' . $location['city'],
                            'request_type' => 'visit'])
                            ->whereDate('created_at', date('Y-m-d'))->first();

                        if(!empty($statVisit))
                        {
                            $statVisit->user_qty = $statVisit->user_qty + 1;
                        }
                        else
                        {
                            $statVisit = new StatVisitModel();
                            $statVisit->city_name = $location['regionName'] . ',' . $location['city'];
                            $statVisit->request_type = 'visit';
                        }

                        Cache::store('file')->put($_SERVER['REMOTE_ADDR'] . '_location',
                            $location['regionName'] . ',' . $location['city'], $seconds = 600);

                        $statVisit->save();
                    }
                }
            }
        }


        return $next($request);
    }
}
