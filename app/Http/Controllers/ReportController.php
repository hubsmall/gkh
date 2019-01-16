<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Flat;
use App\models\Serve;
use App\models\Indication;
use App\models\Street;
use App\models\Quietu;
use App\Charts\flatPays;
use App\Presenters\QuietusPresenter;

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
        $quietusRaw = Quietu::with('flat.owner.privileges.advantage', 'flat.block.street')
                ->whereYear('date', $year)
                ->whereMonth('date', $month)
                ->get();
        $unpaidQuietus = collect();
        foreach ($quietusRaw as $quietu) {
            $unpaidQuietus->push(new QuietusPresenter($quietu));
        }
        return view('reports.debtors', [
            'unpaidQuietus' => $unpaidQuietus
        ]);
    }

    public function quietus(Request $request) {
        $quietu = new QuietusPresenter(Quietu::with('flat.owner.privileges.advantage', 'flat.block.street')->find($request->id));
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
        $ServeTotals = [];
        $quietusRaw = Quietu::with('flat.owner.privileges.advantage', 'flat.block.street')
                ->whereYear('date', $year)
                ->whereMonth('date', $month)
                ->get();
        $quietus = collect();
        foreach ($quietusRaw as $quietu) {
            $quietus->push(new QuietusPresenter($quietu));
        }
        foreach ($serves as $serve) {
            $total = 0;
            foreach ($quietus as $quietu) {
                if ($serve->unit === 'm^2') {
                    $total += $quietu->calculateForAreaServeWithPrivileges($serve);
                } else {
                    $total += $quietu->calculateForIndicationServeWithPrivileges($serve);
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
        $flatsSums = [];
        foreach ($flats as $flat) {
            $total = 0;
            $quietusRaw = Quietu::with('flat.owner.privileges.advantage', 'flat.block.street')
                    ->where('flat_id', $flat->id)
                    ->whereYear('date', $year)
                    ->whereMonth('date', $month)
                    ->get();
            $quietus = collect();
            foreach ($quietusRaw as $quietu) {
                $quietus->push(new QuietusPresenter($quietu));
            }
            foreach ($quietus as $quietu) {
                $total += $quietu->getCalculationWithPrivileges();
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
            $quietusRaw = Quietu::with('flat.owner.privileges.advantage', 'flat.block.street')
                    ->where('flat_id', $flat->id)
                    ->whereYear('date', $year)
                    ->whereMonth('date', $month)
                    ->get();
            $quietus = collect();
            foreach ($quietusRaw as $quietu) {
                $quietus->push(new QuietusPresenter($quietu));
            }
            foreach ($serves as $serve) {
                $calc = 0;
                foreach ($quietus as $quietu) {
                    if ($serve->unit === 'm^2') {
                        $calc += $quietu->calculateForAreaServeWithPrivileges($serve);
                    } else {
                        $calc += $quietu->calculateForIndicationServeWithPrivileges($serve);
                    }
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
