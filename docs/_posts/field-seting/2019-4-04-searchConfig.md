---
layout: post4
title: Search setting class. The call works only in the showDisplay() method
seo_title: Search setting class. The call works only in the showDisplay() method searchConfig()
categories: [documentation]
published: true
method: searchConfig()
permalink: /:categories/:title/
---

---

#### $this->searchConfig() :object

## Example List

***The search will be conducted strictly by the first characters: <kbd> LIKE "SEARCH_STRING%" </kbd>***

`
Example:
$this->searchConfig()->lastSearch();
`

***The search will be conducted on the last characters: <kbd> LIKE "%SEARCH_STRING" </kbd>***

`
Example:
$this->searchConfig()->firstSearch();
`

***Search will be performed by exact match: <kbd> LIKE "SEARCH_STRING" </kbd>***

`
Example:
$this->searchConfig()->exactSearch();
`

***Accepts an array of fields by which the search will be performed. By default, the search is performed on all that are displayed.***

`
Example:
$this->searchConfig()->fieldSearch(['firstname', 'lastname']);
`