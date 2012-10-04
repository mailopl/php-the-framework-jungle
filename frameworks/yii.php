<?php 
return array(
    'Yii' => array(
        'urls' => array(
            'Official website' => 'http://www.yiiframework.com/',
            'Official docs' => 'http://www.yiiframework.com/doc/'
        ),
        'cons' => array(
            'A lot of singletons and global objects. Lots of Yii::app() executions.'
        ),
        'versions' =>  array(
            '1.1' =>  array(
                '.. to get a specified record from database' => array(
                    'content' => '',
                    'gist' => 

//-----------------------------------------------------------------
<<<'CODE'
<pre class='prettyprint linenums languague-php'>
//protected/controllers/UserController.php
{
    $user = User::model()->findByPk(7);
    //or
    $user = User::model()->findByAttributes(array(
        'user_id' => 7
    ));

    //or using custom SQL
    $user = User::model()->findUserByMyCustomSql();
}
</pre>

<pre class='prettyprint linenums languague-php'>
//protected/models/User.php
{
    return $this->findAllBySql('SELECT * FROM users WHERE id=:id', array(':id' => 7));
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
//protected/config/main.php
return array(
    'db' => array(
        'connectionString' => 'mysql:host=localhost;dbname=jungle',
        'emulatePrepare' => true,
        'username' => 'jungle',
        'password' => 'elgnuj',
        'charset' => 'utf8',
    ),
    // ...
);
</pre>
CODE
//-----------------------------------------------------------------

                ),
                '.. to translate my application' => array(
                    'content' => 'Yii uses static method Yii::<b>t()</b> to provide translations. Later on you just run <b>yiic messages</b> command, and Yii creates a single file with translations.',
                    'gist' => 

//-----------------------------------------------------------------
<<<'CODE'
<pre class='prettyprint'>
#Yii CLI
yiic messages
</pre>

<pre class='prettyprint linenums languague-php'>
//protected/controllers/UserController.php
{
    $count = 7;

    echo  Yii::t(
        'system', 
        'n==0#No new messages|n>1# You\'ve got {n} new messages|n==1#One new message', array($count)
    );  
    //You've got 7 new messages
}
</pre>
CODE
//-----------------------------------------------------------------

,
                ),
                '.. to fetch related records' => array(
                    'content' => 'You need to first define a model and define the model relations.',
                    'gist' => 

//-----------------------------------------------------------------
<<<'CODE'
<pre class='prettyprint linenums languague-php'>
//protected/controllers/UserController.php
{
    $user = User::model()->findByPk(7);

    print_r($user->posts); //user posts
    print_r($user->posts[0]->tags); //tags related to particular post
}
</pre>
CODE
//-----------------------------------------------------------------

,
                ),
                '.. to save related records' => array(
                    'content' => 
<<<'TEXT'
As far as there is no built-in way to save "has and belongs to many" records but you can use <a href="http://www.yiiframework.com/extension/esaverelatedbehavior">some</a> <a href="http://www.yiiframework.com/extension/cadvancedarbehavior/">extensions</a>.
Example below shows how to save "belongs to" relation.
TEXT
                    ,
                  
                    'gist' => 

//-----------------------------------------------------------------
<<<'CODE'
<pre class='prettyprint linenums languague-html'>
//protected/views/post/_form.php
        
echo $form->dropDownList( //create select box
    $model, 
    'user_id', 
    CHtml::listData( User::model()->findAll(), 'id', 'email' ) //fetch all users
); 
</pre>

<pre class='prettyprint linenums languague-php'>
//protected/controllers/PostController.php

public function actionCreate()
{
    $model = new Post;

    if(isset($_POST['Post']))
    {
        $model->attributes = $_POST['Post'];
        
        if($model->save()) { 
            $this->redirect(array('index'));
        }
    }
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
//protected/models/user.php
public function rules()
{
    return array(
        array('email, password', 'required'),
        array('email', 'email'),
        array('email','unique'),
        array('password', 'authenticate'),
        array('password','length','min'=>8,'max'=>45),
    );
}

//protected/models/post.php
public function rules()
{
    return array(
        array('name, content', 'required'),
        array('name','length','min'=>3,'max'=>45),
        array('content','length','min'=>3,'max'=>2000),
    );
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
//protected/controllers/PostController.php
{
    $this->render('index',array(
        'post' => Post::model()->findByPk(7),
    ));
}
</pre>
<pre class='prettyprint linenums languague-php'>
//protected/views/posts/index.php

echo CHtml::link(
    $post->user->email, 
    array(
        'users/view', 
        'id' => $post->user->id
    )
); //url

echo CHtml::image('logo.png'); //image
echo CHtml::script('main.js'); //js
echo CHtml::css('style.css'); //css
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
//protected/config/main.php
 'components'=>array(
        'urlManager'=>array(
            'urlFormat'=>'path',
            'rules'=>array(
                '&lt;controller:\w+>/&lt;d:\d+>'=>'&lt;controller>/view',
                '&lt;controller:\w+>/&lt;action:\w+>/&lt;id:\d+>'=>'&lt;controller>/&lt;action>',
                '&lt;controller:\w+>/&lt;action:\w+>'=>'&lt;controller>/&lt;action>',
                
                'people/' => 'user/index',
                'guy/&lt;email:.*?>' => 'user/view'
            ),
        ),
</pre>
CODE
//-----------------------------------------------------------------


                ),
               '.. to have my data cached' => array(
                    'content' =>
<<<'TEXT'
Yii provides support for memcache, XCache, APC and EAccelerator.
TEXT
,
                    'gist' => 

//-----------------------------------------------------------------
<<<'CODE'
<pre class='prettyprint linenums languague-php'>
//protected/controllers/PostController.php
{
    if(!($cachedPosts = Yii::app()->cache->get('cache.post.index'))) {
        $cachedPosts = Post::model()->findAll();
        Yii::app()->cache->set('cache.post.index', $cachedPosts);
    }
}
</pre>

In your model like that:

<pre class='prettyprint linenums languague-php'>
//protected/models/post.php
public function findLatestPosts()
{
    if(!($cachedPosts = Yii::app()->cache->get('cache.post.index'))) {
        $cachedPosts = $this->findAll();
        Yii::app()->cache->set('cache.post.index', $cachedPosts);
    }
    return $cachedPosts;
}
</pre>

Or like that:

<pre class='prettyprint linenums languague-php'>
//protected/models/post.php
public function findLatestPosts()
{
    $dependency = new CDbCacheDependency('SELECT MAX(modified) FROM posts');
    return Post::model()->cache(1000, $dependency)->findAll();
}
</pre>
CODE
//-----------------------------------------------------------------

                ),
                 '.. to define models' => array(
                    'content' => '',
                    'gist' => 

//-----------------------------------------------------------------
<<<'CODE'
<pre class='prettyprint linenums languague-php'>
//protected/models/user.php
class User extends CActiveRecord {   

    public static function model($className=__CLASS__){ //without this method you get an error
        return parent::model($className);
    }
 
    public function relations()
    {
        return array(
            'posts' => array(self::HAS_MANY, 'Post', 'user_id'),
        );
    }
}
//protected/models/post.php
class Post extends CActiveRecord {

    public static function model($className=__CLASS__){
        return parent::model($className);
    }

    public function relations()
    {
        return array(
            'tags' => array(self::MANY_MANY, 'Tag', 'posts_tags(post_id, tag_id)'),
            'user' => array(self::BELONGS_TO, 'User', 'user_id')
        );
    }
}
//protected/models/tag.php
class Tag extends CActiveRecord {

    public static function model($className=__CLASS__){
        return parent::model($className);
    }

    public function relations()
    {
        return array(
            'posts' => array(self::MANY_MANY, 'Post', 'posts_tags(post_id, tag_id)'),
        );
    }
}
</pre>
CODE

//-----------------------------------------------------------------
),

                '.. to go REST' => array(
                    'content' => '',
                    'gist' => 

//-----------------------------------------------------------------
<<<'CODE'
<pre class='prettyprint linenums languague-php'>
//protected/config/main.php
'urlManager'=>array(
    'urlFormat'=>'path',
    'rules'=>array(
        array('posts/index', 'pattern'=>'post', 'verb'=>'GET'),
        array('posts/view', 'pattern'=>'post/&lt;id:\d+>', 'verb'=>'GET'),
        array('posts/update', 'pattern'=>'post/&lt;id:\d+>', 'verb'=>'PUT'),
        array('posts/delete', 'pattern'=>'post/&lt;id:\d+>', 'verb'=>'DELETE'),
        array('posts/create', 'pattern'=>'post', 'verb'=>'POST'),
    ),
),
</pre>

<pre class='prettyprint linenums languague-php'>
//protected/controllers/PostsController.php
class PostsController extends Controller {
    public function actionIndex() 
    {
        header('Content-type: application/json');
        $posts = Post::model()->findAll();
        
        $rows = array();
        foreach($posts as $post) {
            $rows[] = $post->attributes;
        }
        
        echo CJSON::encode($rows);
        Yii::app()->end();
    }

    public function view($id) 
    {
        header('Content-type: application/json');

        echo CJSON::encode(Post::model()->findByPk($_GET['id']));
        Yii::app()->end();
    }
    //...
}
</pre>  
CODE
//-----------------------------------------------------------------

                    ,
                ),
                '.. to authenticate the User' => array(
                    'content' => 'You need to define a class extending from CUserIdentity which represents your logged in user. Since you define it, the rest is very simple.',
                    'gist' =>

//-----------------------------------------------------------------
<<<'CODE'
<pre class='prettyprint linenums languague-php'>
//protected/components/UserIdentity.php
class UserIdentity extends CUserIdentity
{
    private $_id;
    
    public function authenticate() {
        $record = User::model()->findByAttributes(array('email'=>$this->username));
        if($record === null) {
            $this->errorCode=self::ERROR_USERNAME_INVALID;
        } else if ($record->password!==md5($this->password)){
            $this->errorCode=self::ERROR_PASSWORD_INVALID;
        } else {
            $this->_id=$record->id;
            $this->errorCode=self::ERROR_NONE;
        }

        return !$this->errorCode;
    }
 
    public function getId() {
        return $this->_id;
    }
}
</pre>
<pre class='prettyprint linenums languague-php'>
//protected/controllers/UserController.php
class UserController extends Controller 
{
    public function actionLogin()
    {
        $model = new LoginForm;

        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            
            if ($model->validate() && $model->login()){
                $this->redirect(array('/'));
            } else {
                    die('Username or password is incorrect');
            }
                
        }
        $this->render('login', array('model' => $model));
    }

    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }
}   
</pre>
<pre class='prettyprint linenums languague-php'>
//protected/views/site/login.php
$form = $this->beginWidget('CActiveForm', array(
    'id'=>'login-form',
));
    
echo $form->textField($model,'username',array('size'=>'54','class'=>'input')); 
echo $form->error($model,'username',array('class'=>'errors')); 

echo $form->passwordField($model,'password',array('size'=>'54','class'=>'input')); 
echo $form->error($model,'password',array('class'=>'errors')); 

echo CHtml::submitButton('Log in'); 
    
$this->endWidget(); 
</pre>

CODE
//-----------------------------------------------------------------

                    ,
                ),

               /* '.. to control the access to the actions' => array(
                    'content' => '',
                    'gist' => '',
                ),*/
                '.. to send an Email' => array(
                    'content' => 

'Yii does not provide an email sending class but you can use one of the many extensions, or just use
PHPs mail() function.'
                    ,
                    'gist' =>

//-----------------------------------------------------------------
<<<'CODE'
<pre class='prettyprint linenums languague-php'>
//protected/controllers/UserController.php
public function registerAction() {

    mail($_POST['User']['email'], 'Registration', 'Registration OK');

}
</pre>

You may also use <a href="http://www.yiiframework.com/extension/mail" target="_blank">this</a> extension:

<pre class='prettyprint linenums languague-php'>
$message = new YiiMailMessage;
$message->view = 'registration';
$message->addTo($_POST['User']['email']);
$message->from = Yii::app()->params['adminEmail']; //admin email read from configuration file
Yii::app()->mail->send($message);
</pre>
CODE
//-----------------------------------------------------------------

                    ,
                ),
//-----------------------------------------------------------------                
                '.. to control route access' => array(
                    'content' => '',
                    'gist' => 
<<<'CODE'
<pre class='prettyprint linenums languague-php'>
//protected/controllers/UserController.php
public function accessRules() {
        return array(
            array('allow', // allow not logged in users to register and login
                'actions' => array('register', 'login'),
                'users' => array('*'),
            ),
            array('allow', // additionally allow logged in users to log out
                'actions' => array('logout'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to manage users
                'actions' => array('manage'),
                'users' => array('admin'),
            ),
            array('deny', // and deny all other actions for users not logged in
                'users' => array('*'),
            ),
        );
}   
</pre>
CODE
//-----------------------------------------------------------------




                    ,
                ),
                
                '.. to use migrations' => array(
                    'content' => '',
                    'gist' => 
<<<'CODE'
First you create a migration class:

<pre class='prettyprint'>
yiic migrate create create_users
</pre>

Then you fill up() and down() methods:

<pre class='prettyprint linenums languague-php'>
class X_create_users extends CDbMigration
{
    public function up()
    {
         $this->createTable('users', array(
            'id' => 'pk',
            'email' => 'string NOT NULL',
            'password' => 'string NOT NULL',
            'role' => 'integer',
            'created'=> 'datetime'
        ));
    }
 
    public function down()
    {
        $this->dropTable('users');

    }
}          
</pre>

And finally you run the migration: 

<pre class='prettyprint'>
yiic migrate
</pre>
CODE
//-----------------------------------------------------------------
                ),
//-----------------------------------------------------------------
                '.. to show SQL log' => array(
                    'content' => '',
                    'gist' => 
<<<'CODE'
<pre class='prettyprint linenums languague-php'>   
//protected/config/main.php
'preload'=>array('log'),

'db'=>array(
    //...
    'enableParamLogging'=>true,
    'enableProfiling'=>true,
),

'components'=>array(
    'log'=>array(array( 
        'class'=>'CProfileLogRoute', 
        'report'=>'summary',
    )),
    //...
</pre>
CODE
//-----------------------------------------------------------------
),
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
        )
    )
);                