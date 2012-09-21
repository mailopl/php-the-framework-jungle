<?php 
return array(
    'Yii' => array(
        'logo' =>'http://static.yiiframework.com/files/logo/yii.png',
        'versions' =>  array(
            '1.1' =>  array(
                '.. to get a specified record from database' => array(
                    'content' => '',
                    'gist' => 
//-----------------------------------------------------------------
<<<'CODE'
<pre class='prettyprint linenums languague-php'>
//controllers/UserController.php
{
    $user = User::model()->findByPk(7);
    //or
    $user = User::model()->findByAttributes(array(
        'user_id' => 7
    ));
}
</pre>
CODE
//-----------------------------------------------------------------
                ),
                '.. to connect to the database' => array(
                    'content' => '',
                    'gist' => 
//-----------------------------------------------------------------
<<<CODE
<pre class='prettyprint linenums languague-php'>
//config/main.php
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
                    'content' => '',
                    'gist' => 
//-----------------------------------------------------------------
<<<'CODE'
<pre class='prettyprint linenums languague-php'>
//controllers/UserController.php
{
    $count = User::model()->count();

    echo sprintf( Yii::t('system', 'Hello %s !'), 'Josh' );
    
    echo  
        Yii::t('system', 'There is') . 
        Yii::t('system', 'n==1#one user|n>1# {n} users',array($count)) . 
        Yii::t('system', ' logged in')
    ;  
    //Hello Josh! There is 5 users logged in

}
</pre>
CODE
//-----------------------------------------------------------------
,
                ),
               /* '.. to improve performance' => array(
                    'content' => '',
                    'gist' => '',
                ),*/
                '.. to find related records' => array(
                    'content' =>
<<<'TEXT'
You need to first <a href="">define a model</a> and <a href="">define the model relations</a>.
TEXT
,
                    'gist' => 
//-----------------------------------------------------------------
<<<'CODE'
<pre class='prettyprint linenums languague-php'>
//controllers/UserController.php
{
    $user = User::model()->findByPk(7);

    print_r($user->posts); //User hasMany Posts
    print_r($user->posts[0]->tags); //Post hasAndBelongsToMany Tags
}
</pre>
CODE
//-----------------------------------------------------------------
,
                ),
                '.. to save related records' => array(
                    'content' => '',
                    'gist' => '',
                ),
                '.. to validate my record' => array(
                    'content' => '',
                    'gist' => '',
                ),
                '.. to generate a basic view' => array(
                    'content' => '',
                    'gist' => '',
                ),
                '.. to change meaning of URLs' => array(
                    'content' => '',
                    'gist' => '',
                ),
                '.. to have my data cached' => array(
                    'content' => '',
                    'gist' => '',
                ),
                 '.. to define models' => array(
'content' =>

<<<'TEXT'
This example shows not only a basic related models definition, but also validation rules matching our ERD diagram.
TEXT


,'gist' => 

//-----------------------------------------------------------------
<<<'CODE'
<pre class='prettyprint linenums languague-php'>
//models/user.php
class User extends CActiveRecord {   

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
 
    public function relations()
    {
        return array(
            'posts' => array(self::HAS_MANY, 'Post', 'user_id'),
        );
    }

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
}
//models/post.php
class Post extends CActiveRecord {

    public function rules()
    {
        return array(
            array('name, content', 'required'),
            array('name','length','min'=>3,'max'=>45),
            array('content','length','min'=>3,'max'=>2000),
        );
    }

    public function relations()
    {
        return array(
            'tags' => array(self::MANY_MANY, 'Tag', 'posts_tags(post_id, tag_id)'),
            'user' => array(self::BELONGS_TO, 'User', 'user_id')
        );
    }
}
//models/tag.php
class Tag extends CActiveRecord {

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

                '.. to define a Controller' => array(
                    'content' => '',
                    'gist' => '',
                ),
                '.. to go REST' => array(
                    'content' => '',
                    'gist' => '',
                ),
                '.. to authenticate the User' => array(
                    'content' => '',
                    'gist' => '',
                ),
                '.. to send an Email' => array(
                    'content' => '',
                    'gist' => '',
                ),
            ),
        )
    )
);                