<?php require "views/users/functions.php"; ?>

<div class="container mx-auto p-5 rounded shadow secondary overflow-auto">
    <table class="table-bordered">
        <thead>
            <tr>
                <th>Имейл</th>
                <th>Име</th>
                <th>Телефон</th>
                <th>Адрес</th>
                <th>Град</th>
                <th>Област</th>
                <th>Пощ. код</th>
                <th>Държава</th>
                <th>Роля</th>
                <th>Дата</th>
                <th>Статус</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($users) > 0): ?>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= htmlspecialchars($user["email"]) ?></td>
                        <td><?= displayFullName($user) ?></td>
                        <td><?= displayPhoneNumber($user); ?></td>
                        <td><?= displayAddress($user); ?></td>
                        <td><?= displayCity($user); ?></td>
                        <td><?= displayState($user); ?></td>
                        <td><?= displayPostalCode($user); ?></td>
                        <td><?= displayCountry($user); ?></td>
                        <td><?= displayRoleAccess($user); ?></td>
                        <td><?= displayCreatedAt($user); ?></td>
                        <td><?= displayStatus($user); ?></td>
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

<?php if (!empty($users) && count($users) > 0 && $total > $limit): ?>
    <?php require "views/helpers/pagination.php"; ?>
<?php endif; ?>
