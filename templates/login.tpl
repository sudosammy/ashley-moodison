{include file='header.tpl'}
  <div id="body_container">
    <div class="detail_container">
      <div class="detail_box">
        <div class="detail_top_curve">
          <div class="detail_detail_content">
            <div class="welcomezone">
              <div class="blueboldheading">
                <h1><span>{$page_title}</span></h1>
              </div>
              <form method="post" action="{$web_root}process/login.php">
              <div class="search_row">
                <div class="search_column_1">
                  <label>Username</label>
                </div>
                <div class="search_column_2">
                  <input type="text" name="username" placeholder="your username" autofocus="true" />
                </div>
              </div>
              <div class="search_row">
                <div class="search_column_1">
                  <label>Password</label>
                </div>
                <div class="search_column_2">
                  <input type="password" name="password" placeholder="your password" />
                </div>
              </div>
              <div class="search_row last">
                <div class="search_column_1">&nbsp;</div>
                <div class="search_column_2">
                  <input type="submit" name="login" value="Login!" class="search_btn" />
                </div>
              </div>
            </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
{include file='footer.tpl'}
