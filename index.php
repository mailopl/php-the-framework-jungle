<?php
ob_start();

$directory  = dirname(__FILE__)."/frameworks";
$frameworks = array();
$iterator   = new DirectoryIterator($directory);

foreach ($iterator as $fileinfo) {
    
    if ($fileinfo->isFile()) {
        $framework = require $directory . "/" .  $fileinfo->getFilename();
        
        if (!is_array($framework)){
            continue;
        }

        $key = array_keys($framework); 
        $key = $key[0];
        $frameworks[$key] = $framework[$key];
        //$firstVersion = array_shift(array_keys($framework[$key]['versions']));
        //$toJsonify[$key] = array_keys($framework[$key]['versions'][$firstVersion]);
    }
}
$firstFramework = array_shift(array_keys($frameworks));

?>
<!DOCTYPE html>
<html class="no-js">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <title>PHP: The framework jungle</title>
        <meta name="description" content="When it comes to a frameworks in PHP, this is a jungle. Ruby has Rails, PHP has Symfony2, ZF, CakePHP, Yii, Laravel. Here you have everything you need, to choose the right one for you." />
        <meta name="robots" content="index,follow,archive"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
        <meta property="og:image" content="./img/typical_panda_nothing_fancy.png"/>
        <meta property="og:title" content="PHP: The Framework Jungle"/>
        <meta property="og:description" content="When it comes to a frameworks in PHP, this is a jungle. Ruby has Rails, PHP has Symfony2, ZF, CakePHP, Yii, Laravel. Here you have everything you need, to choose the right one for you."/>
        <meta property="og:url" content="http://www.php-jungle.com"/>
        <meta property="og:site_name" content="PHP: The Framework Jungle"/>
        <meta property="og:type" content="website"/>
        
        <link rel="stylesheet" href="css/bootstrap.min.css" />
        <link rel="stylesheet" href="css/bootstrap-responsive.min.css" />
        <link rel="stylesheet" href="css/main.css" />
        <link rel="stylesheet" href="css/chosen.css" />

        
        <link rel="shortcut icon" href="favicon.png">
        <script src="js/vendor/modernizr-2.6.1-respond-1.1.0.min.js"></script>
        
        <?php /*
        <script type="text/javascript">
        var autocomplete = {
            <?php foreach($toJsonify as $name => $data): ?>
                <?php echo $name ?> : <?php echo json_encode($data) ?>,
            <?php endforeach ?>
        };
        </script>*/ ?>
    </head>
    <body>
        <a class="fork-me" href="https://github.com/mailopl/php-the-framework-jungle">
            <img style="position: absolute; top: 0; right: 0; border: 0;" src="https://s3.amazonaws.com/github/ribbons/forkme_right_darkblue_121621.png" alt="Fork me on GitHub">
        </a>


        <div class="interesting-header">
            <img src="./img/typical_panda_nothing_fancy.png" alt="Our panda logo!"/>
            <p>
                <strong>Welcome, in the framework jungle!</strong> <br /> <br />
                
                So you know PHP and few of the fancy frameworks out there, and you know that there's no Rails for PHP. <br />
                Let's take a look, there's Symfony2, ZF2, CakePHP, Yii, Laravel... and the list goes on. <br /><br />
                What do ALL of these frameworks have in common ? <b>Scenarios</b> in which you will use them. 
                <br />For example, <b>user authentication</b>. It doesn't matter if you use Symfony2 or Laravel, if you need some <br />
                badass authentication - you need it, period.
                
                
            </p>
        </div>

        <div class="container">
            <p>
                <h2>What &amp; how ?</h2>
                <p class="explain-me">We set some common factors for all of the frameworks to match. For example, we use <a href="img/erd.png" target="_blank">this database schema <img src="img/database.png" /></a>. <br />
                    Using that schema, we created business rules (ex. email must be unique and in proper format, password must not be empty), <br />
                    common routes (like http://domain.com/users/new) and many more, just pick up a scenario!
            </p>

            <ul class="nav nav-pills">
                <?php foreach($frameworks as $name => $data): ?>
                    <li class="<?php echo $name == $firstFramework ? 'active' : null, empty($data) ? 'disabled' : null ?>">
                        <a href="#<?php echo $name ?>"><?php echo $name ?></a>
                    </li>
                <?php endforeach ?>     
                <li class="tweet"> 
                    <a href="https://twitter.com/share" class="twitter-share-button" data-url="http://phpjungle.org" data-count="none" data-hashtags="php">Tweet</a>
                </li>
            </ul>
            
            <div class="well">
                <?php foreach($frameworks as $name => $data): ?>
                    <?php if(empty($data)) continue; ?>
                    <?php $firstVersion = array_shift(array_keys($data['versions'])); ?>

                    <p class="urls">
                        <?php if(!empty($data['urls'])): ?>
                            <?php foreach($data['urls'] as $title => $url): ?>
                                <a href="<?php echo $url ?>"><?php echo $title ?></a>
                            <?php endforeach ?>
                        <?php endif ?>
                    </p>

                    <h2 id="<?php echo $name ?>"><?php /*<img src="<?php echo $data['logo'] ?>" />*/ ?><?php echo $name ?></h2>


                    <div class="tabbable tabs-left">
                        <ul class="nav nav-tabs">
                            <?php foreach($data['versions'] as $version => $nevermind): ?>
                            <?php $versionId = md5($name . $version) ?>
                                <li <?php echo $version == $firstVersion ? 'class="active"' : null ?>><a href="#<?php echo $versionId ?>" data-toggle="tab"><?php echo $version ?></a></li>
                            <?php endforeach ?>

                        </ul>

                        <div class="tab-content">       
                            <?php foreach($data['versions'] as $version => $versionData): ?>
                            <?php $tabId = md5($name . $version . $title); ?>
                            <?php $versionId = md5($name . $version); ?>
                            
                            <?php $firstTitle = array_shift(array_keys($data['versions'][$version])); ?>
                            
                            <div class="tab-pane<?php echo $version == $firstVersion  ? ' active' : null ?>" id="<?php echo $versionId ?>">   
                                <div class="tabbable">
                                    <select class="chosen" style="width:400px;">
                                         <option></option>
                                         <?php foreach($data['versions'][$version] as $title =>$internalData): ?>
                                                <?php $tabId = md5($name . $version . $title); ?>           
                                                <option rel="#<?php echo $tabId ?>" data-toggle="tab">
                                                <?php echo $title ?>
                                                </option>
                                            <?php endforeach ?>
                                          

                                        </select>
                                        <?php /*
                                        <li class="dropdown">
                                            <a class="dropdown-toggle" id="drop-<?php echo $versionId ?>" role="button" data-toggle="dropdown" href="#">What do I need to do... <b class="caret"></b></a>
                
                                            <ul  class="dropdown-menu" role="menu" aria-labelledby="drop-<?php echo $versionId?>">
                                            <?php foreach($data['versions'][$version] as $title =>$internalData): ?>
                                                <?php $tabId = md5($name . $version . $title); ?>           
                                                <li role="menuitem" <?php echo $title == $firstTitle ? 'class="active"' : null ?>>
                                                    <a tabindex="-1" href="#<?php echo $tabId ?>" data-toggle="tab">
                                                        <?php echo $title ?>
                                                    </a>
                                                </li>
                                            <?php endforeach ?>
                                            </ul>
                                          </li>*/ ?>
                                   
                                    <hr size="1" />
                                    <div class="tab-content">
                                        <?php foreach($data['versions'][$version] as $title =>$otherData): ?>
                                        <?php $tabId = md5($name . $version . $title); ?>
                                        <div class="tab-pane<?php echo $title == $firstTitle ? ' active' : null ?>" id="<?php echo $tabId ?>">
                                            <?php if(!empty($otherData['content'])): ?>
                                                <p><?php echo nl2br($otherData['content']) ?></p>
                                            <?php else: ?>
                                                <p>Sorry, no description. <?php echo join('', array_rand(range('a','z'),6)) ?></p>
                                            <?php endif ?>

                                            <?php if(!empty($otherData['gist'])): ?>
                                                <p><?php echo $otherData['gist'] ?></p>
                                            <?php else: ?>
                                                <p>Sorry, no code snippet. <?php echo join('', array_rand(range('a','z'),6)) ?></p>
                                            <?php endif ?>
                                        </div>
                                         <?php endforeach ?>
                                    </div>
                                </div>
                                </div>
                            <?php endforeach ?>
                        </div>
                    </div>
                <?php endforeach ?>                
            </div> 
            <hr />
            <footer>
                <p>
                Thanks to <a href="http://ww5.iconsmaster.com/">iconmaster</a> for great panda icon, and to <a href="http://twitter.github.com/bootstrap/">twitter</a> that we don't need to handle the design.
                <br />
                
                <strong>PHP: The framework jungle</strong> by <a href="http://about.me/mailo">Marcin Wawrzyniak (mailo)</a> is licensed under 
                <a rel="license" target="_blank" href="http://creativecommons.org/licenses/by-nc-sa/3.0/">Creative Commons Attribution-NonCommercial-ShareAlike 3.0 Unported License</a>
                </p>
            </footer>
        </div>
        <!-- /container -->
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.8.1.min.js"><\/script>')</script>
        <script src="js/chosen.jquery.js"></script>
        <script src="js/vendor/bootstrap.min.js"></script>
        <script src="js/main.js"></script>
        <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
        <?php /*
        <script>jQuery('ul.nav li.dropdown').hover(function() {
  jQuery(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn();
}, function() {
  jQuery(this).find('.dropdown-menu').stop(true, true).delay(200).fadeOut();
});</script>*/ ?>
        <script>
        $(document).ready(function(){
            $(".chosen").data("placeholder","Pick up a scenario! What do I need to do.. ").chosen();
        });
        </script>
    </body>
</html>
<?php 
    $content = ob_get_contents();
    file_put_contents("compiled.jungle.html", preg_replace('/\s+/', ' ', $content));
?>