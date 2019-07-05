---
layout: post4
title: Сallback function gets model object when rendering each row of a table. The call works only in the showDisplay() method
seo_title: Lara-Crud callback function gets model object when rendering each row of a table tableRowsRenderCollback()
categories: [documentation]
published: true
method: tableRowsRenderCollback()
permalink: /:categories/:title/
---

---

#### $this->tableRowsRenderCollback(<span style="color: #693">callable</span>$callback)

## Parameter List

***callable***

The callback function gets the model:

`
Example:
$this->tableRowsRenderCollback(function ($model){
    return $model;
});
`


