---
layout: post
title: Node Class
published: true
---

    Example:
    ---
    namespace App\Http\Node;
    
    use Trafik8787\LaraCrud\Contracts\NodeInterface;
    use Trafik8787\LaraCrud\Models\NodeModelConfiguration;
    
    class ArticleExample extends NodeModelConfiguration implements NodeInterface {
    
        /**
         * @var string
         * Override the default URL is the name of the model
         */
        //public static $alias_url = 'articles';
        
        /**
         * @var string
         * Redefining the title of a section in navigation
         */
        //public static $navigation_title = 'ARTICLES';
      
        public function showDisplay ()
        {
    
        }
    
    
        /**
         * Edit page
         */
        public function showEditDisplay()
        {
           
        }
    
        /**
         * Insert Page
         */
        public function showInsertDisplay()
        {
            $this->showEditDisplay();
        }
    
        public function showDelete()
        {
    
        }
    }
    
&nbsp;
<a name="class-ExampleNode"> 
## Example Class

    namespace App\Http\Node;
    
    use App\Http\Node\Model\CategoryExampleModel;
    use Trafik8787\LaraCrud\Contracts\NodeInterface;
    use Trafik8787\LaraCrud\Models\NodeModelConfiguration;
    
    class ArticleExample extends NodeModelConfiguration implements NodeInterface {
    
        /**
         * @var string
         * Override the default URL is the name of the model
         */
        //public static $alias_url = 'articles';
        
        /**
         * @var string
         * Redefining the title of a section in navigation
         */
        //public static $navigation_title = 'ARTICLES';
    
        
        public function showDisplay ()
        {
    
            /**
             * Page Title
             */
            $this->setTitle('Articles');
            $this->fieldShow(['id','title', 'description']);
            $this->fieldName(['title' => 'Title Article', 'description' => 'Description']);
    
        }
    
    
        /**
         * Edit page
         */
        public function showEditDisplay()
        {
            $this->setTitle('Articles Edit');
            /**
             * Visible fields
             */
            $this->fieldShow(['title', 'description', 'category', 'date', 'category', 'public']);
            $this->fieldName(['title' => 'Title Article',
                'description' => 'Description',
                'date' => 'Date',
                'public' => 'Public',
                'category' => 'Category']);
    
            /**
             * Field Options
             */
            $this->setTypeField([
                'description' => 'textarea',
                'public' => ['radio', ['1' => 'Yes', '0' => 'No']],
                'category' => ['select', [CategoryExampleModel::class, 'id', 'title'], 'multiple', [CategoryExampleModel::class, 'example_category_article', 'articles_id', 'category_id']],
            ]);
    
            $this->Tooltip(['title' => ['Title tooltip', 'top'], 'description' => 'Description tooltip']);
            //$this->enableEditor(['description']);
        }
    
    
        /**
         * Insert Page
         */
        public function showInsertDisplay()
        {
            $this->showEditDisplay();
        }
    
        public function showDelete()
        {
    
        }
    
    }
    
        
    