{include file='header.tpl'}
<script src="{$web_root}js/encrypt-decrypt.js"></script>
<style type="text/css">
table {
    border-collapse: collapse;
    border-spacing: 0;
    text-align: center;
}
tr, td, table {
  border: 1px solid black;
  padding: 5px;
}
table tr:first-of-type {
  font-size: 14px;
  font-weight: bold;
  margin-bottom: 10px;
}
</style>
<script type="text/javascript">
{literal}
$.get('process/ajax_get_key.php', function(data) {
/* JS is async - we're taking a bit of a risk here.
  We use this value in less than 100 lines and hope the key has returned by then.
  Otherwise our messages won't decrypt at runtime. */
  enc_key = data;
/* We could use jQuery's support for AJAX callbacks but...
  cbf. */
})
.fail(function() {
  alert('Failed to load encryption key. Try refreshing.');
});
{/literal}
</script>
  <div id="body_container">
    <div class="detail_container">
      <div class="detail_box">
        <div class="detail_top_curve">
          <div class="detail_detail_content">
            <div class="welcomezone">
              <div class="blueboldheading">
                <h1><span>{$page_title} - {$flag}</span></h1>
              </div>
              <p style="margin-bottom: 15px"><strong>Notification: </strong>
                Welcome to the new(er) admin area, in light of the recent issues with admins snooping on each others private messages - we have enforced strong encryption on all messages.
              </p>
              <h2>Admin Chat</h2>
              <p>Use the Admin Chat feature to send a message to another administrator, or write yourself reminders.</p>
              <div id="result" style="margin-top: 10px; margin-bottom: 10px; color: green; font-size: 16px"></div>

              <form method="post" action="?" id="enc_messages">
                <p>To: {html_options name=send_to options=$admin_list selected=$own_id}</p><br>
                <textarea name="message" style="resize: vertical; margin-bottom: 10px" placeholder="Your message..."></textarea><br>
                <input type="submit" name="send_message" value="Send Encrypted Message" style="margin-bottom: 10px" onclick="return confirm('This action will cost one credit. You have {$credits} left. Are you sure you want to continue?')" />
              </form>
              <div class="clear"></div>
              <h2 style="margin-bottom: 10px">Inbox - Most Recent Messages</h2>
              <table id="message-table" style="width: 100%">
                <tr>
                  <td>From</td>
                  <td>Message</td>
                  <td>Received</td>
                </tr>
              </table>

            </div>
            <div class="clear"></div>
        </div>
      </div>
    </div>
  </div>
<script type="text/javascript">
// get messages when page is ready
$(document).ready(function() {
  $.get('messages/{$account_id}', function(data) {
    $.each(data, function(key, value) {
      var cell1 = '<a href="profile/' + value['receiver_id'] + '">' + value['sender'] + '</a>';
      var cell2 = SECRETCipher.decode(enc_key, value['message']);
      var cell3 = value['timestamp'];
      $('#message-table').append('<tr><td>' + cell1 + '</td><td>' + cell2 + '</td><td>' + cell3 + '</td></tr>');
    });
  })
  .fail(function(xhr, textStatus, errorThrown) {
    alert(errorThrown);
  });
});
{literal}
// post message ajax
$('#enc_messages').submit(function( event ) {
  event.preventDefault();

  var $form = $(this),
    to = $form.find("select[name='send_to']").val(),
    plain_text_message = $form.find("textarea[name='message']").val(),
    url = 'process/ajax_send_message.php';
  var posting = $.post(url, {send_to: to, message: plain_text_message});

  posting.done(function(data) {
    $('#result').empty().append(data);
    $form.find("textarea[name='message']").val("");
  })
  .fail(function(data) {
    alert(data.responseText);
  });
});
{/literal}
</script>
{include file='footer.tpl'}
