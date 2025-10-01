<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    public function index(Request $request)
    {
        $query = Portfolio::published()->orderBy('sort_order')->latest();

        if ($request->has('technology')) {
            $query->whereJsonContains('technologies', $request->technology);
        }

        if ($request->has('featured')) {
            $query->featured();
        }

        $portfolios = $query->paginate(12);

        // Get all unique technologies for filtering
        $allTechnologies = Portfolio::published()
            ->whereNotNull('technologies')
            ->pluck('technologies')
            ->flatten()
            ->unique()
            ->sort()
            ->values();

        return view('frontend.portfolio.index', compact('portfolios', 'allTechnologies'));
    }

    public function show(Portfolio $portfolio)
    {
        if (! $portfolio->is_published) {
            abort(404);
        }

        // Featured image will be lazy loaded when accessed in the view

        // Get related projects
        $relatedProjects = Portfolio::published()
            ->where('id', '!=', $portfolio->id)
            ->latest()
            ->take(3)
            ->get();

        return view('frontend.portfolio.show', compact('portfolio', 'relatedProjects'));
    }
}
