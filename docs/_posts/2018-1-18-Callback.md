---
layout: post
title: Callback Function
published: true
---

    $this->tableRowsRenderCollback(function ($obj){ - функция обратного вызова срабатывает при каждой отрисовке строки таблицы
        return $obj;
    });