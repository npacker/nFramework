<?php if ($code < 500): ?>
<?php $class = 'warn'; ?>
<?php else: ?>
<?php $class = 'critical'; ?>
<?php endif; ?>
<p class="error <?php echo $class; ?>"><?php echo $message; ?></p>
