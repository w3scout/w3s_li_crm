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
                    <td width="600" class="logo">
                        {{logo}}
                        <span class="small_address">{{small_address}}</span>
                    </td>
                    <td class="own_address">
                        <strong>{{company_name}}</strong><br>
                        <br>
                        {{company_street}}<br>
                        {{company_postal}} {{company_place}}<br>
                        <br>
                        {{company_phone_label}}: {{company_phone}}<br>
                        {{company_tax_number_label}}: {{company_tax_number}}
                    </td>
                </tr>
                <tr>
                    <td class="customer_address">
                        {{customer_name}}<br />
                        {{customer_firstname}} {{customer_lastname}}<br />
                        {{customer_street}}<br />
                        {{customer_postal}} {{customer_place}}<br />
                    </td>
                    <td class="invoice_data">
                        <table>
                            <tr>
                                <td class="date">{{invoice_date_label}}:</td>
                                <td>{{invoice_date}}</td>
                            </tr>
                            <tr>
                                <td class="invoice_number">{{invoice_number_label}}:</td>
                                <td>{{invoice_number}}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
        <h1>{{invoice_title}}</h1>
        <p>{{invoice_introduction}}</p>
        <table class="positions">
            <thead>
                <tr>
                    <td width="35" class="quantity">{{position_quantity_label}}</td>
                    <td width="50" class="unit">{{position_unit_label}}</td>
                    <td class="label">{{position_label_label}}</td>
                    <td width="60" class="unit_price">{{position_unit_price_label}}</td>
                    <td width="60" class="total_price">{{position_total_price_label}}</td>
                </tr>
            </thead>
            <tbody>
                {{positions}}
            </tbody>
        </table>
        <p>{{service_remark}}</p>
        <p>{{transfer_remark}}</p>
        <table class="account">
            <thead>
                <tr>
                    <td colspan="2">{{account_data_label}}</td>
                </tr>
            </thead>
            <tbody>
                <tr class="odd">
                    <td>{{account_number_label}}</td>
                    <td>{{account_number}}</td>
                </tr>
                <tr class="even">
                    <td>{{bank_code_label}}</td>
                    <td>{{bank_code}}</td>
                </tr>
                <tr class="odd">
                    <td>{{bank_label}}</td>
                    <td>{{bank}}</td>
                </tr>
            </tbody>
        </table>
        <p>{{greeting}}</p>
    </body>
</html>