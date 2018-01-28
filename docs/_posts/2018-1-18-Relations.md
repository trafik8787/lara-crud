---
layout: post
title: Relations
published: true
---

## One To Many

![Lara-crud One to Many](../images/Screenshot_one_to_many.png)

###  Example of setting `one-to-many` fields. You can override the field type.

>***articles_id***
>
> Foreign key on the  Comment model is `articles_id`

>***id***
>
>  Eloquent will try to match the `articles_id` from the UsersModel model to an `id` on the UsersModel model.
    
    Example:
    $this->setTypeField([
        ...
         'users' => ['text', null, 'one-to-many', [UsersModel::class, ['firstname' => 'Firstname', 'lastname' => 'Lastname', 'email' => 'Email', 'age' => 'Age'], 'articles_id', 'id']],
        ...
    ]);

