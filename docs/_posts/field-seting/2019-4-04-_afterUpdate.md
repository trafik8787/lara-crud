---
layout: post4
title: Accepts model object after update in database. Called even if the changes were not.
seo_title: LaraCrud Accepts model object after update in database _afterUpdate()
categories: [documentation]
published: true
method: _afterUpdate()
permalink: /:categories/:title/
---

---

#### $this->_afterUpdate(<span style="color: #693">callable</span>$callback)

## Parameter List

***$model***

Table model object:

`
Example:
$this->_afterUpdate(function ($model){
 ....      
});
`
