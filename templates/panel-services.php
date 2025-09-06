<?php
// Widok usług klienta
?>
<h2>Moje usługi</h2>
<table class="weblu-table">
    <thead>
        <tr>
            <th>Nazwa usługi</th>
            <th>Status</th>
            <th>Wygasa</th>
            <th>Akcje</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Hosting WordPress</td>
            <td><span class="weblu-status-active">Aktywna</span></td>
            <td>2025-12-31</td>
            <td>
                <button class="weblu-btn">Zarządzaj</button>
                <button class="weblu-btn weblu-btn-secondary">Przedłuż</button>
            </td>
        </tr>
        <tr>
            <td>Strona firmowa</td>
            <td><span class="weblu-status-inactive">Wygasła</span></td>
            <td>2024-06-01</td>
            <td>
                <button class="weblu-btn">Szczegóły</button>
                <button class="weblu-btn weblu-btn-secondary">Odnów</button>
            </td>
        </tr>
    </tbody>
</table>
