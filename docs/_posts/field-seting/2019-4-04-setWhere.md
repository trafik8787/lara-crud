---
layout: post4
title: Defines the selection of data from the database table by condition. The call works only in the showDisplay() method
seo_title: LaraCrud Defines the selection of data from the database table by condition. The call works only in the showDisplay() method setWhere()
categories: [documentation]
published: true
method: setWhere()
permalink: /:categories/:title/
---

---

#### $this->setWhere(<span style="color: #693">string</span> $field, <span style="color: #693">string</span> $operator, <span style="color: #693">mixed</span> $parametr)

## Parameter List

***field***

The name of the field of the database table that is present in the condition.

***operator***

The comparison operator can take the following values: <kbd> =,>, <, =>, = < </kbd>

***parametr***

Comparison parameter.

`
Example:
$this->setWhere('id', '=', 3)
`


