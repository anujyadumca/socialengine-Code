<?php
/**
 * iPragmatech Solution Pvt. Ltd.
 *
 * @category   Application_User Importer
 * @package    User Importer
 * @copyright  Copyright 2008-2013 iPragmatech Solution Pvt. Ltd.
 * @license   � 2013 iPragmatech. All Rights Reserved.
 * @version    $Id: Global.php 9747 2013-07-06 02:08:08Z iPrgamtech $
 * @author     iPragmatech
 */

class Company_Form_Admin_Import extends Engine_Form
{
    public function init()
    {
        //$this
        //  ->setDescription('This plugin created the users in socialengine from the CSV file which is uploaded by admin.For CSV example you can see screen below or <a href="">click here</a>')
        //;

        /*  //select profile Type
         $this->addElement('Select', 'profile', array(
         'label'=>'Profile Type',
         'required' => true,
         'multiOptions' => array(
         '0' => ''

         )
         )); */

        // Init level
        // Populate with categories
        /*
         $categories = Engine_Api::_()->getDbtable('categories', 'group')->getCategoriesAssoc();
         asort($categories, SORT_LOCALE_STRING);
         $categoryOptions = array('0' => 'select');
         $this->addElement('Select', 'cat_id', array(
         'label' => 'Categories',
         'required' => true,
         'multiOptions' => $categories
         )); */

        /*   //select verified or not
         $this->addElement('Select', 'verify', array(
         'label'=>'Verified / Not Verified',
         'required' => true,
         'multiOptions' => array(
         '1' => 'Verified',
         '0' => 'Not Verified',

         )
         )); */
        //select approved or not
        /*  $this->addElement('Select', 'approve', array(
         'label'=>'Approved / Not Approved Members',
         'required' => true,
         'multiOptions' => array(
         '1' => 'Approved',
         '0' => 'Not Approved',
         )
         )); */

        //upload File
        $this->addElement('file', 'csv_file', array(
            'label' => 'Upload csv file',
            'required' => true,
            'destination' => APPLICATION_PATH.'/public/temporary/',
            'multiFile' => 1,
            'validators' => array(
                array('Extension', false, 'csv'),
            ),
        ));
        /*  $this->addElement('Radio', 'notify_email', array(
         'label' => 'Send Welcome Email',
         'multiOptions' => array(
         1 => 'Yes',
         0 => 'No',
         ),
         'value' => 1,
         )); */
        // Add submit button
        $this->addElement('Button', 'submit', array(
            'label' => 'Import',
            'type' => 'submit',
            'ignore' => true,
        ));

        //email queue setting
        /*  $settings = Engine_Api::_()->getApi('settings', 'core')->core_mail;

        if( !@$settings['queueing'] ) {
        $this->addElement('Radio', 'queueing', array(
        'label' => 'Utilize Mail Queue',
        'description' => 'Mail queueing permits the emails to be sent out over time, preventing your mail server
        from being overloaded by outgoing emails.  It is recommended you utilize mail queueing for large email
        blasts to help prevent negative performance impacts on your site.',
        'multiOptions' => array(
        1 => 'Utilize Mail Queue (recommended)',
        0 => 'Send all emails immediately (only recommended for less than 100 recipients).',
        ),
        'value' => 1,
        ));
        } */
    }
}