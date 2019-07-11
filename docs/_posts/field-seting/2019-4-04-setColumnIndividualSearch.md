---
layout: post4
title: The method allows you to add an individual search for each individual field.
seo_title: Lara-Crud The method allows you to add an individual search for each individual field.
categories: [documentation]
published: true
method: setColumnIndividualSearch()
permalink: /:categories/:title/
---

---

#### $this->setColumnIndividualSearch(<span style="color: #693">array</span> $array)

    Example:
    $this->setColumnIndividualSearch(['first_name','last_name']);

    
    Example:
    $this->setColumnIndividualSearch(['first_name','last_name', 'active'])
        ->column('active')->selectControl(['' => '---', '0' => 'Ні', '1' => 'Так']);


![](../../images/individual-column.png){: .image100}
