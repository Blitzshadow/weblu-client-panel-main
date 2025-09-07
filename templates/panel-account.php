<div class="dashboard-module">
    <h1>Konto</h1>
    <p>Informacje o koncie użytkownika.</p>
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
