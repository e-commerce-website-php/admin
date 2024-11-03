<?php
    $errorMessage = $_SESSION["error_message"] ?? null;
    $successMessage = $_SESSION["success_message"] ?? null;
?>

<?php if ($errorMessage): ?>
    <div class="text-white bg-red-700 text-center p-5 rounded shadow custom-border mb-5">
        <?= $errorMessage ?>
    </div>
    <?php unset($_SESSION["error_message"]) ?>
<?php endif; ?>
<?php if ($successMessage): ?>
    <div class="text-white bg-green-700 text-center p-5 rounded shadow custom-border mb-5">
        <?= $successMessage ?>
    </div>
    <?php unset($_SESSION["success_message"]) ?>
<?php endif; ?>