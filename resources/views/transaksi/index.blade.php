@extends('admin.index')
@section('content')
<section class="section schedule text-black">
    <div class="container">
        <div class="row">
            
            <div class="col-12">
                <div class="section-title">
                    <br>
                    <h3 class="m-0 font-weight-bold text-primary">Data Transaksi</h3><br>
                        <a href="{{ route('transaksi.create') }}">
                   <button type="button" class="btn btn-primary bi-plus btn-sm" title="Tambah Transaksi"></button></a>&nbsp;
                   <a href="{{ url('transaksi-pdf')}}">
                   <button type="button" class="btn btn-danger bi-file-earmark-pdf btn-sm" title="Export PDF"></button></a>&nbsp;
                   <a href="{{ url('transaksi-excel')}}">
                   <button type="button" class="btn btn-success bi-file-earmark-excel btn-sm" title="Export Excel"></button></a>
                    <br><br>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama Customer</th>
                            <th scope="col">Jenis Laundry</th>
                            <th scope="col">Berat</th>
                            <th scope="col">Tanggal Awal</th>
                            <th scope="col">Tanggal Ambil</th>
                            <th scope="col">Total Bayar</th>
                            <th scope="col">Nama Karyawan</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                         @php $no = 1; @endphp
                        @foreach($transaksi as $row)
                        <tr>
                        <th scope="row">{{$no++}}</th>
                        <td>{{ $row->customer->nama_customer }}</td>
                        <td>{{ $row->jenis->jenis_laundry }}</td>
                        <td>{{ $row->berat }}&nbsp;Kg</td>
                        <td>{{ $row->tgl_awal }}</td>
                        <td>{{ $row->tgl_ambil }}</td>
                        <td>Rp. {{number_format($row['total_bayar'], 2,',','.')}}</td>
                        <td>{{ $row->karyawan->nama_karyawan }}</td>
                        <td>
                            <form method="POST" action="{{ route('transaksi.destroy',$row->idtransaksi) }}">
                                @csrf
                                @method('DELETE')
                        
                        <a class="btn btn-info btn-sm" title="Detail" href=" {{ route('transaksi.show',$row->idtransaksi) }}"> <i class="bi bi-printer"></i></a>

                        <a class="btn btn-warning btn-sm" title="Edit" href="{{ url('transaksi-edit',$row->idtransaksi) }}"><i class="bi bi-pencil-square"></i></a>

                        <button type="submit" class="btn btn-danger btn-sm" title="Hapus Transaksi"
                                    onclick="return confirm('Yakin ingin menghapus data ?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection
