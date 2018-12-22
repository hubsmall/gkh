<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Tenant;
use App\Repositories\Repository;

class TenantController extends Controller
{
    // space that we can use the repository from
    protected $model;

    public function __construct(Tenant $tenant) {
        // set the model
        $this->model = new Repository($tenant);
    }

    public function index() {
        return $this->model->all();
    }

    public function store(Request $request) {
        $this->validate($request, [
            'body' => 'required|max:500'
        ]);

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
