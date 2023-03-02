@extends('layouts.master')
@section('content')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row align-items-center">
            <div class="col-md-6 col-8 align-self-center">
                <h3 class="page-title mb-0 p-0">Admin List</h3>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('/')}}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Admin</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="col-md-6 col-4 align-self-center">
                <div class="text-end upgrade-btn">
                    <a href="{{ route('create-admin') }}" class="btn btn-success d-none d-md-inline-block text-white"><i
                            class="fas fa-plus"></i> Add Admin</a>
                    {{-- <a href="{{ route('export-admin') }}" class="btn btn-info d-none d-md-inline-block text-white"><i
                            class="fas fa-note"></i> Excel Export
                    </a> --}}
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" name="adminurl" id="adminurl" value="{{ route('admin') }}" />
    <input type="hidden" name="admindeleteurl" id="admindeleteurl" value="{{ route('delete-admin') }}" />
    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">

    <!-- ============================================================== -->
    <!-- End Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Start Page Content -->
        <!-- ============================================================== -->
        <div class="row">
            <!-- column -->
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <input type="date" class="form-control" name="adminStartDate" id="adminStartDate" />
                                <input type="date" class="form-control" name="adminEndDate" id="adminEndDate" />
                                <button type="submit" id="adminFilterBtn" class="btn btn-primary float-left">
                                    Filter</li>
                                </button>
                                <button type="reset" id="adminResetBtn" class="btn btn-info float-left">
                                    Reset</li>
                                </button>
                            </div>
                            {{-- <div class="form-group">
                                <input type="date" class="form-control" name="adminStartDate" id="adminStartDate" />
                                <input type="date" class="form-control" name="adminEndDate" id="adminEndDate" />
                                <button type="submit" id="adminFilterBtn" class="btn btn-primary float-left">
                                    Filter</li>
                                </button>
                                <button type="reset" id="adminResetBtn" class="btn btn-info float-left">
                                    Reset</li>
                                </button>
                            </div> --}}
                        </div>
                        <table id="admin" class="admin table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Contact</th>
                                    <th>Status</th>
                                    <th>Created </th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script></script>
@endsection
