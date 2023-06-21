<?php

namespace App\Http\Controllers;

use App\Models\Cartoon;
use App\Models\Criteria;
use App\Models\CriteriaIndicator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        $cartoons = Cartoon::all();
        $criteria = Criteria::all();
        $criteria_indicators = CriteriaIndicator::all();
        return view('home', compact('cartoons', 'criteria', 'criteria_indicators'));
    }
    public function updateData(Request $request)
    {
        $cartoons = Cartoon::get(['cartoon_id', 'cartoon_name']);
        $criteria = Criteria::get(['criteria_id', 'criteria_name']);
        $error = false;
        $errorMessage = '';
        foreach ($cartoons as $cartoon) {
            foreach ($criteria as $criterion) {
                $value = $request->{'table-' . $cartoon->cartoon_id . '-' . $criterion->criteria_id};
                if ($value == null || $value <= 0) {
                    $error = true;
                    $errorMessage = 'The alternative ' . $cartoon->cartoon_name . ' has a negative or zero value for the criterion ' . $criterion->criteria_name;
                } else {
                    $cartoon->{$criterion->criteria_name} = $value;
                    $cartoon->save();
                }
            }
        }
        if ($error) {
            return redirect()->back()->with('error', $errorMessage);
        }
        return redirect()->back()->with('success', 'Updated all data successfully');
    }
}
