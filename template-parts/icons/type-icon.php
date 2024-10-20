<?php 
if (!isset($role)) : $role = NULL; endif;
if (!isset($type)) : $type = NULL; endif;
?>

<div class="type-icon profile-<?php echo str_replace(' ', '_', strtolower($type)); ?>" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo ucwords($type); if ($role){echo ' - '. $role; } ?>">
    <i class="bi"></i> 
</div> 