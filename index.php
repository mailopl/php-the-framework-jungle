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
    }
}
$firstFramework = array_shift(array_keys($frameworks));

?>
<!DOCTYPE html>
<html class="no-js">
    <head>
        <meta charset="utf-8" />
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

        
        <link href="http://twitter.github.com/bootstrap/assets/js/google-code-prettify/prettify.css" type="text/css" rel="stylesheet" />
        <script type="text/javascript" src="http://twitter.github.com/bootstrap/assets/js/google-code-prettify/prettify.js"></script>


        <link rel="shortcut icon" href="favicon.png">
        <script src="js/vendor/modernizr-2.6.1-respond-1.1.0.min.js"></script>
    </head>
    <body>
        <a class="fork-me" href="https://github.com/mailopl/php-the-framework-jungle">
            <img style="position: absolute; top: 0; right: 0; border: 0;" src="https://s3.amazonaws.com/github/ribbons/forkme_right_darkblue_121621.png" alt="Fork me on GitHub">
        </a>
        <div class="container">
                <img src="./img/typical_panda_nothing_fancy.png" alt="Our panda logo!" class="panda"/>
                <h1 class="show-text">What &amp; how ?</h1>
                <h1 class="show-text" style="display:none">Ok, I get it...</h1>
                
                <div class="hide-me">
                    <p class="explain-me">phpjungle.org Panda tells you, how to do <b>X</b> thing in <b>Y</b> framework </p>
                </div>
                
                <div class="hide-me" style="display:none">
                    
                        <p><strong>Welcome, in the framework jungle!</strong></p>
                        <p>There's no Rails for PHP. </p>
                        <p>There's Symfony2, ZF2, CakePHP, Yii, Kohana, CodeIgniter, Laravel... and the list goes on. <br /><br />
                        What do <strong>ALL</strong> of these frameworks have in common ? <b>Scenarios</b> in which you will use them.</p>
                        <p>For example, <b>user authentication</b>. It doesn't matter if you use Symfony2 or Laravel, if you need some  <br />
                        badass authentication - you can do it in any of them.
                        </p>
                        <p>This site is build to help you spot differences between frameworks. </p>
                        <p>How does REST look like in CakePHP ? Symfony? <br />
                        We hope you find a way out of this jungle and pick a framework that suits your needs and sense of aesthetics.</p>
                        <p>
                        We use <a href="img/erd.png" target="_blank">this database schema <img src="img/database.png" alt="ERD"/></a>. <br />
                        Using that schema, we created business rules, common routes (like http://domain.com/users/new) and few other common factors.
                    </p>
                    
                </div>

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

                    
                    <ul class="urls nav nav-pills">
                        <?php if(!empty($data['urls'])): ?>
                            <?php foreach($data['urls'] as $title => $url): ?>
                              <li>  <a target="_blank" href="<?php echo $url ?>"><?php echo $title ?></a></li>
                            <?php endforeach ?>
                        <?php endif ?>
                    </ul>
                    

                    <h2 id="<?php echo $name ?>"><?php echo $name ?></h2>


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
                                                <option value="#<?php echo $tabId ?>" data-target="#<?php echo $tabId ?>" data-toggle="tab">
                                                <?php echo $title ?>
                                                </option>
                                            <?php endforeach ?>
                                          

                                    </select>                                      
                                    <hr />
                                    <div class="tab-content">
                                        <?php foreach($data['versions'][$version] as $title =>$otherData): ?>
                                        <?php $tabId = md5($name . $version . $title); ?>
                                        <div class="tab-pane" id="<?php echo $tabId ?>">
                                            <?php if(!empty($otherData['content'])): ?>
                                                <p><?php echo nl2br($otherData['content']) ?></p>
                                            <?php else: ?>
                                                <p>Sorry, no reasonable description yet. </p>
                                            <?php endif ?>

                                            <?php if(!empty($otherData['gist'])): ?>
                                                <?php echo $otherData['gist'] ?>
                                            <?php else: ?>
                                                <p>Sorry, no code snippet yet. </p>
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

<?php /*
                <div id="disqus_thread"></div>
                <script type="text/javascript">
                    var disqus_shortname = 'phpjungle';
                    (function() {
                        var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
                        dsq.src = 'http://' + disqus_shortname + '.disqus.com/embed.js';
                        (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
                    })();
                </script>
                <noscript>
                    Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a>
                </noscript>
*/ ?>
            </div> 
            

            <footer>
                This site is in early alpha stage, sorry if I wasted your time.
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
        <script>
        $(document).ready(function(){
            prettyPrint();
            $(".chosen").data("placeholder","Pick up a scenario! What do I need to do.. ").chosen().change(function(e){
                e.preventDefault();
                var id = ($(this).find('option:selected'));
                $(id).tab('show');
            });

            $(".extra-link").click(function(e){
                //e.preventDefault();
                var id = $(this).attr("href");
                console.log(id);
                $(id).tab('show');
                return false;
            });

            $(".show-text").click(function(){
                $("h1").toggle();
                $(".hide-me").toggle('slow');

                
            });
        });
        </script>
    </body>
</html>

<?php 
    $content = ob_get_contents();
    file_put_contents("index.html",$content);
?>