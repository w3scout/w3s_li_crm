<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * PHP version 5
 * @copyright  Artified 2011
 * @author     Paul Kegel <info@artified.nl>
 * @license    MIT (see /LICENSE.txt for further information)
 */

/**
 * Fields
 */
$GLOBALS['TL_LANG']['tl_li_contact']['title']         = array('Titel', 'Voer een titel in.');
$GLOBALS['TL_LANG']['tl_li_contact']['category']      = array('Categorie', 'Selecteer een categorie.');
$GLOBALS['TL_LANG']['tl_li_contact']['startDate']     = array('Start datum', 'Voer de startdatum in volgens de ingestelde tijdsaanduiding');
$GLOBALS['TL_LANG']['tl_li_contact']['startTime']     = array('Start tijd', 'Voer de starttijd in volgens de ingestelde tijdsaanduiding.');
$GLOBALS['TL_LANG']['tl_li_contact']['addEnd']        = array('Einde toevoegen', 'Voer een eind datum en tijd in voor dit contact.');
$GLOBALS['TL_LANG']['tl_li_contact']['endDate']       = array('Eind datum', 'Laat leeg wanneer het slechts een dag betreft');
$GLOBALS['TL_LANG']['tl_li_contact']['endTime']       = array('Eind tijd', 'Gebruik hetzelfde tijstip voor start en eind om een open eind evenement te creeren.');
$GLOBALS['TL_LANG']['tl_li_contact']['result']        = array('Resultaat', 'Selecteer het resultaat');
$GLOBALS['TL_LANG']['tl_li_contact']['direction']     = array('Richting', 'Selecteer een richting');
$GLOBALS['TL_LANG']['tl_li_contact']['note']          = array('Notitie', 'Voer een notitie in.');
$GLOBALS['TL_LANG']['tl_li_contact']['addAttachment'] = array('Bijlage toevoegen', 'Voeg een bijlage toe aan dit contact');
$GLOBALS['TL_LANG']['tl_li_contact']['attachment']    = array('Bijlage', 'Selecteer een bijlage.');

/**
 * Legends
 */
$GLOBALS['TL_LANG']['tl_li_contact']['contact_legend']    = 'Contactmoment';
$GLOBALS['TL_LANG']['tl_li_contact']['date_legend']       = 'Datum en tijd';
$GLOBALS['TL_LANG']['tl_li_contact']['note_legend']       = 'Notitie';
$GLOBALS['TL_LANG']['tl_li_contact']['attachment_legend'] = 'Bijlage';

/**
 * References
 */
$GLOBALS['TL_LANG']['tl_li_contact']['categorys']['phone']     = 'Telefoon';
$GLOBALS['TL_LANG']['tl_li_contact']['categorys']['email']     = 'E-mail';
$GLOBALS['TL_LANG']['tl_li_contact']['categorys']['mail']      = 'Post';
$GLOBALS['TL_LANG']['tl_li_contact']['categorys']['fax']       = 'Fax';
$GLOBALS['TL_LANG']['tl_li_contact']['categorys']['direct']    = 'Bezoek';
$GLOBALS['TL_LANG']['tl_li_contact']['results']['reached']     = 'Behaald';
$GLOBALS['TL_LANG']['tl_li_contact']['results']['not_reached'] = 'Niet behaald';
$GLOBALS['TL_LANG']['tl_li_contact']['directions']['incoming'] = 'Inkomende';
$GLOBALS['TL_LANG']['tl_li_contact']['directions']['outgoing'] = 'Uitgaande';

/**
 * Buttons
 */
$GLOBALS['TL_LANG']['tl_li_contact']['new']    = array('Nieuw contactmoment', 'Maak een nieuw contact');
$GLOBALS['TL_LANG']['tl_li_contact']['edit']   = array('Contactmoment bewerken', 'Wijzig contact ID %s');
$GLOBALS['TL_LANG']['tl_li_contact']['copy']   = array('Contactmoment kopieren', 'Dupliceer contact ID %s');
$GLOBALS['TL_LANG']['tl_li_contact']['delete'] = array('Contactmoment verwijderen', 'Verwijder contact ID %s');
$GLOBALS['TL_LANG']['tl_li_contact']['show']   = array('Contactmoment details', 'Toon details van contact ID %s');

?>