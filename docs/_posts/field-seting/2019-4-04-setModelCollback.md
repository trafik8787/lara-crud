---
layout: post4
title: Сallback function, gets the table model object before displaying the table. The call works only in the showDisplay() method
seo_title: LaraCrud callback function, gets the table model object before displaying the table setModelCollback()
categories: [documentation]
published: true
method: setModelCollback()
permalink: /:categories/:title/
---

---

#### $this->setModelCollback(<span style="color: #693">callable</span>$callback)

## Parameter List

***callable***

The callback function gets the model:

`
Example:
$this->setModelCollback(function ($model){
    return $model;
});
`


