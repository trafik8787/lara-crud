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

    /**
     * DataTable constructor.
     * @param Application $app
     */
    public function __construct (Application $app) {

    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render ($admin)
    {

        //dump($this->getModelObj()->search('sdfsdf'));
        $data = array(
            'name_field' => $this->getModelObj()->getTableColumns(), //названия полей для таблицы HTML
            'json_field' => $this->getJsonColumnDataTable()
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


        $obj = $this->getModelData($request['length'], $request['numPage'], $request['search']['value']);
        $dataArr = $obj->toArray();
        $data = [];

        foreach ($dataArr['data'] as $item) {
            $item['Action'] = $this->getTemplateAction($item['id']);
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
        foreach ($this->getModelObj()->getTableColumns() as $tableColumn) {
            $data_field[] = array('data' => $tableColumn);
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
    public function getModelData($total, $curent_page, $searchValue)
    {
        $this->setPageCurent($curent_page);
        return $this->getModelObj()->search($searchValue)->paginate($total);
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
}