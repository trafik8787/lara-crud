---
layout: post4
title: Overrides the output form on the page
seo_title: Lara-Crud Overrides the output form on the page alertDelete()
categories: [documentation]
published: true
method: alertDelete()
permalink: /:categories/:title/
---

---

#### $this->alertDelete(<span style="color: #693">string</span> $msg, <span style="color: #693">string</span> $event,  <span style="color: #693">string</span> $func)

## Parameter List

***msg***

The message that will be displayed.

***event***

Event before the output of which the message will be displayed 

***func***

JS function name for event handling

`
Example:
$this->alertDelete('Are you sure you want to delete?', 'onsubmit', 'confirmDelete');
`

    
    JS:
    
    function confirmDelete($msg) {
    
        var result = confirm($msg);
    
        if (result) {
            return true;
        } else {
            return false;
        }
    
    }                        

