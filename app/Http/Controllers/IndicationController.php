<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Indication;
use App\Repositories\Repository;

class IndicationController extends Controller
{
    // space that we can use the repository from
    protected $model;

    public function __construct(Indication $indication) {
        // set the model
        $this->model = new Repository($indication);
    }

    public function index() {
        $indications = $this->model->with($this->model->getModel()->belongsTo[0],$this->model->getModel()->belongsTo[1]); 
        $parents = $this->model->parents($this->model->getModel()->grandparents);
        $streets = $parents[0];
        $serves = $parents[1];
        return view('indications.index', [
            'indications' => $indications,
            'streets' => $streets,
            'serves' => $serves,
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
        if($request->block_id && !$request->flat_id){
            $output = $this->model->searchThrough($request->block_id,'indications');
            return response()->json(['result'   => $output]);
        }
        unset($fields['_token']);
        unset($fields['street_id']);
        unset($fields['block_id']);
        $output = $this->model->search($fields);
        return response()->json(['result'   => $output]);
    }
}
