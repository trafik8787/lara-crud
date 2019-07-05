---
layout: post4
title: The field validation method is a wrapper around the base
seo_title: LaraCrud The field validation method is a wrapper around the base Validation()
categories: [documentation]
published: true
method: Validation()
permalink: /:categories/:title/
---

---

##### Available Validation Rules  <https://laravel.com/docs/5.8/validation#available-validation-rules>

#### $this->Validation(<span style="color: #693">array</span> $array)


`
Example:
`

        $this->Validation([
            'name' => 'alpha_num|required|min:5|unique:users,name,' . Request::input('id'),
            'password' => 'required|min:4',
            'select_role' => 'required',
            'group_id' => 'integer',
        ]);


