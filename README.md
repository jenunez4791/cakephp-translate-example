# cakephp-translate-example
Cakephp Translate Behavior Example


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
