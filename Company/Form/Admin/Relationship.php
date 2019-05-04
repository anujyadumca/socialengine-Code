<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Group
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.com/license/
 * @version    $Id: Category.php 9747 2012-07-26 02:08:08Z john $
 * @author     Jung
 */

/**
 * @category   Application_Extensions
 * @package    Group
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.com/license/
 */
class Company_Form_Admin_Relationship extends Engine_Form
{
  protected $_field;

  public function init()
  {
    $this->setMethod('post');

    /*
    $type = new Zend_Form_Element_Hidden('type');
    $type->setValue('heading');
    */

    $label = new Zend_Form_Element_Text('label');
    $label->setLabel('Association Name')
      ->addValidator('NotEmpty')
      ->setRequired(true)
      ->setAttrib('class', 'text');


    $id = new Zend_Form_Element_Hidden('id');


    $this->addElements(array(
      //$type,
      $label,
      $id
    ));
    // Buttons
    $this->addElement('Button', 'submit', array(
      'label' => 'Add Relation',
      'type' => 'submit',
      'ignore' => true,
      'decorators' => array('ViewHelper')
    ));

    $this->addElement('Cancel', 'cancel', array(
      'label' => 'cancel',
      'link' => true,
      'prependText' => ' or ',
      'href' => '',
      'onClick'=> 'javascript:parent.Smoothbox.close();',
      'decorators' => array(
        'ViewHelper'
      )
    ));
    $this->addDisplayGroup(array('submit', 'cancel'), 'buttons');
    $button_group = $this->getDisplayGroup('buttons');

   // $this->addDisplayGroup(array('submit', 'cancel'), 'buttons');
  }

  public function setField($relation)
  {
    $this->_field = $relation;

    // Set up elements
    //$this->removeElement('type');
    $this->label->setValue($relation->title);
    $this->id->setValue($relation->relationship_id);
    $this->submit->setLabel('Edit Association');

    // @todo add the rest of the parameters
  }
}