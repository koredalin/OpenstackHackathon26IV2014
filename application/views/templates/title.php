<div class="container-title">
    <div class="x-large green"><strong><?php echo $title; ?></strong></div>
    <p class="title-links">
        <?php
        if (isset($breadcrumbs)) {
            echo $breadcrumbs . $logout_link;
        } else if (isset($logout_link)) {
            echo $logout_link;
        }
        ?>
    </p>
    <div class="fatal_error">
        <?php
        if (isset($fatalError) && $fatalError) {
            echo '<p>Fatal Error!</p>';
            echo '<p>' . $fatalError . '</p>';
        }
        ?>
    </div>
</div>
<div class="under_line"></div>