<?php

namespace Trafik8787\LaraCrud\EloquentModel;

use Illuminate\Database\Eloquent\Model;

abstract class All extends Model
{

    public function scopePopular($query, $id)
    {
        return $query->where('id', '=', $id);
    }


    public function getTableTypeColumns() {
       // dd($this->getConnection()->getSchemaBuilder()->getColumnType($this->getTable(), 'firstname'));
      //  dd($this->getConnection()->getDoctrineColumn($this->getTable(), 'firstname')->getType()->getName());
      //  dd(get_class_methods($this->getConnection()->getDoctrineColumn($this->getTable(), 'firstname')->getType()));
    }

    public function scopeSearch ($query, $value, $TableColumns) {

        foreach ($TableColumns as $tableColumn) {
            $query->orWhere($tableColumn, 'like', '%' . $value . '%');
        }

        return $query;
    }

    public function One ()
    {
        return $this->hasOne('App\Phone', 'contact_id');
    }

    public function OneToMany ()
    {
        return $this->hasMany('App\Phone', 'contacts_id', 'id');
    }
    
}