<?php

namespace App\Presenters;

use App\Presenters\Presenter;

class QuietusPresenter extends Presenter {
    
    
    public function getDiscount() {
        $privieges = $this->model->flat->owner->privileges;
        $discount = 0;
        foreach ($privieges as $priviege) {
            $discount += $priviege->advantage->percent;
        }
        if ($discount > 1) {
            $discount = 1;
        }
        return (1-$discount);
    }

    public function getCalculationWithPrivileges() {
        return $this->model->calculate * $this->getDiscount();
    }
    public function calculateForIndicationServeWithPrivileges($serve) {
        return $this->model->calculateForIndicationServe($serve) * $this->getDiscount();
    }
    public function calculateForAreaServeWithPrivileges($serve) {
        return $this->model->calculateForAreaServe($serve) * $this->getDiscount();
    }

}
