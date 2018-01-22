---
layout: post
title: Field Settings
keywords: admin, lara-crud, administrator, admin-panel, laravel, field-settings
published: true
---

#### The methods should be called inside the functions `public function showDisplay ()`, `public function showEditDisplay ()`, `public function showInsertDisplay ()`. [Node Class Example]({{ site.baseurl }}/Node-Class/#class-ExampleNode)

## Available Methods
***

[$this->setTitle](#metod-setTitle)

[$this->fieldShow](#metod-fieldShow)

[$this->fieldName](#metod-fieldName)

[$this->buttonDelete](#metod-buttonDelete)

[$this->buttonEdit](#metod-buttonEdit)

[$this->buttonAdd](#metod-buttonAdd)

[$this->buttonCopy](#metod-buttonCopy)

[$this->buttonGroupDelete](#metod-buttonGroupDelete)

[$this->textLimit](#metod-textLimit)

[$this->showEntries](#metod-showEntries)

[$this->fieldOrderBy](#metod-fieldOrderBy)

[$this->setWhere](#metod-setWhere)

[$this->columnColorWhere](#metod-columnColorWhere)

[$this->Tooltip](#metod-Tooltip)

[$this->addFieldClass](#metod-addFieldClass)

[$this->setTypeField](#metod-setTypeField)


## Method Listing


<a name="metod-setTitle"> 

#### $this->setTitle(<span style="color: #693">string</span> $str)

Set the page name from the top:

    Example:
    $this->setTitle('Name Page');

 

&nbsp;
<a name="metod-fieldShow"> 

#### $this->fieldShow(<span style="color: #693">array</span> $array)

Defines the list and order of the order of the fields that will be available in the form or in the table:

    Example:
    $this->fieldShow(['firstname', 'lastname']);


&nbsp;
<a name="metod-fieldName"> 

#### $this->fieldName(<span style="color: #693">array</span> $array)

Overrides the names of fields in tables or forms:

    Example:
    $this->fieldName('firstname' => 'Firstname', 'lastname' => 'Lastname']);
    

&nbsp;    
<a name="metod-buttonDelete"> 

#### $this->buttonDelete(<span style="color: #693">bool</span> $var = false)

The display of the **Delete buttons** in the rows of the table can be `true` or` false`:

    Example:
    $this->buttonDelete(true);


&nbsp;    
<a name="metod-buttonEdit"> 

#### $this->buttonEdit(<span style="color: #693">bool</span> $var = true)

The display of the **Edit buttons** in the rows of the table can be `true` or` false`:

    Example:
    $this->buttonEdit(true);
    
    
&nbsp;    
<a name="metod-buttonAdd"> 

#### $this->buttonAdd(<span style="color: #693">bool</span> $var = true)

The display of the Add New button can take values `true` or` false`:

    Example:
    $this->buttonAdd(true);
    

&nbsp;    
<a name="metod-buttonCopy"> 

#### $this->buttonCopy(<span style="color: #693">bool</span> $var = true)

The display of the Copy button can take values `true` or` false`:

    Example:
    $this->buttonCopy(true);   
             

&nbsp;             
<a name="metod-buttonGroupDelete"> 

#### $this->buttonGroupDelete(<span style="color: #693">bool</span> $var = true)

The display of the Delete button for multiple deletions can take values `true` or` false`:

    Example:
    $this->buttonGroupDelete(false);
    
    
&nbsp;    
<a name="metod-textLimit"> 

#### $this->textLimit(<span style="color: #693">int</span> $var)

Determines the number of characters displayed in the table, in which case the string ends **{...}**. The call works only in the `showDisplay` method:

    Example:
    $this->textLimit(25);  
    

&nbsp;    
<a name="metod-showEntries"> 

#### $this->showEntries(<span style="color: #693">int</span> $var)

The number of rows in the table on one page. The call works only in the `showDisplay` method:

    Example:
    $this->showEntries(25);
           
                         
&nbsp;                         
<a name="metod-fieldOrderBy"> 

#### $this->fieldOrderBy(<span style="color: #693">int</span> $numberColumn, <span style="color: #693">string</span> $typeSort)

Override the sort in the default table. The call works only in the `showDisplay` method:

## Parameter List



>***numberColumn***
>
> The column number in the table by which the sorting will take place. The count starts at 0.

>***typeSort***
>
> Sort sort in descending order or ascending. It can be `asc` or` desc`:

    Example:
   
    $this->fieldOrderBy(1, 'asc');
    
    
&nbsp;     
<a name="metod-setWhere"> 

#### $this->setWhere(<span style="color: #693">string</span> $field, <span style="color: #693">string</span> $operator, <span style="color: #693">mixed</span> $parametr)

Defines the selection of data from the database table by condition. The call works only in the `showDisplay` method:

## Parameter List

>***field***
>
> The name of the field of the database table that is present in the condition.

>***operator***
>
> The comparison operator can take the following values: `=,>, <, =>, = <`.

>***parametr***
>
>Comparison parameter.

    Example:
    $this->setWhere('id', '=', 3);    
    
    

&nbsp;     
<a name="metod-columnColorWhere"> 

#### $this->columnColorWhere(<span style="color: #693">string</span> $field, <span style="color: #693">string</span> $operator, <span style="color: #693">mixed</span> $parametr, <span style="color: #693">string</span> $color)

Sets the color of a table row to a condition. The call works only in the `showDisplay` method:

## Parameter List

>***field***
>
> The name of the field of the database table that is present in the condition.

>***operator***
>
> The comparison operator can take the following values: `=,>, <, =>, = <`.

>***parametr***
>
>Comparison parameter.

>***color***
>
>Color code.

    Example:
    $this->columnColorWhere('id', '=', 3);        
    
    
&nbsp;    
<a name="metod-Tooltip"> 

#### $this->Tooltip(<span style="color: #693">array</span> $array)

Sets the prompts for the fields in the form. Accepts an associative array in the form of keys appear fields of the database table and prompt text, you can also determine the direction of the display of the prompts `left, right, top, bottom`:

    Example:
    $this->Tooltip(['lastname' => ['Lastname toptip', 'right'], 'firstname' => 'Firstname toptip', 'email' => ['Email toptip', 'top']]);
    

&nbsp;             
<a name="metod-addFieldClass"> 

#### $this->addFieldClass(<span style="color: #693">array</span> $array)

Add a css class field

    Example:
    $this->addFieldClass(['firstname' => 'my-class']);
    
    
    
&nbsp;     
<a name="metod-setTypeField"> 

#### $this->setTypeField(<span style="color: #693">array</span> [$field => <span style="color: #693">mixed</span> $param])

## Parameter List

>***array***
>
> Takes the array settings field.

>***param***
>
> Can be an array or string.

## Example of setting `text` fields. You can override the field type.
    
    Example:
    $this->setTypeField([
        'field_name' => 'textarea' or 'text' or 'number' or 'tel' ...,
        ...
    ]);

## Example of setting the `radio` field.

    Example:
    $this->setTypeField([
      'field_name' => ['radio', ['1' => 'Yes', '0' => 'No', '3' => 'Maybe']],
      ...
    ]);               

## Example of setting the `checkbox` field.

    Example:
    $this->setTypeField([
      'field_name' => ['checkbox', '1'],
      ...
    ]);
    
## Example of configuring the `select` field.    

     Example:
     $this->setTypeField([
        'field_name' => ['select', ['1' => '111', '2' => '222']],
        ...
     ]);    
        
## Example of configuring the `select` field. The data in the field is loaded with Ajax.

    Example:
    $this->setTypeField([
      'field_name' => ['select', [CategoryModel::class, 'id', 'title']],
      ...
    ]);    
    
## Example of setting the field `select` relation many to many data in the field are loaded Ajax.

    Example:
    /**
    * category_contacts - Relationship table    
    */
    $this->setTypeField([
      'field_name' => ['select', [CategoryModel::class, 'id', 'title'], 'multiple', [CategoryModel::class, 'category_contacts', 'contacts_id', 'category_id']],
      ... or
      'field_name' => ['select', ['1' => 'Yes', '2' => 'No', '3' => 'Maybe'], 'multiple', [CategoryModel::class, 'category_contacts2', 'contacts_id', 'category_id']]
    ]);             
    
## An example of setting the `file` field. 
    
## Parameter List

>***file***
>
> Field Type

>***file_upload_directory***
>
> The name of the directory where the files are downloaded. `public\file_upload_directory`. 

> If the `multiple` constant is set multiple downloads of files.

    Example:
    $this->setTypeField([
      'field_name' => ['file', 'file_upload_directory', 'multiple'],
      ...
    ]);                               