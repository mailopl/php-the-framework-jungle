<?php 
return array(
    'PhalconPHP' => array(
        'urls' => array(
            'Official website' => 'http://phalconphp.com',
            'Official docs' => 'http://phalconphp.com/documentation'
        ),
        'cons' => array(
            'Written in C which is also a big advantage. Very young but mature.',
        ),
        'versions' =>  array(
            '0.5' =>  array(
                '.. to get a specified record from database' => array(
                    'content' => '',
                    'gist' => 

//-----------------------------------------------------------------
<<<'CODE'
<pre class='prettyprint linenums languague-php'>
//app/controllers/UserController.php
{
    //by its integer primary key
    $user = User::findFirst(7);

    //by other primary key
    $user = User::findFirst('code=7');

    //or using custom SQL
    $user = User::findUserByMyCustomSql();
}
</pre>

<pre class='prettyprint linenums languague-php'>
//app/models/user.php
{
    return $this->db->query('SELECT * FROM users WHERE id=?', array(7));
}
</pre>
CODE
//-----------------------------------------------------------------

                ),
                '.. to connect to a database' => array(
                    'content' => 'You just need to set your config data, and inject database connection:',
                    'gist' => 
//-----------------------------------------------------------------
<<<'CODE'

<pre class='prettyprint linenums languague-ini'>
//app/config/config.ini
[database]
host     = localhost
username = root
password = elgnuj
name     = jungle
</pre>
<pre class='prettyprint linenums languague-php'>
$di->set('db', function() use ($config) {
    return new \Phalcon\Db\Adapter\Pdo\Mysql(array(
        "host" => $config->database->host,
        "username" => $config->database->username,
        "password" => $config->database->password,
        "dbname" => $config->database->name
    ));
});
</pre>
CODE
//-----------------------------------------------------------------
,
                ),
                '.. to translate my application' => array(
                    'content' => 'PhalconPHP uses <a href="http://www.php.net/manual/en/intro.intl.php" target="_blank">intl</a> extension to provide translations.',
                    'gist' => 
//-----------------------------------------------------------------
<<<'CODE'
<pre class='prettyprint linenums languague-php'>
//app/controllers/UserController.php
{
    $count = 7;

    $message = new MessageFormatter($locale, 
     "{0,choice,0#No new messages|
      1#One new message|
      1<You've got {0,number} new messages}."
    );

    echo $message->format($count); //You've got 7 new messages
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
//app/controllers/UserController.php
{
    $user = User::findFirst(7);

    print_r($user->getPosts()); //user posts
    print_r($user->getPosts()[0]->getPostTags()); //tags related to particular post
}
</pre>
CODE
//-----------------------------------------------------------------

,
                ),
                '.. to save related records' => array(
                    'content' => 'In PhalconPHP saving related records requires some extra work - transactions.',
                    'gist' => 

//-----------------------------------------------------------------
<<<'CODE'
<pre class='prettyprint linenums languague-html'>
//app/views/posts/create.phtml
&lt;?php use \Phalcon\Tag as Tag; ?&gt;
&lt;?= Tag::form("posts/create") ?&gt;
    &lt;?= Tag::textField(array("name")) ?&gt;
    &lt;?= Tag::textArea(array("content")) ?&gt;
    &lt;?= Tag::select(array("user_id", $users, "using" => array("id", "email"))) ?&gt;
    &lt;?= Tag::select(array("user_id", $users, "using" => array("id", "email"),"multiple"=>"multiple")) ?&gt;
    &lt;?= Tag::submitButton("Save") ?&gt;
&lt;/form>
</pre>

<pre class='prettyprint linenums languague-php'>
//app/controllers/PostController.php
use Phalcon\Mvc\Model\Transaction\Failed as TransactionFailed;

public function addAction()
{
    if ($this->request->isPost()) {
        
        try{
            $transaction = $this->transactionManager->get();
            
            $post = new Post;
            $post->setTransaction($transaction);
            $post->name = $request->getPost('name','striptags');
            $post->user_id = $request->getPost('user_id', 'int');
            $post->content = $request->getPost('content');
            
            if ($post->save() === false){
                $transaction->rollback("Error saving a record, sorry");
            }
            
            foreach($this->request->getPost('tag_id') as $tagId){
                $tag = new PostTags;
                $tag->setTransaction($transaction);
                $tag->post_id = $post->id;
                $tag->tag_id = $tagId;
                if (false == $tag->save()) {
                    $transaction->rollback('Cannot save tag #' . $tagId);
                }
            }

            $transaction->commit();
          
        } catch(TransactionFailed $e) { 
            die($e->getMessage());
        }
    }

    $this->view->setVar('tags', Tag::find());
    $this->view->setVar('users', User::find());
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
//app/models/User.php
use Phalcon\Mvc\Model\Validator\Uniqueness;
use Phalcon\Mvc\Model\Validator\Email;

class Users extends Phalcon\Mvc\Model {
    public function validation() {
        $this->validate(new Uniqueness(
            array(
                "field"   => "email",
                "message" => "This email is already used."
            )
        ));
        $this->validate(new Email(array(
             'field' => 'email',
             "message" => "Enter a valid email."
        )));

        return $this->validationHasFailed() != true;
    }
}
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
//app/views/post/index.phtml

echo \Phalcon\Tag::linkTo(array(
        'for' => 'view-user', 
        'id' => $post->getUser()->id
    ), 
    $post->getUser()->email
); 

echo \Phalcon\Tag::image('logo.png'); //image
echo \Phalcon\Tag::javascriptInclude('main.js'); //js
echo \Phalcon\Tag::stylesheetLink('style.css'); //css
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
//app/routes.php
$router = new \Phalcon\Mvc\Router();

$router->add("/people", "Users::index");
$router->add("/guy/{email}", "Users::view");

$router->handle();
</pre>
CODE
//-----------------------------------------------------------------

,
                ),
                '.. to have my data cached' => array(
                    'content' =>
<<<'TEXT'
In PhalconPHP you can cache <a href="http://docs.phalconphp.com/en/latest/reference/cache.html#caching-output-fragments" target="_blank">HTML fragments</a> and <a target="_blank" href="http://docs.phalconphp.com/en/latest/reference/cache.html#caching-arbitrary-data">database queries</a>.
PhalconPHP has built in support for <a target="_blank" href="http://docs.phalconphp.com/en/latest/reference/cache.html#memcached-backend-example">memcached</a>, APC and file cache.


TEXT
                    ,
                    'gist' =>  
//-----------------------------------------------------------------
<<<'CODE'


After you previously configure cache in your DI, you can use it like this:
<pre class='prettyprint linenums languague-php'>
//app/cntrollers/PostController.php      
{
    if(!($cachedPosts = $this->cache->get('cache.post.index'))) {
        $cachedPosts = Post::find();
        $this->cache->save('cache.post.index', $cachedPosts);
    }
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
//app/models/User.php
class User extends \Phalcon\Mvc\Model {
    public function getSource() {
        return "users";
    }

   
    public function initialize() {
        $this->hasMany("id", "Post", "user_id");
    }
}
//app/models/Post.php
class Post extends \Phalcon\Mvc\Model {
    public function getSource() {
        return "posts";
    }
    
    public function initialize() {
        $this->belongsTo("user_id", "User", "id");
        $this->hasMany("id", "PostTags", "post_id");
    }
}
//app/models/Tag.php
class Tag extends \Phalcon\Mvc\Model {
    public function getSource() {
        return "tags";
    }

    public function initialize() {
        $this->hasMany("id", "PostTags", "tag_id");
    }
}
</pre>
CODE
//-----------------------------------------------------------------

),
                '.. to go REST' => array(
                    'content' => 'You need at least two things - routing and controller code.',
                    'gist' => 

//-----------------------------------------------------------------
<<<'CODE'
<pre class='prettyprint linenums languague-php'>
//app/controllers/PostController.php
class PostController extends  \Phalcon\Mvc\Controller 
{
    public function index() {
        $posts = Post::find();

        $data = array();
        foreach($posts as $post) {
            $data[] = array(
                'id' => $post->id,
                'name' => $post->title,
            );
        }

        echo json_encode($data);
    }

    public function view($id) {
        $post = Post::find($id);
        echo json_encode($post);
    }
    //...
}
</pre>  
CODE
//-----------------------------------------------------------------

                    ,
                ),
                '.. to authenticate the User' => array(
                    'content' => 'PhalconPHP doesn\'t provide user Auth component by default.',
                    'gist' => 

//-----------------------------------------------------------------
<<<'CODE'
<pre class='prettyprint linenums languague-php'>
//app/controllers/UserController.php
class UserController extends \Phalcon\Mvc\Controller
{
    public $components = array(
        'Auth' => array(
            'username' => 'email' //we change default username field to email since we use it
        )
    );  
    
    public function login() 
    {
       if ($this->request->isPost()) {
            $email    = $this->request->getPost('email', 'email');
            $password = sha1($this->request->getPost('password'));
            $user     = Users::findFirst("email='$email' AND password='$password'");
            
            if ($user != false) {
                $this->session->set('auth', array(
                    'id' => $user->id,
                    'name' => $user->name
                ));

                $this->flash->success('Welcome '.$user->name);
                
                return $this->dispatcher->forward(array(
                    'controller' => 'users',
                    'action' => 'profile',
                    'id'=>$user->id
                ));
            }
            $this->flash->error('Wrong email/password');
        }
    }
    
    public function logout() 
    {
        $this->session->remove('auth');
        $this->flash->success('Goodbye!');
        return $this->forward('/');
    }                  
}
</pre>


<pre class='prettyprint linenums languague-php'>
//app/view/users/login.phtml
&lt;?php echo Tag::form('user/login') ?&gt;
&lt;?php echo Tag::textField(array("email", "size" => "30")) ?&gt;
&lt;?php echo Tag::passwordField(array("password", "size" => "30")) ?&gt;
&lt;?php echo Tag::submitButton(array('Log in')) ?&gt;
&lt;/form&gt;
</pre>
CODE
//-----------------------------------------------------------------

              
,
                ),
                '.. to send an Email' => array(
                    'content' => 'PhalconPHP does not provide an email sending class but you can use one of the many extensions (like SwiftMail), or just use
PHPs mail() function.',
                    'gist' => 

//-----------------------------------------------------------------
<<<'CODE'
<pre class='prettyprint linenums languague-php'>
//app/controllers/UserController.php
public function register() {
    mail($_POST['User']['email'], 'Registration', 'Registration OK');
}
</pre>
CODE
//-----------------------------------------------------------------

                    ,
                ),
                '.. to use migrations' => array(
                    'content' => '',
                    'gist' =>
//-----------------------------------------------------------------
<<<'CODE'

Running following command will dump tables and views from your database:

<pre class='prettyprint'>
phalcon gen-migration             
</pre>

When you run that command again, PhalconPHP will create subfolder with another version number and dumped tables/views.
CODE
//-----------------------------------------------------------------
                ),

                '.. to show SQL log' => array(
                    'content' => '',
                    'gist' => 
//-----------------------------------------------------------------
<<<'CODE'
<pre class='prettyprint linenums languague-php'>
//your bootstrap or index.php file
$eventsManager  = new \Phalcon\Events\Manager();
$di->set('db', function() use ($config, $eventsManager){

    $eventManager->attach('db', function($event, $connection) {
        if ($event->getType() == 'afterQuery') {
            echo $connection->getSQLStatement();
        }
    });

    $connection = new \Phalcon\Db\Adapter\Pdo\Mysql(array(
        "host" => $config->database->host,
        "username" => $config->database->username,
        "password" => $config->database->password,
        "dbname" => $config->database->name
    ));

    $connection->setEventsManager($eventsManager);

    return $connection;
});
</pre>
CODE
                ),
//-----------------------------------------------------------------
               /*
                 '.. to handle user input data' => array(
                    'content' => '',
                    'gist' => '',
                ),
                'to use session data' => array(
                    'content' => '',
                    'gist' => '',
                ),
                'to use CLI' => array(
                    'content' => '',
                    'gist' => '',
                ),
                 'to initially configure this framework' => array(
                    'content' => '',
                    'gist' => '',
                )
                */

            ),
            //add here a new version
        )
    )
);                