<?php 

namespace RedRockSusbscriptions;

if ($message = Reporter::pop()) {

?>
    <div class="notice is-dismissible <?php echo $message['type'] ?>">
        <p>
            <?php echo $message['message'] ?>
        </p>
    </div>
<?php
}
?>
