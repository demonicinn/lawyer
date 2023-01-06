<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Subscription
{
    use LivewireAlert;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
       
        $date = date('Y-m-d');
        $user = auth()->user();
        
        
        
        $subscription = $user->lawyerSubscription()
                        ->where('from_date', '<=', $date)
                        ->where('to_date', '>=', $date)
                        ->orderBy('id', 'desc')
                        ->first();

        
        if(@$subscription){
            return $next($request);
        }

        return redirect()->route('lawyer.subscription');
    }
}
