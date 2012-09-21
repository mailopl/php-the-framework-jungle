<?php 
return array(
    'CakePHP' => array(
        'logo' =>'http://cakephp.org/img/logo/cakephp_logo_125_trans.png',
        'urls' => array(
            'Official website' => 'http://cakephp.org',
            'Official docs' => 'http://docs.cakephp.org'
        ),
        'versions' =>  array(
            '2.2' =>  array(
                '.. to get a specified record from database' => array(
                    'content' => '',
                    'gist' => 
<<<'CODE'
<pre class='prettyprint linenums languague-php'>
//controllers/UserController.php
{
    $user = $this->User->find('first', array(
        'conditions' => array(
            'User.id' => 7
        )
    ));
}
</pre>
CODE
                ),
                '.. to connect to the database' => array(
                    'content' => '',
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
                    'content' => 'test',
                    'gist' => 
//-----------------------------------------------------------------
<<<'CODE'
<pre class='prettyprint linenums languague-php'>
//controllers/UserController.php
{
    $count = $this->User->find('count');

    echo sprintf(__('Hello %s !',true), 'Josh');
    echo sprintf(
        __('There is ') . ' %s' . __n('user', 'users', $count) . __(' logged in'),
        $count;
    );
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
    $user = $this->User->find('first', array(
        'attributes' => array(
            'id' => '7'
        )
    ));

    print_r($user['Posts']); //User hasMany Posts
    print_r($user['Posts'][0]['Tags']); //Post hasAndBelongsToMany Tags
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
                /*'.. to find related records' => array(
                    'content' => '',
                    'gist' => '',
                ),*/
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
class User extends AppModel {

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
    public $hasMany = array(
        'Post' => array(
                'className' => 'Post',
                'foreignKey' => 'user_id',
        )
    );
}
//models/post.php
class Post extends AppModel {
    public $validate = array(
        'name' => array(
            'rule'    => array('minLength', '3'),
        ),
        'content' => array(
            'rule'    => array('minLength', '3'),
            'message' => 'Minimum 3 characters long'
        ),
    );

     public $hasAndBelongsToMany = array(
        'Tag' => array(
            'className'              => 'Tag',
            'joinTable'              => 'post_tags',
            'foreignKey'             => 'post_id',
            'associationForeignKey'  => 'tag_id',
            'unique'                 => true,
        )
    );

    //or simply 
    //public $hasAndBelongsToMany = array('Tag');

    public $belongsTo = array(
        'User' => array(
            'className'    => 'User',
            'foreignKey'   => 'user_id'        
        )
    );
}
//models/tag.php
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
    
    //or simply 
    //public $hasAndBelongsToMany = array('Post');
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
        '1.3' =>  array(
               '.. to get a specified record from database' => array(
                    'content' => 
                    "Model ensures that provided data is in the correct format and handles business logic. 
                    Usually represents a database table (another example would be Model as REST service).",
                    'gist' => '<script src="https://gist.github.com/3743496.js"> </script>'
                ),
                '.. to connect to the database' => array(
                    'content' => '',
                    'gist' => '',
                ),
                '.. to translate my application' => array(
                    'content' => '',
                    'gist' => '',
                ),
                '.. to improve performance' => array(
                    'content' => '',
                    'gist' => '',
                ),
                '.. to find related records' => array(
                    'content' => '',
                    'gist' => '',
                ),
                '.. to save related records' => array(
                    'content' => '',
                    'gist' => '',
                ),
                '.. to validate my record' => array(
                    'content' => '',
                    'gist' => '',
                ),
                '.. to find related records' => array(
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
                '.. to define a Model' => array(
                    'content' => '',
                    'gist' => '',
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