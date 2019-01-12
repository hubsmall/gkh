<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Flat;
use App\models\Serve;
use App\models\Indication;

class ReportController extends Controller {

    //  1)перекрестный расчет за текущий месяц +
    //  2)диаграмма плата по каждой квартире за текущий месяц
    //  3)список должников с суммой долга 
    //  4)квитанция в надлежащем виде на печать (pdf,excel)
    //  5)диаграмма на печать
    //  6)общедоовая ведомость с итогом по каждому виду услуг
    //  7)ведомость на печать     
    public function index() {
        return view('reports.index', [
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
            $table[$flat->block->street->name.','.$flat->block->number.','.$flat->number] = $flatArray;
        }
        $finalRow = [];
        for ($i=0; $i<=count($serves); $i++) {
            if($i === count($serves)){
                $totalServes = array_sum(array_column($table, $i));
                $totalFlats = array_sum($finalRow);
                $finalRow[] = $totalServes.'/'.$totalFlats;
            }else{
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
