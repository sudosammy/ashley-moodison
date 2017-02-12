{include file='head_tags.tpl'}
<body>
<div id="layout">
  <div id="header">
    <div class="heart"><img src="{$web_root}images/heart_2.gif" alt="" /></div>
    <div class="form_container">
			<h2>Intimate Signup</h2>
      <form action="{$web_root}process/create_account.php" enctype="multipart/form-data" method="post">
        <fieldset>
        <div class="search_row">
          <div class="search_column_1">
            <label>My name is</label>
          </div>
          <div class="search_column_2">
            <input type="text" name="username" placeholder="this will be your username">
          </div>
        </div>
        <div class="search_row">
          <div class="search_column_1">
            <label>My password is</label>
          </div>
          <div class="search_column_2">
            <input type="password" name="password" placeholder="must be >4 characters">
          </div>
        </div>
        <div class="search_row">
          <div class="search_column_1">
            <label>My picture is</label>
          </div>
          <div class="search_column_2">
            <input type="file" name="image">
          </div>
        </div>
				<div class="search_row">
					<div class="search_column_1">
						<label class="captcha"><img src="{$web_root}images/captcha.php" id="changeimg" title="Click to generate new image." style="cursor: pointer"></label>
					</div>
					<div class="search_column_2">
						<input type="text" name="captcha" placeholder="complete the captcha">
					</div>
				</div>
        <div class="search_row last">
          <div class="search_column_1">&nbsp;</div>
          <div class="search_column_2">
            <input type="submit" class="search_btn" name="create-account" value="Signup"/>
          </div>
        </div>
        </fieldset>
      </form>
    </div>
    <div class="banner"><img src="{$web_root}images/pic_1.gif" alt="" /></div>
    {if isset($msg_success)}
    <p style="color: green; font-size: 16px; padding-top: 5px; padding-bottom: 5px;">{$msg_success}</p>
    {elseif isset($msg_error)}
    <p style="color: red; font-size: 16px; padding-top: 5px; padding-bottom: 5px;">{$msg_error}</p>
    {/if}
		{include file='nav.tpl'}
