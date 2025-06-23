document.addEventListener('DOMContentLoaded', function () {
    const avatarInput = document.getElementById('avatarInput');
    const avatarPreview = document.getElementById('avatarPreview');
    if (avatarInput && avatarPreview) {
        avatarInput.addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = function (event) {
                avatarPreview.src = event.target.result;
            };
            reader.readAsDataURL(file);
        });
    }
});
