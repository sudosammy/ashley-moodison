{include file='header.tpl'}
  </div>
  <div id="body_container">
    <div id="left_container">
			<div class="latest_profile">
			  <h2>Latest Profiles</h2>
        {section name=profiles loop=$member}
			  <div class="detail">
			    <div class="photo"><a href="{$web_root}profile/{$member[profiles].account_id}"><img src="{$web_root}images/uploads/{$member[profiles].profile_image}" alt="" style="max-height: 66px; max-width: 66px;" /></a></div>
			    <div class="containt">
			      <p style="overflow: hidden; height: 85px;">Name: <span>{$member[profiles].username}</span><br />
			        Bio: <span>{$member[profiles].description}</span></p>
			      <span class="know_more"><a href="{$web_root}profile/{$member[profiles].account_id}">Know more</a></span></div>
			  </div>
        {/section}

			</div>
    </div>
    <div id="right_container">
      <div class="top_containt">
        <h2>Welcome to {$site_title}</h2>
        <p>Welcome to dating like you have experienced before! Unlike our predecessor, {$site_title} won't scrape all your personal information and leak it to the world. We take online security more seriously than your bank.<br>Man! Online dating Rules!</p>
      </div>
      <div class="bottom_containt">
        <h2>Don’t Be A Loser!</h2>
        <ul>
          <li>Potentially a real female member!</li>
          <li class="b">Super secure, cannot be breached!</li>
          <li class="c">87% free forever!</li>
        </ul>
      </div>
    </div>
  </div>
{include file='footer.tpl'}
