<nav class="h-[60px] flex items-center justify-center shadow">
    <ul>
        <?php if (!empty($user)): ?>
            <li>
                <a href="/">Табло</a>
            </li>
            <li>
                <a href="/users">Потребители</a>
            </li>
            <li>
                <a href="/auth/logout?_method=DELETE">Изход</a>
            </li>
        <?php else: ?>
            <li>
                <a href="/auth/login">Вход</a>
            </li>
        <?php endif; ?>
    </ul>
</nav>
