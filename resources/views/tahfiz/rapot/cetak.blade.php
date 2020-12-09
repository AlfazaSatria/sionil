<!DOCTYPE html>
<html>

<body>
    <table>
        <tr>
            <td style="border: 1px solid black;">
                {{ $tahfiz->nama_tahfiz }}
            </td>
        </tr> 
        @foreach ($nilais as $nilai)
        <tr>
            <td>{{ $nilai->indikator }}</td>
            <td>=</td>
            <td>{{ $nilai->predikat }}</td>    
        </tr> 
        @endforeach
        <tr>
            <td>{{ $nilaiRapot->membaca }}</td>
            <td>{{ $nilaiRapot->mendengarkan }}</td>
            <td>{{ $nilaiRapot->mengikuti }}</td>
            <td>{{ $nilaiRapot->menghafal }}</td>
        </tr>
    </table>
</body>
</html>