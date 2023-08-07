<table>
    <tr>
        <td style="vertical-align: sub;height:25px;font-size:16px;font-weight:bold;" colspan="16">LogBook Report</td>
    </tr>
    <tr></tr>
    <tr>
        <th style="width:30px;background: #e9e9e9;font-weight: bold;font-size:13px;">LogBook ID</th>
        <th style="width:20px;background: #e9e9e9;font-weight: bold;font-size:13px;">Name</th>
        <th style="width:20px;background: #e9e9e9;font-weight: bold;font-size:13px;">Email</th>
        <th style="width:20px;background: #e9e9e9;font-weight: bold;font-size:13px;">Phone</th>
        <th style="width:20px;background: #e9e9e9;font-weight: bold;font-size:13px;">Visit Division</th>
        <th style="width:20px;background: #e9e9e9;font-weight: bold;font-size:13px;">Division Visitee</th>
        <th style="width:30px;background: #e9e9e9;font-weight: bold;font-size:13px;">Tujuan Kunjungan</th>
        <th style="width:30px;background: #e9e9e9;font-weight: bold;font-size:13px;">Relation Type</th>
        <th style="width:25px;background: #e9e9e9;font-weight: bold;font-size:13px;">Jam</th>
    </tr>

    @foreach($logs as $logbooks)
    <tr>
        <td style="word-wrap: break-word;text-align:left;">{{ $logbooks->id }}</td>
        <td style="word-wrap: break-word;text-align:left;">{{ $logbooks->name }}</td>
        <td style="word-wrap: break-word;text-align:left;">{{ $logbooks->email }}</td>
        <td style="word-wrap: break-word;text-align:left;">{{ $logbooks->no_telp }}</td>
        <td style="word-wrap: break-word;text-align:left;">{{ $logbooks->visitdivisi->name }}</td>
        <td style="word-wrap: break-word;text-align:left;">{{ $logbooks->division_visitee }}</td>
        <td style="word-wrap: break-word;text-align:left;">{{ $logbooks->tujuan_kunjungan }}</td>
        <td style="word-wrap: break-word;text-align:left;">{{ $logbooks->relation_type }}</td>
        <td style="word-wrap: break-word;text-align:left;">{{ $logbooks->jam }}</td>
    </tr>
    @endforeach
</table>