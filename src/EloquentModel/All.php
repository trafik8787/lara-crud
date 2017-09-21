<?php

namespace Trafik8787\LaraCrud\EloquentModel;

use Illuminate\Database\Eloquent\Model;

abstract class All extends Model
{
    public function scopePopular($query, $id)
    {
        return $query->where('id', '=', $id);
    }

    public function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }

    public function scopeSearch ($query, $value) {

        return $query->orWhere('firstname', 'like', '%' . $value . '%');
    }
}