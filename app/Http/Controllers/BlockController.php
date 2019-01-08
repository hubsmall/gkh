<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Block;
use App\Repositories\Repository;

class BlockController extends Controller {

    // space that we can use the repository from
    protected $model;

    public function __construct(Block $block) {
        // set the model
        $this->model = new Repository($block);
    }

    public function index() {
        $blocks = $this->model->with($this->model->getModel()->belongsTo);
        $parents = $this->model->parents($this->model->getModel()->parents);
        $streets = $parents[0];
        //dd($streets);
        return view('blocks.index', [
            'blocks' => $blocks,
            'streets' => $streets,
        ]);
    }

    public function store(Request $request) {
        // create record and pass in only fields that are fillable
        return $this->model->create($request->only($this->model->getModel()->fillable));
    }

    public function show($id) {
        return $this->model->show($id);
    }

    public function update(Request $request) {    
        return response()->json($this->model->update($request->only($this->model->getModel()->fillable), $request->id));
    }

    public function destroy(Request $request) {
        //dd($request->id);
        return $this->model->delete($request->id);
    }
    
    public function search(Request $request) {
        $fields = $request->only($this->model->getModel()->fillable);
        unset($fields['_token']);
        $output = $this->model->search($fields);
        return response()->json(['result'   => $output]);
    }

}
