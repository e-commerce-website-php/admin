<nav class="h-[60px] flex items-center justify-center shadow">
    <ul>
        <?php if (!empty($user)): ?>
            <li>
                <a href="/" class="<?= $_SERVER["REQUEST_URI"] === "/" ? "active" : "" ?>">Табло</a>
            </li>
            <li>
                <a href="/users" class="<?= $_SERVER["REQUEST_URI"] === "/users" ? "active" : "" ?>">Потребители</a>
            </li>
            <li>
                <a href="/products" class="<?= str_starts_with($_SERVER["REQUEST_URI"], "/products") ? "active" : "" ?>">Продукти</a>
            </li>
            <li>
                <a href="/categories" class="<?= str_starts_with($_SERVER["REQUEST_URI"], "/categories") ? "active" : "" ?>">Категории</a>
            </li>
            <li>
                <a href="/auth/logout?_method=DELETE">Изход</a>
            </li>
        <?php else: ?>
            <li>
                <a href="/auth/login" class="<?= $_SERVER["REQUEST_URI"] === "/auth/login" ? "active" : "" ?>">Вход</a>
            </li>
        <?php endif; ?>
    </ul>
</nav>
