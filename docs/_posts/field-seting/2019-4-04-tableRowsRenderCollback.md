---
layout: post4
title:  The callback function is triggered each time a table row is rendered. The use works only in the showDisplay() 
seo_title: LaraCrud  The callback function is triggered each time a table row is rendered tableRowsRenderCollback()
categories: [documentation]
published: true
method: tableRowsRenderCollback()
permalink: /:categories/:title/
---

---

####  $this->tableRowsRenderCollback(<span style="color: #693">callable</span>$callback)

The method allows you to override the data that is displayed in the table.

    Example:
    $this->tableRowsRenderCollback(function ($model){
            if ($model->active == 1) {
                $model->active = 'Yes';
            }    
            return $model;
        });



