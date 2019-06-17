<?php if ($message = Memberful_WP_Reporting::pop()): ?>
<div class="notice is-dismissible <?php echo $message['type'] ?>">
    <p>
        <?php echo $message['message'] ?>
    </p>
</div>
<?php endif; ?>
