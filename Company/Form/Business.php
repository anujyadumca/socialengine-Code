<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Group
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.com/license/
 * @version    $Id: Create.php 9747 2012-07-26 02:08:08Z john $
 * @author     John
 */

/**
 * @category   Application_Extensions
 * @package    Group
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.com/license/
 */
class Company_Form_Business extends Engine_Form
{
    public function init()
    {
        $user = Engine_Api::_()->user()->getViewer();

        $this
        ->setTitle('Create New Business Contact');




        $this->addElement('Text', 'name', array(
            'label' => 'Name',
            'allowEmpty' => false,
            'required' => true,
            'validators' => array(
                array('NotEmpty', true),
                array('StringLength', false, array(1, 64)),
            ),
            'filters' => array(
                'StripTags',
                new Engine_Filter_Censor(),
            ),
        ));

        $this->addElement('Text', 'email', array(
            'label' => 'Email',
            'allowEmpty' => false,
            'required' => false,
            'validators' => array(
                array('NotEmpty', false),
                array('StringLength', false, array(1, 64)),
            ),

        ));

        $this->addElement('Textarea', 'address', array(
            'label' => 'Address',
            'validators' => array(
                array('NotEmpty', true),
                //array('StringLength', false, array(1, 1027)),
            ),
            'filters' => array(
                'StripTags',
                new Engine_Filter_Censor(),
                new Engine_Filter_EnableLinks(),
                new Engine_Filter_StringLength(array('max' => 10000)),
            ),
        ));

        $this->addElement('Text', 'phone', array(
            'label' => 'Phone No',
            'validators' => array(
                array('NotEmpty', true),
                //array('StringLength', false, array(1, 1027)),
            ),
            'filters' => array(
                'StripTags',
                new Engine_Filter_Censor(),
                new Engine_Filter_EnableLinks(),
                new Engine_Filter_StringLength(array('max' => 10000)),
            ),
        ));

        $this->addElement('Radio', 'businesstype', array(
            'label' => 'Business Type',
            'multiOptions' => array(
                '1' => 'Contact for Patnership',
                '2' => 'Contact for Suppliers Proposals',
                '3' => 'Request for Proposal'
            ),
            'value' => '1',
        ));


        $this->addElement('Text', 'link', array(
            'label' => 'Patnership Page Link',
            'allowEmpty' => false,
            'required' => true,
            'registerInArrayValidator' => false,
        ));



/*
        $this->addElement('File', 'photo', array(
            'label' => 'Profile Photo'
        ));
        $this->photo->addValidator('Extension', false, 'jpg,png,gif,jpeg');

        //     $this->addElement('Select', 'category_id', array(
        //     		'label' => 'Category',
        //     		'multiOptions' => array(
            //     				'0' => ' '
            //     		),
        //     )); */




        // Buttons
        $this->addElement('Button', 'submit', array(
            'label' => 'Save Changes',
            'type' => 'submit',
            'ignore' => true,
            'decorators' => array(
                'ViewHelper',
            ),
        ));

        $this->addElement('Cancel', 'cancel', array(
            'label' => 'cancel',
            'link' => true,
            'prependText' => ' or ',
            'decorators' => array(
                'ViewHelper',
            ),
        ));

        $this->addDisplayGroup(array('submit', 'cancel'), 'buttons', array(
            'decorators' => array(
                'FormElements',
                'DivDivDivWrapper',
            ),
        ));
    }
}