<?php
/**
 * Created by PhpStorm.
 * User: Vitalik
 * Date: 30.08.2017
 * Time: 22:43
 */

namespace Trafik8787\LaraCrud\Models;

use Illuminate\Contracts\Foundation\Application;
use Trafik8787\LaraCrud\Contracts\NodeModelConfigurationInterface;

abstract class NodeModelConfigurationManager implements NodeModelConfigurationInterface
{
    protected $model;
    protected $class;
    protected $alias;
    protected $app;
    protected $title;
    protected $titleEdit;
    protected $url;
    public $objRoute;
    private static $objModel;

    protected $buttonDelete = true;
    protected $buttonEdit = true;
    protected $fieldShowDisplay = [];
    protected $fieldName = [];
    protected $textLimit = [];
    protected $fieldOrderBy = [0, 'asc'];
    protected $showEntries = 10;

    /**
     * NodeModelConfigurationManager constructor.
     * @param Application $app
     * @param null $model
     */
    public function __construct (Application $app, $model = null) {

        $this->app= $app;
        $this->model = $model;
    }

    /**
     * @param $query
     */
    public function scopeTest ($query)
    {
        $query->where('id', '=', 1);
    }

    /**
     * @return null
     */
    public function getModel () {
        return $this->model;
    }

    /**
     * @return mixed
     */
    public function getModelObj()
    {
        if (empty(self::$objModel)) {
            self::$objModel = new $this->model;
        }
        return self::$objModel;
    }

    /**
     * @return mixed
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @return mixed
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * @return mixed
     */
    public function getTitle ()
    {
        return $this->title;
    }

    /**
     * @return mixed
     */
    public function getTitleEdit ()
    {
        return $this->titleEdit;
    }

    /**
     * @return array
     */
    public function getFieldName() {
        return $this->fieldName;
    }

    /**
     * @return bool
     */
    public function getButtonDelete (): bool
    {
        return $this->buttonDelete;
    }

    /**
     * @return bool
     */
    public function getButtonEdit (): bool
    {
        return $this->buttonEdit;
    }

    /**
     * @return array
     */
    public function getFieldShowDisplay(): array {
        return $this->fieldShowDisplay;
    }


    /**
     * @return array
     *
     */
    public function getTextLimit($object)
    {
        foreach ($this->textLimit as $field => $limit) {
            $object->{$field} = str_limit($object->{$field}, $limit, $end = '...');
        }
        return $object;
    }

    /**
     * @return array
     */
    public function getFieldOrderBy(): array
    {
        return $this->fieldOrderBy;
    }

    /**
     * @return mixed
     */
    public function getShowEntries():int
    {
        return $this->showEntries;
    }


}