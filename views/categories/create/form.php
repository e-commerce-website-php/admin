<?php
function getValue(string $key, ?array $array = null, ?string $default = ""): mixed
{
    $array = $array ?? $_POST;
    return !empty($array[$key]) ? $array[$key] : $default;
}
    $validationErrors = $_SESSION["errors"] ?? [];
    Setup::deleteSessions(["post", "image", "parent_category", "errors", "error", "error_message"]);
?>

<div class="secondary container mx-5 lg:mx-auto mt-5 p-10 lg:p-10 border rounded shadow">
    <form id="form" action="/categories/create" method="POST" class="mx-auto" enctype="multipart/form-data">

        <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-10">
            <div class="mb-4">
                <label for="name" class="block text-sm font-bold mb-2">Име на категорията: <span
                        class="text-red-500">*</span></label>
                <input type="text" id="name" name="name" value="<?= getValue("name") ?>" required autofocus>
                
                <?php if (!empty($validationErrors["category_name_validation_error"])): ?>
                    <div class="text-sm text-red-500"><?= $validationErrors["category_name_validation_error"] ?></div>
                <?php endif; ?>
            </div>

            <div class="mb-4">
                <label for="slug" class="block text-sm font-bold mb-2">URL адрес: <span
                        class="text-red-500">*</span></label>
                <input type="text" id="slug" name="slug" value="<?= getValue("slug") ?>" required>
                <div class="text-sm text-gray-600">Напишете URL адресът след домейна, с който искате да се отваря тази категория.</div>

                <?php if (!empty($validationErrors["category_slug_validation_error"])): ?>
                    <div class="text-sm text-red-500"><?= $validationErrors["category_slug_validation_error"] ?></div>
                <?php endif; ?>
            </div>

            <div class="mb-4">
                <label for="status" class="block text-sm font-bold">Статус</label>
                <select name="status" id="status" class="form-control">
                    <option value="active">Активна</option>
                    <option value="inactive">Неактивна</option>
                </select>
            </div>
        </div>

        <div class="mb-4">
            <label for="description" class="block text-sm font-bold mb-2">Описание:</label>
            <textarea id="description" name="description" rows="5"><?= getValue("description") ?></textarea>
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

        <div class="mb-4">
            <label for="image">Картинка</label>
            <input type="file" name="image" id="image" accept="image/png,image/jpeg" onchange="onUpload(event)">
            <img id="imagePreview" width="360" height="360" style="display: none;" class="mt-5 rounded custom-border shadow">
        </div>

        <input type="text" name="secure_token" value="<?= $_SESSION["secure_token"] ?? "" ?>" hidden>

        <div class="mt-5">
            <button type="submit" class="button primary">
                Създаване
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
