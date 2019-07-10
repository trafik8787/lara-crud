---
layout: post4
title: Join tables into one
seo_title: Lara-Crud Join tables into one. The call works only in the showDisplay() method showDisplay()
categories: [documentation]
published: true
method: tableJoin()
permalink: /:categories/:title/
---

---

    $this->tableJoin($tableName, string$tableColumnOld, string$tableColumnLocal)
                ->select($fieldTable, $asName);

Or

      $this->tableJoin(Closure $closure)
                ->select($fieldTable, $asName);

Join tables into one. The call works only in the showDisplay() method showDisplay()

## Parameter List

***$tableName***

The name of the table you want to join

***$tableColumnOld***

Column of the joined table to create a relationship: <kbd> logs.user_id </kbd>

***$tableColumnLocal***

Local(current) table column for relationship creation: <kbd> users.id </kbd>

***$fieldTable***

The column of the table to be displayed: <kbd> users.name </kbd> 

***$asName***

New column name: <kbd> users.name </kbd> 

***Closure $closure***



    Example:
    public function showDisplay () {
       
          -------other code------
        //inner Join
        $this->tableJoin('logs', 'logs.user_id',  'user.id')
            ->select('logs.text', 'LOGS_TEXT')
            ->select('logs.date', 'LOGS_DATE');
    
        //        $this->tableJoin('logs', 'logs.user_id',  'user.id')
        //            ->select('logs.text', 'LOGS_TEXT')
        //            ->select('logs.date', 'LOGS_DATE')->leftJoin();
        
        //        $this->tableJoin('logs', 'logs.user_id',  'user.id')
        //            ->select('logs.text', 'LOGS_TEXT')
        //            ->select('logs.date', 'LOGS_DATE')->rightJoin();
    
        $this->fieldShow(['LOGS_TEXT', 'LOGS_DATE']);
        
        $this->fieldName(['LOGS_TEXT' => 'Text logs', 'LOGS_DATE' => 'Logs date']);
        
          -------other code------
    }
    
    
    Example:
    public function showDisplay () {
       
          -------other code------
        //inner Join
        $this->tableJoin(function ($model){
             return $model->join('logs', function ($join){
                 $join->on('logs.user_id', '=', 'user.id');
 
             });
        })
        ->select('logs.text', 'LOGS_TEXT')
        ->select('logs.date', 'LOGS_DATE');
        
          -------other code------
    }



