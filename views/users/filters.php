<form class="secondary container mx-auto my-5 px-5 text-center rounded shadow" action="/users" method="GET">
    <div class="flex items-center max-sm:flex-col gap-2">
        <select class="form-control sm:max-w-xs" name="column" id="column">
            <option <?= !empty($_GET["column"]) && $_GET["column"] === "email" ? "selected" : null ?> value="email">Имейл
            </option>
            <option <?= !empty($_GET["column"]) && $_GET["column"] === "first_name" ? "selected" : null ?>
                value="first_name">Име</option>
            <option <?= !empty($_GET["column"]) && $_GET["column"] === "last_name" ? "selected" : null ?>
                value="last_name">Фамилия</option>
            <option <?= !empty($_GET["column"]) && $_GET["column"] === "phone_number" ? "selected" : null ?>
                value="phone_number">Телефон</option>
            <option <?= !empty($_GET["column"]) && $_GET["column"] === "address" ? "selected" : null ?> value="address">
                Физически адрес</option>
            <option <?= !empty($_GET["column"]) && $_GET["column"] === "city" ? "selected" : null ?> value="city">Град
            </option>
            <option <?= !empty($_GET["column"]) && $_GET["column"] === "state" ? "selected" : null ?> value="state">Област
            </option>
            <option <?= !empty($_GET["column"]) && $_GET["column"] === "postal_code" ? "selected" : null ?>
                value="postal_code">Пощенски код</option>
            <option <?= !empty($_GET["column"]) && $_GET["column"] === "country" ? "selected" : null ?> value="country">
                Държава</option>
        </select>
        <input class="form-control" type="text" name="search" value="<?= $_GET["search"] ?? "" ?>"
            placeholder="Търсене..." />

        <button type="submit" class="text-link">
            Търсене
        </button>
    </div>
</form>