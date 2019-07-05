---
layout: post4
title:  The callback function adds a custom button to each line. Instead of a function, there may be a name for the router showDisplay() 
seo_title: Lara-Crud The callback function adds a custom button to each line. Instead of a function, there may be a name for the router. addAction()
categories: [documentation]
published: true
method: addAction()
permalink: /:categories/:title/
---

---

####  $this->addAction(<span style="color: #693">string</span>$nameButton, <span style="color: #693">string</span>$url, <span style="color: #693">callable</span>$callback)

The method allows you to add additional actions on the records in the table. When pressing the button, the object of the current record model is returned to the function.

    Example:
       $this->addAction('Ban', 'ban', function ($model){ 
           return $model;
       });



