<?php

namespace App\Http\Middleware;

use Closure;
use Session;
class SetBranch
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!Session::has('BraID')) {
            $branch = \App\Models\Branch::get();
            if(sizeof($branch)!=0 || \Auth::user('admin')->user_group_id!=1) {
                return redirect('/branch');
            }
        }
        return $next($request);
    }
}
