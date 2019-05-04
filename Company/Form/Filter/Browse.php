<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Company
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.com/license/
 * @version    $Id: Browse.php 9826 2012-11-21 02:56:50Z richard $
 * @author     John
 */

/**
 * @category   Application_Extensions
 * @package    Company
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.com/license/
 */
class Company_Form_Filter_Browse extends Engine_Form
{

	public function init()
	{
		$this->clearDecorators()
		->addDecorators(array(
				'FormElements',
				array('HtmlTag', array('tag' => 'dl')),
				'Form',
		))
		->setMethod('get')
		->setAttrib('class', 'filters')
		//->setAttrib('onchange', 'this.submit()')
		;

		// get all params
		$log = Engine_Api::_ ()->getApi ( 'core', 'socialapi' )->getLog ();
		$request = Zend_Controller_Front::getInstance()->getRequest();
		$params = $request->getParams();

		$this->addElement('Text', 'search_text', array(
				'label' => 'Company Search',
		));

		/* $this->addElement('Text', 'search_text', array(
		    'label' => 'Company Description',
		));

		 // get category parent categories
		$category_id = $params['category_id'];
		$categories = Engine_Api::_()->getApi('categories','company')->getParentCategoriesSelect();
		$this->addElement('Select', 'category_id', array(
				'label' => 'Country',
				'multiOptions' => $categories,
				'value' => $category_id
		));


		// check article new or edit if new display all parent category otherwise only display selected category will be shown
		$category_id_level_one = array();
		if ($category_id){
			$category_id_level_one = Engine_Api::_()->getApi('categories','company')->getCategoriesSelectElementBasedOnParentId($category_id);
		}
		$this->addElement('Select', 'category_id_level_one', array(
				'label' => 'State',
				'multiOptions' => $category_id_level_one,
				'value' => $params['category_id_level_one']
		));

		$this->addElement('Text', 'category_id_level_two', array(
		    'label' => 'Zip Code',
		    'placeholder' => "zipcode...",
		));

		$this->addElement('Radio', 'companytype', array(
		   'label' => 'Company Type',
		    'multiOptions' => array(
		        '1' => 'High Company',
		        '2' => 'College/University'
             ),
		    'value' => '1',
		));
 */		// check article new or edit if new display all parent category otherwise only display selected category will be shown
		/* $category_id_level_two = array();
		if ($params['category_id_level_two']){
			$category_id_level_two = Engine_Api::_()->getApi('categories','company')->getCategoriesSelectElementBasedOnParentId($params['category_id_level_one']);
		}
		$this->addElement('Select', 'category_id_level_two', array(
				//'label' => 'Category Level two',
				'multiOptions' => $category_id_level_two,
				'value' => $params['category_id_level_two']
		)); */

		// find button
		$this->addElement('Button', 'find', array(
				'type' => 'submit',
				'label' => 'Search',
				'ignore' => true,
				'order' => 10000001,
		));


		$this->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array('action'=>'browse'),'company_general',true));

	}

	//   public function init()
	//   {
	//     $this->clearDecorators()
	//       ->addDecorators(array(
	//         'FormElements',
	//         array('HtmlTag', array('tag' => 'dl')),
	//         'Form',
			//       ))
	//       ->setMethod('get')
			//       ->setAttrib('class', 'filters')
			//       //->setAttrib('onchange', 'this.submit()')
			//       ;

			//     $this->addElement('Text', 'search_text', array(
			//       'label' => 'Search Companys:',
			//     ));

			//     $this->addElement('Select', 'category_id', array(
					//       'label' => 'Category:',
					//       'multiOptions' => array(
							//         '' => 'All Categories',
							//       ),
					//       'decorators' => array(
							//         'ViewHelper',
					//         array('HtmlTag', array('tag' => 'dd')),
					//         array('Label', array('tag' => 'dt', 'placement' => 'PREPEND'))
							//       ),
							//       'onchange' => '$(this).getParent("form").submit();',
							//     ));

							//     $this->addElement('Select', 'view', array(
							//       'label' => 'View:',
							//       'multiOptions' => array(
									//         '' => 'Everyone\'s Companys',
									//         '1' => 'Only My Friends\' Companys',
									//       ),
							//       'decorators' => array(
									//         'ViewHelper',
									//         array('HtmlTag', array('tag' => 'dd')),
									//         array('Label', array('tag' => 'dt', 'placement' => 'PREPEND'))
									//       ),
											//       'onchange' => '$(this).getParent("form").submit();',
											//     ));

									//     $this->addElement('Select', 'order', array(
											//       'label' => 'List By:',
											//       'multiOptions' => array(
													//         'creation_date DESC' => 'Recently Created',
													//         'member_count DESC' => 'Most Popular',
													//       ),
											//       'decorators' => array(
													//         'ViewHelper',
													//         array('HtmlTag', array('tag' => 'dd')),
													//         array('Label', array('tag' => 'dt', 'placement' => 'PREPEND'))
													//       ),
															//       'value' => 'creation_date DESC',
															//       'onchange' => '$(this).getParent("form").submit();',
															//     ));

															//     $this->addElement('Button', 'find', array(
															//       'type' => 'submit',
															//       'label' => 'Search',
															//       'ignore' => true,
															//       'order' => 10000001,
															//     ));
															//   }
	}
