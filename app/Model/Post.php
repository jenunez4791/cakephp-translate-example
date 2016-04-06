<?php
App::uses('AppModel', 'Model');
/**
 * Post Model
 *
 */
class Post extends AppModel {
		
		public $actsAs = array(
	        'Translate' => array(            
	            //'title' => 'titleTranslation',
	            'title',
	            'body'
	        )
	    );
}
