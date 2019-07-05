---
layout: post4
title: Accepts a model object before updating to the database. You can change the data before saving.
seo_title: Lara-Crud Accepts a model object before updating to the database. You can change the data before saving beforeUpdate()
categories: [documentation]
published: true
method: beforeUpdate()
permalink: /:categories/:title/
---

---

#### $this->beforeUpdate(<span style="color: #693">callable</span>$callback)

## Parameter List

***$model***

Table model object:

`
Example:
$this->beforeUpdateUpdate(function ($model){
 ....      
});
`
