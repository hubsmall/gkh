<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Privilege;
use App\Repositories\Repository;

class PrivilegedController extends Controller {
    
    protected $model;

    public function __construct(Privilege $privilege) {
        $this->model = new Repository($privilege);
    }

    public function index() {
        $privileges = $this->model->with($this->model->getModel()->belongsTo[0],$this->model->getModel()->belongsTo[1]); 
        $parents = $this->model->parents($this->model->getModel()->parents);
        $owners = $parents[0];
        $advantages = $parents[1];
        return view('privileges.index', [
            'privileges' => $privileges,
            'owners' => $owners,
            'advantages' => $advantages,
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
