<?php
/**
 * Created by PhpStorm.
 * User: Vitalik
 * Date: 11.09.2017
 * Time: 16:00
 */

namespace Trafik8787\LaraCrud\Table;



use Illuminate\Foundation\Application;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Trafik8787\LaraCrud\Contracts\AdminInterface;
use Trafik8787\LaraCrud\Contracts\NodeModelConfigurationInterface;
use Trafik8787\LaraCrud\Contracts\TableInterface;
use Trafik8787\LaraCrud\Models\NodeModelConfiguration;
use Trafik8787\LaraCrud\Models\NodeModelConfigurationManager;

class DataTable implements TableInterface
{

    public $objModel;
    public $objConfig;
    public $admin;

    /**
     * DataTable constructor.
     * @param Application $app
     */
    public function __construct (Application $app) {

    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render ()
    {
//        dump($this->objConfig->getTextLimit());
//        dump($this->admin);
        //dump($this->nameColumns());
        //dump($this->getModelObj()->search('sdfsdf'));

        $data = array(
            'name_field' => $this->nameColumns(), //названия полей для таблицы HTML
            'json_field' => $this->getJsonColumnDataTable(),
            'titlePage'  => $this->objConfig->getTitle(),
            'data_json' =>  json_encode([
                'order' => $this->objConfig->getFieldOrderBy(), //сортировка
                'pageLength' => $this->objConfig->getShowEntries()
            ])
        );

        return view('lara::Table.table', $data);
    }

    /**
     * @return array
     * todo получить список полей текущей таблицы
     */
    public function getColumn ()
    {
        return DB::getSchemaBuilder()->getColumnListing($this->objConfig->getModelObj()->getTable());
    }


    /**
     * @return mixed
     */
    private function getModelObj()
    {
        return $this->objConfig->getModelObj();
    }


    /**
     * @param $admin
     * @return \Illuminate\Http\JsonResponse
     */
    public function jsonResponseTable ($admin)
    {
        $request = $admin->getRequest();


        $obj = $this->getModelData($request['length'], $request['numPage'], $request['search']['value'], $request['order'][0]);
        $dataArr = $obj->toArray();
        $data = [];

        foreach ($obj as $item) {
            $item['Action'] = $this->getTemplateAction($item->{$this->admin->KeyName});
            $data[] = $item;
        }

        return Response::json([
            'draw' => $request['draw'],
            'recordsTotal' => $this->getModelObj()->count(),
            'recordsFiltered' => $dataArr['total'],
            'data' => $data
        ]);

    }


    /**
     * @return string
     * Формирование json для секции column DataTable
     */
    public function getJsonColumnDataTable ()
    {
        $data_field = [];
        foreach ($this->nameColumns() as $field => $name) {
            $data_field[] = array('data' => $field);
        }
        $data_field[] = array('data' => 'Action', 'orderable' => false, 'width' => '10%');

        return json_encode($data_field, true);
    }


    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getTemplateAction($id)
    {

        return view('lara::Form.action', ['id' => $id, 'configNode' => $this->objConfig])->render();
    }


    /**
     * @param $total
     * @param $curent_page
     * @return mixed
     */
    public function getModelData($total, $curent_page, $searchValue, $order)
    {
        $this->setPageCurent($curent_page);
        $order_field = $this->nameColumnsOrder($order['column']);
        $result = $this->getModelObj()->search($searchValue, $this->admin->TableColumns);
        $result = $result->select(array_keys($this->nameColumns()))->orderBy($order_field, $order['dir']);
        $result = $result->paginate($total);

        $result->map(function ($object){

            return  $this->objConfig->getTextLimit($object);
        });

        return $result;
    }


    /**
     * @param $currentPage
     * todo установка номера страницы
     */
    public function setPageCurent ($currentPage)
    {
        Paginator::currentPageResolver(function() use ($currentPage) {
            return $currentPage;
        });
    }


    /**
     * @param $id
     * @return mixed
     */
    public function deleteRows($admin)
    {
        $id = $admin->getRequest()->input('id');
        return $this->getModelObj()->find($id)->delete();
    }


    /**
     * @return array
     * todo поля доступные для выборки
     */
    public function nameColumns ():array
    {

        $field = $this->admin->TableColumns;
        $field_name = $this->objConfig->getFieldName();
        $field_display = $this->objConfig->getFieldShow();

        //проверяем определен ли масив полей которые должны отображатся и осуществляем схождение масивов всех полей и обьявленных
        if (!empty($field_display)) {
            $field = array_intersect($field_display, $field);
        }

        $data = [];
        foreach ($field as $fields) {

            if (isset($field_name[$fields])) {
                $data[$fields] = $field_name[$fields];
            } else {
                $data[$fields] = $fields;
            }

        }

        return $data;
    }


    /**
     * @return array
     * todo order[0][column]: получаем название поля по индексу переданному из DataTable
     */
    public function nameColumnsOrder(int $index): string
    {
        $data = [];
        foreach ($this->nameColumns() as $field => $name) {
            $data[] = $field;
        }
        //dd($data[$index]);
        return $data[$index];
    }
}