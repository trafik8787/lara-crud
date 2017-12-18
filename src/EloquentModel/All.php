<?php

namespace Trafik8787\LaraCrud\EloquentModel;

use Illuminate\Database\Eloquent\Model;

abstract class All extends Model
{

    public function scopeSearch ($query, $value, $TableColumns) {

        foreach ($TableColumns as $tableColumn) {
            $query->orWhere($tableColumn, 'like', '%' . $value . '%');
        }

        return $query;
    }

}