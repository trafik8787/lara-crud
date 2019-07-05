---
layout: post4
title: Set the page name from the top
seo_title: LaraCrud Set the page name from the top setTitle() 
categories: [documentation]
published: true
method: setTitle()
permalink: /:categories/:title/
---

---

#### $this->setTitle(<span style="color: #693">string</span> $str)

`
Example:
$this->setTitle('Name Page');
`
    
    
    namespace App\Http\Node;

    use Trafik8787\LaraCrud\Contracts\NodeInterface;
    use Trafik8787\LaraCrud\Models\NodeModelConfiguration;
    
    class Article extends NodeModelConfiguration implements NodeInterface {
    
    
        public function showDisplay ()
        {
            $this->setTitle('Article');
            
            ....
        }
        
        public function showEditDisplay()
        {
            $this->setTitle('Article');
                
            ....
        }
        
        public function showInsertDisplay()
        {
            $this->setTitle('Article');
                    
            ....
        }

