<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="{$lang->items['LANG_GLOBAL_LANGCODE']}-{$lang->items['LANG_GLOBAL_LANGCODE']}" lang="{$lang->items['LANG_GLOBAL_LANGCODE']}-{$lang->items['LANG_GLOBAL_LANGCODE']}" dir="ltr" >
<head>
 <base href="$url2board/" />
 <title>$master_board_name | {$lang->items['LANG_CONTACT_CONTACT']}</title>
 $headinclude
 <script type="text/javascript" src="components/include/jquery.min.js"></script>
 <script type="text/javascript" src="components/include/jquery.validate.min.js"></script>
 <link href="components/com_contactmailer/contactmailer.css" rel="stylesheet" type="text/css" media="all" />
</head>
<body>
$header
<table cellpadding="{$style['tableincellpadding']}" cellspacing="{$style['tableincellspacing']}" style="border: {$style['tableinborder']}; width:{$style['tableinwidth']}" class="tableinborder">
 <tr>
  <td class="tablea"><table class="inner smallfont">
   <tr>
    <td class="left"><a href="index.php{$SID_ARG_1ST}">$master_board_name</a> &raquo; {$lang->items['LANG_CONTACT_CONTACT']}</td>
    <td class="right">$usercbar</td>
   </tr>
  </table></td>
 </tr>
</table><br />
<div class="smallfont require">{$lang->items['LANG_CONTACT_FIELD']}</div>
<form action="contact.php" method="post" id="contact_form">
 <input type="hidden" name="addinfo" value="$randomNumTotal" />
 <table cellpadding="{$style['tableincellpadding']}" cellspacing="{$style['tableincellspacing']}" border="{$style['tableinborder']}" class="tableinborder content">
  <tr>
   <td class="tabletitle" colspan="3">
    <table class="inner normalfont">
     <tr class="tabletitle_fc">
      <td><b>{$lang->items['LANG_CONTACT_CONTACTFORM']}</b></td>
     </tr>
    </table>
   </td>
  </tr>
  $contact_preview
  $contact_error
  $contact_send
  <tr>
   <th class="tablecat normalfont" colspan="3">{$lang->items['LANG_CONTACT_INSERT']}</th>
  </tr>
  <tr id="genders">
   <th class="tablea smallfont">{$lang->items['LANG_CONTACT_FORM']}:*</th> 
   <td class="tablea smallfont$colem">
    <label for="anrede">{$lang->items['LANG_CONTACT_MALE']}</label>
    <input type="radio" name="anrede" value="Herr" id="men" class="required" $checkbox[0] />
    <label for="anrede">{$lang->items['LANG_CONTACT_FEMALE']}</label>
    <input type="radio" name="anrede" value="Frau" id="women" $checkbox[1] />
   </td> 
   <td class="tableb icons" rowspan="3"><img src="components/com_contactmailer/images/contact_personal.png" alt="{$lang->items['LANG_CONTACT_NAME']}" title="{$lang->items['LANG_CONTACT_NAME']}" /></td>
  </tr> 
  <tr id="name"> 
   <th class="tableb smallfont"><label for="namen">{$lang->items['LANG_CONTACT_NAME']}:&#42;</label></th>
   <td class="tableb smallfont"><input type="text" class="input required" id="namen" name="name" value="$name" size="48" maxlength="40" /></td> 
  </tr>
  <tr id="vorname"> 
   <th class="tablea smallfont"><label for="vname">{$lang->items['LANG_CONTACT_VNAME']}:&#42;</label></th> 
   <td class="tablea smallfont"><input type="text" class="input required" id="vname" name="vorname" value="$vorname" size="48" maxlength="40" /></td> 
  </tr>
  <tr id="email"> 
   <th class="tableb smallfont"><label for="n_email">{$lang->items['LANG_CONTACT_EMAIL']}:&#42;</label></th> 
   <td class="tableb smallfont"><input type="email" id="n_email" class="input required email" name="email" value="$email" size="48" maxlength="50" /></td>
   <td class="tableb icons"><img src="components/com_contactmailer/images/contact_email.png" alt="{$lang->items['LANG_CONTACT_EMAIL']}" title="{$lang->items['LANG_CONTACT_EMAIL']}" /></td> 
  </tr>
  <if($conset[1]==1)><then>
   <tr>
    <th class="tablea smallfont"><label for="street">{$lang->items['LANG_CONTACT_STREET']}:</label></th>
    <td class="tablea"><input type="text" class"input" id="street" name="street" value="$street" size="38" maxlength="50" />  / <input type="text" class="input" name="streetn" value="$streetn" size="2" maxlength="3" /></td>
    <td class="tableb icons" rowspan="2"><img src="components/com_contactmailer/images/contact_home.png" alt="{$lang->items['LANG_CONTACT_HOME']}" title="{$lang->items['LANG_CONTACT_HOME']}" /></td>
   </tr>
   <tr>
    <th class="tableb smallfont"><label for="plz">{$lang->items['LANG_CONTACT_HOME']}:</label></th>
    <td class="tableb"><input type="text" class="input" id="plz" name="plz" value="$plz" size="5" maxlength="5" />  / <input type="text" class="input" name="ort" value="$ort" size="35" maxlength="30" /></td>
   </tr>
  </then></if>
  <if($conset[2]==1)><then>
   <tr> 
    <th class="tablea smallfont"><label for="phone">{$lang->items['LANG_CONTACT_PHONE']}:</label></th>
    <td class="tablea"><input type="text" class="input" id="phone" name="phone" value="$phone" size="48" maxlength="50" /></td> 
    <td class="tablea icons"><img src="components/com_contactmailer/images/contact_phone.png" alt="{$lang->items['LANG_CONTACT_PHONE']}" title="{$lang->items['LANG_CONTACT_PHONE']}" /></td>
   </tr>
  </then></if>
  <if($conset[3]==1)><then>
   <tr> 
    <th class="tableb smallfont"><label for="fax">{$lang->items['LANG_CONTACT_FAX']}:</label></th>
    <td class="tableb"><input type="text" class="input" id="fax" name="fax" value="$fax" size="48" maxlength="50" /></td>
    <td class="tableb icons"><img src="components/com_contactmailer/images/contact_fax.png" alt="{$lang->items['LANG_CONTACT_FAX']}" title="{$lang->items['LANG_CONTACT_FAX']}" /></td>
   </tr>
  </then></if>
  <tr id="betreff"> 
   <th class="tablea smallfont"><label for="n_betreff">{$lang->items['LANG_CONTACT_SUBJECT']}:&#42;</label></th>
   <td colspan="2" class="tablea smallfont"><input type="text" id="n_betreff" class="input required" name="betreff" value="$betreff" size="48" maxlength="50" /></td> 
  </tr>
  <tr id="texts">
   <th class="tableb smallfont"><label for="text">{$lang->items['LANG_CONTACT_MESSAGE']}:&#42;</label></th>
   <td colspan="2" class="tableb smallfont"><textarea name="text" id="text" cols="49" rows="12" class="input required minlength">$text</textarea><br /><span id="counter">0</span>/1000 {$lang->items['LANG_CONTACT_MESSAGE_COUNTER']}</td>
  </tr>
  <tr> 
   <th class="tablea smallfont"><label for="private_key">{$lang->items['LANG_CONTACT_SECURECODE']}:&#42;</label><br />
   {$lang->items['LANG_CONTACT_SECURECODE_DESC']}</th>
   <td colspan="2" class="tablea smallfont"><input type="text" name="captchaImage" size="6" value="$randomNum + $randomNum2" disabled="disabled" class="input" />
   <input type="text" name="private_key" id="private_key" size="5" maxlength="5" value="" class="input required digits" /></td> 
  </tr> 
  <tr> 
   <td class="tablea" style="text-align: center" colspan="3">
    <input type="submit" accesskey="s" class="input" name="send" value="{$lang->items['LANG_CONTACT_SEND']}" />
    <input type="submit" accesskey="p" class="input" name="preview" value="{$lang->items['LANG_CONTACT_PREVIEW']}" />
    <input type="reset" accesskey="r" class="input" name="zurücksetzen" value="{$lang->items['LANG_CONTACT_RESET']}" />
   </td>
  </tr> 
 </table>
</form>
<p class="space"></p>
<div class="copyright smallfont">{$lang->items['LANG_CONTACT_COPY']}</div>
$footer
 <script type='text/javascript'>
  $(document).ready(function(){
   $("#contact_form").validate({
	errorClass: "warning",
	rules: {
		text: {
		  required: true,
		  rangelength: [10, 1000]
		}
  }
   });
   $('#text').keyup(function() {
     var charLength = $(this).val().length;
     $('#counter').html(charLength);
   });
  });
 </script>  
</body>
</html>