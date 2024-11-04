<div class="mb-4">
    <label for="additional_images" class="block text-sm font-bold mb-2">Допълнителни картинки</label>
    <input type="file" name="additional_images[]" id="additional_images" accept="image/png,image/jpeg"
        onchange="previewImages(event)" multiple>
    <div class="flex gap-5" id="preview"></div>
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
                    img.classList.add('mt-5', 'rounded', 'custom-border', 'shadow', "w-[360px]", "h-[360px]", "object-cover");
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