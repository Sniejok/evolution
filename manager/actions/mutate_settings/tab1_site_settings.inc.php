<?php
	$site_unavailable_message_view = isset($site_unavailable_message) ? $site_unavailable_message : $_lang['siteunavailable_message_default'];
?>
<!-- Site Settings -->
<div class="tab-page" id="tabPage2">
<h2 class="tab"><?php echo $_lang['settings_site'] ?></h2>
<script type="text/javascript">tpSettings.addTabPage( document.getElementById( "tabPage2" ) );</script>
<table border="0" cellspacing="0" cellpadding="3">
  <tr>
    <td nowrap class="warning"><?php echo $_lang['sitestatus_title'] ?></td>
    <td>
        <?php echo wrap_label($_lang['online'],  form_radio('site_status', 1));?><br />
        <?php echo wrap_label($_lang['offline'], form_radio('site_status', 0));?>
    </td>
  </tr>
  <tr>
    <td width="200">&nbsp;</td>
    <td class="comment"><?php echo $_lang['sitestatus_message'] ?></td>
  </tr>
  <tr>
    <td colspan="2"><div class="split"></div></td>
  </tr>
    <tr>
      <td nowrap class="warning"><?php echo $modx->htmlspecialchars($_lang['sitename_title']) ?></td>
      <td ><input onchange="documentDirty=true;" type="text" maxlength="255" style="width: 200px;" name="site_name" value="<?php echo $modx->htmlspecialchars($site_name); ?>" /></td>
    </tr>
    <tr>
      <td width="200">&nbsp;</td>
      <td class="comment"><?php echo $_lang['sitename_message'] ?></td>
    </tr>
    <tr>
      <td colspan="2"><div class="split"></div></td>
    </tr>
  <tr>
    <td nowrap class="warning"><?php echo $_lang['sitestart_title'] ?></td>
    <td><input onchange="documentDirty=true;" type="text" maxlength="10" size="5" name="site_start" value="<?php echo $site_start; ?>" /></td>
  </tr>
  <tr>
    <td width="200">&nbsp;</td>
    <td class="comment"><?php echo $_lang['sitestart_message'] ?></td>
  </tr>
  <tr>
    <td colspan="2"><div class="split"></div></td>
  </tr>
  <tr>
    <td nowrap class="warning"><?php echo $_lang['errorpage_title'] ?></td>
    <td><input onchange="documentDirty=true;" type="text" maxlength="10" size="5" name="error_page" value="<?php echo $error_page; ?>" /></td>
  </tr>
  <tr>
    <td width="200">&nbsp;</td>
    <td class="comment"><?php echo $_lang['errorpage_message'] ?></td>
  </tr>
  <tr>
    <td colspan="2"><div class="split"></div></td>
  </tr>
  <tr>
    <td nowrap class="warning"><?php echo $_lang['unauthorizedpage_title'] ?></td>
    <td><input onchange="documentDirty=true;" type="text" maxlength="10" size="5" name="unauthorized_page" value="<?php echo $unauthorized_page; ?>" /></td>
  </tr>
  <tr>
    <td width="200">&nbsp;</td>
    <td class="comment"><?php echo $_lang['unauthorizedpage_message'] ?></td>
  </tr>
  <tr>
    <td colspan="2"><div class="split"></div></td>
  </tr>
  <tr>
    <td nowrap class="warning" valign="top"><?php echo $_lang['siteunavailable_page_title'] ?></td>
    <td><input onchange="documentDirty=true;" name="site_unavailable_page" type="text" maxlength="10" size="5" value="<?php echo $site_unavailable_page; ?>" /></td>
  </tr>
  <tr>
    <td width="200">&nbsp;</td>
    <td class="comment"><?php echo $_lang['siteunavailable_page_message'] ?></td>
  </tr>
  <tr>
    <td colspan="2"><div class="split"></div></td>
  </tr>
  <tr>
    <td nowrap class="warning" valign="top"><?php echo $_lang['siteunavailable_title'] ?>
      <br />
      <p><?php echo $_lang['update_settings_from_language']; ?></p>
      <select name="reload_site_unavailable" id="reload_site_unavailable_select" onchange="confirmLangChange(this, 'siteunavailable_message_default', 'site_unavailable_message_textarea');">
<?php echo get_lang_options('siteunavailable_message_default');?>
      </select>
    </td>
    <td> <textarea name="site_unavailable_message" id="site_unavailable_message_textarea" style="width:100%; height: 120px;"><?php echo $site_unavailable_message_view; ?></textarea>
        <input type="hidden" name="siteunavailable_message_default" id="siteunavailable_message_default_hidden" value="<?php echo addslashes($_lang['siteunavailable_message_default']);?>" />
    </td>
  </tr>
  <tr>
    <td width="200">&nbsp;</td>
    <td class="comment"><?php echo $_lang['siteunavailable_message'];?></td>
  </tr>
  <tr>
    <td colspan="2"><div class="split"></div></td>
  </tr>
  <tr>
    <td nowrap class="warning" valign="top"><?php echo $_lang['defaulttemplate_title'] ?></td>
    <td>
    <?php
        $rs = $modx->db->select(
            't.templatename, t.id, c.category',
            $modx->getFullTableName('site_templates')." AS t
                LEFT JOIN ".$modx->getFullTableName('categories')." AS c ON t.category = c.id",
            "",
            'c.category, t.templatename ASC'
            );
    ?>
      <select name="default_template" class="inputBox" onchange="documentDirty=true;wrap=document.getElementById('template_reset_options_wrapper');if(this.options[this.selectedIndex].value != '<?php echo $default_template;?>'){wrap.style.display='block';}else{wrap.style.display='none';}" style="width:150px">
        <?php
        
        $currentCategory = '';
                        while ($row = $modx->db->getRow($rs)) {
            $thisCategory = $row['category'];
            if($thisCategory == null) {
                $thisCategory = $_lang['no_category'];
            }
            if($thisCategory != $currentCategory) {
                if($closeOptGroup) {
                    echo "\t\t\t\t\t</optgroup>\n";
                }
                echo "\t\t\t\t\t<optgroup label=\"$thisCategory\">\n";
                $closeOptGroup = true;
            } else {
                $closeOptGroup = false;
            }
            
            $selectedtext = $row['id'] == $default_template ? ' selected="selected"' : '';
            if ($selectedtext) {
                $oldTmpId = $row['id'];
                $oldTmpName = $row['templatename'];
            }
            
            echo "\t\t\t\t\t".'<option value="'.$row['id'].'"'.$selectedtext.'>'.$row['templatename']."</option>\n";
            $currentCategory = $thisCategory;
        }
        if($thisCategory != '') {
            echo "\t\t\t\t\t</optgroup>\n";
        }
?>
      </select>
          <br />
        <div id="template_reset_options_wrapper" style="display:none;">
            <input type="radio" name="reset_template" value="1" /> <?php echo $_lang['template_reset_all']; ?><br />
            <input type="radio" name="reset_template" value="2" /> <?php echo sprintf($_lang['template_reset_specific'],$oldTmpName); ?>
        </div>
        <input type="hidden" name="old_template" value="<?php echo $oldTmpId; ?>" />
    </td>
  </tr>
  <tr>
    <td width="200">&nbsp;</td>
    <td class="comment"><?php echo $_lang['defaulttemplate_message'] ?></td>
  </tr>
  <tr>
    <td colspan="2"><div class="split"></div></td>
  </tr>
    <tr>
        <td nowrap class="warning" valign="top"><?php echo $_lang['defaulttemplate_logic_title'];?></td>
        <td>
            <p><?php echo $_lang['defaulttemplate_logic_general_message'];?></p>
            <input type="radio" name="auto_template_logic" value="system"<?php if($auto_template_logic == 'system') {echo " checked='checked'";}?>/> <?php echo $_lang['defaulttemplate_logic_system_message']; ?><br />
            <input type="radio" name="auto_template_logic" value="parent"<?php if($auto_template_logic == 'parent') {echo " checked='checked'";}?>/> <?php echo $_lang['defaulttemplate_logic_parent_message']; ?><br />
            <input type="radio" name="auto_template_logic" value="sibling"<?php if($auto_template_logic == 'sibling') {echo " checked='checked'";}?>/> <?php echo $_lang['defaulttemplate_logic_sibling_message']; ?><br />
        </td>
    </tr>
    <tr>
        <td colspan="2"><div class="split"></div></td>
    </tr>
  <tr>
    <td nowrap class="warning" valign="top"><?php echo $_lang['defaultpublish_title'] ?></td>
    <td>
        <?php echo wrap_label($_lang['yes'],form_radio('publish_default', 1));?><br />
        <?php echo wrap_label($_lang['no'],form_radio('publish_default', 0));?>
    </td>
  </tr>
  <tr>
    <td width="200">&nbsp;</td>
    <td class="comment"><?php echo $_lang['defaultpublish_message'] ?></td>
  </tr>

  <tr>
    <td colspan="2"><div class="split"></div></td>
  </tr>
  <tr>
    <td nowrap class="warning" valign="top"><?php echo $_lang['defaultcache_title'] ?></td>
    <td>
        <?php echo wrap_label($_lang['yes'],form_radio('cache_default', 1));?><br />
        <?php echo wrap_label($_lang['no'],form_radio('cache_default', 0));?>
    </td>
  </tr>
  <tr>
    <td width="200">&nbsp;</td>
    <td class="comment"><?php echo $_lang['defaultcache_message'] ?></td>
  </tr>
  <tr>
    <td colspan="2"><div class="split"></div></td>
  </tr>
  <tr>
    <td nowrap class="warning" valign="top"><?php echo $_lang['defaultsearch_title'] ?></td>
    <td>
        <?php echo wrap_label($_lang['yes'],form_radio('search_default', 1));?><br />
        <?php echo wrap_label($_lang['no'],form_radio('search_default', 0));?>
    </td>
  </tr>
  <tr>
    <td width="200">&nbsp;</td>
    <td class="comment"><?php echo $_lang['defaultsearch_message'] ?></td>
  </tr>
  <tr>
    <td colspan="2"><div class="split"></div></td>
  </tr>
  <tr>
    <td nowrap class="warning" valign="top"><?php echo $_lang['defaultmenuindex_title'] ?></td>
    <td>
        <?php echo wrap_label($_lang['yes'],form_radio('auto_menuindex', 1));?><br />
        <?php echo wrap_label($_lang['no'],form_radio('auto_menuindex', 0));?>
    </td>
  </tr>
  <tr>
    <td width="200">&nbsp;</td>
    <td class="comment"><?php echo $_lang['defaultmenuindex_message'] ?></td>
  </tr>
  <tr>
    <td colspan="2"><div class="split"></div></td>
  </tr>
  <tr>
    <td nowrap class="warning" valign="top"><?php echo $_lang['custom_contenttype_title'] ?></td>
    <td><input name="txt_custom_contenttype" type="text" maxlength="100" style="width: 200px;height:100px" value="" /> <input type="button" value="<?php echo $_lang['add']; ?>" onclick='addContentType()' /><br />
    <table border="0" cellspacing="0" cellpadding="0"><tr><td valign="top">
    <select name="lst_custom_contenttype" style="width:200px;" size="5">
    <?php
        $ct = explode(",",$custom_contenttype);
        for($i=0;$i<count($ct);$i++) {
            echo "<option value=\"".$ct[$i]."\">".$ct[$i]."</option>";
        }
    ?>
    </select>
    <input name="custom_contenttype" type="hidden" value="<?php echo $custom_contenttype; ?>" />
    </td><td valign="top">&nbsp;<input name="removecontenttype" type="button" value="<?php echo $_lang['remove']; ?>" onclick='removeContentType()' /></td></tr></table>
    </td>
  </tr>
  <tr>
    <td width="200">&nbsp;</td>
    <td class="comment"><?php echo $_lang['custom_contenttype_message'] ?></td>
  </tr>
<tr>
    <td colspan="2"><div class="split"></div></td>
  </tr>
<tr>
<td nowrap class="warning" valign="top"><?php echo $_lang['docid_incrmnt_method_title'] ?></td>
<td>
<label><input type="radio" name="docid_incrmnt_method" value="0"
    <?php echo ($docid_incrmnt_method=='0') ? 'checked="checked"' : "" ; ?> />
    <?php echo $_lang['docid_incrmnt_method_0']?></label><br />
    
<label><input type="radio" name="docid_incrmnt_method" value="1"
    <?php echo ($docid_incrmnt_method=='1') ? 'checked="checked"' : "" ; ?> />
    <?php echo $_lang['docid_incrmnt_method_1']?></label><br />
<label><input type="radio" name="docid_incrmnt_method" value="2"
    <?php echo ($docid_incrmnt_method=='2') ? 'checked="checked"' : "" ; ?> />
    <?php echo $_lang['docid_incrmnt_method_2']?></label><br />
</td>
</tr>
<tr>
    <td colspan="2"><div class="split"></div></td>
  </tr>

<tr>
<td nowrap class="warning"><?php echo $_lang['cache_type_title'] ?></td>
<td>
<?php echo wrap_label($_lang['cache_type_1'],form_radio('cache_type', 1));?><br />
<?php echo wrap_label($_lang['cache_type_2'], form_radio('cache_type', 2));?>
</td>
</tr>
  <tr>
    <td colspan="2"><div class="split"></div></td>
  </tr>
  <tr>
    <td nowrap class="warning"><?php echo $_lang['xhtml_urls_title'] ?></td>
    <td>
        <?php echo wrap_label($_lang['yes'],form_radio('xhtml_urls', 1));?><br />
        <?php echo wrap_label($_lang['no'], form_radio('xhtml_urls', 0));?>
    </td>
  </tr>
  <tr>
    <td width="200">&nbsp;</td>
    <td class="comment"><?php echo $_lang['xhtml_urls_message'] ?></td>
  </tr>
  <tr>
    <td colspan="2"><div class="split"></div></td>
  </tr>
    <tr>
      <td nowrap class="warning"><?php echo $_lang['serveroffset_title'] ?></td>
      <td> <select name="server_offset_time" size="1" class="inputBox">
          <?php
      for($i=-24; $i<25; $i++) {
          $seconds = $i*60*60;
          $selectedtext = $seconds==$server_offset_time ? "selected='selected'" : "" ;
      ?>
          <option value="<?php echo $seconds; ?>" <?php echo $selectedtext; ?>><?php echo $i; ?></option>
          <?php
      }
      ?>
        </select> </td>
    </tr>
    <tr>
      <td width="200">&nbsp;</td>
      <td class="comment"><?php printf($_lang['serveroffset_message'], strftime('%H:%M:%S', time()), strftime('%H:%M:%S', time()+$server_offset_time)); ?></td>
    </tr>
    <tr>
      <td colspan="2"><div class='split'>&nbsp;</div></td>
    </tr>
    <tr>
      <td nowrap class="warning"><?php echo $_lang['server_protocol_title'] ?></td>
      <td>
        <?php echo wrap_label($_lang['server_protocol_http'],form_radio('server_protocol', 'http'));?><br />
        <?php echo wrap_label($_lang['server_protocol_https'], form_radio('server_protocol', 'https'));?>
      </td>
    </tr>
    <tr>
      <td width="200">&nbsp;</td>
      <td class="comment"><?php echo $_lang['server_protocol_message'] ?></td>
    </tr>
    <tr>
      <td colspan="2"><div class="split"></div></td>
    </tr>
    <tr>
      <td nowrap class="warning"><?php echo $_lang['enable_filter_title'] ?></td>
      <td >
        <?php
            // Check if PHX is enabled
            $modx->invokeEvent('OnParseDocument');
            if(class_exists('PHxParser')) {
                $disabledFilters = 1;
                echo '<b>'.$_lang['enable_filter_phx_warning'].'</b><br/>';
            }
        ?>
        <?php echo wrap_label($_lang['yes'],form_radio('enable_filter', 1, '', $disabledFilters));?><br />
        <?php echo wrap_label($_lang['no'], form_radio('enable_filter', 0, '', $disabledFilters));?>
      </td>
    </tr>
    <tr>
      <td width="200">&nbsp;</td>
      <td class="comment"><?php echo $_lang['enable_filter_message']; ?></td>
    </tr>
    <tr>
      <td colspan="2"><div class="split"></div></td>
    </tr>
    <tr>
      <td nowrap class="warning"><?php echo $_lang['rss_url_news_title'] ?></td>
      <td ><input onchange="documentDirty=true;" type="text" maxlength="350" style="width: 350px;" name="rss_url_news" value="<?php echo $rss_url_news; ?>" /></td>
    </tr>
    <tr>
      <td width="200">&nbsp;</td>
      <td class="comment"><?php echo $_lang['rss_url_news_message'] ?></td>
    </tr>
    <tr>
      <td colspan="2"><div class="split"></div></td>
    </tr>
  <tr>
    <td nowrap class="warning" valign="top"><?php echo $_lang['track_visitors_title'] ?></td>
    <td>
        <?php echo wrap_label($_lang['yes'],form_radio('track_visitors', 1));?><br />
        <?php echo wrap_label($_lang['no'],form_radio('track_visitors', 0));?>
    </td>
  </tr>
  <tr>
    <td width="200">&nbsp;</td>
    <td class="comment"><?php echo $_lang['track_visitors_message'] ?></td>
  </tr>
  <tr>
    <td colspan="2"><div class="split"></div></td>
  </tr>
  <tr>
    <td nowrap class="warning" valign="top"><?php echo $_lang['top_howmany_title'] ?></td>
    <td><input onchange="documentDirty=true;" type="text" maxlength="50" size="5" name="top_howmany" value="<?php echo $top_howmany; ?>" /></td>
  </tr>
  <tr>
    <td width="200">&nbsp;</td>
    <td class="comment"><?php echo $_lang['top_howmany_message'] ?></td>
  </tr>
  <tr>
    <td colspan="2"><div class="split"></div></td>
  </tr>
  <tr>
    <td colspan="2">
        <?php
            // invoke OnSiteSettingsRender event
            $evtOut = $modx->invokeEvent('OnSiteSettingsRender');
            if(is_array($evtOut)) echo implode("",$evtOut);
        ?>
    </td>
  </tr>
</table>
</div>
