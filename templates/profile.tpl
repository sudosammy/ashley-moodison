{include file='header.tpl'}
  <div id="body_container">
    <div class="detail_container">
      <div class="detail_box">
        <div class="detail_top_curve">
          <div class="detail_detail_content">
            <div class="welcomezone">
              <div style="margin-bottom:20px; border-bottom:1px dotted #000; padding-bottom:10px;">
                <div class="blueboldheading">
                  <h1><span>Hi, {$smarty.session.account.username}{if $admin} - Administrator - {$flag3}{/if}</span></h1>
                </div>
                <div> <img src="{$web_root}images/uploads/{$profile_image}" alt="" class="project-img" style="float: left; margin-right: 20px; max-width: 300px; max-height: 500px;" /> </div>
                {if is_null($description)}
                <p>Write a profile description for 10 points!</p>
                {else}
                <form method="post" action="{$web_root}ctf/show_hint.php">
                  <input type="submit" onclick="return confirm('Getting a hint will cost one credit. You currently have {$credits}, are you sure you want a hint?')" value="CTF Hint" />
                </form>
                {/if}
                <form method="post" action="{$web_root}process/update_desc.php" style="margin-top: 15px">
                  <textarea name="description" style="resize: vertical; margin-bottom: 10px" placeholder="Your profile text...">{if !empty($description)}{$description}{/if}</textarea><br>
                  <input type="submit" value="Update" name="update" style="margin-bottom: 10px" />
                </form>
            <div class="clear"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
{include file='footer.tpl'}
