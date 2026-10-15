<table class="table">
    <thead>
        <tr>
            <th>#</th>
            <th>NIK</th>
            <th>Nama</th>
            <th>Nomor Telepon</th>
            <th>Jabatan</th>
            <th>Tanggal Daftar</th>
            <th>Home Base</th>
            <th>Status</th>
        </tr>
    </thead>
    @php
        $no = 1;
    @endphp
    @if(!empty($anggota))
        <tbody>
            @foreach ($anggota as $row)                            
                <tr>
                    <th scope="row">{{ $no }}</th>
                    <td>{{ $row->nik }}</td>
                    <td>{{ $row->nama }}</td>
                    <td>{{ $row->no_telepon }}</td>
                    <td>{{ $row->jabatan }}</td>
                    <td>{{ date('d-m-Y', strtotime($row->tgl_daftar)) }}</td>
                    <td>{{ $row->homebase }}</td>
                    <td>
                        @if($row->status == '1')
                            {{ 'Aktif' }}
                        @else
                            {{ 'Non Aktif' }}
                        @endif
                    </td>
                </tr>
                @php
                    $no++;
                @endphp
            @endforeach
        </tbody>
    @endif                
</table>