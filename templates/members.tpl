{include file='header.tpl'}
  <div id="body_container">
    <div class="detail_container">
      <div class="detail_box">
        <div class="detail_top_curve">
          <div class="detail_detail_content">
            <div class="welcomezone">
              <div style="margin-bottom:20px; padding-bottom:10px;">
                <div class="blueboldheading">
                  <h1>{$page_title}</span></h1>
                </div>
                <h2>Search for a member</h2>
                <form method="get" action="{$web_root}members">
                <div class="search_row">
                  <div class="search_column_1">
                    <label>Search via name</label>
                  </div>
                  <div class="search_column_2">
                    <input type="text" name="username" placeholder="username" autofocus="true" />
                  </div>
                </div>
                <br />
                <h2>Search for pictures</h2>
                <div class="search_row">
                  <div class="search_column_1">
                    <label>Picture names containing:</label>
                  </div>
                  <div class="search_column_2">
                    <input type="text" name="picture" placeholder="picture name" />
                  </div>
                </div>
                <div class="search_row last">
                  <div class="search_column_1">&nbsp;</div>
                  <div class="search_column_2">
                    <input type="submit" name="search" value="Search" class="search_btn" />
                  </div>
                </div>
                </form>
                <br />
                <h1>Search Results</h1>
                {section name=info loop=$member}
                  <h1><a href="{$web_root}profile/{$member[info].account_id}">{$member[info].username}{if $member[info].admin} - Administrator{/if}</a></h1>
                  <div> <img src="{$web_root}images/uploads/{$member[info].profile_image}" class="project-img" style="max-height: 100px; max-width: 200px" />
                    <p style="overflow: hidden; height: 100px">{$member[info].description}</p>
                  </div>
                  <br />
                {/section}

                {section name=image loop=$member_images}
                  <img src="data:image/png;base64, {$member_images[image].profile_image}" alt="Picture!" style="padding: 15px" />
                {sectionelse}
                  <!-- No images found - {$search_path} -->
                {/section}
              </div>
            <div class="clear"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
{include file='footer.tpl'}
