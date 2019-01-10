<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Serve;
use App\Repositories\Repository;

class ServeController extends Controller
{
    // space that we can use the repository from
    protected $model;

    public function __construct(Serve $serve) {
        // set the model
        $this->model = new Repository($serve);
    }

    public function index() {
        $serves = $this->model->all();
        return view('serves.index', [
            'serves' => $serves
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
        unset($fields['_token']);
        $output = $this->model->search($fields);
        return response()->json(['result' => $output]);
    }
}
