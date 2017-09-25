<?php
/**
 * Created by PhpStorm.
 * User: Vitalik
 * Date: 28.08.2017
 * Time: 20:26
 */

namespace Trafik8787\LaraCrud\Models;

use Closure;

class NodeModelConfiguration extends NodeModelConfigurationManager
{


    /**
     * @param $title
     */
    public function setTitle ($title)
    {
        $this->title = $title;
    }


    /**
     * @param $url
     */
    public function url ($url)
    {
        $this->url = $url;
    }

    /**
     * @param array $field
     */
    public function fieldName(array $field)
    {
        $this->fieldName = $field;
    }
    /**
     * @param bool $value
     */
    public function buttonDelete (bool $value = true)
    {
        $this->buttonDelete = $value;
    }

    /**
     * @param bool $value
     */
    public function buttonEdit (bool $value = true){
        $this->buttonEdit = $value;
    }

    /**
     * @param array $value
     */
    public function fieldShow(array $value){
        $this->fieldShow = $value;
    }

    /**
     * @param string $field
     * @param int $limit
     * todo определить сокращение текста в конкретных полях и лимит символов
     */
    public function textLimit(string $field, int $limit) {
        $this->textLimit[$field] = $limit;
    }

    /**
     * @param int $field
     * @param string $sort
     */
    public function fieldOrderBy(int $field, string $sort)
    {
        $this->fieldOrderBy = [$field, $sort];
    }

    /**
     * @param int $count
     */
    public function showEntries (int $count)
    {
        $this->showEntries = $count;
    }


    /**
     * @param $field
     * @param $operator
     * @param $value
     */
    public function setWhere ($field, $operator, $value)
    {
        $this->setWhere = func_get_args();
    }


    /**
     * @param Closure $closure
     */
    public function tableRowsRenderCollback (Closure $closure)
    {
        $this->closure = $closure;

    }

    public function columnColorWhere ($field, $operator, $value, $color)
    {
        $this->columnColorWhere[] = func_get_args();
    }

}