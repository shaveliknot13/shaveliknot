<?php
/**
 * @package     Joomla.Plugin
 * @subpackage  Fields.Avatar
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JLoader::import('components.com_fields.libraries.fieldsplugin', JPATH_ADMINISTRATOR);
JLoader::import('components.com_shoppingoverview.helpers.shoppingoverview', JPATH_SITE);

$doc = & JFactory::getDocument();
$langYaz = JFactory::getLanguage();
$lang =  shoppingoverviewSiteHelper::getPerfixLang($doc->getlanguage());
$langYaz->load('com_shoppingoverview');

JText::script('COM_SHOPPINGOVERVIEW_EDIT_FILD_24');
JText::script('COM_SHOPPINGOVERVIEW_TEXT_41');
JText::script('COM_SHOPPINGOVERVIEW_TEXT_42');
JText::script('COM_SHOPPINGOVERVIEW_LOADING');

//var_dump(JText::script('COM_SHOPPINGOVERVIEW_EDIT_FILD_42'));

$baseUrl = JUri::base();
JHtml::_('jquery.framework');
$doc
    ->addScript( $baseUrl . 'plugins/fields/avatar/assets/js/jquery.imgareaselect.pack.js' )
    ->addScript( $baseUrl . 'plugins/fields/avatar/assets/js/pluginsFieldsAvatar.js' )
    ->addStyleSheet( $baseUrl . 'plugins/fields/avatar/assets/css/pluginsFieldsAvatar.css' )
    ->addStyleSheet( $baseUrl . 'plugins/fields/avatar/assets/css/imgareaselect-default.css' )
;



/**
 * Fields Avatar Plugin
 *
 * @since  3.7.0
 */
class PlgFieldsAvatar extends FieldsPlugin
{
	/**
	 * Transforms the field into a DOM XML element and appends it as a child on the given parent.
	 *
	 * @param   stdClass    $field   The field.
	 * @param   DOMElement  $parent  The field node parent.
	 * @param   JForm       $form    The form.
	 *
	 * @return  DOMElement
	 *
	 * @since   3.7.0
	 */
	public function onCustomFieldsPrepareDom($field, DOMElement $parent, JForm $form)
	{

		$fieldNode = parent::onCustomFieldsPrepareDom($field, $parent, $form);

		if (!$fieldNode)
		{
			return $fieldNode;
		}

		$fieldNode->setAttribute('validate', 'url');

		if (! $fieldNode->getAttribute('relative'))
		{
			$fieldNode->removeAttribute('relative');

        }

		return $fieldNode;
	}

    public function onContentAfterSave($context, $item, $isNew, $data = array())
    {
        // Check if data is an array and the item has an id
        if (!is_array($data) || empty($item->id))
        {
            return true;
        }

        // Create correct context for category
        if ($context == 'com_categories.category')
        {
            $context = $item->extension . '.categories';

            // Set the catid on the category to get only the fields which belong to this category
            $item->catid = $item->id;
        }

        // Check the context
        $parts = FieldsHelper::extract($context, $item);

        if (!$parts)
        {
            return true;
        }

        // Compile the right context for the fields
        $context = $parts[0] . '.' . $parts[1];

        // Loading the fields
        $fields = FieldsHelper::getFields($context, $item);

        if (!$fields)
        {
            return true;
        }

        // Get the fields data
        $fieldsData = !empty($data['com_fields']) ? $data['com_fields'] : array();

        // Loading the model
        $model = JModelLegacy::getInstance('Field', 'FieldsModel', array('ignore_request' => true));

        // Loop over the fields
        foreach ($fields as $field)
        {
            // Determine the value if it is available from the data
            $value = key_exists($field->name, $fieldsData) ? $fieldsData[$field->name] : null;

            // Setting the value for the field and the item
            $model->setFieldValue($field->id, $item->id, $value);
        }

        return true;
    }


    public function onUserAfterSave($userData, $isNew, $success, $msg)
    {
        // It is not possible to manipulate the user during save events
        // Check if data is valid or we are in a recursion
        if (!$userData['id'] || !$success)
        {
            return true;
        }

        $user = JFactory::getUser($userData['id']);

        $task = JFactory::getApplication()->input->getCmd('task');

        // Skip fields save when we activate a user, because we will lose the saved data
        if (in_array($task, array('activate', 'block', 'unblock')))
        {
            return true;
        }

        $userData['com_fields']['avatar'] = $this->crops($userData['com_fields']['avatar']);

        // Trigger the events with a real user
        $this->onContentAfterSave('com_users.user', $user, false, $userData);

        $app = JFactory::getApplication();
        $app->enqueueMessage(JText::_('COM_SHOPPINGOVERVIEW_SAVED'));
        $app->redirect('/component/users/profile?layout=edit');

        return true;
    }

    public function crops($img){

        $big_img = JPATH_SITE . $img;

        if (!file_exists($big_img)) {

            return 'no-avatar.png';

        }

        $image = new JImage( $big_img );

        $getimagesize = getimagesize($big_img);

        if('image/jpeg' == $getimagesize['mime']){
            $type = '.jpg';
        }elseif('image/png' == $getimagesize['mime']){
            $type = '.png';
        }else{
            $type = '.jpg';
        }

        $unic = base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);
        $filename = $unic.$type;

        if(file_exists($unic.$type)){
            $filename = $unic.$filename;
        }

        $big_img = JPATH_SITE . '/images/avatar/' . $filename;
        $img = '/images/avatar/' . $filename;


        $image->cropResize( 200, 200, false );
        $image->toFile( $big_img );

        return $img;
    }

}
