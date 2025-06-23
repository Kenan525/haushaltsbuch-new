<h2 class="mb-4 text-center">👤 Mein Profil</h2>

<?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<div class="profile-card mx-auto mt-4" style="max-width:700px;">
    <form method="post" action="/profile/update" enctype="multipart/form-data" id="profileForm">
        <div class="row align-items-center">
            <div class="col-md-4 text-center mb-4 mb-md-0">
                <img id="avatarPreview" src="<?= htmlspecialchars($user['image'] ?? '/assets/images/default-avatar.png') ?>"
                     class="rounded-circle avatar-lg"
                     alt="Profilbild">

                <div class="mt-3">
                    <label for="avatarInput" class="form-label d-block small text-muted">📷 Neues Bild auswählen</label>
                    <input type="file" class="form-control" name="avatar" id="avatarInput" accept="image/*">
                </div>
            </div>

            <div class="col-md-8">
                <div class="row mb-3">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <label for="firstNameInput" class="form-label">Vorname</label>
                        <input type="text" id="firstNameInput" name="first_name" class="form-control"
                               value="<?= htmlspecialchars($user['first_name'] ?? '') ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="lastNameInput" class="form-label">Nachname</label>
                        <input type="text" id="lastNameInput" name="last_name" class="form-control"
                               value="<?= htmlspecialchars($user['last_name'] ?? '') ?>" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="emailInput" class="form-label">E-Mail</label>
                    <input type="email" id="emailInput" class="form-control" value="<?= htmlspecialchars($user['email'] ?? '') ?>" readonly>
                </div>
                <input type="hidden" name="token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
                <button type="submit" class="btn btn-primary w-100">💾 Änderungen speichern</button>
            </div>
        </div>
    </form>
</div>
