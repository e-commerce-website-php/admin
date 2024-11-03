<?php require "views/includes/header.php"; ?>

<header>
    <?php require "views/includes/navigation.php"; ?>
</header>

<main class="px-5 mb-5">
    <div class="container mx-auto">
        <h1 class="page-heading">Създаване на нова категория</h1>
        <?php if (!empty($_SESSION["parent_category"])): ?>
            <div>
                <span>Родителска категория: </span>
                <span><?= $_SESSION["parent_category"]["name"] ?></span>
            </div>
        <?php else: ?>
            <div>Не е зададена родителска категория</div>
        <?php endif; ?>
    </div>

    <?php require "views/helpers/display-messages.php"; ?>
    <?php require "views/categories/create/form.php"; ?>
</main>

<?php require "views/includes/footer.php"; ?>