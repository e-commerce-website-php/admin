<form class="secondary container mx-auto my-5 px-5 text-center rounded shadow" action="/categories" method="GET">
    <div class="flex items-center max-sm:flex-col gap-2">
        <div class="flex gap-2">
            <select class="form-control w-fit" name="limit" id="limit">
                <option <?= !empty($limit) && $limit === 5 ? "selected" : null ?> value="5">5 категории</option>
                <option <?= !empty($limit) && $limit === 10 ? "selected" : null ?> value="10">10 категории</option>
                <option <?= !empty($limit) && $limit === 20 ? "selected" : null ?> value="20">20 категории</option>
                <option <?= !empty($limit) && $limit === 30 ? "selected" : null ?> value="30">30 категории</option>
                <option <?= !empty($limit) && $limit === 40 ? "selected" : null ?> value="40">40 категории</option>
                <option <?= !empty($limit) && $limit === 50 ? "selected" : null ?> value="50">50 категории</option>
                <option <?= !empty($limit) && $limit === 100 ? "selected" : null ?> value="100">100 категории</option>
            </select>

            <select class="form-control sm:max-w-xs w-fit" name="column" id="column">
                <option <?= !empty($_GET["column"]) && $_GET["column"] === "name" ? "selected" : null ?> value="name">Име</option>
                <option <?= !empty($_GET["column"]) && $_GET["column"] === "description" ? "selected" : null ?> value="description">Описание</option>
                <option <?= !empty($_GET["column"]) && $_GET["column"] === "active" ? "selected" : null ?> value="active">Активни</option>
                <option <?= !empty($_GET["column"]) && $_GET["column"] === "inactive" ? "selected" : null ?> value="inactive">Неактивни</option>
            </select>
        </div>

        <input class="form-control" type="text" name="search" value="<?= $_GET["search"] ?? "" ?>" placeholder="Търсене..." />

        <button type="submit" class="text-link">
            Прилагане
        </button>
    </div>
</form>
