<?php

namespace App\Http\Controllers;

use App\Models\Cartoon;
use App\Models\Criteria;
use App\Models\CriteriaIndicator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CartoonController extends Controller
{
    public function index()
    {
        $cartoons = Cartoon::get(['cartoon_id', 'cartoon_name', 'cartoon_img']);
        $criteria_indicators = CriteriaIndicator::all();
        $criteria = Criteria::all();
        return view('welcome', compact('cartoons', 'criteria_indicators', 'criteria'));
    }
    function results($ranked, $normalized, $weighted, $minMax, $finalResult, $weights)
    {
        $ids = implode(',', $ranked);
        $results = Cartoon::whereIntegerInRaw('cartoon_id', $ranked)
            ->orderByRaw(Cartoon::raw("FIELD(cartoon_id, $ids)"))
            ->get(['cartoon_id', 'cartoon_name', 'cartoon_img']);
        $cartoons = Cartoon::get(['cartoon_id', 'cartoon_name', 'cartoon_img']);
        $criteria_indicators = CriteriaIndicator::all();
        $criteria = Criteria::all();
        Session::flash('success', $results[0]->cartoon_name . ' is the highest-ranking among all your choices');
        return view('welcome', compact(
            'cartoons',
            'criteria_indicators',
            'criteria',
            'results',
            'normalized',
            'weighted',
            'minMax',
            'finalResult',
            'ranked',
            'weights'
        ));
    }
    public function process(Request $request)
    {
        if ($request->has('cartoons')) {
            if (count($request->cartoons) < 2) {
                return redirect()->back()->with('error', 'Please select at least 2 cartoons');
            } else {
                $criteria = Criteria::all();
                foreach ($criteria as $criterion) {
                    if (!$request->has('criteria_indicator' . $criterion->criteria_id)) {
                        return redirect()->back()->with('error', 'Please select the weight of criteria ' . $criterion->criteria_name);
                    }
                }
                // start working on Multi-Objective Optimization Method by Ratio Analysis method
                $cartoons = $request->cartoons;
                $weights = array();
                foreach ($criteria as $criterion) {
                    $weights[$criterion->criteria_name] = $request->{'criteria_indicator' . $criterion->criteria_id};
                }
                // Normalize
                $normalized = $this->normalize($criteria, $cartoons);
                // Normalized * weights
                $weighted = $this->weighted($criteria, $cartoons, $normalized, $weights);
                // Sum of weighted and get final result
                $minMax = $this->minMax($criteria, $cartoons, $weighted);
                // Rank the results
                $finalResult = $this->ranking($cartoons, $minMax);
                // Send to results
                $ranked = array_keys($finalResult);

                return $this->results($ranked, $normalized, $weighted, $minMax, $finalResult, $weights);
            }
        } else {
            return redirect()->back()->with('error', 'Please select at least 2 cartoons');
        }
    }
    public function normalize($criteria, $cartoons)
    {
        $scores = array();
        foreach ($criteria as $criterion) {
            foreach ($cartoons as $cartoon) {
                $a = Cartoon::where('cartoon_id', $cartoon)->first();
                $value = pow($a->{$criterion->criteria_name}, 2);
                $scores[$cartoon][$criterion->criteria_name] = $value;
            }
            $value = array_sum(array_column($scores, $criterion->criteria_name));
            $value = sqrt($value);
            foreach ($cartoons as $cartoon) {
                $a = Cartoon::where('cartoon_id', $cartoon)->first();
                $scores[$cartoon][$criterion->criteria_name] = $a->{$criterion->criteria_name} / $value;
            }
        }
        return $scores;
    }
    public function weighted($criteria, $cartoons, $normalized, $weights)
    {
        $scores = $normalized;
        foreach ($criteria as $criterion) {
            foreach ($cartoons as $cartoon) {
                $value = $scores[$cartoon][$criterion->criteria_name] * $weights[$criterion->criteria_name];
                $scores[$cartoon][$criterion->criteria_name] = $value;
            }
        }
        return $scores;
    }
    public function minMax($criteria, $cartoons, $weighted)
    {
        $scores = $weighted;
        $results = array();
        foreach ($cartoons as $cartoon) {
            $valueMax = 0;
            $valueMin = 0;
            foreach ($criteria as $criterion) {
                if ($criterion->criteria_type == 'benefit') {
                    $valueMax +=  $scores[$cartoon][$criterion->criteria_name];
                } else if ($criterion->criteria_type == 'cost') {
                    $valueMin +=  $scores[$cartoon][$criterion->criteria_name];
                }
            }
            $results[$cartoon]['max'] = $valueMax;
            $results[$cartoon]['min'] = $valueMin;
        }
        return $results;
    }
    public function ranking($cartoons, $results)
    {
        $ranking = array();
        foreach ($cartoons as $cartoon) {
            $value = $results[$cartoon]['max'] - $results[$cartoon]['min'];
            $ranking[$cartoon] = $value;
        }
        return $this->sort($ranking);
    }
    public function sort($ranking)
    {
        arsort($ranking, SORT_NUMERIC);
        return $ranking;
    }
    public function editDataCartoon(Cartoon $cartoon, Request $request)
    {
        $oldName = $cartoon->cartoon_name;
        $cartoon->cartoon_name = $request->cartoon_name;
        $cartoon->save();
        Session::flash('success', 'Cartoon ' . $oldName . ' has been renamed to ' . $cartoon->cartoon_name);
        return redirect()->back();
    }
    public function deleteCartoon(Cartoon $cartoon)
    {
        Storage::delete('public/' . $cartoon->cartoon_img);
        $cartoon->delete();
        Session::flash('success', 'Cartoon ' . $cartoon->cartoon_name . ' has been deleted');
        return redirect()->back();
    }
    public function addCartoon(Request $request)
    {
        if ($request->cartoonName == '') {
            return redirect()->back()->with('error', 'Please enter a name for the cartoon');
        }
        if ($request->file('cartoonImg')) {
            $filename = $request->file('cartoonImg')->store('images', 'public');
        } else {
            $filename = 'images/noImage.jpg';
        }
        $cartoon = new Cartoon();
        $cartoon->cartoon_name = $request->cartoonName;
        $cartoon->cartoon_img = $filename;
        $cartoon->save();
        Session::flash('success', 'Cartoon ' . $cartoon->cartoonName . ' has been added');
        return redirect()->back();
    }
    public function editCartoonImage(Cartoon $cartoon, Request $request)
    {
        if ($request->file('cartoonImg')) {
            $filename = $request->file('cartoonImg')->store('images', 'public');
            Storage::delete('public/' . $cartoon->cartoon_img);
            $cartoon->cartoon_img = $filename;
            $cartoon->save();
            Session::flash('success', 'Cartoon ' . $cartoon->cartoon_name . ' has been updated');
        } else {
            Session::flash('error', 'Please select an image');
        }
        return redirect()->back();
    }
    public function deleteSelectedCartoon(Request $request)
    {
        if ($request->has('cartoons')) {
            $cartoons = $request->cartoons;
            foreach ($cartoons as $cartoon) {
                $cartoon = Cartoon::where('cartoon_id', $cartoon)->first();
                Storage::delete('public/' . $cartoon->cartoon_img);
                $cartoon->delete();
            }
            return redirect()->back()->with('success', 'Deleted all (' . count($cartoons) . ') data successfully');
        } else {
            return redirect()->back()->with('error', 'Please select at least one cartoon');
        }
    }

    public function addCriteria(Request $request)
    {
        if ($request->criteriaName == '') {
            return redirect()->back()->with('error', 'Please enter a name for the criteria');
        }
        Schema::table('cartoons', function (Blueprint $table) use ($request) {
            $table->double($request->criteriaName)->default(0);
        });
        $criteria = new Criteria();
        $criteria->criteria_name = $request->criteriaName;
        $criteria->criteria_type = $request->criteriaType;
        $criteria->save();
        Session::flash('success', 'Criteria ' . $criteria->criteria_name . ' has been added');
        return redirect()->back();
    }
    public function editCriteria(Criteria $criteria, Request $request)
    {
        if ($request->criteriaName == '') {
            return redirect()->back()->with('error', 'Please enter a name for the criteria');
        }
        Schema::table('cartoons', function (Blueprint $table) use ($request, $criteria) {
            $table->renameColumn("[$criteria->criteria_name]", "[$request->criteriaName]");
        });
        $criteria->criteria_name = $request->criteriaName;
        $criteria->criteria_type = $request->criteriaType;
        $criteria->save();
        Session::flash('success', 'Criteria ' . $criteria->criteria_name . ' has been updated');
        return redirect()->back();
    }
    public function deleteCriteria(Criteria $criteria)
    {
        Schema::table('cartoons', function (Blueprint $table) use ($criteria) {
            $table->dropColumn($criteria->criteria_name);
        });
        $criteria->delete();
        Session::flash('success', 'Criteria ' . $criteria->criteria_name . ' has been deleted');
        return redirect()->back();
    }
    public function addCriteriaIndicator(Request $request)
    {
        if ($request->criteriaIndicatorName == '') {
            return redirect()->back()->with('error', 'Please enter a name for the criteria indicator');
        }
        if ($request->criteriaIndicatorValue == '') {
            return redirect()->back()->with('error', 'Please enter a value for the criteria indicator');
        }
        $criteriaIndicator = new CriteriaIndicator();
        $criteriaIndicator->criteria_indicator_name = $request->criteriaIndicatorName;
        $criteriaIndicator->criteria_indicator_value = $request->criteriaIndicatorValue;
        $criteriaIndicator->save();
        Session::flash('success', 'Criteria indicator ' . $criteriaIndicator->criteria_indicator_name . ' has been added');
        return redirect()->back();
    }
    public function editCriteriaIndicator(CriteriaIndicator $criteriaIndicator, Request $request)
    {
        if ($request->criteriaIndicatorName == '') {
            return redirect()->back()->with('error', 'Please enter a name for the criteria indicator');
        }
        if ($request->criteriaIndicatorValue == '') {
            return redirect()->back()->with('error', 'Please enter a value for the criteria indicator');
        }
        $criteriaIndicator->criteria_indicator_name = $request->criteriaIndicatorName;
        $criteriaIndicator->criteria_indicator_value = $request->criteriaIndicatorValue;
        $criteriaIndicator->save();
        Session::flash('success', 'Criteria indicator ' . $criteriaIndicator->criteria_indicator_name . ' has been updated');
        return redirect()->back();
    }
    public function deleteCriteriaIndicator(CriteriaIndicator $criteriaIndicator)
    {
        $criteriaIndicator->delete();
        Session::flash('success', 'Criteria indicator ' . $criteriaIndicator->criteria_indicator_name . ' has been deleted');
        return redirect()->back();
    }
}
