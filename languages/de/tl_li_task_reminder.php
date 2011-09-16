<?php
if (!defined('TL_ROOT'))
    die('You cannot access this file directly!');

/**
 * @copyright   Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author      Christian Kolb <info@liplex.de>
 * @author      ApoY2k <apoy2k@gmail.com>
 * @license     MIT (see /LICENSE.txt for further information)
 */
$GLOBALS['TL_LANG']['tl_li_task_reminder'] = array(
    'noProject'     => 'Kein Projekt',
    'noCustomer'    => 'Kein Kunde',
    
    'toCustomer'        => array('Kunde', 'Bitte wählen Sie einen Kunden aus.'),
    'toTask'            => array('Aufgabe', 'Bitte wählen Sie die Aufgabe aus.'),
    'remindOnce'        => array('Einmalig erinnern', 'Soll einmalig eine Erinnerung verschickt werden?'),
    'remindDate'        => array('Erinnerungsdatum', 'Bitte geben Sie das Datum, an dem die Erinnerung verschickt werden soll, ein.'),
    'remindRepeatedly'  => array('Wiederholt erinnern', 'Soll die Erinnerung im Intervall bis zur Deadline verschickt werden?'),
    'remindInterval'    => array('Intervall', 'Bitte wählen Sie den Intervall aus.'),
    
    'reminder_legend'   => 'Erinnerung',
    'once_legend'       => 'Einmalig',
    'repeatedly_legend' => 'Wiederholt',
    
    'remindInterval' => array(
        'daily'     => 'Täglich',
        'weekly'    => 'Wöchentlich',
        'monthly'   => 'Monatlich',
        'yearly'    => 'Jährlich',
    ),
    'subject'           => 'Aufgabenerinnerung',
    'text'              => 'Aufgabenerinnerung für die Aufgabe "%s" mit der Deadline %s.',
    'customerRemark'    => 'Die Aufgabe gehört zum Kunden "%s %s".',
    
    'new'       => array('Neue Erinnerung', 'Neue Erinnerung erstellen'),
    'edit'      => array('Erinnerung editieren', 'Die Erinnerung mit der ID %s editieren'),
    'copy'      => array('Erinnerung kopieren', 'Die Erinnerung mit der ID %s kopieren'),
    'delete'    => array('Erinnerung löschen', 'Die Erinnerung mit der ID %s löschen'),
    'show'      => array('Erinnerungdetails anzeigen', 'Die Details der Erinnerung mit der ID %s anzeigen'),
);
