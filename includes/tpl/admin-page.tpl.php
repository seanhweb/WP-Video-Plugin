<div class="wrap">
    <form method="post" action="tools.php?page=video-plugin">
        <h1>Set the Youtube API Key</h1>
            <table class="wp-list-table widefat fixed striped posts">
                <tr>
                    <th>API Key</th>
                </tr>
                    <td style="width:20px;">
                        <input type="text" name="youtube_api_key" value="<?php print $yt_api_key; ?>" style="width:100%;" />
                        <input type="hidden" name="hidden_field" value="Y" />
                    </td>
            </table>
        <?php submit_button(); ?>
    </form>
</div>
