<div class="under_line"></div>

<div class="validation_fail">
    <?php
        if (isset($validation_error) && $validation_error) {
            echo '<p>' . $validation_error . '</p>';
        }
    ?>
</div>

<form action="<?php echo $baseDirectory; ?>auth" method="post">
    <table>
        <tr>
            <td>Enter username:</td>
            <td><input type="text" name="os_username"></td>
        </tr>
        <tr>
            <td>Enter password:</td>
            <td><input type="password" name="os_password"></td>
        </tr>
        <tr>
            <td colspan="2">
                <button type="submit">Log in</button>
            </td>
        </tr>
    </table>
</form>

