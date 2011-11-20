<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>{{invoice_title}}</title>
        <meta http-equiv="Content-Type" content="text/html;charset='utf-8'" />
        <link rel="stylesheet" type="text/css" href="system/modules/li_crm/css/invoice_default.css" />
    </head>
    <body>
        <table class="invoice_head">
            <tbody>
                <tr>
                    <td class="logo">
                        <img src="<?php echo $template['logo']; ?>" alt="Logo" title="Logo" />
                        <span class="small_address"><?php echo $template['company_name']."<br />".$template['company_street']." ".$template['company_postal']." ".$template['company_city']; ?></span>
                    </td>
                    <td class="own_address">
                        <strong><?php echo $template['company_name']; ?></strong><br />
                        <br />
                        <?php echo $template['company_street']; ?><br />
                        <?php echo $template['company_postal']." ".$template['company_city']; ?><br />
                        <br />
                        <?php echo $template['phone_label'].": ".$template['company_phone']; ?><br />
                        <?php echo $template['company_tax_number_label'].": ".$template['company_tax_number']; ?>
                    </td>
                </tr>
                <tr>
                    <td class="customer_address">
                        <?php echo $template['customer_company']; ?><br />
                        <?php echo $template['customer_firstname']; ?> <?php echo $template['customer_lastname']; ?><br />
                        <?php echo $template['customer_street']; ?><br />
                        <?php echo $template['customer_postal']; ?> <?php echo $template['customer_city']; ?><br />
                    </td>
                    <td class="invoice_data">
                        <table>
                            <tr>
                                <td class="date"><?php echo $template['invoice_date_label']; ?>:</td>
                                <td><?php echo $template['invoice_date']; ?></td>
                            </tr>
                            <tr>
                                <td class="invoice_number"><?php echo $template['invoice_number_label']; ?>:</td>
                                <td><?php echo $template['invoice_number']; ?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
        
        <h1><?php echo $template['invoice_title']; ?></h1>
        <p><?php echo $template['invoice_introduction']; ?></p>
        <?php echo $template['description_before']; ?>
        <table class="positions">
            <thead>
                <tr>
                    <td width="35" class="quantity"><?php echo $template['position_quantity_label']; ?></td>
                    <td width="50" class="unit"><?php echo $template['position_unit_label']; ?></td>
                    <td class="label"><?php echo $template['position_label_label']; ?></td>
                    <td width="60" class="unit_price"><?php echo $template['position_unit_price_label']; ?></td>
                    <td width="60" class="total_price"><?php echo $template['position_total_price_label']; ?></td>
                </tr>
            </thead>
            <tbody>
                <?php echo $template['positions']; ?>
            </tbody>
        </table>
        <?php echo $template['description_after']; ?>
        <p><?php echo $template['performance_date_remark']; ?></p>
        <p><?php echo $template['maturity_remark']; ?></p>
        <table class="account">
            <thead>
                <tr>
                    <td colspan="2"><?php echo $template['account_data_label']; ?></td>
                </tr>
            </thead>
            <tbody>
                <tr class="odd">
                    <td><?php echo $template['account_number_label']; ?></td>
                    <td><?php echo $template['account_number']; ?></td>
                </tr>
                <tr class="even">
                    <td><?php echo $template['bank_code_label']; ?></td>
                    <td><?php echo $template['bank_code']; ?></td>
                </tr>
                <tr class="odd">
                    <td><?php echo $template['bank_label']; ?></td>
                    <td><?php echo $template['bank']; ?></td>
                </tr>
            </tbody>
        </table>
        <p><?php echo $template['greeting']; ?></p>
    </body>
</html>