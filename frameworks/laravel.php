<?php 
return array(
    'Laravel' => array(
        'urls' => array(
            'Official website' => 'http://laravel.com',
            'Official docs' => 'http://laravel.com/docs'
        ),
        'cons' => array(
            'Poor documentation - lacks features as database transactions or saving HABTM relations through Form.',
            'Lack of default M/V/C CLI generator (comes in bundle).'
        ),
        'versions' =>  array(
            '3.2.x' =>  array(
                '.. to get a specified record from database' => array(
                    'content' => '',
                    'gist' => 

//-----------------------------------------------------------------
<<<'CODE'
<pre class='prettyprint linenums languague-php'>
//application/controllers/user.php
{
    $user = User::find(7);
    
    //or using custom SQL
    $user = User::findUserByMyCustomSql();
}
</pre>

<pre class='prettyprint linenums languague-php'>
//application/models/user.php
{
    return DB::query('SELECT * FROM users WHERE id=?', array(7));
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
//application/config/database.php
//...
'connections' => array(
        'mysql' => array(
            'driver'   => 'mysql',
            'host'     => 'localhost',
            'database' => 'jungle',
            'username' => 'jungle',
            'password' => 'elgnuj',
            'charset'  => 'utf8',
        ),
),
//...
</pre>
CODE
//-----------------------------------------------------------------
,
                ),
                '.. to translate my application' => array(
                    'content' => 'Laravel uses double underscore function to provide easy localization but you have to create localization array on your own.',
                    'gist' => 
//-----------------------------------------------------------------
<<<'CODE'
<pre class='prettyprint linenums languague-php'>
//application/languages/en/app.php
return array(
    'msg' => array(
        'no' => 'No new messages',
        'one' => 'One new message',
        'many' => 'You\'ve got :number new messages.'
    )
);
</pre>

<pre class='prettyprint linenums languague-php'>
//application/controllers/user.php
{
    $count = 7;

    if ($count == 0){
        echo __('app.msg.no');
    }else if($count == 1){
        echo __('app.msg.one');
    }else{
        echo __('app.msg.many', array('number' => $count));
    }
    //You've got 7 new messages
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
//application/controllers/user.php
{
    $user = User::find(7);

    print_r($user->posts); //user posts
    print_r($user->posts[0]->tags); //tags related to particular post
}
</pre>
CODE
//-----------------------------------------------------------------

,
                ),
                '.. to save related records' => array(
                    'content' => 'In Laravel saving related records requires some extra work:',
                    'gist' => 

//-----------------------------------------------------------------
<<<'CODE'
<pre class='prettyprint linenums languague-html'>
//application/views/post/create.php
echo Form::open('post/create');
    echo Form::text('name');
    echo Form::textarea('content');
    echo Form::select('user_id', $users); //creates select field for belongs_to relation
    echo Form::select('tag_id[]', $tags, null, array('multiple'=>'multiple'));//creates multi-select field
    echo Form::submit('save');
echo Form::close();
</pre>

Keep in mind that some parts (like transaction) of the code below should be placed in the model file, but for simplicity purposes we will leave them as below:

<pre class='prettyprint linenums languague-php'>
//application/controllers/post.php
public function add()
{
    if (Request::method() == 'POST') {
        $post = new Post(array(
                'name'    => Input::get('name'),
                'content' => Input::get('content'),
                'user_id' => Input::get('user_id'),
            )
        );

        try {
            DB::transaction(function() use ($post)
            {
                $post->save();

                foreach(Input::get('tag_id') as $tag_id) {
                    $post->tags()->attach($tag_id);
                }
            });
        } catch(PDOException $e) {
            die('Error saving a record, sorry');
        }
    }
    return View::make('user.index', array(
        'tags' => Tag::order_by('id','desc')->lists('name','id'),
        'users'=> User::order_by('id','desc')->lists('email','id')
    ));     
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
//application/models/user.php
public static $validation = array(
    'email' => 'required|email|unique:users',
    'password'=>'required|min:8'
);

//application/models/post.php
public static $validation = array(
    'name' => 'required|min:3|max:50',
    'content' => 'required|min:3|max:2000'
);

//application/controllers/post.php
{
    $validation = Validator::make(Input::all(), Post::$validation);

    if ($validation->fails()) {
        return $validation->errors;
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
//application/controllers/post.php
{
    return View::make('post.index', array(
        'post' => Post::find(7)
    ));
}
</pre>

<pre class='prettyprint linenums languague-php'>
//application/views/post/index.php
use Laravel\Html as Html;

echo Html::link(URL::to_action('user@view', array($post->user->id)), $post->user->email); //url
echo Html::image('logo.png'); //image
echo Html::script('main.js'); //js
echo Html::style('style.css'); //css
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
//application/routes.php
Route::any('people', 'users@index');
Route::any('guy/(:email)', 'users@view');
</pre>
CODE
//-----------------------------------------------------------------

,
                ),
                '.. to have my data cached' => array(
                    'content' =>
<<<'TEXT'
Laravel has built in support for memcached, APC, Redis, Database cache, File system cache and Memory cache (arrays).
TEXT
                    ,
                    'gist' =>  
//-----------------------------------------------------------------
<<<'CODE'

<pre class='prettyprint linenums languague-php'>
//application/controllers/post.php
{
    if(!($cached_posts = Cache::get('cache.post.index'))) {
        $cached_posts = Post::all();
        Cache::put('cache.post.index', $cached_posts, 1800);
    }
}
</pre>

Or in your model:

<pre class='prettyprint linenums languague-php'>
//application/models/post.php
public static function find_latest_posts()
{
    if(!($cached_posts = Cache::get('cache.post.index'))) {
        $cached_posts = static::all();
        Cache::put('cache.post.index', $cached_posts, 1800);
    }
    return $cached_posts;
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
//application/models/user.php
class User extends Eloquent {

    public static $timestamps = false;
    
     public function posts() {
          return $this->has_many('Post');
     }
}

//application/models/post.php
class Post extends Eloquent {

    public function tags() {
        return $this->has_many_and_belongs_to('Tag');
    }
    
    public function user(){
        return $this->belongs_to('User');
    }
}

//application/models/tag.php
class Tag extends AppModel {

     public function posts() {
        return $this->has_many_and_belongs_to('Post');
    }
}
</pre>
CODE
//-----------------------------------------------------------------

),
                '.. to go REST' => array(
                    'content' => 'You need at least one thing - a controller with $restful property set to true.',
                    'gist' => 

//-----------------------------------------------------------------
<<<'CODE'
<pre class='prettyprint linenums languague-php'>
//application/controllers/post.php
class Posts_Controller extends Base_Controller {

    public $restful = true;
    
    public function get_index() {
        $posts = Post::all();
        return Response::eloquent($posts);
    }
}
//application/controllers/post.php
class Post_Controller extends Base_Controller {

    public $restful = true;

    public function get_index($id) {
        $post = Post::find($id);
        return Response::eloquent($post);
    }
}
</pre>  
CODE
//-----------------------------------------------------------------

                    ,
                ),
                '.. to authenticate the User' => array(
                    'content' => 'Laravel has built in Auth component so user authentication is very easy.',
                    'gist' => 

//-----------------------------------------------------------------
<<<'CODE'
<pre class='prettyprint linenums languague-php'>
//application/controllers/user.php
class User_Controller extends Base_Controller 
{
  
    public function action_login() 
    {
        $credentials = array(
            'email' => Input::get('email'), 
            'password' => Input::get('password')
        );

        if (Auth::attempt($credentials)){
            return Redirect::to('/');
        }else{
            die('Username or password is incorrect');
        }
    }
    
    public function logout() 
    {
        Auth::logout();
    }                  
}
</pre>


<pre class='prettyprint linenums languague-php'>
//application/views/user/login.php
echo Form::open('user/login');
    echo Form::text('email');
    echo Form::password('password');
    echo Form::submit('Log in');
echo Form::close();
</pre>
CODE
//-----------------------------------------------------------------

              
,
                ),
                '.. to send an Email' => array(
                    'content' => '
                    There is no built in Email component in Laravel, but you can easily install Swift Mailer Bundle.',
                    'gist' => 


//-----------------------------------------------------------------
<<<'CODE'
<pre class='prettyprint'>
#command line
php artisan bundle:install messages
</pre>

<pre class='prettyprint linenums languague-php'>
//application/controllers/user.php
public function register() {

    Message::to(Input::get('email'))
    ->from('admin@phpjungle.org', 'Jungle Chief')
    ->subject('Registration')
    ->body('Registration OK')
    ->send();
}
</pre>
CODE
//-----------------------------------------------------------------

                    ,
                ),
                
                '.. to control route access' => array(
                    'content' => '',
                    'gist' =>
//-----------------------------------------------------------------
<<<'CODE'
<pre class='prettyprint linenums languague-php'>
//application/controllers.user.php
public function __construct()
{
    parent::__construct();

    //by default the users has access to the register and login actions, 
    //but he must be logged in, to log out or see the profile page
    $this->filter('before', 'auth')->only(array('logout','profile')); 

    $this->filter('before', 'auth:admin')->only(array('manage'));  //admin can manage users
}  

//application/routes.php
Route::filter('auth:admin', function() //we need to define what "auth:admin" filter means
{
    if (isset(Auth::user()) && Auth::user()->role != 'admin') return Redirect::to('login');
});  
</pre>
CODE
,
                ),
                
                '.. to use migrations' => array(
                    'content' => '',
                    'gist' => 
               
//-----------------------------------------------------------------
<<<'CODE'
First you run: 
<pre class='prettyprint'>
php artisan migrate:install //creates migrations table
php artisan migrate:make create_users //creates migration file
</pre>

Then you fill up() and down() methods:
<pre class='prettyprint linenums languague-php'>
class Create_Users {
    /**
     * Make changes to the database.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function($table) {
            $table->increments('id');
            $table->string('email', 45);
            $table->string('password', 45);
            $table->integer('role');
        });
    }
    /**
     * Revert the changes to the database.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
</pre>

And finally you run the migration: 
<pre class='prettyprint'>
php artisan migrate
</pre>

CODE
//-----------------------------------------------------------------
 ),

                '.. to show SQL log' => array(
                    'content' => '',
                    'gist' => 
//-----------------------------------------------------------------
<<<'CODE'
<pre class='prettyprint linenums languague-php'>                    
//in your view or controller
print_r(DB::connection()->queries);
</pre>
CODE
                )
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