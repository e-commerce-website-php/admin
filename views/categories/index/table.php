<?php require "views/categories/index/functions.php"; ?>

<div class="container mx-auto p-5 rounded shadow secondary overflow-auto">
    <table class="table-bordered">
        <thead>
            <tr>
                <th>Име</th>
                <th>Връзка</th>
                <th>Описание</th>
                <th>Изображение</th>
                <th>Родителска</th>
                <th>Статус</th>
                <th>Опции</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($categories) && count($categories) > 0): ?>
                <?php foreach ($categories as $category): ?>
                    <tr data-category-id="<?= $category["id"] ?>">
                        <td><?= displayColumn("name", $category) ?></td>
                        <td><?= displayColumn("slug", $category) ?></td>
                        <td><?= displayColumn("description", $category) ?></td>
                        <td><?= displayImage($category) ?></td>
                        <td><?= displayParent($category) ?></td>
                        <td><?= displayStatus($category) ?></td>
                        <td>
                            <form action="/categories" method="POST" id="categoryForm">
                                <select onchange="send(event)" name="option" id="option">
                                    <option value="none">Опции</option>
                                    <option value="delete">Изтриване</option>
                                    <option value="edit">Редактиране</option>
                                    <?php if ($category["status"] === "inactive"): ?>
                                        <option value="activate">Активиране</option>
                                    <?php else: ?>
                                        <option value="deactivate">Деактивиране</option>
                                    <?php endif; ?>
                                </select>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="11">Няма намерени резултати.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php if (!empty($categories) && count($categories) > 0 && $total > $limit): ?>
    <?php require "views/helpers/pagination.php"; ?>
<?php endif; ?>

<script>
    function send(event) {
        const selectedValue = event.target.value;
        const id = event.target.closest("tr").getAttribute("data-category-id");

        if (selectedValue === "edit") {
            window.location.href = `/categories/edit?id=${id}`;
        }
        
        if (selectedValue === "delete") {
            if (confirm("<?= LANGUAGE["delete_confirm"] ?>")) {
                deleteItem(id);
            }
        }
        
        event.target.value = "none";
    }

    async function deleteItem(id) {
        const url = `/categories/delete?id=${id}`;
        const response = await fetch(url, { method: "DELETE" });

        if (response.status !== 200) {
            const data = await response.json();
            alert(data.errors);
        }
        
        window.location.reload();
    }
</script>