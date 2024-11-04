<?php require "views/products/index/functions.php"; ?>

<div class="container mx-auto p-5 rounded shadow secondary overflow-auto">
    <table class="table-bordered">
        <thead>
            <tr>
                <th>Номер</th>
                <th>Име</th>
                <th>Предна снимка</th>
                <th>Цена</th>
                <th>Пр. цена</th>
                <th>Данък</th>
                <th>Категория</th>
                <th>Статус</th>
                <th>Опции</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($products) && count($products) > 0): ?>
                <?php foreach ($products as $product): ?>
                    <tr data-product-id="<?= $product["id"] ?>">
                        <td><?= displayColumn("name", $product) ?></td>
                        <td><?= displayColumn("slug", $product) ?></td>
                        <td><?= displayImage($product) ?></td>
                        <td><?= displayPrice($product) ?></td>
                        <td><?= displayPrice($product) ?></td>
                        <td><?= displayTax($product) ?></td>
                        <td><?= displayCategory($product) ?></td>
                        <td><?= displayStatus($product) ?></td>
                        <td>
                            <form action="/products" method="POST" id="productForm">
                                <select onchange="send(event)" name="option" id="option">
                                    <option value="none">Опции</option>
                                    <option value="delete">Изтриване</option>
                                    <option value="edit">Редактиране</option>
                                    <?php if ($product["status"] === "inactive"): ?>
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

<?php if (!empty($products) && count($products) > 0 && $total > $limit): ?>
    <?php require "views/helpers/pagination.php"; ?>
<?php endif; ?>

<script>
    function send(event) {
        const selectedValue = event.target.value;
        const id = event.target.closest("tr").getAttribute("data-product-id");

        if (selectedValue === "edit") {
            window.location.href = `/products/edit?id=${id}`;
        }
        
        if (selectedValue === "delete") {
            if (confirm("<?= LANGUAGE["delete_confirm"] ?>")) {
                deleteItem(id);
            }
        }
        
        event.target.value = "none";
    }

    async function deleteItem(id) {
        const url = `/products/delete?id=${id}`;
        const response = await fetch(url, { method: "DELETE" });

        if (response.status !== 200) {
            const data = await response.json();
            alert(data.errors);
        }
        
        window.location.reload();
    }
</script>