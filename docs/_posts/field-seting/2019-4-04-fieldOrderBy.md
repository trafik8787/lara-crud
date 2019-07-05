---
layout: post4
title: Override the sort in the default table. The call works only in the showDisplay() method
seo_title: Lara-Crud Override the sort in the default table. The call works only in the showDisplay() method fieldOrderBy()
categories: [documentation]
published: true
method: fieldOrderBy()
permalink: /:categories/:title/
---

---

#### $this->fieldOrderBy(<span style="color: #693">int</span> $numberColumn, <span style="color: #693">string</span> $typeSort)

## Parameter List

---

***numberColumn***

 The column number in the table by which the sorting will take place. The count starts at 0.

***typeSort***
    
Sort sort in descending order or ascending. It can be __asc__ or __desc__:

`
Example:
$this->fieldOrderBy(1, 'asc');
`


