
<?php
/*
  if (isset($action_result)) {
  echo $action_result;
  echo '<div class="under_line"></div>';
  }
 */
?>

<div>
    <form action="<?php echo $baseDirectory; ?>swift/createContainer" method="post">
        <table class='hcenter'>
            <tr>
                <td colspan="2">Create a container </td>
            </tr>
            <tr>
                <td><input type="text" name="new_container_name" placeholder="Container's name"></td>
                <td>
                    <button type="submit">Create Container</button>
                </td>
            </tr>
        </table>
    </form>
</div>
<div class="auto_scroll-swift">
<div class="under_line"></div>
<div>
    <p>Containers list:</p>
</div>
<div>
    <?php echo $container_links; ?>
</div>
</div>