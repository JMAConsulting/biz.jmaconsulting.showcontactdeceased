<?php

require_once 'showcontactdeceased.civix.php';

/**
 * Implementation of hook_civicrm_config
 */
function showcontactdeceased_civicrm_config(&$config) {
  _showcontactdeceased_civix_civicrm_config($config);
}

/**
 * Implementation of hook_civicrm_xmlMenu
 *
 * @param $files array(string)
 */
function showcontactdeceased_civicrm_xmlMenu(&$files) {
  _showcontactdeceased_civix_civicrm_xmlMenu($files);
}

/**
 * Implementation of hook_civicrm_install
 */
function showcontactdeceased_civicrm_install() {
  return _showcontactdeceased_civix_civicrm_install();
}

/**
 * Implementation of hook_civicrm_uninstall
 */
function showcontactdeceased_civicrm_uninstall() {
  return _showcontactdeceased_civix_civicrm_uninstall();
}

/**
 * Implementation of hook_civicrm_enable
 */
function showcontactdeceased_civicrm_enable() {
  return _showcontactdeceased_civix_civicrm_enable();
}

/**
 * Implementation of hook_civicrm_disable
 */
function showcontactdeceased_civicrm_disable() {
  return _showcontactdeceased_civix_civicrm_disable();
}

/**
 * Implementation of hook_civicrm_upgrade
 *
 * @param $op string, the type of operation being performed; 'check' or 'enqueue'
 * @param $queue CRM_Queue_Queue, (for 'enqueue') the modifiable list of pending up upgrade tasks
 *
 * @return mixed  based on op. for 'check', returns array(boolean) (TRUE if upgrades are pending)
 *                for 'enqueue', returns void
 */
function showcontactdeceased_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _showcontactdeceased_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implementation of hook_civicrm_managed
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 */
function showcontactdeceased_civicrm_managed(&$entities) {
  return _showcontactdeceased_civix_civicrm_managed($entities);
}

/**
 * Implementation of hook_civicrm_pageRun
 *
 * Add 'deceased' to the name at the top of the contact summary page 
 * for all contacts with Deceased set true
 * 
 */
function showcontactdeceased_civicrm_pageRun(&$page) {
  if (in_array($page->getVar('_name'), array('CRM_Contact_Page_View_Summary', 'CRM_Contact_Page_Inline_ContactName'))) {
    $isDeceased = $page->get_template_vars('is_deceased');
    if (!$isDeceased && $page->getVar('_name') == 'CRM_Contact_Page_Inline_ContactName') {
      $contactId = $page->get_template_vars('contactId');
      $isDeceased = CRM_Core_DAO::getFieldValue('CRM_Contact_DAO_Contact', $contactId, 'is_deceased');
    }
    if ($isDeceased) {
      $title = $page->get_template_vars('title');
      $title .= ' <span class= "font-red">(deceased)</span>';
      $page->assign('title', $title);
    }
  }
}

/**
 * Implementation of hook_civicrm_buildForm
 *
 * Add 'deceased' to the name at the top of the contact edit form
 * for all contacts with Deceased set true
 * 
 */
function showcontactdeceased_civicrm_buildForm($formName, &$form) {
  if ($formName == 'CRM_Contact_Form_Contact' && $form->getVar('_action') == CRM_Core_Action::UPDATE) {
    $deceased = CRM_Utils_Array::value('is_deceased', $form->_values);
    if ($deceased) {
      CRM_Utils_System::setTitle(CRM_Utils_Array::value('display_name', $form->_values) . ' <span style= "color:red">(deceased)</span>');
    }
  }
}