<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Flat;
use App\models\Serve;
use App\models\Indication;
use App\models\Street;
use App\models\Quietu;
use App\Charts\flatPays;

class ReportController extends Controller {

    //  1)перекрестный расчет за текущий месяц +
    //  2)диаграмма плата по каждой квартире за текущий месяц +
    //  3)список должников с суммой долга  +
    //  4)квитанция в надлежащем виде на печать +
    //  5)диаграмма на печать +
    //  6)кооперативная ведомость с итогом по каждому виду услуг +
    //  7)ведомость на печать +
    //  8)архивация + 
    //  9)льготы в паттерне стратегия 


    public function about() {
        $streets = Street::all();
        return view('reports.about', [
        ]);
    }

    public function index() {
        $streets = Street::all();
        return view('reports.index', [
            'streets' => $streets
        ]);
    }

    public function archivation() {
        $todayYear = date("Y");
        $oldQuietus = Quietu::where('date', '<', $todayYear)
                ->where('pay_status', 1)
                ->get();
        \Storage::disk('local')->put($todayYear . '.json', json_encode($oldQuietus));

        return 1;
    }

    public function debtors(Request $request) {
        $year = date('Y', strtotime($request->date));
        $month = date('m', strtotime($request->date));
        $unpaidQuietus = Quietu::with('flat.owner', 'flat.block.street')
                ->where('pay_status', 0)
                ->whereYear('date', $year)
                ->whereMonth('date', $month)
                ->get();
        //$flatsDebtors = Flat::with('block.street', 'owner')->find($unpaidQuietus);
        return view('reports.debtors', [
            'unpaidQuietus' => $unpaidQuietus
        ]);
    }

    public function quietus(Request $request) {
        $quietu = Quietu::with('flat.owner', 'flat.block.street')->find($request->id);
        $serves = Serve::all();
        $indicationServes = $serves->where('unit', '!==', 'm^2');
        $areaServes = $serves->where('unit', 'm^2');

        return view('reports.quietus', [
            'quietu' => $quietu,
            'indicationServes' => $indicationServes,
            'areaServes' => $areaServes
        ]);
    }

    public function cooperativeCalculate(Request $request) {
        $year = date('Y', strtotime($request->date));
        $month = date('m', strtotime($request->date));
        $serves = Serve::all();
        $flats = Flat::all();
        $ServeTotals = [];
        foreach ($serves as $serve) {
            $total = 0;
            if ($serve->unit === 'm^2') {
                foreach ($flats as $flat) {
                    $total = $total + $serve->tariff * $flat->area;
                }
            } else {
                $indications = Indication::where('serve_id', $serve->id)
                                ->whereYear('date', $year)
                                ->whereMonth('date', $month)->get();
                foreach ($indications as $indication) {
                    $total = $total + $serve->tariff * $indication->indication;
                }
            }
            $ServeTotals[$serve->name] = $total;
        }
        $ServeTotals['summary'] = array_sum($ServeTotals);
        return view('reports.cooperativeCalculate', [
            'ServeTotals' => $ServeTotals,
            'serves' => $serves,
            'year' => $year,
            'month' => $month
        ]);
    }

    public function getcalculateAttribute($flats, $year, $month) {
        $serves = Serve::all();
        // count on area
        $areaServes = $serves->where('unit', 'm^2');
        $flatsSums = [];
        foreach ($flats as $flat) {
            $total = 0;
            $area = $flat->area;
            foreach ($areaServes as $areaServe) {
                $total = $total + $areaServe->tariff * $area;
            }
            // count on indications
            $indicationServes = $serves->where('unit', '!==', 'm^2');
            foreach ($indicationServes as $indicationServe) {
                $monthIndications = Indication::where('flat_id', $flat->id)
                        ->where('serve_id', $indicationServe->id)
                        ->whereYear('date', $year)
                        ->whereMonth('date', $month)
                        ->get();
                foreach ($monthIndications as $monthIndication) {
                    $total = $total + $indicationServe->tariff * $monthIndication->indication;
                }
            }
            $flatsSums[] = $total;
        }
        return $flatsSums;
    }

    public function diagramm(Request $request) {
        $year = date('Y', strtotime($request->date));
        $month = date('m', strtotime($request->date));
        $flats = Flat::with('block.street')->where('block_id', $request->block_id)->get();
        $chart = new flatPays();
        $flatLabels = [];
        foreach ($flats as $flat) {
            $flatLabels[] = $flat->number;
        }
        $chart->labels($flatLabels);
        $data = self::getcalculateAttribute($flats, $year, $month);
        $chart->dataset($flats[0]->block->street->name . '/' . $flats[0]->block->number, 'bar', $data);
        return view('reports.diagramm', [
            'chart' => $chart
        ]);
    }

    public function crossCalculte(Request $request) {
        $year = date('Y', strtotime($request->date));
        $month = date('m', strtotime($request->date));
        $flats = Flat::with('block.street')->get();
        $serves = Serve::all();
        $table = [];
        foreach ($flats as $flat) {
            $flatArray = [];
            foreach ($serves as $serve) {
                $calc = 0;
                if ($serve->unit !== 'm^2') {
                    $monthIndications = Indication::where('flat_id', $flat->id)
                            ->where('serve_id', $serve->id)
                            ->whereYear('date', $year)
                            ->whereMonth('date', $month)
                            ->get();
                    foreach ($monthIndications as $monthIndication) {
                        $calc = $calc + $serve->tariff * $monthIndication->indication;
                    }
                } else {
                    $calc = $flat->area * $serve->tariff;
                }
                $flatArray[] = $calc;
            }
            $flatArray[] = array_sum($flatArray);
            $table[$flat->block->street->name . ',' . $flat->block->number . ',' . $flat->number] = $flatArray;
        }
        $finalRow = [];
        for ($i = 0; $i <= count($serves); $i++) {
            if ($i === count($serves)) {
                $totalServes = array_sum(array_column($table, $i));
                $totalFlats = array_sum($finalRow);
                $finalRow[] = $totalServes . '/' . $totalFlats;
            } else {
                $finalRow[] = array_sum(array_column($table, $i));
            }
        }
        $table['summary'] = $finalRow;
        return view('reports.crossCaculate', [
            'table' => $table,
            'flats' => $flats,
            'serves' => $serves
        ]);
    }

}
