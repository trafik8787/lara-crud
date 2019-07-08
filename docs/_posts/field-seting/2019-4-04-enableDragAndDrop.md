---
layout: post4
title: The method includes the ability to change the order of lines by dragging.
seo_title: Lara-Crud The method includes the ability to change the order of lines by dragging enableDragAndDrop()
categories: [documentation]
published: true
method: enableDragAndDrop()
permalink: /:categories/:title/
---

---

#### The method is used together with setOrder Fixed () because the table must be fixed. The name field is passed to the enableDragAndDrop () method for sorting. It must be an integer

#### $this->enableDragAndDrop(<span style="color: #693">field</span> string)


    
    Example:
    $this->setOrderFixed([3 , 'desc']);
    $this->enableDragAndDrop('sort');
    


