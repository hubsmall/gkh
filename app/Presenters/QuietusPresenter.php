<?php

namespace App\Presenters;

use App\Presenters\Presenter;

class QuietusPresenter extends Presenter {

    public function getCalculationWithPrivileges() {
        $privieges = $this->model->flat->owner->privileges;
        $discount = 0;
        foreach ($privieges as $priviege) {
            $discount += $priviege->advantage->percent;
        }
        if ($discount > 1) {
            $discount = 1;
        }
        return $this->model->calculate * (1-$discount);
    }

}
