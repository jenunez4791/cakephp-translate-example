<<<<<<< HEAD
# CakePHP

[![Latest Stable Version](https://poser.pugx.org/cakephp/cakephp/v/stable.svg)](https://packagist.org/packages/cakephp/cakephp)
[![License](https://poser.pugx.org/cakephp/cakephp/license.svg)](https://packagist.org/packages/cakephp/cakephp)
[![Bake Status](https://secure.travis-ci.org/cakephp/cakephp.png?branch=master)](http://travis-ci.org/cakephp/cakephp)
[![Code consistency](http://squizlabs.github.io/PHP_CodeSniffer/analysis/cakephp/cakephp/grade.svg)](http://squizlabs.github.io/PHP_CodeSniffer/analysis/cakephp/cakephp/)

[![CakePHP](http://cakephp.org/img/cake-logo.png)](http://www.cakephp.org)

CakePHP is a rapid development framework for PHP which uses commonly known design patterns like Active Record, Association Data Mapping, Front Controller and MVC.
Our primary goal is to provide a structured framework that enables PHP users at all levels to rapidly develop robust web applications, without any loss to flexibility.


## Some Handy Links

[CakePHP](http://www.cakephp.org) - The rapid development PHP framework

[CookBook](http://book.cakephp.org) - THE CakePHP user documentation; start learning here!

[API](http://api.cakephp.org) - A reference to CakePHP's classes

[Plugins](http://plugins.cakephp.org/) - A repository of extensions to the framework

[The Bakery](http://bakery.cakephp.org) - Tips, tutorials and articles

[Community Center](http://community.cakephp.org) - A source for everything community related

[Training](http://training.cakephp.org) - Join a live session and get skilled with the framework

[CakeFest](http://cakefest.org) - Don't miss our annual CakePHP conference

[Cake Software Foundation](http://cakefoundation.org) - Promoting development related to CakePHP


## Get Support!

[#cakephp](http://webchat.freenode.net/?channels=#cakephp) on irc.freenode.net - Come chat with us, we have cake

[Google Group](https://groups.google.com/group/cake-php) - Community mailing list and forum

[GitHub Issues](https://github.com/cakephp/cakephp/issues) - Got issues? Please tell us!

[Roadmaps](https://github.com/cakephp/cakephp/wiki#roadmaps) - Want to contribute? Get involved!


## Contributing

[CONTRIBUTING.md](CONTRIBUTING.md) - Quick pointers for contributing to the CakePHP project

[CookBook "Contributing" Section (2.x)](http://book.cakephp.org/2.0/en/contributing.html) [(3.0)](http://book.cakephp.org/3.0/en/contributing.html) - Version-specific details about contributing to the project
=======
# cakephp-translate-example
Cakephp Translate Behavior Example

**[Gettext](https://en.wikipedia.org/wiki/Gettext) is an internationalization and localization (i18n)**

**Tools for po editor https://poedit.net/**

The three-character locale codes conform to the [ISO 639-2](http://www.loc.gov/standards/iso639-2/php/code_list.php) standard, although if you create regional locales (en_US, en_GB, etc.) cake will use them if appropriate.

#Initializing the i18n Database Tables

*Generating POT files*
```code
./Console/cake i18n extract
```
*Create the tables*
```code
./Console/cake i18n initdb
```

#Internationalizing Your Application

To internationalize your code, all you need to do is to wrap strings in __() like so:
```php
<h2><?php echo __('Posts'); ?></h2>
```

CakePHP will look for your po files in the following location:

```code
/app/Locale/<locale>/LC_MESSAGES/<domain>.po
```

The default domain is ‘default’, therefore your locale folder would look something like this:
```code
/app/Locale/eng/LC_MESSAGES/default.po (English)
/app/Locale/fra/LC_MESSAGES/default.po (French)
/app/Locale/por/LC_MESSAGES/default.po (Portuguese)
```

#Localization in CakePHP

##Database
```mysql
--
-- Database: `cake_translate`
--

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE `posts` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(50) DEFAULT NULL,
  `body` text,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
```

###Step 1: app/Config/routes.php###

```php
  $languageCodes = array('language' => 'eng|msa');

	Router::connect('/', array('controller' => 'posts', 'action' => 'index'));
	Router::connect('/:language', array('controller' => 'posts', 'action' => 'index'), $languageCodes);


	//default cakePHP routing, with language codes
	Router::connect('/:language/:controller/:action/*', array(), $languageCodes);
	Router::connect('/:language/:controller', array('action' => 'index'), $languageCodes);	
```
###Step 2: app/Config/core.php###
To change or set the language for your application, all you need to do is the following in core.php:
```code
Configure::write('Config.language', 'eng');
```

###Step 3: create app/View/Helper/MyHtmlHelper.php###
```php
<?php

App::uses('HtmlHelper', 'View/Helper');
class MyHtmlHelper extends HtmlHelper {

    public function url($url = null, $full = false) {        
        if(is_array($url)){
            if(!isset($url['language']) && isset($this->params['language'])) {
                $url['language'] = $this->params['language'];
            }
        }
        return parent::url($url, $full);
    }
}
```


At the beginning of each request in your controller’s beforeFilter you should configure Configure as well:

```php
class AppController extends Controller {
    public function beforeFilter() {
        if ($this->Session->check('Config.language')) {
            Configure::write('Config.language', $this->Session->read('Config.language'));
        }
    }
}
```

###Prepare AppController to support internationalization###
 Open /app/Controllers/AppController and place the following lines. Comments in code: 
 
 ```php
 class AppController extends Controller {

	
	/**
    * set an alias for the newly created helper: Html<->MyHtml
    *
    */
    public $helpers = array('Html' => array('className' => 'MyHtml'));

    /**
    * beforeFilter
    * 
    */
    public function beforeFilter() {
    	if (!isset($this->params['language']) && $this->Session->check('Config.language')) {
            Configure::write('Config.language', $this->Session->read('Config.language'));            
        }elseif(isset($this->params['language']) && 
                ($this->params['language'] !=  $this->Session->read('Config.language'))) {                               
            $this->Session->write('Config.language', $this->params['language']);
            Configure::write('Config.language', $this->params['language']);
        }
    }
    
    /**
    * redirect
    *
    */
    public function redirect( $url, $status = NULL, $exit = true ) {
        if (!isset($url['language']) && $this->Session->check('Config.language')) {
            $url['language'] = $this->Session->read('Config.language');
        }
        parent::redirect($url,$status,$exit);
    }
}

 ```
 
###Step 5: app/View/...###
create link for change language 
```php
	echo $this->Html->link('English', array('language'=>'eng'));
	echo $this->Html->link('Français', array('language'=>'fre')); 
```
>>>>>>> 595f687b0c8b63fec1e58fe8d464696523a87409
