<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Street;
use App\Repositories\Repository;

class StreetController extends Controller {

    // space that we can use the repository from
    protected $model;

    public function __construct(Street $street) {
        // set the model
        $this->model = new Repository($street);
    }

    public function index() {
        $streets = $this->model->all();
        return view('streets.index', [
            'streets' => $streets,
        ]);
    }

    public function store(Request $request) {
//        $this->validate($request, [
//            'body' => 'required|max:500'
//        ]);

        // create record and pass in only fields that are fillable
        return $this->model->create($request->only($this->model->getModel()->fillable));
    }

    public function show($id) {
        return $this->model->show($id);
    }

    public function update(Request $request) {
        // update model and only pass in the fillable fields
        $this->model->update($request->only($this->model->getModel()->fillable), $request->id);      
        return response()->json($this->model->show($request->id));
    }

    public function destroy(Request $request) {
        return $this->model->delete($request->id);
    }
    
    public function search(Request $request) {
        $fields = $request->only($this->model->getModel()->fillable);
        unset($fields['_token']);
        $output = $this->model->search($fields);
        return response()->json(['result'   => $output]);
    }

}
