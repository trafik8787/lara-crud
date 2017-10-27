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
use Trafik8787\LaraCrud\Contracts\TableInterface;

class DataTable implements TableInterface
{

    public $objModel;
    public $objConfig;
    public $admin;
    public $app;
    /**
     * DataTable constructor.
     * @param Application $app
     */
    public function __construct (Application $app) {
        $this->app = $app;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render ()
    {
        //dump(config('lara-config.url_group'));
        $data = array(
            'name_field' => $this->objConfig->nameColumns(), //названия полей для таблицы HTML
            'json_field' => $this->getJsonColumnDataTable(),
            'titlePage'  => $this->objConfig->getTitle(),
            'data_json' =>  json_encode([
                'order' => $this->objConfig->getFieldOrderBy(), //сортировка
                'pageLength' => $this->objConfig->getShowEntries(),
                'rowsColorWidth' => $this->objConfig->getColumnColorWhere()
            ])
        );

        return view('lara::Table.table', $data);
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function renderDashboard()
    {
        return view('lara::Table.dashboard')->with('data', $this->objConfig->showDisplay());
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
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function jsonResponseTable ($admin)
    {
        $request = $admin->getRequest();
        //dd($request);

        if (!empty($request['selected'])) {
            //груповое удаление
            return $this->groupDelete($request['selected']);
        }

        $obj = $this->getModelData($request['length'], $request['numPage'], $request['search']['value'], $request['order'][0]);
        $dataArr = $obj->toArray();
        $data = [];

        foreach ($obj as $item) {

            $item['Action'] = $this->getTemplateAction($item->{$this->admin->KeyName});
            $item['#'] = '<input class="text-center" name="selected[]" type="checkbox" value="'.$item->{$this->admin->KeyName}.'">';
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
        $data_field[] = array('data' => '#', 'orderable' => false, 'width' => '5px');

        foreach ($this->objConfig->nameColumns() as $field => $name) {
            $data_field[] = array('data' => $field);
        }
        $data_field[] = array('data' => 'Action', 'orderable' => false, 'width' => 'auto');

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
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function newAction ()
    {
        $url = null;

        unset($this->objConfig->textLimit);

        $model = $this->getModelObj()->find($this->admin->route->parameters['adminModelId']);

        foreach ($this->objConfig->getNewAction() as $url => $item) {

            if ($url == $this->admin->route->parameters['newAction'] and isset($item['closure'])) {

                $this->objConfig->newActionCollback($item['closure'], $model);
                return $this->redirect();
            }

            if ($url == $this->admin->route->parameters['newAction'] and isset($item['action'])) {

                return redirect()->route($item['action'],['id' => $model->{$this->admin->KeyName}]);
            }

        }

    }


    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function redirect ()
    {
        return redirect()->back();
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
        $result = $result->select(array_keys($this->objConfig->nameColumns()))->orderBy($order_field, $order['dir']);
        $result = $this->objConfig->getWhere($result);
        $result = $result->paginate($total);

        $result->map(function ($object){

            $object = $this->objConfig->SetTableRowsRenderCollback($object);
            $object = $this->objConfig->getTextLimit($object);

            return  $object;
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
        $this->getModelObj()->find($id)->delete();
        return $this->redirect();
    }

    /**
     * @param $arr_id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function groupDelete ($arr_id)
    {
        $this->getModelObj()->destroy($arr_id);
        return $this->redirect();
    }

    /**
     * @return array
     * todo order[0][column]: получаем название поля по индексу переданному из DataTable
     */
    public function nameColumnsOrder(int $index): string
    {
        $data = [];
        foreach ($this->objConfig->nameColumns() as $field => $name) {
            $data[] = $field;
        }
        // - 1 потому что первая колонка чекбоксы
        return $data[$index-1];
    }
}