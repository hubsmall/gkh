<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

/**
 * Description of Repository
 *
 * @author vova
 */
class Repository implements RepositoryInterface {

    // model property on class instances
    protected $model;

    // Constructor to bind model to repo
    public function __construct(Model $model) {
        $this->model = $model;
    }

    // Get all instances of model
    public function all() {
        return $this->model->all();
    }

    // create a new record in the database
    public function create(array $data) {
        $created = $this->model->create($data);
        if ($this->model->belongsTo) {
            $parents = $this->model->belongsTo;
            $result = $this->model;
            foreach ($parents as $parent) {
                $result = $result->with($parent);
            }
            return $result->findOrFail($created->id);
        }
        return $created;
    }

    // update record in the database
    public function update(array $data, $id) {
        $record = $this->model->find($id);
        $record->update($data);
        if ($this->model->belongsTo) {
            $parents = $this->model->belongsTo;
            $result = $this->model;
            foreach ($parents as $parent) {
                $result = $result->with($parent);
            }
            return $result->findOrFail($record->id);
        }
        return $record;
    }

    // remove record from the database
    public function delete($id) {
        return $this->model->destroy($id);
    }

    // show the record with the given id
    public function show($id) {
        return $this->model->findOrFail($id);
    }

    // Get the associated model
    public function getModel() {
        return $this->model;
    }

    // Set the associated model
    public function setModel($model) {
        $this->model = $model;
        return $this;
    }

    // Eager load database relationships
    public function with($relations) {
        return $this->model->with($relations)->get();
    }

    public function search(array $data) {


        if ($this->model->belongsTo) {
            $parents = $this->model->belongsTo;
            $searchResult = $this->model;
            foreach ($parents as $parent) {
                $searchResult = $searchResult->with($parent);
            }
        } else {
            $searchResult = $this->model;
        }
        foreach ($data as $key => $val) {
            $searchResult = $searchResult->where($key, 'like', $val . '%');
        }
        $searchResult = $searchResult->get();
        return $searchResult;
    }

    public function parents($parents) {
        $parentsCollection = collect();
        foreach ($parents as $parent) {
            $parentSection = $parent::all();
            $parentsCollection->push($parentSection);
        }
        return $parentsCollection;
    }

    public function searchThrough($grandparentId) {
        $searchResult = $this->model->grandparents[0]::find($grandparentId)->grandchildren;
        $Ids = $searchResult->map(function ($item) {
            return $item->id;
        });
        //использовать айдишники $searchResult и заново сделатб запрос для забора отношений 
        if ($this->model->belongsTo) {
            $parents = $this->model->belongsTo;
            $searchResult = $this->model;
            foreach ($parents as $parent) {
                $searchResult = $searchResult->with($parent);
            }
            return $searchResult->find($Ids);
        }
        return $this->model->find($Ids);
    }

}
