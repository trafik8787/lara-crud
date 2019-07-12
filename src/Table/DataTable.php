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
use Trafik8787\LaraCrud\Contracts\ActionTableInterface;
use Trafik8787\LaraCrud\Contracts\TableInterface;

class DataTable implements TableInterface
{

    public $objModel;
    public $objConfig;
    public $admin;
    public $app;
    public $actionTable;
    private $request;

    /**
     * DataTable constructor.
     * @param Application $app
     */
    public function __construct(Application $app, ActionTableInterface $actionTable)
    {
        $this->app = $app;
        $this->actionTable = $actionTable;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render()
    {
        //dd($this->objConfig->getSearshIndividualObject()->getColumns());
        // dd($this->objConfig->getSearshIndividualObject());
        $data = array(
            'name_field' => $this->objConfig->nameColumns(), //названия полей для таблицы HTML
            'columnSearch' => $this->objConfig->getSearshIndividualObject(), //индивидуальный поиск по полям
            'json_field' => $this->getJsonColumnDataTable(),
            'titlePage' => $this->objConfig->getTitle(),
            'buttonAdd' => $this->objConfig->getButtonAdd(),
            'buttonCopy' => $this->objConfig->getButtonCopy(),
            'buttonGroupDelete' => $this->objConfig->getButtonGroupDelete(),
            'buttonAction' => $this->actionTable->enableColumnAction(),
            'childRowsColumnBool' => $this->objConfig->getShowChildRows(),
            'addViewCustom' => $this->objConfig->setViewsCustomTop($this->getModelObj()),
            'tableDataBody' => $this->getDataBodytable(),
            'data_json' => json_encode([
                'order' => $this->objConfig->getFieldOrderBy(), //сортировка
                'pageLength' => $this->objConfig->getShowEntries(),
                'rowsColorWidth' => $this->objConfig->getColumnColorWhere(),
                'rowReorder' => $this->objConfig->getEnableDragAndDrop(),
                'orderFixed' => $this->objConfig->getOrderFixed(),
                'disablePaginate' => $this->paginateStatus(),
                'stateSave' => $this->objConfig->getStateSave(),
                'searching' => $this->objConfig->getSearchDisable(),
                'serverSide' => $this->objConfig->getDisableAjaxLoadData()
            ])
        );

        return view('lara::Table.table', $data);
    }

    public function paginateStatus ()
    {
        if (!$this->objConfig->getDisableAjaxLoadData()) {
            return true;
        }
        return $this->objConfig->getDisablePaginate();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function customRender()
    {
        $data = $this->objConfig->getRenderCustom();

        return view('lara::Table.dashboard', compact('data'));
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
    public function getColumn()
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
    public function jsonResponseTable($admin)
    {
        $this->request = $admin->getRequest();


        //груповое удаление
        if (isset($this->request['delete_group_' . csrf_token()])) {
            return $this->groupDelete($this->request);
            //копирование
        } elseif (isset($this->request['copy_' . csrf_token()])) {
            return $this->copyData($this->request);
            //запрос на child rows
        } elseif (isset($this->request['child_rows'])) {
            return $this->objConfig->SetShowChildRows()
                ->model($this->getModelObj())
                ->render($this->objConfig);
        } elseif (isset($this->request['rowReorder']) and $this->request->ajax()) {
            $this->sortDragAndDrop($this->request);
        }


        $obj = $this->getModelData($this->request['length'], $this->request['numPage'], $this->request['search']['value'], $this->request['order'][0]);

        if ($this->objConfig->getEmptyDataTable() and $obj === false) {
            $dataArr['total'] = 0;
            $count = 0;
        } else {

            $dataArr = $obj->toArray();
            $count = $this->getModelObj()->count();
        }


        $data = $this->getData($obj);

        return Response::json([
            'draw' => $this->request['draw'],
            'recordsTotal' => $count,
            'recordsFiltered' => $this->objConfig->getDisablePaginate() ? $dataArr['total'] : 0, //если пагинация отключена ставим 0
            'data' => $data
        ]);

    }


    public function getData($obj)
    {
        $data = [];

        $actionTable = $this->actionTable->objConfig($this->objConfig);

        if (!empty($obj)) {

            foreach ($obj as $item) {


                $arr_button = [];
                if ($this->objConfig->getShowChildRows()) {
                    $arr_button = array(' ' => '<a href="#" class="details-control-div" data-id="' . $item->{$this->admin->KeyName} . '"><span class="glyphicon glyphicon-plus-sign"></span></a>');
                }

                if ($actionTable->enableColumnAction()) {
                    $item['Action'] = $actionTable->beforeShowButtonEdit($this->objConfig->getButtonEdit($item))
                        ->render($item->{$this->admin->KeyName});
                }

                if ($this->objConfig->getButtonGroupDelete() or $this->objConfig->getButtonCopy()) {
                    $item['#'] = '<input class="text-center" name="selected_' . csrf_token() . '[]" type="checkbox" value="' . $item->{$this->admin->KeyName} . '">';
                }

                $arr2 = array_merge($arr_button, $item->toArray());

                $data[] = $arr2;

            }
        }

        return $data;
    }


    public function getDataBodytable()
    {
        if (!$this->objConfig->getDisableAjaxLoadData()) {
            return $this->getData($this->getModelData());
        }
    }


    /**
     * @return string
     * Формирование json для секции column DataTable
     */
    public function getJsonColumnDataTable()
    {
        //child Rows
        if ($this->objConfig->getShowChildRows()) {
            $data_field[] = array('data' => ' ', 'orderable' => false, 'width' => '5px');
        }

        //отключение групового удаления
        if ($this->objConfig->getButtonGroupDelete() or $this->objConfig->getButtonCopy()) {
            $data_field[] = array('data' => '#', 'orderable' => false, 'width' => '5px');
        }

        foreach ($this->objConfig->nameColumns() as $field => $name) {

            $orderable = $this->objConfig->getFieldOrderByDisable($field);

            //проверяем новое ли это поле
            if ($this->objConfig->getNewColumn($field)) {
                $orderable = false;
            }

            $data_field[] = array('data' => $field, "orderable" => $orderable);
        }

        if ($this->actionTable->objConfig($this->objConfig)->enableColumnAction()) {
            $data_field[] = array('data' => 'Action', 'orderable' => false, 'width' => 'auto');
        }

        return $data_field;
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function newAction()
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

                return redirect()->route($item['action'], ['id' => $model->{$this->admin->KeyName}]);
            }

        }

    }


    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function redirect()
    {
        return redirect()->back();
    }

    /**
     * @param $total
     * @param $curent_page
     * @return mixed
     */
    public function getModelData($total = null, $curent_page = null, $searchValue = null, $order = null)
    {
        $select = $this->objConfig->getFieldShow();


        $nameColumn = $this->objConfig->nameColumns();

        $select = array_keys($nameColumn);

        $select = array_diff($select, $this->objConfig->getNewColumn());

        if (!in_array($this->admin->KeyName, $select)) {
            $select[] = $this->admin->KeyName;
        }

        if ($this->objConfig->getEmptyDataTable() and empty($searchValue)) {

            return false;
        }


        //если определен Join
        if ($this->objConfig->joinTableObj()->getJoinTable() != null) {
            $select = $this->objConfig->joinTableObj()->getSelect();
        }

        $this->setPageCurent($curent_page);

        //если загрузка Ajax выключеена
        if ($this->objConfig->getDisableAjaxLoadData() !== false) {
            $order_field = $this->nameColumnsOrder($order['column']);
        }


        $result = $this->objConfig->getWhere($this->getModelObj());

        //передача в класс
        $result = $this->objConfig->joinTableObj()->setModel($result);
        //хук модели таблицы
        $result = $this->objConfig->getModelCollback($result);

        $result = $result->select($select);

        //если определен Join
        if ($this->objConfig->joinTableObj()->getJoinTable() != null) {
            $select = $this->objConfig->joinTableObj()->getAsNameSearch();
        }

        //если загрузка Ajax выключеена
        if ($this->objConfig->getDisableAjaxLoadData() !== false) {
            //поиск
            $result = $this->searchModel($result, $searchValue, $select);
            $result = $result->orderBy($order_field, $order['dir']);
        }

        //хук
        $result = $this->objConfig->getTableModelCollback($result);

        //если пагинация включена
        if ($this->objConfig->getDisablePaginate()) {
            $result = $result->paginate($total);
        } else {
            $result = $result->get();
        }

        $result->map(function ($object) use ($nameColumn) {

            foreach ($nameColumn as $key => $rows) {
                if (!isset($object->{$key})) {
                    $object->{$key} = null;
                }
            }

            $object = $this->objConfig->SetTableRowsRenderCollback($object);
            $object = $this->objConfig->getTextLimit($object);

            return $object;
        });


        return $result;
    }


    /**
     * @param $objModel
     * @param $searchValue
     * @param $TableColumns
     * @return mixed
     */
    public function searchModel($objModel, $searchValue, $TableColumns)
    {
        if (!empty($searchValue)) {
            //поиск подключаем метод класса
            $objModel = $this->objConfig->getSearchConfig()->setSearch($objModel, $TableColumns, $searchValue);
        }


        if ($this->objConfig->getSearshIndividualObject()) {

            $column = $this->objConfig->getSearshIndividualObject()->searchColumn($this->request['columns']);

            if ($column) {

                $objModel->where(function ($query) use ($column) {
                    foreach ($column as $column => $value) {
                        $query->where($column, 'like', $value . '%');
                    }
                });

            }

        }

        return $objModel;
    }


    /**
     * @param $currentPage
     * todo установка номера страницы
     */
    public function setPageCurent($currentPage)
    {
        Paginator::currentPageResolver(function () use ($currentPage) {
            return $currentPage;
        });
    }


    /**
     * @param $id
     * @return mixed
     */
    public function deleteRows($admin)
    {
        if ($this->objConfig->getButtonDelete() === false) {
            return $this->redirect();
        }

        $id = $admin->getRequest()->input('id');
        $this->getModelObj()->find($id)->delete();

        if (!empty($this->objConfig->getSaveRedirect())) {
            return redirect($this->objConfig->getSaveRedirect());
        } else {
            return $this->redirect();
        }
    }

    /**
     * @param $arr_id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function groupDelete($request)
    {
        if (!empty($request['selected_' . csrf_token()])) {
            $this->getModelObj()->destroy($request['selected_' . csrf_token()]);
        }

        return $this->redirect();
    }

    /**
     * @return array
     * todo order[0][column]: получаем название поля по индексу переданному из DataTable
     */
    public function nameColumnsOrder(int $index = 1): string
    {
        $data = [];
        $i = null;

        foreach ($this->objConfig->nameColumns() as $field => $name) {
            //в зависимости от того будет ли столбец чекбоксов определяем будет ли начинатся масив с нуля или с единицы
            if ($this->objConfig->getBolleanCheckedColumn() === 'false') {
                $data[] = $field;
            } else {
                $i = ++$i;
                $data[$i] = $field;
            }
        }

        return $data[$index];
    }

    /**
     * @param $request
     */
    public function copyData($request)
    {
        if (!empty($request['selected_' . csrf_token()])) {

            $newModel = $this->getModelObj()->find(collect($request['selected_' . csrf_token()])->first())->replicate();
            $newModel->save();
            return $this->redirect();
        }
    }


    /**
     * @param $request
     */
    public function sortDragAndDrop($request)
    {
        $arrValues = $request['rowReorder'];

        $name = $this->objConfig->getEnableDragAndDrop();
        $model = $this->getModelObj();

        $result = null;

        $newResult = [];
        foreach ($arrValues as $arrValue) {
            $idRow = $model->where($name, $arrValue['oldData'])->first();
            $newResult[] = [$this->admin->KeyName => $idRow->{$this->admin->KeyName}, $name => $arrValue['newData']];
        }

        foreach ($newResult as $row) {
            $data = $model->find($row[$this->admin->KeyName]);
            $data->{$name} = $row[$name];
            $data->save();
        }

        exit(200);
    }

}