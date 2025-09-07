<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Konto</h4>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><strong>Email:</strong> <?php echo esc_html($user->user_email ?? ''); ?></li>
                    <li class="list-group-item"><strong>Login:</strong> <?php echo esc_html($user->user_login ?? ''); ?></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php
// Widok i edycja profilu
?>
<h2>Dane kontaktowe</h2>
<form class="weblu-form" method="post" action="">
    <label>Email:<br>
        <input type="email" name="email" value="<?php echo esc_attr($account['email']); ?>" required>
    </label><br>
    <label>Telefon:<br>
        <input type="text" name="phone" value="<?php echo esc_attr($account['phone']); ?>" pattern="[0-9+\- ]{7,}" required>
    </label><br>
    <button class="weblu-btn" type="submit">Zapisz zmiany</button>
</form>
