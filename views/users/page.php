<?php require "views/includes/header.php"; ?>

<header>
    <?php require "views/includes/navigation.php"; ?>
</header>

<main>
    <div class="container mx-auto max-md:px-5">
        <h1 class="page-heading">Потребители (<?= $total ?>)</h1>
        <?php require "filters.php"; ?>
    </div>

    <?php require "views/users/table.php"; ?>
</main>

<?php require "views/includes/footer.php"; ?>
