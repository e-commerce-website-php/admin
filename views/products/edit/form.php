<?php
function getValue(string $key, ?array $array = null, ?string $default = ""): mixed
{
    $array = $array ?? $_POST;
    return !empty($array[$key]) ? $array[$key] : $default;
}
    $validationErrors = $_SESSION["errors"] ?? [];
    Setup::deleteSessions(["post", "image", "errors", "error", "error_message"]);
?>

<div class="secondary container mx-5 lg:mx-auto mt-5 p-10 lg:p-10 border rounded shadow">
    <form id="form" action="/products/edit?id=<?= $_GET["id"] ?>" method="POST" class="mx-auto" enctype="multipart/form-data">

    <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-10">
            <div class="mb-4">
                <label for="name" class="block text-sm font-bold mb-2">Име на продукта: <span
                        class="text-red-500">*</span></label>
                <input type="text" id="name" name="name" value="<?= getValue("name", $product) ?>" required autofocus>

                <?php if (!empty($validationErrors["product_name_validation_error"])): ?>
                    <div class="text-sm text-red-500"><?= $validationErrors["product_name_validation_error"] ?></div>
                <?php endif; ?>
            </div>

            <div class="mb-4">
                <label for="slug" class="block text-sm font-bold mb-2">URL адрес: <span
                        class="text-red-500">*</span></label>
                <input type="text" id="slug" name="slug" value="<?= getValue("slug", $product) ?>" required>
                <div class="text-sm text-gray-600">Напишете URL адресът след домейна, с който искате да се отваря тази
                    категория.</div>

                <?php if (!empty($validationErrors["product_slug_validation_error"])): ?>
                    <div class="text-sm text-red-500"><?= $validationErrors["product_slug_validation_error"] ?></div>
                <?php endif; ?>
            </div>

            <div class="mb-4">
                <label for="status" class="block text-sm font-bold">Статус</label>
                <select name="status" id="status" class="form-control">
                    <option <?= $product["status"] === "publish" ? "selected" : "" ?> value="publish">Публикуван</option>
                    <option <?= $product["status"] === "draft" ? "selected" : "" ?> value="draft">Чернова</option>
                    <option <?= $product["status"] === "pending" ? "selected" : "" ?> value="pending">Изчакване</option>
                    <option <?= $product["status"] === "private" ? "selected" : "" ?> value="private">Частен</option>
                </select>
            </div>
        </div>

        <div class="mb-4">
            <label for="short_description" class="block text-sm font-bold mb-2">Кратко описание:</label>
            <textarea id="short_description" name="short_description"
                rows="5"><?= getValue("short_description", $product) ?></textarea>
        </div>

        <div class="mb-4">
            <label for="description" class="block text-sm font-bold mb-2">Описание:</label>
            <textarea id="description" name="description" rows="10"><?= getValue("description", $product) ?></textarea>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
            <div class="mb-4">
                <label for="price" class="block text-sm font-bold mb-2">Цена:</label>
                <input type="text" value="<?= getValue("price", $product) ?>" name="price" id="price">
            </div>

            <div class="mb-4">
                <label for="tax" class="block text-sm font-bold mb-2">Данък в проценти:</label>
                <input type="text" value="<?= getValue("tax", $product) ?>" name="tax" id="tax" min="0" max="100">
            </div>

            <div class="mb-4">
                <label for="sale_price" class="block text-sm font-bold mb-2">Промоционална цена:</label>
                <input type="text" value="<?= getValue("sale_price", $product) ?>" name="sale_price" id="sale_price">
            </div>
        </div>

        <div class="grid sm:grid-cols-2 gap-5">
            <div class="mb-4">
                <label for="show_stock" class="block text-sm font-bold mb-2">Количество:</label>
                <input type="number" value="<?= getValue("show_stock", $product) ?>" name="show_stock" id="show_stock" min="0">
            </div>

            <div class="mb-4">
                <label for="stock_quantity" class="block text-sm font-bold mb-2">Количество на склад:</label>
                <input type="number" value="<?= getValue("stock_quantity", $product) ?>" name="stock_quantity" id="stock_quantity"
                    min="0">
            </div>
        </div>

        <div class="mb-4">
            <label for="sku" class="block text-sm font-bold mb-2">Уникален номер:</label>
            <input type="text" value="<?= getValue("sku", $product) ?>" name="sku" id="sku">

            <?php if (!empty($validationErrors["product_sku_validation_error"])): ?>
                <div class="text-sm text-red-500"><?= $validationErrors["product_sku_validation_error"] ?></div>
            <?php endif; ?>
        </div>

        <div class="mb-4">
            <label for="seo_title" class="block text-sm font-bold mb-2">SEO заглавие:</label>
            <input type="text" id="seo_title" name="seo_title" value="<?= getValue("seo_title", $product) ?>">

            <?php if (!empty($validationErrors["meta_title_validation_error"])): ?>
                <div class="text-sm text-red-500"><?= $validationErrors["meta_title_validation_error"] ?></div>
            <?php endif; ?>
        </div>

        <div class="mb-4">
            <label for="seo_description" class="block text-sm font-bold mb-2">SEO описание:</label>
            <textarea id="seo_description" name="seo_description" rows="5"><?= getValue("seo_description", $product) ?></textarea>

            <?php if (!empty($validationErrors["meta_description_validation_error"])): ?>
                <div class="text-sm text-red-500"><?= $validationErrors["meta_description_validation_error"] ?></div>
            <?php endif; ?>
        </div>

        <div class="mb-4">
            <label for="seo_keywords" class="block text-sm font-bold mb-2">SEO ключови думи:</label>
            <input type="text" id="seo_keywords" name="seo_keywords" value="<?= getValue("seo_keywords", $product) ?>"
                placeholder="Напишете ключови думи, разделени със запетая и интервал.">
        </div>

        <div class="mb-4">
            <label for="image" class="block text-sm font-bold mb-2">Промяна на картинката</label>
            <input type="file" name="image" id="image" accept="image/png,image/jpeg" onchange="onUpload(event)">
            <?php if ($product["image"]): ?>
                <div class="mt-5">
                    <div>Текуща картинка</div>
                    <img class="w-[360px] h-[360px] object-cover" decoding="async" src="/<?= $product["image"] ?>" width="360" height="360" class="rounded custom-border shadow">
                </div>
            <?php endif; ?>
            <img id="imagePreview" width="360" height="360" style="display: none;" class="w-[360px] h-[360px] object-cover mt-5 rounded custom-border shadow">
        </div>
        
        <input type="text" name="secure_token" value="<?= $_SESSION["secure_token"] ?? "" ?>" hidden>

        <div class="mt-5">
            <button type="submit" class="button primary">
                Редактиране
            </button>
        </div>
    </form>
</div>

<script>
    function onUpload(event) {
        const file = event.target.files[0];
        const allowedTypes = ['image/png', 'image/jpeg'];

        if (!file) {
            const img = document.getElementById('imagePreview');
            img.src = "";
            img.style.display = 'none';
        }

        if (!allowedTypes.includes(file.type)) {
            alert('<?= LANGUAGE["inavlid_image_type_message"] ?>');
            document.getElementById("image").value = "";
            return;
        }

        if (file.size > 2 * 1024 * 1024) {
            alert('<?= LANGUAGE["max_image_size_message"] ?>');
            document.getElementById("image").value = "";
            return;
        }

        const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.getElementById('imagePreview');
                img.src = e.target.result;
                img.style.display = 'block';
            }
            reader.readAsDataURL(file);
    }
</script>
