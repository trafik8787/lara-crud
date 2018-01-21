---
layout: post
title: Callback Function
published: true
---

&nbsp;
The callback function is triggered each time a table row is rendered:
    
    Example:
    $this->tableRowsRenderCollback(function ($obj){
        return $obj;
    });

&nbsp;    
The callback function adds a custom button to each line. Instead of a function, there may be a name for the router.
    
    Example:
    $this->addAction('Ban', 'ban', function ($obj){ 
        return $obj;
    });

&nbsp;    
The callback function retrieves the data after the table is updated.
    
    $this->afterUpdate(function ($value){
         return $value;
    });
    
&nbsp;    
The callback function retrieves the data before the table is updated.
    
    $this->beforeUpdate(function ($value){
        return $value;
    });
    
&nbsp;
The callback function receives the data after adding it to the table.
    
    $this->afterInsert(function ($value){
            return $value;
    });

&nbsp; 
The callback function retrieves the data before adding it to the table. 
    
    $this->beforeInsert(function ($value){
            return $value;
    }); 

&nbsp;    
The callback function retrieves the data after it is removed from the table.    
    
    $this->afterDelete(function ($value){
            return $value;
    });
    
&nbsp;  
The callback function retrieves data before deleting it from the table.
    
    $this->beforeDelete(function ($value){
            return $value;
    });