---
layout: post
title: Validation
published: true
---

#### $this->Validation(<span style="color: #693">array</span> $array)

The validation method is essentially a wrapper over the Laravel method [Validation](https://laravel.com/docs/5.5/validation#available-validation-rules):

    Example:
    $this->Validation(['tel' => 'required|min:5|numeric', 
                       'firstname' => 'required', 
                       'email' => 'required']);