<?php 
return array(
    'CakePHP' => array(
        'urls' => array(
            'Official website' => 'http://cakephp.org',
            'Official docs' => 'http://book.cakephp.org'
        ),
        'cons' => array(
            'Convention over configuration can be your enemy when not creating a typical CRUD webapp.',
            'Not fully object-oriented (lots of arrays that could have been avoided).'
        ),
        'versions' =>  array(
            '2.2' =>  array(
                '.. to get a specified record from database' => array(
                    'content' => '',
                    'gist' => 

//-----------------------------------------------------------------
<<<'CODE'
<pre class='prettyprint linenums languague-php'>
//app/Controller/UserController.php
{
    $user = $this->User->find('first', array(
        'conditions' => array(
            'User.id' => 7
        )
    ));
    //or using custom SQL
    $user = $this->User->findUserByMyCustomSql();
}
</pre>

<pre class='prettyprint linenums languague-php'>
//app/Model/User.php
{
    return $this->query('SELECT * FROM users WHERE id=?', array(7));
}
</pre>
CODE
//-----------------------------------------------------------------

                ),
                '.. to connect to a database' => array(
                    'content' => 'You just need to set your config data, and you are good to go.',
                    'gist' => 
//-----------------------------------------------------------------
<<<'CODE'
<pre class='prettyprint linenums languague-php'>
//app/Config/database.php
class DATABASE_CONFIG {
    public $default = array(
        'datasource'  => 'Database/Mysql',
        'persistent'  => false,
        'host'        => 'localhost',
        'login'       => 'jungle',
        'password'    => 'elgnuj',
        'database'    => 'jungle',
    );
}
</pre>
CODE
//-----------------------------------------------------------------
,
                ),
                '.. to translate my application' => array(
                    'content' => 'CakePHP uses double underscore and __n() functions to provide easy localization. Later on you just run <a target="_blank" href="http://book.cakephp.org/2.0/en/console-and-shells/i18n-shell.html">cake i18n extract</a> command.',
                    'gist' => 
//-----------------------------------------------------------------
<<<'CODE'
<pre class='prettyprint'>
#CakePHP CLI
cake i18n extract
</pre>

<pre class='prettyprint linenums languague-php'>
//app/Controller/UserController.php
{
    $count = $this->User->find('count');

    echo sprintf(__('Hello %s !',true), 'Josh');
    echo sprintf(
        __('There are ') . ' %s' . __n('user', 'users', $count) . __(' logged in'),
        $count;
    );
    //Hello Josh! There are 5 users logged in
}
</pre>
CODE
//-----------------------------------------------------------------
,
                ),
                '.. to fetch related records' => array(
                    'content' => 'You need to first define a model and proper relations and then you just:',
                    'gist' => 

//-----------------------------------------------------------------
<<<'CODE'
<pre class='prettyprint linenums languague-php'>
//app/Controller/UserController.php
{
    $user = $this->User->findById(7);

    print_r($user['Posts']); //user posts
    print_r($user['Posts'][0]['Tags']); //tags related to particular post
}
</pre>
CODE
//-----------------------------------------------------------------

,
                ),
                '.. to save related records' => array(
                    'content' => 'In CakePHP saving related records (belongs to, has many, habtm) is super easy as you can see below.',
                    'gist' => 

//-----------------------------------------------------------------
<<<'CODE'
<pre class='prettyprint linenums languague-html'>
//app/View/Post/add.ctp
echo $this->Form->create('Post');
    echo $this->Form->input('name');
    echo $this->Form->input('content');
    echo $this->Form->input('Tag'); //creates multi-select field
    echo $this->Form->input('User'); //creates select field for belongs_to relation
echo $this->Form->end('Save');
</pre>

<pre class='prettyprint linenums languague-php'>
//app/Controller/PostsController.php
public function add()
{
    if ($this->request->is('post')) {
        
        if ($this->Post->save($this->request->data)) {
            //success
        }
    }

    $this->set('tags', $this->Post->Tag->find('list'));
    $this->set('users', $this->Post->User->find('list'));
}
</pre>
CODE
//-----------------------------------------------------------------

,
                ),
                

                '.. to validate my model' => array(
                    'content' => '',
                    'gist' => 

//-----------------------------------------------------------------
<<<'CODE'
<pre class='prettyprint linenums languague-php'>
//app/Model/User.php
public $validate = array(
    'email' => array(
        'isUnique' => array(
            'rule'     => 'isUnique',
            'message'  => 'This email is already used.'
        ),
        'email' => array(
            'rule'    => 'email',
            'message' => 'Enter a valid email.'
        )
    ),
    'password' => array(
        'rule'    => array('minLength', '8'),
        'message' => 'Minimum 8 characters long'
    ),
);

//app/Model/Post.php
public $validate = array(
    'name' => array(
        'rule'    => array('minLength', '3'),
    ),
    'content' => array(
        'rule'    => array('minLength', '3'),
        'message' => 'Minimum 3 characters long'
    ),
);
</pre>
CODE
//-----------------------------------------------------------------

),

                '.. to generate a basic view' => array(
                    'content' => '',
                    'gist' => 

//-----------------------------------------------------------------
<<<'CODE'
<pre class='prettyprint linenums languague-php'>
//app/Controller/PostsController.php
{
    $this->render('index',array(
         'post'=> $this->Post->findById(7),
    ));
}
</pre>

<pre class='prettyprint linenums languague-php'>
//app/View/Post/index.ctp

echo $this->Html->link(
    $post['User']['email'], 
    array(
        'controller' => 'users', 
        'action' => 'view', 
        $post['User']['id']
    )
); //url

echo $this->Html->image('logo.png'); //image
echo $this->Html->script('main.js'); //js
echo $this->Html->css('style.css'); //css
</pre>
CODE
//-----------------------------------------------------------------

                ),
                '.. to have pretty URLs' => array(
                    'content' => '',
                    'gist' => 

//-----------------------------------------------------------------
<<<'CODE'
<pre class='prettyprint linenums languague-php'>
//app/Config/routes.php
Router::connect('/people/*', array('controller' => 'users', 'action' => 'index'));
Router::connect('/guy/:email*', array('controller' => 'users', 'action' => 'view'));
</pre>
CODE
//-----------------------------------------------------------------

,
                ),
                '.. to have my data cached' => array(
                    'content' =>
<<<'TEXT'
In CakePHP you can cache queries (in your model) using <a href="http://book.cakephp.org/2.0/en/models/model-attributes.html#cachequeries" target="_blank">$cacheQueries</a> attribute,
<a href="http://book.cakephp.org/2.0/en/core-libraries/helpers/cache.html" target="_blank">views </a> or any variable using <a href="http://book.cakephp.org/2.0/en/core-libraries/caching.html" target="_blank">Cache</a> class.

CakePHP has built in support for memcache, XCache, APC and Redis.

TEXT
                    ,
                    'gist' =>  
//-----------------------------------------------------------------
<<<'CODE'
<pre class='prettyprint linenums languague-php'>
//app/Controller/PostController.php
{
    if(!($cachedPosts = Cache::read('cache.post.index'))) {
        $cachedPosts = $this->Post->find('all');
        Cache::write('cache.post.index', $cachedPosts);
    }
}
</pre>

Or in your model:

<pre class='prettyprint linenums languague-php'>
//app/Model/Post.php
public function findLatestPosts()
{
    if(!($cachedPosts = Cache::read('cache.post.index'))) {
        $cachedPosts = $this->find('all');
        Cache::write('cache.post.index', $cachedPosts);
    }
    return $cachedPosts;
}
</pre>
CODE
//-----------------------------------------------------------------

                    ,
                ),
                '.. to define models' => array(
                    'content' => '',
'gist' => 

//-----------------------------------------------------------------
<<<'CODE'
<pre class='prettyprint linenums languague-php'>
//app/Model/User.php
class User extends AppModel {
    public $displayField = 'email';

    public $hasMany = array(
        'Post' => array(
            'className' => 'Post',
            'foreignKey' => 'user_id',
        )
    );
}

//app/Model/Post.php
class Post extends AppModel {
    public $hasAndBelongsToMany = array(
        'Tag' => array(
            'className'              => 'Tag',
            'joinTable'              => 'post_tags',
            'foreignKey'             => 'post_id',
            'associationForeignKey'  => 'tag_id',
            'unique'                 => true,
        )
    );

    public $belongsTo = array(
        'User' => array(
            'className'    => 'User',
            'foreignKey'   => 'user_id'        
        )
    );
}

//app/Model/Tag.php
class Tag extends AppModel {

    public $hasAndBelongsToMany = array(
        'Post' => array(
            'className'              => 'Post',
            'joinTable'              => 'post_tags',
            'foreignKey'             => 'tag_id',
            'associationForeignKey'  => 'post_id',
            'unique'                 => true,
        )
    );
}
</pre>
CODE
//-----------------------------------------------------------------

),
                '.. to go REST' => array(
                    'content' => 'You need three things - set up routing, define some controller and a view that outputs json data.',
                    'gist' => 

//-----------------------------------------------------------------
<<<'CODE'
<pre class='prettyprint linenums languague-php'>
//app/Config/routes.php
Router::mapResources('posts');
Router::parseExtensions();
</pre>

<pre class='prettyprint linenums languague-php'>
//app/Controller/PostsController.php
class PostsController extends AppController {

    public $components = array('RequestHandler');

    public function index() {
        $posts = $this->Post->find('all');
        $this->set(array(
            'posts' => $posts,
            '_serialize' => array('post')
        ));
    }

    public function view($id) {
        $post = $this->Post->findById($id); //or you could just json_encode here
        $this->set(array(
            'post' => $post,
            '_serialize' => array('post')
        ));
    }
    //...
}
</pre>  

<pre class='prettyprint linenums languague-php'>
//app/View/Post/json/view.ctp
echo json_encode($post);
</pre>

<pre class='prettyprint linenums languague-php'>
//app/View/Post/json/index.ctp
foreach ($posts as &amp;$post) {
    unset($post['Post']['user_id']);
}
echo json_encode($posts);
</pre>
CODE
//-----------------------------------------------------------------

                    ,
                ),
                '.. to authenticate the User' => array(
                    'content' => 'CakePHP has built in excellent Auth component.',
                    'gist' => 

//-----------------------------------------------------------------
<<<'CODE'
<pre class='prettyprint linenums languague-php'>
//app/Controller/UserController.php
class UserController extends AppController 
{
    public $components = array(
        'Auth' => array(
            'username' => 'email' //we change default username field to email since we use it
        )
    );  
    
    public function login() 
    {
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                return $this->redirect($this->Auth->redirect());
            } else {
                die('Username or password is incorrect');
            }
        }
    }
    
    public function logout() 
    {
        $this->redirect($this->Auth->logout());    
    }                  
}
</pre>


<pre class='prettyprint linenums languague-php'>
//app/View/User/login.ctp
echo $this->Session->flash('auth');
echo $this->Form->create('User');
echo $this->Form->input('email');
echo $this->Form->input('password');
echo $this->Form->end('Log in');
</pre>
CODE
//-----------------------------------------------------------------

              
,
                ),
                '.. to send an Email' => array(
                    'content' => 'CakePHP has built in CakeEmail component for sending emails.',
                    'gist' => 

//-----------------------------------------------------------------
<<<'CODE'
<pre class='prettyprint linenums languague-php'>
//app/Controller/UserController.php
public function register() {
    App::uses('CakeEmail', 'Network/Email');

    //...
    $email = new CakeEmail();
    $email
        ->from(array('admin@phpjungle.org' => 'Jungle Chief'))
        ->to($_POST['User']['email'])
        ->subject('Registration')
        ->send('Registration OK');

    //or in "one" liner:
    CakeEmail::deliver(
        $_POST['User']['email'], 
        'Registration', 
        'Registration OK', 
        array('from' => 'admin@phpjungle.org')
    );

}
</pre>
CODE
//-----------------------------------------------------------------

                    ,
                ),
                /*
                '.. to control route access' => array(
                    'content' => '',
                    'gist' => '',
                ),
                '.. to use migrations' => array(
                    'content' => '',
                    'gist' => '',
                ),
                 '.. to handle user input data' => array(
                    'content' => '',
                    'gist' => '',
                ),
                'to show SQL log' => array(
                    'content' => '',
                    'gist' => '',
                )
                'to use session data' => array(
                    'content' => '',
                    'gist' => '',
                )
                'to use CLI' => array(
                    'content' => '',
                    'gist' => '',
                )
                */

            ),
            //add here a new version
        )
    )
);                