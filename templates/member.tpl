{include file='header.tpl'}
  <div id="body_container">
    <div class="detail_container">
      <div class="detail_box">
        <div class="detail_top_curve">
          <div class="detail_detail_content">
            <div class="welcomezone">
              <div style="margin-bottom:20px; border-bottom:1px dotted #000; padding-bottom:10px;">
                <div class="blueboldheading">
                  <h1><span>{$username}'s Profile {if $admin} - Administrator{/if}</span></h1>
                </div>
                <div> <img src="{$web_root}images/uploads/{$profile_image}" alt="" class="project-img" style="float: left; margin-right: 20px; max-width: 300px; max-height: 500px" /> </div>
                <p>{$description}</p>
            <div class="clear"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
{include file='footer.tpl'}
