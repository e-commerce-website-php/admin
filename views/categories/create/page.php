<?php require "views/includes/header.php"; ?>

<header>
    <?php require "views/includes/navigation.php"; ?>
</header>

<main>
    <div class="container mx-auto max-md:px-5">
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

    <?php require "views/categories/create/form.php"; ?>
</main>

<?php require "views/includes/footer.php"; ?>
