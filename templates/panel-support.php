<div class="dashboard-module">
    <h1>Wsparcie</h1>
    <p>Kontakt i zgłoszenia do wsparcia technicznego.</p>
</div>
<?php
// Widok kontaktu z supportem
?>
<h2>Kontakt z supportem</h2>
<form class="weblu-form" method="post" action="">
    <label>Tytuł zgłoszenia:<br>
        <input type="text" name="subject" required>
    </label><br>
    <label>Treść zgłoszenia:<br>
        <textarea name="message" rows="4" required></textarea>
    </label><br>
    <button class="weblu-btn" type="submit">Wyślij zgłoszenie</button>
</form>
<h3>Twoje zgłoszenia</h3>
<table class="weblu-table">
    <thead>
        <tr>
            <th>Tytuł</th>
            <th>Status</th>
            <th>Data</th>
            <th>Akcje</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Problem z fakturą</td>
            <td><span class="weblu-status-open">Otwarte</span></td>
            <td>2025-09-05</td>
            <td><button class="weblu-btn">Szczegóły</button></td>
        </tr>
        <tr>
            <td>Przedłużenie hostingu</td>
            <td><span class="weblu-status-closed">Zamknięte</span></td>
            <td>2025-08-20</td>
            <td><button class="weblu-btn">Szczegóły</button></td>
        </tr>
    </tbody>
</table>
