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
    private $request;
    private $admin;

    public function __construct (Application $app, AdminInterface $admin) {
        //получаем обект модели
        $this->admin = $admin;

    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render ()
    {
        //dump(get_class_methods($this->getModelObj()->paginate(10)));

       // $er = $this->getModelData(5, 2)->toArray();
      //  dump($this->objModel);
//        foreach ($er->toArray() as $item) {
//            dump($item);
//        }

        //dump($this->getModelData(5, 1));
       // dump($this->getModelObj()->getTableColumns());

        $data = array(
            'name_field' => $this->getModelObj()->getTableColumns(), //названия полей для таблицы HTML
            'json_field' => $this->getJsonColumnDataTable()
        );

        //dump($this->admin);
        return view('lara::Table.table', $data);
    }

    /**
     * @return array
     * todo получить список полей текущей таблицы
     */
    public function getColumn ()
    {
        return DB::getSchemaBuilder()->getColumnListing($this->objModel->getModelObj()->getTable());
    }


    /**
     * @return mixed
     */
    private function getModelObj()
    {
        return $this->objModel->getModelObj();
    }


    public function jsonResponseTable ()
    {
        $request = $this->admin->getRequest();


        $obj = $this->getModelData($request['length'], $request['numPage']);
        $dataArr = $obj->toArray();
        $data = [];

        foreach ($dataArr['data'] as $item) {
            $item['Action'] = $this->getTemplateAction($item['id']);
            $data[] = $item;
        }



            //dump($dataArr['data']);

        //print_r($this->getModelObj()->count());
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
        $data_field[] = array('data' => 'Action', 'orderable' => false);

        return json_encode($data_field, true);
    }


    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getTemplateAction($id)
    {

        return view('lara::Form.action', ['id' => $id, 'configNode' => $this->objModel])->render();
    }


    public function getModelData($total, $curent_page)
    {
        $this->setPageCurent($curent_page);

        return $this->getModelObj()->paginate($total);
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

}