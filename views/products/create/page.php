<?php require "views/includes/header.php"; ?>

<header>
    <?php require "views/includes/navigation.php"; ?>
</header>

<main class="px-5 mb-5">
    <div class="container mx-auto">
        <h1 class="page-heading">Създаване на нов продукт</h1>
        <?php if (!empty($_SESSION["product_category"])): ?>
            <div>
                <span>Родителска категория: </span>
                <span><?= $_SESSION["product_category"]["name"] ?></span>
            </div>
        <?php else: ?>
            <div>Не е зададена категория</div>
        <?php endif; ?>
        <div class="mt-5">
            <?php require "views/helpers/display-messages.php"; ?>
        </div>
    </div>

    <?php require "views/products/create/form.php"; ?>
</main>

<?php require "views/includes/footer.php"; ?>