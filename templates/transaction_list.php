<h2>Buchungen</h2>
<a href="/transactions/form" class="btn btn-success mb-3">Neue Buchung</a>
<table class="table table-bordered">
    <thead>
    <tr>
        <th>Datum</th>
        <th>Betrag</th>
        <th>Kategorie</th>
        <th>Beschreibung</th>
        <th>Aktionen</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($transactions as $trans): ?>
        <tr>
            <td><?= htmlspecialchars($trans['transaction_date']) ?></td>
            <td><?= htmlspecialchars($trans['amount']) ?></td>
            <td><?= htmlspecialchars($trans['category'] ?? '') ?></td>
            <td><?= htmlspecialchars($trans['description']) ?></td>
            <td>
                <a class="btn btn-sm btn-primary" href="/transactions/form?id=<?= $trans['id'] ?>">Bearbeiten</a>
                <a class="btn btn-sm btn-danger" href="/transactions/delete?id=<?= $trans['id'] ?>" onclick="return confirm('Wirklich löschen?');">Löschen</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
