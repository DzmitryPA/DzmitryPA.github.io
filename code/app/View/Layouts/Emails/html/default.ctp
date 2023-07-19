<table width="710" align="center" style="table-layout:fixed; font-family:Arial, Helvetica, sans-serif; border:1px solid #537286; box-shadow: 0 0 5px #537286; padding:10px 15px;">
    <tbody><tr>
            <td valign="top" style=" background-color: #EFEFEF;">
                <table width="100%">
                    <tbody><tr>
                            <td>
                                <a href="<?php echo HTTP_PATH; ?>">
                                    <img alt="<?php echo SITE_TITLE; ?>" src="<?php echo HTTP_PATH; ?>/app/webroot/img/email_logo.png"/>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        <tr>
            <td valign="top">
                <table width="100%">
                    <tbody>
                        <?php
                        echo $content_for_layout;
                        ?>
                        <tr>
                            <td style="color:#434343; font-size:13px; line-height:18px;">
                                <p style="color:#434343; margin:10px 0 0;">If you need any assistance, please e-mail us at <a style="color:#000; text-decoration: underline;" href="mailto:<?php echo MAIL_FROM;?>"><?php echo MAIL_FROM;?></a>.</p>

                                <p style="color:#000000;font:bold 15px Arial, Helvetica, sans-serif; margin:10px 0 0;"> The <?php echo SITE_TITLE;?> Team</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>


        <tr>
            <td>
                <table width="100%" style="border-top:1px solid #ddd;">
                    <tbody><tr>
                            <td style="font-size:11px; line-height:18px;">
                                <p style="margin:10px 0 0;">*Note: Any automatically generated mails from <?php echo SITE_TITLE; ?> may include one-click link which you can go right into the site without having to log in. Please do not forward this mail to anyone as you do not want anyone else to abuse your account!</p>
                            </td>
                        </tr>
                    </tbody></table>
                <!-- End Footer Notifications -->
            </td>
        </tr>
        <tr>
            <td valign="top">
                <!-- Begin Footer -->
                <table width="100%" style="border-top:1px solid #ddd; background-color:#EFEFEF; color: #0B0B0B;">
                    <tbody><tr>
                            <td style="font-size:12px;">
                                <p style="color:#000; width:100%;">&nbsp;Copyright &copy; <?php echo date('Y'); ?> <?php echo SITE_TITLE; ?> All Rights Reserved.</p>
                    <?php /*<p style="color:#000000;margin:10px 0 10px;">&nbsp;<?php echo $this->Html->link('Terms & Conditions', HTTP_PATH.'/terms-and-condition',array('style'=>'color:#000000;'));?>&nbsp; | &nbsp;<?php echo $this->Html->link('Privacy Policy', HTTP_PATH.'/privacy-policy',array('style'=>'color:#000000;'));?>&nbsp; </p> */?>
                            </td>
                            <td align="right">
                                <a href="<?php echo HTTP_PATH; ?>"><img alt="<?php echo SITE_TITLE; ?>" src="<?php echo HTTP_PATH; ?>/app/webroot/img/email_logo_footer.png"/></a>
                                &nbsp;&nbsp;
                            </td>
                        </tr>
                    </tbody></table>
                <!-- End Footer -->
            </td>
        </tr>
    </tbody></table>
<?php //exit;   ?>