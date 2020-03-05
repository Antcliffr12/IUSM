<?php
/*
    Template Name: Salesforce
    Email Template: True
*/

global $post;

$title = $post->post_title;
$content = wpautop($post->post_content);

$date = (string)$post->post_date;
$date = strtotime($date);
$date = date('F j, Y', $date);

$image_url = get_the_post_thumbnail_url($post->ID);
$caption = get_post(get_post_thumbnail_id($post->ID))->post_excerpt;

$contactName = get_query_var('contact_name');
$contactOfficePhone = get_query_var('contact_office_phone');
$contactMobilePhone = get_query_var('contact_mobile_phone');
$contactEmail = get_query_var('contact_email');

?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title><?= $title ?></title>
    <meta charset="UTF-8">
</head>
<body>
<span id="" style="font-family:arial,helvetica,sans-serif;font-size:10pt;">
<center>
<table border="1" bordercolor="#666666" cellpadding="10" cellspacing="0" width="600">
<tr>
<td bgcolor="#7D110C" colspan="2" valign="top"><img align="left" height="30" src="http://news.indiana.edu/img/iusm/iu_crimson.jpg" width="171"/></td>
</tr>
<tr>
<td bgcolor="#ECE9D8" valign="top" width="400">
<table border="0" cellpadding="10" cellspacing="0" width="100%">
<tr>
<td valign="top"><img align="left" height="52" src="http://news.indiana.edu/img/iusm/news-email.jpg" width="439"/></td>
</tr>
<tr>
<td valign="top">
<h2>For Immediate Release</h2>
<font face="Arial, Helvetica, sans-serif" size="2"><?= $date ?></font><br/>
<br/>
<h1 class="newsheadline"><?= $title ?></h1>
<font face="Arial, Helvetica, sans-serif" size="2">

<?= $content ?>

</font></td>
</tr>
</table>
</td>
<td bgcolor="#F2F2F2" valign="top" width="200">
<table border="0" cellpadding="10" cellspacing="0" width="100%">
<tr>




<h5>
    <font face="Arial, Helvetica, sans-serif">
        <td bgcolor="#F2F2F2" bordercolor="#999999"><center>
                <table bgcolor="#787364" cellpadding="1">
                    <tr>
                        <td>
                            <table bgcolor="#FFFFFF" cellpadding="4">
                                <tr><td valign="top">
                                        <img alt="<?= $caption ?>" src="<?= $image_url ?>" title="<?= $caption ?>" width="180"/>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </center>
            <font face="Arial, Helvetica, sans-serif" size="1"><?= $caption ?></font>
            <p><font face="Arial, Helvetica, sans-serif" size="2"><a href="<?= $image_url ?>" title="<?= $caption ?>">Download print quality image</a></font></p><br/><hr/></td>
    </font>
</h5>

<font face="Arial, Helvetica, sans-serif" size="2"/><br/>
<br/>
    <!--picture link--><br/>
<br/>
<br/>
    <!-- stayed around here -->
<hr noshade=""/>

</tr>
<tr>
<td bgcolor="#F2F2F2" valign="top"><font face="Arial, Helvetica, sans-serif" size="2"/>
<div class="nr-media-contact-wrap"><font face="Arial, Helvetica, sans-serif" size="2"><font face="Arial, Helvetica, sans-serif" size="2">
            <h3>Media Contact</h3><?= $contactName ?><br/>
            <?php if(!empty($contactOfficePhone)){ ?>
                Office <?= $contactOfficePhone ?><br/>
            <?php } ?>
            <?php if(!empty($contactMobilePhone)){ ?>
                Mobile <?= $contactMobilePhone ?><br/>
            <?php } ?>
            <?php if(!empty($contactEmail)){ ?>
                <a href="mailto:&#10;<?= $contactEmail ?>"><?= $contactEmail ?></a><br/>
            <?php } ?>
            <br/><br/><br/></font><br/></font><br/>
<hr noshade=""/>
</div>
</td>
</tr>
<tr>
<td bgcolor="#F2F2F2" valign="top">
<address style="font-style:normal;"><font face="Arial, Helvetica, sans-serif" size="2"><a href="http://medicine.iu.edu">IU School of Medicine</a>
</font><br/>
<br/>
 <font face="Arial, Helvetica, sans-serif" size="2">Health Information and Translational Sciences Building<br/>
 410 W. 10th Street<br/>
 Indianapolis, IN 46202<br/>
 Phone: (317) 274-7722<br/>
 Fax: (317) 278-8722<br/>
</font><br/>
</address>
<hr noshade=""/>
</td>
</tr>
<tr>
<td bgcolor="#F2F2F2" valign="top"><font face="Arial, Helvetica, sans-serif" size="2"><font face="Arial, Helvetica, sans-serif" size="2"><a href="http://news.medicine.iu.edu/releases/2017/08/regenstrief-developing-testing-real-world-automated-patient-identification.shtml">
            View web version
        </a></font><br/></font><br/>

<hr noshade=""/>
<font face="Arial, Helvetica, sans-serif" size="2"/></td>
</tr>
</table>
</td>
</tr>
<tr bgcolor="#D6D3C1">
<td colspan="2" valign="top">
<table bgcolor="#D6D3C1" border="0" cellpadding="5" cellspacing="0" width="100%">
<tr>
<td valign="top"><font face="Arial, Helvetica, sans-serif" size="2"><strong>About Indiana University School of Medicine</strong> Indiana University School of Medicine is one of the nation's premier medical schools and is a leader and innovator in medical education, research and clinical care. The country's largest medical school, IU School of Medicine educates more than 1,600 medical and graduate degree students on nine campuses in Indiana, and its faculty holds more than $300 million in research grants and contracts, to advance the School's missions and promote life sciences. For more information please visit http://medicine.iu.edu.</font></td>
</tr>
    <!--<table align="center" width="500">-->
<div id="hide-footer">
<tr>
<td align="center" style="padding:14px 0 28px 0; margin:0; font-style:normal; font-family:arial,helvetica,sans-serif;font-size:10pt; font-weight:normal; line-height:22px; color:#8f8f8f;" valign="top" width="500">
	     <address style="font-style:normal; font-family:Arial, Helvetica, sans-serif; font-size:12px; font-weight:normal; line-height:24px;">
        <address style="font-style:normal; font-family:Arial, Helvetica, sans-serif; font-size:12px; font-weight:normal; line-height:24px;">
        <a href="http://news.iu.edu/newsletters/archives/iu-in-the-news/" style="color:#990000;text-decoration:none;">
                               %%Member_Busname%%
                                    <br/>
                                  %%Member_Addr%%
                                    <br/>
                                %%Member_City%%, %%Member_State%% %%Member_PostalCode%%
                                </a>
        </address>
        </address>
</td>
</tr>
<tr>
<td align="center" style="padding:14px 0 28px 0; margin:0; font-style:normal; font-family:arial,helvetica,sans-serif;font-size:10pt; font-weight:normal; line-height:22px; color:#8f8f8f;" valign="top" width="500">
    This e-mail was sent to
                    <span class="footerIULinkColor"><a href="mailto:%%emailaddr%%" style="color:#990000; text-decoration:none;">%%emailaddr%%</a></span> by
                    <a href="mailto:iusm@indiana.edu" style="color:#990000; text-decoration:none;" target="_blank">Indiana University School of Medicine</a>.
                    To update communication preferences, visit the
                    <a alias="Update Profile" href="%%profile_center_url%%" style="color:#990000; text-decoration:none;" target="_blank">Profile Center</a>.
  </td>

</tr>

<tr>
    <td align="center" style="padding:17px 0 0 0;" valign="top"><a href="%%unsub_center_url%%" style="color:#990000; text-decoration:none; font-family:Arial, Helvetica, sans-serif; font-size:12px; font-weight:normal;">Unsubscribe</a></td>
</tr>
    <!--</table>-->
</div>
<custom name="opencounter" type="tracking">
</custom>
</table>

</td>
</tr>

</table>
</center></span>
<br/>
<br/>
</body>
</html>
