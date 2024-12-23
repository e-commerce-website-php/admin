<?php require "views/includes/header.php"; ?>

<header>
    <?php require "views/includes/navigation.php"; ?>
</header>

<main class="mx-5">
    <div class="container mx-auto">
        <h1 class="page-heading">Редактиране на нова категория</h1>
        <div class="mt-5">
            <?php require "views/helpers/display-messages.php"; ?>
        </div>
    </div>

    <?php require "views/categories/edit/form.php"; ?>
</main>

<?php require "views/includes/footer.php"; ?>
