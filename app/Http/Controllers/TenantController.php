<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Tenant;
use App\Repositories\Repository;

class TenantController extends Controller {

    // space that we can use the repository from
    protected $model;

    public function __construct(Tenant $tenant) {
        // set the model
        $this->model = new Repository($tenant);
    }

    public function index() {
        $tenants = $this->model->all();
        return view('tenants.index', [
            'tenants' => $tenants
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
