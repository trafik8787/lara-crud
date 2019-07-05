---
layout: post4
title: The method determines the properties of fields
seo_title: LaraCrud The method determines the properties of fields
categories: [documentation]
published: true
method: setTypeField()
permalink: /:categories/:title/
---

---

#### $this->setTypeField(<span style="color: #693">array</span> [$field => <span style="color: #693">mixed</span> $param])

## Parameter List

***array***

Takes the array settings field.

***param***

Can be an array or string.

### Example of setting <kbd>text</kbd> fields. You can override the field type.

`
Example:
$this->setTypeField([
    'field_name' => 'textarea' or 'text' or 'number' or 'tel' ...,
    ...
]);
`

### Example of setting the <kbd>radio</kbd> field.

`
Example:
    $this->setTypeField([
      'field_name' => ['radio', ['1' => 'Yes', '0' => 'No', '3' => 'Maybe']],
      ...
    ]);  
`           

### Example of setting the <kbd>checkbox</kbd> field.

`
Example:
    $this->setTypeField([
      'field_name' => ['checkbox', '1'],
      ...
    ]);
`
    
### Example of configuring the <kbd>select</kbd> field.    

`
Example:
     $this->setTypeField([
        'field_name' => ['select', ['1' => '111', '2' => '222']],
        ...
     ]);  
`  
        
### Example of configuring the <kbd>select</kbd> field. The data in the field is loaded with Ajax.

`
 Example:
    $this->setTypeField([
      'field_name' => ['select', [CategoryModel::class, 'id', 'title']],
      ...
    ]);    
`
    
### Example of setting the field <kbd>select</kbd> relation many to many data in the field are loaded Ajax.
 

    Example:
    /**
    * category_contacts - Relationship table    
    */
    
    $this->setTypeField([
      'field_name' => ['select', [CategoryModel::class, 'id', 'title'], 'multiple', [CategoryModel::class, 'category_contacts', 'contacts_id', 'category_id']],
      ... or
      'field_name' => ['select', ['1' => 'Yes', '2' => 'No', '3' => 'Maybe'], 'multiple', [CategoryModel::class, 'category_contacts2', 'contacts_id', 'category_id']]
    ]);   

            
    
### An example of setting the <kbd>file</kbd> field. 
    
## Parameter List

***file***

Field Type

***file_upload_directory***

The name of the directory where the files are downloaded. <kbd>public\file_upload_directory</kbd>

If the <kbd>multiple</kbd> constant is set multiple downloads of files.

`
Example:
    $this->setTypeField([
      'field_name' => ['file', 'file_upload_directory', 'multiple'],
      ...
    ]);     
`

