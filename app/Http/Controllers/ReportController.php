<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Flat;
use App\models\Serve;
use App\models\Indication;
use App\models\Street;
use App\Charts\flatPays;

class ReportController extends Controller {

    //  1)перекрестный расчет за текущий месяц +
    //  2)диаграмма плата по каждой квартире за текущий месяц +
    //  3)список должников с суммой долга 
    //  4)квитанция в надлежащем виде на печать (pdf,excel)
    //  5)диаграмма на печать +
    //  6)общедоовая ведомость с итогом по каждому виду услуг
    //  7)ведомость на печать     
    public function index() {
        $streets = Street::all();
        return view('reports.index', [
            'streets' => $streets
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
                $indication = Indication::where('flat_id', $flat->id)
                                ->where('serve_id', $indicationServe->id)
                                ->whereYear('created_at', $year)
                                ->whereMonth('created_at', $month)->first();
                $total = $total + $indicationServe->tariff * $indication->indication;
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
        //dd($data);
        $chart->dataset($flats[0]->block->street->name . '/' . $flats[0]->block->number, 'bar', $data);
        return view('reports.diagramm', [
            'chart' => $chart
        ]);
    }

    public function crossCalculte(Request $request) {
        $year = date('Y', strtotime($request->date));
        $month = date('m', strtotime($request->date));
        dd($request->query);
        $flats = Flat::with('block.street')->get();
        $serves = Serve::all();
        $table = [];
        foreach ($flats as $flat) {
            $flatArray = [];
            foreach ($serves as $serve) {
                $calc = 0;
                if ($serve->unit !== 'm^2') {
                    $indication = Indication::where('flat_id', $flat->id)
                                    ->where('serve_id', $serve->id)
                                    ->whereYear('created_at', $year)
                                    ->whereMonth('created_at', $month)->first();                    
                    $calc = $indication->indication * $serve->tariff;
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
