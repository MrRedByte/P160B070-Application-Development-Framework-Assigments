<?php

namespace App\Http\Controllers;

use App\Models\Owner;
use App\Models\Car;
use App\Models\Policy;
use App\Models\Claim;
use App\Models\Quote;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Dashboard statistics
        $stats = [
            'total_owners' => Owner::count(),
            'total_cars' => Car::count(),
            'active_policies' => Policy::where('status', 'active')->count(),
            'total_policies' => Policy::count(),
            'pending_claims' => Claim::where('status', 'filed')->count(),
            'total_claims' => Claim::count(),
            'pending_quotes' => Quote::where('status', 'pending')->count(),
            'total_quotes' => Quote::count(),
        ];

        // Recent policies
        $recentPolicies = Policy::with(['owner', 'car'])
            ->latest()
            ->take(5)
            ->get();

        // Recent claims
        $recentClaims = Claim::with(['policy', 'driver'])
            ->latest()
            ->take(5)
            ->get();

        // Upcoming payments (policies expiring soon)
        $expiringPolicies = Policy::where('status', 'active')
            ->where('end_date', '<=', now()->addDays(30))
            ->with(['owner', 'car'])
            ->orderBy('end_date')
            ->take(5)
            ->get();

        return view('home', compact('stats', 'recentPolicies', 'recentClaims', 'expiringPolicies'));
    }
}
