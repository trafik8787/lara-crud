---
layout: post4
title: Sets the color of a table row to a condition. The call works only in the showDisplay method
seo_title: Sets the color of a table row to a condition. The call works only in the showDisplay() method columnColorWhere()
categories: [documentation]
published: true
method: columnColorWhere()
permalink: /:categories/:title/
---

---

#### $this->columnColorWhere(<span style="color: #693">string</span> $field, <span style="color: #693">string</span> $operator, <span style="color: #693">mixed</span> $parametr, <span style="color: #693">string</span> $color)

## Parameter List

***field***

The name of the field of the database table that is present in the condition.

***operator***

The comparison operator can take the following values: <kbd> =,>, <, =>, = < </kbd>

***parametr***

Comparison parameter.

***color***

Color code.

`
Example:
$this->columnColorWhere('id', '=', 3);
`


