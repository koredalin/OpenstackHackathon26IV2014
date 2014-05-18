
<?php
// var_dump($containers_list);
if (isset($containers_list) || !empty($containers_list)) {
    echo "<input type='hidden' id='cont_list' value='".json_encode($containers_list)."'>";
}
?>

<div>
    <form action="<?php echo $baseDirectory; ?>swift/createContainer" method="post">
        <div>Create a container </div>
            <div>
                <span><input type="text" name="new_container_name" placeholder="Container's name" id="new_container_name"></span>
                <span>
                    <button type="submit" id="create_container_btn">Create Container</button>
                </span>
            </div>
    </form>
</div>

<div class="validation_fail">
    <?php
    if (isset($validation_error)) {
        echo $validation_error;
    }
    ?>
</div>
<div class="under_line"></div>
<div class="auto_scroll-swift">

    <div>
        <p>Containers list:</p>
    </div>
    <div class="list">
        <?php echo $container_links; ?>
    </div>
</div>

<div class="height_distance"></div>



<?php
/*
  if (isset($action_result)) {
  echo $action_result;
  echo '<div class="under_line"></div>';
  }
 */
?>