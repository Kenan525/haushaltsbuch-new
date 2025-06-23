<h2><?= isset($transaction) ? 'Buchung bearbeiten' : 'Buchung erstellen' ?></h2>

<form method="post" action="/transactions/save">
    <input type="hidden" name="id" value="<?= htmlspecialchars($transaction->id ?? '') ?>">

    <div class="mb-3">
        <label class="form-label">Datum</label>
        <input type="date" name="transaction_date" class="form-control"
               value="<?= htmlspecialchars($transaction->transactionDate ?? date('Y-m-d')) ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Betrag</label>
        <input type="number" step="0.01" name="amount" class="form-control"
               value="<?= htmlspecialchars($transaction->amount ?? '0.00') ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Kategorien</label>
        <select name="categories[]" class="form-select" multiple size="5">
            <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat->id ?>"
                    <?= (isset($selectedCategories) && in_array($cat->id, $selectedCategories)) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($cat->name) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <small class="text-muted">Mehrere Kategorien mit STRG / CMD wählen.</small>
    </div>

    <div class="mb-3">
        <label class="form-label">Beschreibung</label>
        <textarea name="description" class="form-control"><?= htmlspecialchars($transaction->description ?? '') ?></textarea>
    </div>
    <input type="hidden" name="token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">

    <button type="submit" class="btn btn-primary">Speichern</button>
    <a href="/transactions" class="btn btn-secondary">Abbrechen</a>
</form>
