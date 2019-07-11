---
layout: post4
title: The method calls the callback function before loading the form. Allows you to override the model.
seo_title: Lara-Crud The method calls the callback function before loading the form. Allows you to override the model setBeforeModelFormCollback()
categories: [documentation]
published: true
method: setBeforeModelFormCollback()
permalink: /:categories/:title/
---

---

#### $this->setBeforeModelFormCollback(<span style="color: #693">callable</span>$callback)



      Example:
      $this->setBeforeModelFormCollback(function ($model){
    
        if (!empty($model->BLOCK) and $model->BLOCK == 0) {
            $model->BLOCK = 'no';
        }
       
        return $model;
    
      });



