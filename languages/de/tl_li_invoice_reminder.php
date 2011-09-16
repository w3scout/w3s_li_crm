<?php
if (!defined('TL_ROOT'))
    die('You cannot access this file directly!');

/**
 * @copyright   Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author      Christian Kolb <info@liplex.de>
 * @author      ApoY2k <apoy2k@gmail.com>
 * @license     MIT (see /LICENSE.txt for further information)
 */
$GLOBALS['TL_LANG']['tl_li_invoice_reminder'] = array(
    'toCustomer'        => array('Kunde', 'Bitte wählen Sie einen Kunden aus.'),
    'toInvoice'         => array('Rechnung', 'Bitte wählen Sie die Rechnung aus.'),
    'remindOnce'        => array('Einmalig erinnern', 'Soll einmalig eine Erinnerung verschickt werden?'),
    'remindDate'        => array('Erinnerungsdatum', 'Bitte geben Sie das Datum, an dem die Erinnerung verschickt werden soll, ein.'),
    'remindRepeatedly'  => array('Wiederholt erinnern', 'Soll die Erinnerung im Intervall verschickt werden?'),
    'remindInterval'    => array('Intervall', 'Bitte wählen Sie den Intervall aus.'),
    
    'reminder_legend'   => 'Erinnerung',
    'once_legend'       => 'Einmalig',
    'repeatedly_legend' => 'Wiederholt',
    
    'noCustomer'    => 'Kein Kunde',
    
    'remindInterval' => array(
        'daily'     => 'Täglich',
        'weekly'    => 'Wöchentlich',
        'monthly'   => 'Monatlich',
        'yearly'    => 'Jährlich',
    ),
    
    'subject'           => 'Rechnungserinnerung',
    'text'              => 'Rechnungserinnerung für die Rechnung "%s" vom %s.',
    'customerRemark'    => 'Die Rechnung gehört zu dem Kunden "%s %s".',
    
    'new'       => array('Neue Erinnerung', 'Neue Erinnerung erstellen'),
    'edit'      => array('Erinnerung editieren', 'Die Erinnerung mit der ID %s editieren'),
    'copy'      => array('Erinnerung kopieren', 'Die Erinnerung mit der ID %s kopieren'),
    'delete'    => array('Erinnerung löschen', 'Die Erinnerung mit der ID %s löschen'),
    'show'      => array('Erinnerungdetails anzeigen', 'Die Details der Erinnerung mit der ID %s anzeigen'),
);
