---
layout: post4
title: It takes a callback function as an argument.
seo_title: LaraCrud  The call works only in the showDisplay()
categories: [documentation]
published: true
method: showChildRows()
permalink: /:categories/:title/
---

---

#### $this->showChildRows(<span style="color: #693">funk</span> funk)

#### Objects of the current record model are passed to the function.


    $this->showChildRows();

![](../../images/childRows2.png){: .image100}

`
Example:
`

    $this->showChildRows(function ($model, $view){
                    return view('history', compact('model'));
                });

![](../../images/childRows.png){: .image100}
