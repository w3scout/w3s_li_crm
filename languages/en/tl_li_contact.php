<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * PHP version 5
 * @copyright  Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author     Christian Kolb <info@liplex.de>
 * @license    MIT (see /LICENSE.txt for further information)
 */

/**
 * Fields
 */
$GLOBALS['TL_LANG']['tl_li_contact']['title']         = array('Title', 'Please enter the title.');
$GLOBALS['TL_LANG']['tl_li_contact']['category']      = array('Category', 'Please choose the category.');
$GLOBALS['TL_LANG']['tl_li_contact']['startDate']     = array('Start date', 'Please enter the start date according to the global date format.');
$GLOBALS['TL_LANG']['tl_li_contact']['startTime']     = array('Start time', 'Please enter the start time according to the global time format.');
$GLOBALS['TL_LANG']['tl_li_contact']['addEnd']        = array('Add end', 'Add an end date and end time to the contact.');
$GLOBALS['TL_LANG']['tl_li_contact']['endDate']       = array('End date', 'Leave blank to create a single day event.');
$GLOBALS['TL_LANG']['tl_li_contact']['endTime']       = array('End time', 'Use the same value for start and end time to create an open-ended event.');
$GLOBALS['TL_LANG']['tl_li_contact']['result']        = array('Result', 'Please choose a result.');
$GLOBALS['TL_LANG']['tl_li_contact']['direction']     = array('Direction', 'Please choose a direction.');
$GLOBALS['TL_LANG']['tl_li_contact']['note']          = array('Note', 'Please enter a note.');
$GLOBALS['TL_LANG']['tl_li_contact']['addAttachment'] = array('Add attachment', 'Add an attachment to the contact.');
$GLOBALS['TL_LANG']['tl_li_contact']['attachment']    = array('Attachment', 'Please choose an attachment.');

/**
 * Legends
 */
$GLOBALS['TL_LANG']['tl_li_contact']['contact_legend']    = 'Contact';
$GLOBALS['TL_LANG']['tl_li_contact']['date_legend']       = 'Date and time';
$GLOBALS['TL_LANG']['tl_li_contact']['note_legend']       = 'Note';
$GLOBALS['TL_LANG']['tl_li_contact']['attachment_legend'] = 'Attachment';

/**
 * References
 */
$GLOBALS['TL_LANG']['tl_li_contact']['categorys']['phone']     = 'Phone';
$GLOBALS['TL_LANG']['tl_li_contact']['categorys']['email']     = 'Email';
$GLOBALS['TL_LANG']['tl_li_contact']['categorys']['mail']      = 'Mail';
$GLOBALS['TL_LANG']['tl_li_contact']['categorys']['fax']       = 'Fax';
$GLOBALS['TL_LANG']['tl_li_contact']['categorys']['direct']    = 'Visit';
$GLOBALS['TL_LANG']['tl_li_contact']['results']['reached']     = 'Reached';
$GLOBALS['TL_LANG']['tl_li_contact']['results']['not_reached'] = 'Not reached';
$GLOBALS['TL_LANG']['tl_li_contact']['directions']['incoming'] = 'Incoming';
$GLOBALS['TL_LANG']['tl_li_contact']['directions']['outgoing'] = 'Outgoing';

/**
 * Buttons
 */
$GLOBALS['TL_LANG']['tl_li_contact']['new']    = array('New contact', 'Create new contact');
$GLOBALS['TL_LANG']['tl_li_contact']['edit']   = array('Edit contact', 'Edit contact with the ID %s');
$GLOBALS['TL_LANG']['tl_li_contact']['copy']   = array('Copy contact', 'Copy contact with the ID %s');
$GLOBALS['TL_LANG']['tl_li_contact']['delete'] = array('Delete contact', 'Delete contact with the ID %s');
$GLOBALS['TL_LANG']['tl_li_contact']['show']   = array('Contact details', 'Show details of the contact with the ID %s');

?>