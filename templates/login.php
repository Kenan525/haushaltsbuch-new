<?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form class="form-signin" method="POST" action="/login">
    <img class="mb-4" src="/assets/images/icon.png" alt="Logo" width="72" height="72">
    <h1 class="h3 mb-3 font-weight-normal">Bitte einloggen</h1>
    <label for="inputEmail" class="sr-only">Email address</label>
    <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
    <label for="inputPassword" class="sr-only">Password</label>
    <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
    <?php if (!empty($csrf_token)): ?>
        <input type="hidden" name="token" value="<?= htmlspecialchars($csrf_token) ?>">
    <?php endif; ?>
    <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
</form>
