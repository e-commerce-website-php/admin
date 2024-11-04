<div class="mb-4">
    <label for="image" class="block text-sm font-bold mb-2">Картинка</label>
    <input type="file" name="image" id="image" accept="image/png,image/jpeg" onchange="onUpload(event)">
    <img id="imagePreview" width="360" height="360" style="display: none;" class="mt-5 rounded custom-border shadow">
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
        reader.onload = function (e) {
            const img = document.getElementById('imagePreview');
            img.src = e.target.result;
            img.style.display = 'block';
        }
        reader.readAsDataURL(file);
    }
</script>
