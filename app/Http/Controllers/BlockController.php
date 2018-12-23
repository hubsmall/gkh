<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Block;
use App\Repositories\Repository;

class BlockController extends Controller
{
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

    public function update(Request $request, $id) {
        // update model and only pass in the fillable fields
        $this->model->update($request->only($this->model->getModel()->fillable), $id);

        return $this->model->find($id);
    }

    public function destroy($id) {
        return $this->model->delete($id);
    }
}
