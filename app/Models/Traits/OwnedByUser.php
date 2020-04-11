<?php

namespace App\Models\Traits;

use App\Models\Scopes\OwnedByUserScope;

trait OwnedByUser
{

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function bootOwnedByUser()
    {
        static::addGlobalScope(new OwnedByUserScope);

        static::creating(function($model) {

            $model->user_id = \Auth::id();

        });

    }

}
