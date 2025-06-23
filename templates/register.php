<?php if (!empty($_GET['error'])): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($_GET['error']) ?></div>
<?php endif; ?>

<form class="form-signin" method="POST" action="/register/save">
    <img class="mb-4" src="/assets/images/icon.png" alt="Logo" width="72" height="72">
    <h1 class="h3 mb-3 font-weight-normal">Registrieren</h1>
    <input type="text" name="first_name" class="form-control mb-2" placeholder="Vorname" required autofocus>
    <input type="text" name="last_name" class="form-control mb-2" placeholder="Nachname" required>
    <input type="email" name="email" class="form-control mb-2" placeholder="Email address" required>
    <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>
    <button class="btn btn-lg btn-primary btn-block" type="submit">Registrieren</button>
</form>
