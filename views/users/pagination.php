<nav class="container mx-auto mt-5 text-center rounded shadow">
    <ul class="pagination flex items-center justify-center">
        <?php
        $totalPages = ceil($total / ($limit ?? SETTINGS["pagination_items_count"]));
        $start = max(1, $page - 3);
        $end = min($totalPages, $page + 3);
        ?>

        <?php if ($page > 1): ?>
            <li><a href="?<?= http_build_query(array_merge($_GET, ["page" => $page - 1])) ?>">Предишна</a></li>
        <?php endif; ?>

        <?php if ($start > 1): ?>
            <li><a href="?page=1">1</a></li>
            <?php if ($start > 2): ?>
                <li><span>...</span></li>
            <?php endif; ?>
        <?php endif; ?>

        <?php for ($i = $start; $i <= $end; $i++): ?>
            <li <?= $page == $i ? ' class="active"' : '' ?>>
                <a href="?<?= http_build_query(array_merge($_GET, ["page" => $i])) ?>"><?= $i ?></a>
            </li>
        <?php endfor; ?>

        <?php if ($end < $totalPages): ?>
            <?php if ($end < $totalPages - 1): ?>
                <li><span>...</span></li>
            <?php endif; ?>
            <li><a href="?<?= http_build_query(array_merge($_GET, ["page" => $totalPages])) ?>"><?= $totalPages ?></a></li>
        <?php endif; ?>

        <?php if ($page < $totalPages): ?>
            <li><a href="?<?= http_build_query(array_merge($_GET, ["page" => $page + 1])) ?>">Следваща</a></li>
        <?php endif; ?>
    </ul>
</nav>