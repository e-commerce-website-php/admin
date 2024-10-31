<?php
    function getValue(string $key, ?array $array = null, ?string $default = ""): mixed {
        $array = $array ?? $_POST;
        return !empty($array[$key]) ? $array[$key] : $default;
    }
    $errorMessage = $_SESSION["error_message"] ?? null;
    $successMessage = $_SESSION["success_message"] ?? null;
?>

<div class="secondary max-w-xl mx-5 lg:mx-auto mt-5 p-10 lg:p-10 border rounded shadow">
    <form id="form" action="/auth/login" method="POST" class="mx-auto">

        <?php if ($errorMessage): ?>
            <div class="text-red-500 text-center">
                <?= $errorMessage ?>
            </div>
            <?php unset($_SESSION["error_message"]) ?>
        <?php endif; ?>
        <?php if ($successMessage): ?>
            <div class="text-green-500 text-center mb-5">
                <?= $successMessage ?>
            </div>
            <?php unset($_SESSION["success_message"]) ?>
        <?php endif; ?>

        <div class="mb-4">
            <label for="email" class="block text-sm font-bold mb-2">Email: <span class="text-red-500">*</span></label>
            <input type="email" id="email" name="email" value="<?= getValue("email") ?>" required autofocus>
        </div>

        <div class="mb-4">
            <label for="password" class="block text-sm font-bold mb-2">Парола: <span class="text-red-500">*</span></label>
            <input type="password" id="password" name="password" value="<?= getValue("password") ?>" required>
        </div>

        <a href="/auth/forgot-password" class="text-link">Забравена парола</a>

        <input type="text" name="secure_token" value="<?= $_SESSION["secure_token"] ?? "" ?>" hidden>

        <div class="mt-5">
            <button type="submit" class="button primary">
                Влизане в профила
            </button>
        </div>
        <div class="mt-5">
            <a href="/auth/register" class="block my-5 text-link">Нямам профил</a>
        </div>
    </form>
</div>