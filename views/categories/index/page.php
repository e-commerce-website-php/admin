<?php require "views/includes/header.php"; ?>

<header>
    <?php require "views/includes/navigation.php"; ?>
</header>

<main class="px-5 mb-5">
    <div class="container mx-auto">
        <div class="flex items-center justify-between gap-2 my-5">
            <h1 class="page-heading my-0">Категории (<?= $total ?>)</h1>
            <a href="/categories/create" class="button primary">Създаване</a>
        </div>

        <div class="mt-5">
            <?php require "views/helpers/display-messages.php"; ?>
        </div>
        
        <?php if (!empty($categories) && count($categories) > 0): ?>
            <?php require "views/categories/index/filters.php"; ?>
        <?php endif; ?>
    </div>

    <?php require "views/categories/index/table.php"; ?>
</main>

<?php require "views/includes/footer.php"; ?>