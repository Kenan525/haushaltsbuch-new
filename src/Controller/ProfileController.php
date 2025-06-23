<?php
declare(strict_types=1);

namespace Src\Controller;

use Src\Service\ProfileService;

class ProfileController extends AbstractController
{
    private ProfileService $profileService;
    public function __construct()
    {
        $this->profileService = new ProfileService();
        parent::__construct();
    }

    public function show(): void
    {
        $user = $this->auth->user();
        $this->view->render('profile', [
            'user' => $user,
            //'csrf_token' => \Csrf::getToken()
            'isLoggedIn' => $this->auth->check(),
        ]);
    }

    public function update(): void
    {
        $user = $this->auth->user();
        if (!$user) {
            header('Location: /login');
            exit;
        }

        // CSRF prüfen
        /*if (!\Csrf::validate($_POST['token'] ?? null)) {
            $this->view->render('user/profile', [
                'user' => $user,
                'error' => 'Ungültiges Token!',
                'csrf_token' => \Csrf::getToken()
            ]);
            return;
        }*/

        $first = $_POST['first_name'] ?? '';
        $last = $_POST['last_name'] ?? '';
        $imagePath = $user['image'] ?? '/assets/images/default-avatar.png';

        // Avatar upload
        if (!empty($_FILES['avatar']['tmp_name'])) {
            $ext = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
            $filename = 'avatar_' . $user['id'] . '.' . $ext;
            $destination = __DIR__ . '/../../public/assets/images/avatars/' . $filename;
            if (!is_dir(dirname($destination)) && !mkdir($concurrentDirectory = dirname($destination), 0777, true) && !is_dir($concurrentDirectory)) {
                throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
            }
            move_uploaded_file($_FILES['avatar']['tmp_name'], $destination);
            $imagePath = '/assets/images/avatars/' . $filename;
        }

        $this->profileService->updateProfile($user['id'], $first, $last, $imagePath);

        // Session-Update (optional: reload session user from DB)
        $_SESSION['user']['first_name'] = $first;
        $_SESSION['user']['last_name'] = $last;
        $_SESSION['user']['name'] = $first . ' ' . $last;
        $_SESSION['user']['image'] = $imagePath;

        header('Location: /profile');
        exit;
    }
}
