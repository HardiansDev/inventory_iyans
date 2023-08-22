@extends('layouts.master')
@section('title')
    <title>Aplikasi Inventory | PIC</title>
@endsection

@section('content')
    <section class="content-header">
        <h1>
            Management PIC
            <small>Gudangku </small>
        </h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Data PIC</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <form role="form" action="/pic/simpan" method="POST">
                                        @csrf
                                        <div class="input-group">
                                            <input type="text"
                                                class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                                name="name" placeholder="Input PIC Disini.." id="name" required>
                                            <span class="input-group-btn">
                                                <button class="btn btn-info btn-flat">Tambah PIC</button>
                                            </span>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <form action="{{ route('pic.index') }}" method="GET">
                                        <div class="input-group">
                                            <input type="search" class="form-control" name="search"
                                                placeholder="Cari Disini" id="search" value="{{ $search }}"
                                                autofocus>
                                            <span class="input-group-btn">
                                                <button type="submit" class="btn btn-warning btn-flat">Cari</button>
                                            </span>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <p></p>
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama PIC</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @forelse ($pics as $index => $item)
                                    <tr>
                                        <td> {{ $index + $pics->firstItem() }} </td>
                                        <td>{{ $item->name }}</td>
                                        <td>
                                            <a href="{{ route('pic.edit', ['id' => $item->id ]) }}" class="btn btn-warning btn-sm">Edit</a>
                                            <a href="#" class="btn btn-danger btn-sm deletepic"
                                                data-idpic="{{ $item->id }}"
                                                data-namapic="{{ $item->name }}">Hapus</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Sayang Banget Data nya Gaada</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{-- {{ $categories->links() }} --}}
                        {!! $pics->appends(Request::except('page'))->render() !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
