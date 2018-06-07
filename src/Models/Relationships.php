<?php
/**
 * Created by PhpStorm.
 * User: Vitalik
 * Date: 12.10.2017
 * Time: 17:43
 */

namespace Trafik8787\LaraCrud\Models;

use Trafik8787\LaraCrud\Contracts\Model\RelationshipsInterface;

/**
 * Class Relationships
 * @package Trafik8787\LaraCrud\Models
 */
class Relationships implements RelationshipsInterface
{
    public $model;
    public $class;
    public $foreign_key;
    public $local_key;
    public $other_table; //связующая таблица

    /**
     * Relationships constructor.
     * @param $model
     * @param $class
     * @param null $other_table
     * @param $foreign_key
     * @param $local_key
     */
    public function __construct($model, $class, $other_table = null, $foreign_key, $local_key)
    {
        $this->model = $model;
        $this->class = $class;
        $this->foreign_key = $foreign_key;
        $this->local_key = $local_key;
        $this->other_table = $other_table;
    }

    /**
     * @return mixed
     */
    public function OneToOne()
    {
        return $this->model->hasOne($this->class, $this->foreign_key, $this->local_key);
    }

    /**
     * @return mixed
     */
    public function OneToMany()
    {
        return $this->model->hasMany($this->class, $this->foreign_key, $this->local_key);
    }

    /**
     * @return mixed
     */
    public function ManyToMany()
    {
        return $this->model->belongsToMany($this->class, $this->other_table, $this->foreign_key, $this->local_key);
    }
}