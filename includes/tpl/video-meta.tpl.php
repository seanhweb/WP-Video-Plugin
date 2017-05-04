<table class="admin">
    <tr>
        <td colspan=2><p><i>Please enter JUST the youtube OR Vimeo ID. E.G TimW1s36NCI/112212232</i></p></td>
    </tr>
    <tr>
        <th>Video ID</th>
        <td><input type="text" name="videoid" value="<?php print $videoid; ?>"/></td>
    </tr>
    <tr>
        <th>Provider</th>
        <td>
            <table>
                <tr>
                    <td>
                        <input type="radio" name="provider" value="youtube" <?php if($provider == 'youtube') {print 'checked'; } ?>>Youtube
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="radio" name="provider" value="vimeo" <?php if($provider == 'vimeo') {print 'checked'; } ?>>Vimeo
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <th>Season</th>
        <td>
            <select name="season">
                <option value="">
                    N/A
                </option>
                <?php for($x=1;$x<10;$x++): ?>
                    <option value="<?php print $x; ?>" <?php if($x == $season){print 'selected'; }?>>
                        <?php print $x; ?>
                    </option>
                <?php endfor; ?>
            </select>
        </td>
    </tr>
    <tr>
        <th>Episode</th>
        <td>
            <select name="episode">
                <option value="">
                    N/A
                </option>
                <?php for($x=1;$x<31;$x++): ?>
                    <option value="<?php print $x; ?>" <?php if($x == $episode){print 'selected'; }?>>
                        <?php print $x; ?>
                    </option>
                <?php endfor; ?>
            </select>
        </td>
    </tr>
</table>
