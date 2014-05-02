<?php
/**
 * @category View Footer
 * @description Main footer
 */
?>

    </div>
</div>
<footer class="footer">
    <div>
        <p>&copy; Hristo Hristov / Last update: 
            <?php 
            $lastUpdate=isset($lastUpdate) ? $lastUpdate : 'No date set.'; 
            echo $lastUpdate;
            ?>
        </p>
    </div>
</footer>



</body>
</html>