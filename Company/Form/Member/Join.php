<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Group
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.com/license/
 * @version    $Id: Join.php 9747 2012-07-26 02:08:08Z john $
 * @author     John
 */

/**
 * @category   Application_Extensions
 * @package    Group
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.com/license/
 */
class Company_Form_Member_Join extends Engine_Form
{
  public function init()
  {
    $this->setTitle('Join Company')
      ->setDescription('Would you like to join this company?');
      $relationships = $relationshipTable = Engine_Api::_()->getDbtable('relationships', 'company')->getRelationshipsAssoc();
      $this->addElement('Radio', 'association', array(
          'label' => 'Choose Your Association',
          'class'=>'family',
          'multiOptions' => $relationships,
          'value' => '1',
      	  'onchange' => 'javascript:showgraduation(this.value);',
      ));

      $this->addElement('text', 'graduation', array(
      		'label' => 'Your Graduation Year',
      		'class'=>'graduation',
      		'id' => 'graduation'
      ));

    //$this->addElement('Hash', 'token');

    $this->addElement('Button', 'submit', array(
      'label' => 'Join Company',
      'ignore' => true,
      'decorators' => array('ViewHelper'),
      'type' => 'submit'
    ));

    $this->addElement('Cancel', 'cancel', array(
      'prependText' => ' or ',
      'label' => 'cancel',
      'link' => true,
      'href' => '',
      'onclick' => 'parent.Smoothbox.close();',
      'decorators' => array(
        'ViewHelper'
      ),
    ));

    $this->addDisplayGroup(array(
      'submit',
      'cancel'
    ), 'buttons');

    $this->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array()))->setMethod('POST');
  }
}