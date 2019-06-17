---
layout: post4
title: The display of the Edit buttons in the rows of the table can be true or false
seo_title: LaraCrud The display of the Edit buttons in the rows of the table can be true or false buttonEdit()
categories: [documentation]
published: true
method: buttonEdit()
permalink: /:categories/:title/
---

---

#### $this->buttonEdit(<span style="color: #693">bool</span> $var = true, <span style="color: #693">callable</span>$callback)

## Parameter List

***var***

Takes a boolean value

`
Example:
$this->buttonEdit(false);
`

***callable***

The callback function gets the model:

`
Example:
$this->buttonEdit(false, function ($model){
    return true; //or return fasle;
});
`


