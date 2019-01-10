<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Flat;
use App\Repositories\Repository;

class FlatController extends Controller
{
    // space that we can use the repository from
    protected $model;

    public function __construct(Flat $flat) {
        // set the model
        $this->model = new Repository($flat);
    }

    public function index() {
        $flats = $this->model->with($this->model->getModel()->belongsTo[0],$this->model->getModel()->belongsTo[1]); 
        $parents = $this->model->parents($this->model->getModel()->grandparents);
        $streets = $parents[0];
        $tenants = $parents[1];
        return view('flats.index', [
            'flats' => $flats,
            'streets' => $streets,
            'tenants' => $tenants,
        ]);
    }

    public function store(Request $request) {
        return $this->model->create($request->only($this->model->getModel()->fillable));
    }

    public function show($id) {
        return $this->model->show($id);
    }

    public function update(Request $request) {
        return response()->json($this->model->update($request->only($this->model->getModel()->fillable), $request->id));
    }

    public function destroy(Request $request) {
        return $this->model->delete($request->id);
    }
    public function search(Request $request) {
        $fields = $request->only($this->model->getModel()->fillable);
        if($request->street_id && !$request->block_id){
            $output = $this->model->searchThrough($request->street_id);
            return response()->json(['result'   => $output]);
        }
        unset($fields['_token']);
        unset($fields['street_id']);
        $output = $this->model->search($fields);
        return response()->json(['result'   => $output]);
    }
}
