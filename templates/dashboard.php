<h2>Willkommen, <?= htmlspecialchars($user['name']) ?>!</h2>
<p class="lead">Dies ist dein persönliches Haushalts-Dashboard.</p>

<div class="row mt-4">
    <div class="col-md-6">
        <a href="/transactions" class="btn btn-primary w-100 mb-2">📄 Buchungen anzeigen</a>
    </div>
    <div class="col-md-6">
        <a href="/transactions/form" class="btn btn-success w-100 mb-2">➕ Neue Buchung</a>
    </div>
</div>

<hr>
<h5>📊 Monatliche Übersicht</h5>
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Jahr</th>
            <th>Monat</th>
            <th>Einnahmen</th>
            <th>Ausgaben</th>
            <th>Saldo</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($monthly as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row['year']) ?></td>
                <td><?= htmlspecialchars($row['month']) ?></td>
                <td><?= number_format((float)$row['income'], 2, ',', '.') ?> €</td>
                <td><?= number_format(abs((float)$row['expense']), 2, ',', '.') ?> €</td>
                <td><?= number_format((float)$row['income'] + (float)$row['expense'], 2, ',', '.') ?> €</td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<hr>
<h5>🔍 Filter & gefilterte Buchungen</h5>

<form method="get" action="/dashboard" class="mb-3">
    <div class="row">
        <div class="col-md-2">
            <label>Jahr</label>
            <input type="number" name="year" value="<?= htmlspecialchars($filters['year'] ?? '') ?>" class="form-control">
        </div>
        <div class="col-md-2">
            <label>Monat</label>
            <input type="number" name="month" value="<?= htmlspecialchars($filters['month'] ?? '') ?>" class="form-control" min="1" max="12">
        </div>
        <div class="col-md-4">
            <label>Kategorie</label>
            <select name="category" class="form-select">
                <option value="">-- Alle --</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat->id ?>" <?= ($filters['category'] ?? '') == $cat->id ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cat->name) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-2">
            <label>Typ</label>
            <select name="type" class="form-select">
                <option value="">-- Alle --</option>
                <option value="income" <?= ($filters['type'] ?? '') === 'income' ? 'selected' : '' ?>>Einnahmen</option>
                <option value="expense" <?= ($filters['type'] ?? '') === 'expense' ? 'selected' : '' ?>>Ausgaben</option>
            </select>
        </div>
        <div class="col-md-2 d-grid align-items-end">
            <button type="submit" class="btn btn-outline-primary">Filtern</button>
        </div>
    </div>
</form>

<?php if (count($filtered)): ?>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Datum</th>
            <th>Betrag</th>
            <th>Kategorie</th>
            <th>Beschreibung</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($filtered as $t): ?>
            <tr>
                <td><?= htmlspecialchars($t['transaction_date']) ?></td>
                <td><?= number_format($t['amount'], 2, ',', '.') ?> €</td>
                <td><?= htmlspecialchars($t['category'] ?? '') ?></td>
                <td><?= htmlspecialchars($t['description'] ?? '') ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p class="text-muted">Keine Einträge gefunden.</p>
<?php endif; ?>

<?php if ($isAdmin): ?>
    <hr>
    <h5>🔐 Adminbereich</h5>
    <p><a href="/admin/statistics">Globale Statistik anzeigen</a></p>
    <p><a href="/admin/users">Benutzerverwaltung</a></p>
    <p><a href="/categories">Kategorien verwalten</a></p>
<?php endif; ?>
