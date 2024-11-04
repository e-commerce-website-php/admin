<div class="mb-4">
    <label for="additional_images" class="block text-sm font-bold mb-2">Допълнителни картинки</label>
    <input type="file" name="additional_images[]" id="additional_images" accept="image/png,image/jpeg" onchange="previewImages(event)" multiple>

    <?php if (isset($product["additional_images"]) && is_array($product["additional_images"])): ?>
        <div class="mt-5">
            <div>Допълнителни картинки</div>
            <div class="flex flex-wrap gap-4">
                <?php foreach ($product["additional_images"] as $additionalImage): ?>
                    <?php if ($additionalImage): ?>
                        <img class="w-[180px] h-[180px] object-cover" decoding="async" src="/<?= $additionalImage ?>" width="180" height="180" class="rounded custom-border shadow">
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <div class="flex gap-5 mt-5" id="preview"></div>
    <div class="loader" id="loader">Зареждане на изображения...</div>
</div>

<script>
    function previewImages() {
        const previewContainer = document.getElementById('preview');
        previewContainer.innerHTML = '';
        loader.style.display = 'flex';

        const files = event.target.files;
        let loadedImages = 0;

        for (let i = 0; i < files.length; i++) {
            const file = files[i];

            if (file.type.startsWith('image/')) {
                const reader = new FileReader();

                reader.onload = function (e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.width = 360;
                    img.height = 360;
                    img.classList.add("w-[180px]", "h-[180px]", "object-cover");
                    previewContainer.appendChild(img);

                    loadedImages++;

                    if (loadedImages === files.length) {
                        loader.style.display = 'none';
                    }
                };

                reader.readAsDataURL(file);
            } else {
                alert("<?= LANGUAGE["inavlid_image_type_message"] ?>");
                loader.style.display = 'none';
            }
        }
    }
</script>
