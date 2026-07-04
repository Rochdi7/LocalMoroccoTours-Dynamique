<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use App\Models\Activity;
use App\Models\Trekking;
use App\Models\Post;
use App\Models\User;
use App\Models\Location;
use App\Models\SpecialOffer;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard with summary statistics.
     */
    public function index()
    {
        $stats = [
            'tours' => Tour::count(),
            'activities' => Activity::count(),
            'trekkings' => Trekking::count(),
            'posts' => Post::count(),
            'offers' => SpecialOffer::count(), 
            'locations' => Location::count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
