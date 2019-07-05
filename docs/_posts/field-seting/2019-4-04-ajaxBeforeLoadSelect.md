---
layout: post4
title: The method is designed to control the "Select" field. It makes it possible to override data in the field when requesting an AJAX to the database.
seo_title: LaraCrud The method is designed to control the "Select" field. It makes it possible to override data in the field when requesting an AJAX to the database ajaxBeforeLoadSelect()
categories: [documentation]
published: true
method: ajaxBeforeLoadSelect()
permalink: /:categories/:title/
---

---

#### This method only works when used 
                                            
        $this->setTypeField([
        'field_name' => ['select', [CategoryModel::class, 'id', 'title']],
        ...
        ]);                                             


#### $this->ajaxBeforeLoadSelect(<span style="color: #693">funk</span> $funk)

`Example:`

     $this->ajaxBeforeLoadSelect(function ($model, $request){
        //return array                                       
     })


`Example:`

     $this->ajaxBeforeLoadSelect()
                 ->set('user_id')
                 ->show(['first_name', 'second_name']);

## Parameter List

---

***method set($name_field)***

 The name of the field to be redefined.

***method show($array)***
    
The method takes an array of fields to be displayed one after the other in the "select" list.

***method limit($count)***
    
Determines the size of the list. The default is 10

***method limit($count)***
    
Determines the size of the list. The default is 10

***method lastSearch()***
    
The mask for the search field will be "search string %"

***method firstSearch()***
    
The mask for the search field will be "% search string"


`Example:`

     $this->ajaxBeforeLoadSelect()
                 ->set('user_id')
                 ->show(['first_name', 'second_name'])
                 ->limit(15)
                 ->lastSearch()
                 ->firstSearch();
                 
                 // result
                 //  "% search string %"
                 