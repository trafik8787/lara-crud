---
layout: post4
title: Accepts a model object before being added to the database. You can change the data before saving.
seo_title: LaraCrud Accepts a model object before being added to the database. You can change the data before saving beforeInsert()
categories: [documentation]
published: true
method: beforeInsert()
permalink: /:categories/:title/
---

---

#### $this->beforeInsert(<span style="color: #693">callable</span>$callback)

## Parameter List

***$model***

Table model object:

`
Example:
$this->beforeInsert(function ($model){
 ....      
});
`
