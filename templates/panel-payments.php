<?php
// Widok faktur/płatności
?>
<h2>Faktury i płatności</h2>
<table class="weblu-table">
    <thead>
        <tr>
            <th>Numer</th>
            <th>Data</th>
            <th>Kwota</th>
            <th>Status</th>
            <th>Akcje</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>FV/2025/09/001</td>
            <td>2025-09-01</td>
            <td>299,00 zł</td>
            <td><span class="weblu-status-paid">Opłacona</span></td>
            <td><button class="weblu-btn">Pobierz PDF</button></td>
        </tr>
        <tr>
            <td>FV/2025/08/002</td>
            <td>2025-08-01</td>
            <td>299,00 zł</td>
            <td><span class="weblu-status-unpaid">Nieopłacona</span></td>
            <td><button class="weblu-btn">Opłać</button></td>
        </tr>
    </tbody>
</table>
