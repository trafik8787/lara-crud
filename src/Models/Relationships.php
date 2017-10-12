<?php
/**
 * Created by PhpStorm.
 * User: Vitalik
 * Date: 12.10.2017
 * Time: 17:43
 */

namespace Trafik8787\LaraCrud\Models;


use Trafik8787\LaraCrud\Contracts\Model\RelationshipsInterface;

class Relationships implements RelationshipsInterface
{
    protected $model;

    public function __construct ($model) {
        $this->model = $model;
    }

    public function OneToOne()
    {
        return $this->model->hasOne('App\Phone', 'contact_id');
    }

    public function OneToMany()
    {
        return $this->model->hasMany('App\Phone', 'contacts_id');
    }

    public function MenyToMany()
    {
        // TODO: Implement MenyToMany() method.
    }


    public function make()
    {
        return $this;
    }
}