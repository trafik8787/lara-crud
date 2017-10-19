<?php
/**
 * Created by PhpStorm.
 * User: Vitalik
 * Date: 10.10.2017
 * Time: 20:50
 */

namespace Trafik8787\LaraCrud\Form;


use Illuminate\Http\Request;
use Trafik8787\LaraCrud\Contracts\Component\UploadFileInterface;
use Trafik8787\LaraCrud\Contracts\NodeModelConfigurationInterface;

class UploadFile implements UploadFileInterface
{
    private $request;
    private $field;
    private $objConfig;
    private $jsonMultipleArr;
    private $uploadAllSettings;

    public function __construct (Request $request) {

        $this->request = $request;

    }

    /**
     * @return array
     */
    public function setUploadFile()
    {
        $request_all = $this->request->input();

        /**
         * array:1 [▼
        "email" => array:2 [▼
        "path" => "image"
        "status" => "multiple"
        ]
        ]
         */

        if (!empty($this->request->file())) {
            foreach ($this->request->file() as $nameField => $item) {
                //истинно если файлы не множественные
                if (is_object($item)) {
                    $request_all[$nameField] = $this->saveFile($nameField, $item);

                }
                //если множественный выбор
                if (is_array($item)) {
                    foreach ($item as $rows) {
                        $this->jsonMultipleArr[] = $this->saveFile($nameField, $rows);
                    }

                    //добавляем еще файлы к существующим
                    if (!empty($request_all[$nameField])) {
                        $this->jsonMultipleArr = array_merge($this->jsonMultipleArr, $request_all[$nameField]);
                    }

                    $request_all[$nameField] = json_encode($this->jsonMultipleArr);
                }
            }

        } else {
            //если файлы существующие обновлять не добавляя новых
            $request_all = $this->requestArrUpdateInput();
        }

        return $request_all;
    }


    /**
     * @return array|string
     */
    public function requestArrUpdateInput()
    {
        $request_all = $this->request->input();

        if (!empty($this->objConfig->getFileUploadSetingAll())) {

            foreach ($this->objConfig->getFileUploadSetingAll() as $nameField => $uploadAllSetting) {
                if (!empty($request_all[$nameField]) and is_array($request_all[$nameField])) {
                    $request_all[$nameField] = json_encode($request_all[$nameField]);
                } else {
                    //если удалены все картинки то создаем поле в масиве POST с нулевым значением чтоб обнулить поле в таблице
                    $request_all[$nameField] = null;
                }
            }

        }
        return $request_all;
    }

    /**
     * @param $obj
     * @return array
     */
    public function objConfig($obj)
    {
        $this->objConfig = $obj;
        return $this->setUploadFile();
    }


    /**
     * @param $nameField
     * @param $file
     * todo сохраняем файл
     */
    public function saveFile($nameField, $file)
    {
        $fieldSetings = $this->objConfig->getFileUploadSeting($nameField);

        $path = base_path('public/'.$fieldSetings['path']);
        $nameFile = $file->hashName();
       // dd(get_class_methods($file));
      //  dd($file->getSize());
        $file->move($path, $nameFile);
        return $fieldSetings['path'].'/'.$nameFile;
    }


    /**
     * @param $size
     * @param int $precision
     * @return int|string
     */
    public static function formatBytes($size, $precision = 2)
    {
        if ($size > 0) {
            $size = (int) $size;
            $base = log($size) / log(1024);
            $suffixes = array(' bytes', ' KB', ' MB', ' GB', ' TB');

            return round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];
        } else {
            return $size;
        }
    }
}