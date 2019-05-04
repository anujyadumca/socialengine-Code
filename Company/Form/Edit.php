<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Group
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.com/license/
 * @version    $Id: Edit.php 9747 2012-07-26 02:08:08Z john $
 * @author     John
 */

/**
 * @category   Application_Extensions
 * @package    Group
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.com/license/
 */
class Company_Form_Edit extends Engine_Form
{
  public function init()
  {
    $user = Engine_Api::_()->user()->getViewer();

    $this
      ->setTitle('Edit Company');

    $this->addElement('Text', 'title', array(
      'label' => 'Company Name',
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

    $this->addElement('Textarea', 'description', array(
      'label' => 'Company Description',
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


    $this->addElement('File', 'photo', array(
      'label' => 'Profile Photo'
    ));
    $this->photo->addValidator('Extension', false, 'jpg,png,gif,jpeg');

    // check article new or edit if new display all parent category otherwise only display selected category will be shown
    $group = Engine_Api::_()->core()->getSubject();

    $categories = array();
//     if ($group->category_id){
//     	$categories = Engine_Api::_()->getApi('categories','company')->getParentCategoriesSelect($group->category_id);
//     }
//     else{
//     	$categories = Engine_Api::_()->getApi('categories','company')->getParentCategoriesSelect();
//     }

    $categories = Engine_Api::_()->getApi('categories','company')->getParentCategoriesSelect();
    $this->addElement('Select', 'country_id', array(
    		'label' => 'Country',
    		'multiOptions' => $categories,
    ));

 // check article new or edit if new display all parent category otherwise only display selected category will be shown
    $states = array();
    if ($group->state_id){
        $states = Engine_Api::_()->getApi('categories','company')->getCategoriesSelectElementBasedOnParentId($group->country_id);
    }

    $this->addElement('Select', 'state_id', array(
    		'label' => 'State',
    		'allowEmpty' => false,
    		'required' => true,
    		'registerInArrayValidator' => false,
            'multiOptions' => $states,
            'value' => $this->_item->state_id
    ));

//     // check article new or edit if new display all parent category otherwise only display selected category will be shown
    $cities = array();

     $cities = Engine_Api::_()->getApi('categories','company')->getCategoriesSelectElementBasedOnParentId($group->state_id);

     $this->addElement('Select', 'city_id', array(
     		'label' => 'City',
    		'allowEmpty' => false,
     		'required' => true,
    		'registerInArrayValidator' => false,
            'multiOptions' => $cities,
            'value' => $this->_item->city_id
    ));

     $industries = Engine_Api::_()->getApi('categories','company')->getParentIndustriesSelect();
     $this->addElement('Select', 'industry_id', array(
         'label' => 'Industries',
         'multiOptions' => $industries,
     ));

     $sectors = array();
     if ($group->sector_id){
         $sectors = Engine_Api::_()->getApi('categories','company')->getParentSectorsSelect($group->industry_id);
     }
     $this->addElement('Select', 'sector_id', array(
         'label' => 'Sectors',
         'allowEmpty' => false,
         'required' => true,
         'registerInArrayValidator' => false,
         'multiOptions' => $sectors,
         'value' => $this->_item->sector_id
     ));

     $this->addElement('Text', 'postal_code', array(
         'label' => 'Postal Code',
     ));

     $this->addElement('Textarea', 'address_one', array(
         'label' => 'Address 1',
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
     $this->addElement('Textarea', 'address_two', array(
         'label' => 'Address 2',
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

     $this->addElement('Text', 'website', array(
         'label' => 'Website',
     ));

     $this->addElement('Text', 'state_corp', array(
         'label' => 'State of Incorporation',
     ));

    $this->addElement('Radio', 'search', array(
      'label' => 'Include in search results?',
      'multiOptions' => array(
        '1' => 'Yes, include in search results.',
        '0' => 'No, hide from search results.',
      ),
      'value' => '1',
    ));

    $this->addElement('Radio', 'auth_invite', array(
      'label' => 'Let members invite others?',
      'multiOptions' => array(
        'member' => 'Yes, members can invite other people.',
        'officer' => 'No, only officers can invite other people.',
      ),
      'value' => 'member',
    ));

    $this->addElement('Radio', 'approval', array(
      'label' => 'Approve members?',
      'description' => ' When people try to join this group, should they be allowed '.
        'to join immediately, or should they be forced to wait for approval?',
      'multiOptions' => array(
        '0' => 'New members can join immediately.',
        '1' => 'New members must be approved.',
      ),
      'value' => '0',
    ));

    // Privacy
    $availableLabels = array(
      'everyone'    => 'Everyone',
      'registered'  => 'Registered Members',
      'member'      => 'All Company Members',
      'officer'     => 'Officers and Owner Only',
      'owner'       => 'Owner Only',
    );


    // View
    $viewOptions = (array) Engine_Api::_()->authorization()->getAdapter('levels')->getAllowed('company', $user, 'auth_view');
    $viewOptions = array_intersect_key($availableLabels, array_flip($viewOptions));

    if( !empty($viewOptions) && count($viewOptions) >= 1 ) {
      // Make a hidden field
      if(count($viewOptions) == 1) {
        $this->addElement('hidden', 'auth_view', array('order' => 101, 'value' => key($viewOptions)));
      // Make select box
      } else {
        $this->addElement('Select', 'auth_view', array(
            'label' => 'View Privacy',
            'description' => 'Who may see this group?',
            'multiOptions' => $viewOptions,
            'value' => key($viewOptions),
          ));
          $this->auth_view->getDecorator('Description')->setOption('placement', 'append');
      }
    }

    // Comment
    $commentOptions = (array) Engine_Api::_()->authorization()->getAdapter('levels')->getAllowed('company', $user, 'auth_comment');
    $commentOptions = array_intersect_key($availableLabels, array_flip($commentOptions));

    if( !empty($commentOptions) && count($commentOptions) >= 1 ) {
      // Make a hidden field
      if(count($commentOptions) == 1) {
        $this->addElement('hidden', 'auth_comment', array('order' => 102, 'value' => key($commentOptions)));
      // Make select box
      } else {
        $this->addElement('Select', 'auth_comment', array(
            'label' => 'Comment Privacy',
            'description' => 'Who may post on this group\'s wall?',
            'multiOptions' => $commentOptions,
            'value' => key($commentOptions),
        ));
        $this->auth_comment->getDecorator('Description')->setOption('placement', 'append');
      }
    }

    // Photo
    $photoOptions = (array) Engine_Api::_()->authorization()->getAdapter('levels')->getAllowed('company', $user, 'auth_photo');
    $photoOptions = array_intersect_key($availableLabels, array_flip($photoOptions));

    if( !empty($photoOptions) && count($photoOptions) >= 1 ) {
      // Make a hidden field
      if(count($photoOptions) == 1) {
        $this->addElement('hidden', 'auth_photo', array('order' => 103, 'value' => key($photoOptions)));
      // Make select box
      } else {
        $this->addElement('Select', 'auth_photo', array(
            'label' => 'Photo Uploads',
            'description' => 'Who may upload photos to this group?',
            'multiOptions' => $photoOptions,
            'value' => key($photoOptions),
        ));
        $this->auth_photo->getDecorator('Description')->setOption('placement', 'append');
      }
    }

    // Event
    $eventOptions = (array) Engine_Api::_()->authorization()->getAdapter('levels')->getAllowed('company', $user, 'auth_event');
    $eventOptions = array_intersect_key($availableLabels, array_flip($eventOptions));

    if( !empty($eventOptions) && count($eventOptions) >= 1 ) {
      // Make a hidden field
      if(count($eventOptions) == 1) {
        $this->addElement('hidden', 'auth_event', array('order' => 104, 'value' => key($eventOptions)));
      // Make select box
      } else {
        $this->addElement('Select', 'auth_event', array(
            'label' => 'Event Creation',
            'description' => 'Who may create events for this group?',
            'multiOptions' => $eventOptions,
            'value' => key($eventOptions),
        ));
        $this->auth_event->getDecorator('Description')->setOption('placement', 'append');
      }
    }


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