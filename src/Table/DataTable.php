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
use Trafik8787\LaraCrud\Contracts\ChildRowsInterface;
use Trafik8787\LaraCrud\Contracts\TableInterface;

class DataTable implements TableInterface
{

    public $objModel;
    public $objConfig;
    public $admin;
    public $app;
    public $actionTable;

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

        //dump(config('lara-config.url_group'));
        $data = array(
            'name_field' => $this->objConfig->nameColumns(), //названия полей для таблицы HTML
            'json_field' => $this->getJsonColumnDataTable(),
            'titlePage' => $this->objConfig->getTitle(),
            'buttonAdd' => $this->objConfig->getButtonAdd(),
            'buttonCopy' => $this->objConfig->getButtonCopy(),
            'buttonGroupDelete' => $this->objConfig->getButtonGroupDelete(),
            'buttonAction' => $this->actionTable->enableColumnAction(),
            'childRowsColumnBool' => $this->objConfig->getShowChildRows(),
            'data_json' => json_encode([
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
        $request = $admin->getRequest();

        //груповое удаление
        if (isset($request['delete_group_' . csrf_token()])) {
            return $this->groupDelete($request);
            //копирование
        } elseif (isset($request['copy_' . csrf_token()])) {
            return $this->copyData($request);
            //запрос на child rows
        } elseif (isset($request['child_rows'])) {
            return $this->objConfig->SetShowChildRows()
                ->model($this->getModelObj())
                ->render($this->objConfig);
        }


        $obj = $this->getModelData($request['length'], $request['numPage'], $request['search']['value'], $request['order'][0]);
        $dataArr = $obj->toArray();
        $data = [];

        foreach ($obj as $item) {

            $arr_button = [];
            if ($this->objConfig->getShowChildRows()) {
                $arr_button = array(' ' => '<a href="#" class="details-control-div" data-id="' . $item->{$this->admin->KeyName} . '"><span class="glyphicon glyphicon-plus-sign"></span></a>');
            }

            if ($this->actionTable->objConfig($this->objConfig)->enableColumnAction()) {
                $item['Action'] = $this->actionTable->objConfig($this->objConfig)->render($item->{$this->admin->KeyName});
            }


            if ($this->objConfig->getButtonGroupDelete() or $this->objConfig->getButtonCopy()) {
                $item['#'] = '<input class="text-center" name="selected_' . csrf_token() . '[]" type="checkbox" value="' . $item->{$this->admin->KeyName} . '">';
            }

            $arr2 = array_merge($arr_button, $item->toArray());

            $data[] = $arr2;

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
            $data_field[] = array('data' => $field);
        }

        if ($this->actionTable->objConfig($this->objConfig)->enableColumnAction()) {
            $data_field[] = array('data' => 'Action', 'orderable' => false, 'width' => 'auto');
        }

        return json_encode($data_field, true);
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
    public function getModelData($total, $curent_page, $searchValue, $order)
    {

        $select = array_keys($this->objConfig->nameColumns());
        $select[] = $this->admin->KeyName;

        $this->setPageCurent($curent_page);
        $order_field = $this->nameColumnsOrder($order['column']);
        $result = $this->objConfig->getWhere($this->getModelObj());
        //хук модели таблицы
        $result = $this->objConfig->getModelCollback($result);
        $result = $result->select($select);
        $result = $this->searchModel($result, $searchValue, $this->objConfig->getFieldShow());
        $result = $result->orderBy($order_field, $order['dir']);

        $result = $result->paginate($total);

        $result->map(function ($object) {

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

        foreach ($TableColumns as $tableColumn) {

//            $objModel->orWhere($tableColumn, 'like', '%' . $searchValue . '%');
            $objModel->where(function ($query) use ($tableColumn, $searchValue) {
                $query->orWhere($tableColumn, 'like', '%' . $searchValue . '%');
            });
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
        return $this->redirect();
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
    public function nameColumnsOrder(int $index): string
    {

        $data = [];
        $i = null;

        foreach ($this->objConfig->nameColumns() as $field => $name) {
            //в зависимости от того будет ли столбец чекбоксов определяем будет ли начинатся масив с нуля или с единицы
            if ($this->objConfig->getBolleanCheckedColumn() === false) {
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
}