<h2>📊 Globale Statistik</h2>

<div class="row mt-4">
    <div class="col-md-6">
        <ul class="list-group">
            <li class="list-group-item">👥 Registrierte Benutzer: <strong><?= $totalUsers ?></strong></li>
            <li class="list-group-item">🧾 Buchungen gesamt: <strong><?= $stat['total_transactions'] ?></strong></li>
            <li class="list-group-item">💰 Einnahmen: <strong><?= number_format((float)$stat['total_income'], 2, ',', '.') ?> €</strong></li>
            <li class="list-group-item">💸 Ausgaben: <strong><?= number_format(abs((float)$stat['total_expense']), 2, ',', '.') ?> €</strong></li>
            <li class="list-group-item">📈 Gesamtsumme: <strong><?= number_format((float)$stat['total_amount'], 2, ',', '.') ?> €</strong></li>
            <li class="list-group-item">📉 Durchschnitt je Buchung: <strong><?= number_format((float)$stat['avg_transaction'], 2, ',', '.') ?> €</strong></li>
        </ul>
    </div>

    <div class="col-md-6">
        <h5>Buchungen pro Kategorie</h5>
        <ul class="list-group">
            <?php foreach ($categoryStats as $cat): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <?= htmlspecialchars($cat['name']) ?>
                    <span class="badge bg-primary rounded-pill"><?= $cat['count'] ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
