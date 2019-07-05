---
layout: post4
title: The method allows to display an arbitrary template above the table and form.
seo_title: LaraCrud  The method allows to display an arbitrary template above the table and form. addViewsCustomTop()
categories: [documentation]
published: true
method: addViewsCustomTop()
permalink: /:categories/:title/
---

---

#### $this->addViewsCustomTop(<span style="color: #693">funk</span> $funk)


`
Example:
`
    
    $this->addViewsCustomTop(function ($model){
        //model User
        $user = new User();
        return view('custom_view', compact('user'));
    });


