<h2><?= isset($category) ? 'Kategorie bearbeiten' : 'Kategorie erstellen' ?></h2>
<form method="post" action="/categories/save">
    <input type="hidden" name="id" value="<?= htmlspecialchars($category->id ?? '') ?>">
    <div class="mb-3">
        <label class="form-label">Name</label>
        <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($category->name ?? '') ?>" required>
    </div>
    <input type="hidden" name="token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
    <button type="submit" class="btn btn-primary">Speichern</button>
    <a href="/categories" class="btn btn-secondary">Abbrechen</a>
</form>

