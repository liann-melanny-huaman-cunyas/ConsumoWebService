<table>
    <thead>
        <tr>
            <th>Moneda</th>
            <th>Tasa de Cambio</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($monedasFiltradas as $moneda => $tasa)
            <tr>
                <td>{{ $moneda }}</td>
                <td>{{ $tasa }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
