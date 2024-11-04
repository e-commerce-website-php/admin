<?php require "views/includes/header.php"; ?>

<header>
    <?php require "views/includes/navigation.php"; ?>
</header>

<main class="px-5 mb-5">
    <div class="container mx-auto">
        <div class="flex items-center justify-between gap-2 my-5">
            <h1 class="page-heading my-0">Продукти (<?= $total ?>)</h1>
            <a href="/products/create" class="button primary">Създаване</a>
        </div>

        <?php require "views/helpers/display-messages.php"; ?>

        <?php if (!empty($products) && count($products) > 0): ?>
            <?php require "views/products/index/filters.php"; ?>
        <?php endif; ?>
    </div>

    <?php require "views/products/index/table.php"; ?>
</main>

<?php require "views/includes/footer.php"; ?>