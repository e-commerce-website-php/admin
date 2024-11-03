<?php require "views/includes/header.php"; ?>

<header>
    <?php require "views/includes/navigation.php"; ?>
</header>

<main>
    <div class="container mx-auto max-md:px-5">
        <div class="flex items-center justify-between gap-2 mt-5">
            <h1 class="page-heading my-0">Категории (<?= $total ?>)</h1>
            <a href="/categories/create" class="button primary">Създаване</a>
        </div>
        <?php require "views/categories/index/filters.php"; ?>
    </div>

    <?php require "views/categories/index/table.php"; ?>
</main>

<?php require "views/includes/footer.php"; ?>
