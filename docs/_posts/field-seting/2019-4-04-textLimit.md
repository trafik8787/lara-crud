---
layout: post4
title: Determines the number of characters displayed in the table, in which case the string ends. The call works only in the showDisplay() method
seo_title: Lara-Crud Determines the number of characters displayed in the table, in which case the string ends. The call works only in the showDisplay method textLimit()
categories: [documentation]
published: true
method: textLimit()
permalink: /:categories/:title/
---

---

#### $this->textLimit(<span style="color: #693">int</span> $var)


`
Example:
$this->textLimit(25);
`

    namespace App\Http\Node;
    
        use Trafik8787\LaraCrud\Contracts\NodeInterface;
        use Trafik8787\LaraCrud\Models\NodeModelConfiguration;
        
        class Article extends NodeModelConfiguration implements NodeInterface {
        
        
            public function showDisplay ()
            {
                $this->textLimit(25);
                
                ....
            }
            

