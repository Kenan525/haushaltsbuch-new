<h2>Benutzerverwaltung</h2>
<table class="table table-bordered">
    <thead>
    <tr>
        <th>ID</th>
        <th>Email</th>
        <th>Name</th>
        <th>Rolle</th>
        <th>Status</th>
        <th>Aktionen</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($users as $u): ?>
        <tr>
            <td><?= htmlspecialchars($u->id) ?></td>
            <td><?= htmlspecialchars($u->email) ?></td>
            <td><?= htmlspecialchars($u->getFullName()) ?></td>
            <td><?= htmlspecialchars($u->role) ?></td>
            <td><?= $u->isActive ? 'aktiv' : 'inaktiv' ?></td>
            <td>
                <a class="btn btn-sm btn-warning" href="/admin/users/toggle?id=<?= $u->id ?>">
                    <?= $u->isActive ? 'Deaktivieren' : 'Aktivieren' ?>
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
