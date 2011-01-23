<tr>
 <th class="tablecat normalfont" colspan="3">{$lang->items['LANG_CONTACT_PREVIEW']}</th>
</tr>
<tr>
 <th class="tablea smallfont">$anrede</th>
 <td class="tablea smallfont" colspan="2">$nv </td>
</tr>
<tr>
 <th class="tableb smallfont">{$lang->items['LANG_CONTACT_EMAIL']}:</th>
 <td class="tableb smallfont" colspan="2">$em</td>
</tr>
<if($conset[1]==1)><then>
 <tr>
  <th class="tablea smallfont">{$lang->items['LANG_CONTACT_STREET']}:</th>
  <td class="tablea smallfont" colspan="2">$adr</td>
 </tr>
 <tr>
  <th class="tableb smallfont">{$lang->items['LANG_CONTACT_HOME']}:</th>
  <td class="tableb smallfont" colspan="2">$home</td>
 </tr>
</then></if>
<if($conset[2]==1)><then><tr>
 <th class="tablea smallfont">{$lang->items['LANG_CONTACT_PHONE']}:</th>
 <td class="tablea smallfont" colspan="2">$ph</td>
</tr></then></if>
<if($conset[3]==1)><then><tr>
 <th class="tableb smallfont">{$lang->items['LANG_CONTACT_FAX']}:</th>
 <td class="tableb smallfont" colspan="2">$pf</td>
</tr></then></if>
<tr>
 <th class="tablea smallfont">{$lang->items['LANG_CONTACT_SUBJECT']}:</th>
 <td class="tablea smallfont" colspan="2">$betref</td>
</tr>
<tr>
 <th class="tableb smallfont">{$lang->items['LANG_CONTACT_MESSAGE']}:</th>
 <td class="tablea smallfont" colspan="2">$textp</td>
</tr>