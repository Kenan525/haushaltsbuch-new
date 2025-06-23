<h2>Kategorien</h2>
<a href="/categories/form" class="btn btn-success mb-3">Neue Kategorie</a>
<table class="table table-bordered">
    <thead>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Aktionen</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($categories as $cat): ?>
        <tr>
            <td><?= htmlspecialchars($cat->id) ?></td>
            <td><?= htmlspecialchars($cat->name) ?></td>
            <td>
                <a class="btn btn-sm btn-primary" href="/categories/form?id=<?= $cat->id ?>">Bearbeiten</a>
                <a class="btn btn-sm btn-danger" href="/categories/delete?id=<?= $cat->id ?>" onclick="return confirm('Wirklich löschen?');">Löschen</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
