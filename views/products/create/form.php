<?php
function getValue(string $key, ?array $array = null, ?string $default = ""): mixed
{
    $array = $array ?? $_POST;
    return !empty($array[$key]) ? $array[$key] : $default;
}
$validationErrors = $_SESSION["errors"] ?? [];
Setup::deleteSessions(["post", "image", "parent_category", "errors", "error", "error_message"]);
?>

<div class="secondary container mx-5 lg:mx-auto mt-5 p-10 border rounded shadow">
    <form id="form" action="/products/create" method="POST" class="mx-auto" enctype="multipart/form-data">

        <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-10">
            <div class="mb-4">
                <label for="name" class="block text-sm font-bold mb-2">Име на продукта: <span
                        class="text-red-500">*</span></label>
                <input type="text" id="name" name="name" value="<?= getValue("name") ?>" required autofocus>

                <?php if (!empty($validationErrors["product_name_validation_error"])): ?>
                    <div class="text-sm text-red-500"><?= $validationErrors["product_name_validation_error"] ?></div>
                <?php endif; ?>
            </div>

            <div class="mb-4">
                <label for="slug" class="block text-sm font-bold mb-2">URL адрес: <span
                        class="text-red-500">*</span></label>
                <input type="text" id="slug" name="slug" value="<?= getValue("slug") ?>" required>
                <div class="text-sm text-gray-600">Напишете URL адресът след домейна, с който искате да се отваря тази
                    категория.</div>

                <?php if (!empty($validationErrors["product_slug_validation_error"])): ?>
                    <div class="text-sm text-red-500"><?= $validationErrors["product_slug_validation_error"] ?></div>
                <?php endif; ?>
            </div>

            <div class="mb-4">
                <label for="status" class="block text-sm font-bold">Статус</label>
                <select name="status" id="status" class="form-control">
                    <option value="publish">Публикуван</option>
                    <option value="draft">Чернова</option>
                    <option value="pending">Изчакване</option>
                    <option value="private">Частен</option>
                </select>
            </div>
        </div>

        <div class="mb-4">
            <label for="short_description" class="block text-sm font-bold mb-2">Кратко описание:</label>
            <textarea id="short_description" name="short_description"
                rows="5"><?= getValue("short_description") ?></textarea>
        </div>

        <div class="mb-4">
            <label for="description" class="block text-sm font-bold mb-2">Описание:</label>
            <textarea id="description" name="description" rows="10"><?= getValue("description") ?></textarea>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
            <div class="mb-4">
                <label for="price" class="block text-sm font-bold mb-2">Цена:</label>
                <input type="text" value="<?= getValue("price") ?>" name="price" id="price">
            </div>

            <div class="mb-4">
                <label for="tax" class="block text-sm font-bold mb-2">Данък в проценти:</label>
                <input type="text" value="<?= getValue("tax") ?>" name="tax" id="tax" min="0" max="100">
            </div>

            <div class="mb-4">
                <label for="sale_price" class="block text-sm font-bold mb-2">Промоционална цена:</label>
                <input type="text" value="<?= getValue("sale_price") ?>" name="sale_price" id="sale_price">
            </div>
        </div>

        <div class="grid sm:grid-cols-2 gap-5">
            <div class="mb-4">
                <label for="show_stock" class="block text-sm font-bold mb-2">Количество:</label>
                <input type="number" value="<?= getValue("show_stock") ?>" name="show_stock" id="show_stock" min="0">
            </div>

            <div class="mb-4">
                <label for="stock_quantity" class="block text-sm font-bold mb-2">Количество на склад:</label>
                <input type="number" value="<?= getValue("stock_quantity") ?>" name="stock_quantity" id="stock_quantity"
                    min="0">
            </div>
        </div>

        <div class="mb-4">
            <label for="sku" class="block text-sm font-bold mb-2">Уникален номер:</label>
            <input type="text" value="<?= getValue("sku") ?>" name="sku" id="sku">

            <?php if (!empty($validationErrors["product_sku_validation_error"])): ?>
                <div class="text-sm text-red-500"><?= $validationErrors["product_sku_validation_error"] ?></div>
            <?php endif; ?>
        </div>

        <div class="mb-4">
            <label for="seo_title" class="block text-sm font-bold mb-2">SEO заглавие:</label>
            <input type="text" id="seo_title" name="seo_title" value="<?= getValue("seo_title") ?>">

            <?php if (!empty($validationErrors["meta_title_validation_error"])): ?>
                <div class="text-sm text-red-500"><?= $validationErrors["meta_title_validation_error"] ?></div>
            <?php endif; ?>
        </div>

        <div class="mb-4">
            <label for="seo_description" class="block text-sm font-bold mb-2">SEO описание:</label>
            <textarea id="seo_description" name="seo_description" rows="5"><?= getValue("seo_description") ?></textarea>

            <?php if (!empty($validationErrors["meta_description_validation_error"])): ?>
                <div class="text-sm text-red-500"><?= $validationErrors["meta_description_validation_error"] ?></div>
            <?php endif; ?>
        </div>

        <div class="mb-4">
            <label for="seo_keywords" class="block text-sm font-bold mb-2">SEO ключови думи:</label>
            <input type="text" id="seo_keywords" name="seo_keywords" value="<?= getValue("seo_keywords") ?>"
                placeholder="Напишете ключови думи, разделени със запетая и интервал.">
        </div>

        <?php require "image.php"; ?>
        
        <?php require "additional-images.php"; ?>

        <input type="text" name="secure_token" value="<?= $_SESSION["secure_token"] ?? "" ?>" hidden>

        <div class="mt-5">
            <button type="submit" class="button primary">
                Създаване
            </button>
        </div>
    </form>
</div>