@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        {{ __('Domain renew list') }}

                        <div class="d-flex justify-content-end mb-3">
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addNewDomainOrSSL">
                                Add Domain
                            </button>
                        </div>

                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="card-body">
                            <h5 class="card-title align-left d-flex"></h5>
                            <div class="d-flex justify-content-end mb-3">

                            </div>
                            <!-- /.card-header -->
                            <table id="domain_table" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Domain Name</th>
                                        <th>Expiration Date</th>
                                        <th>Client</th>
                                        <th>Type/Domain</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>b2m-tech.com
                                        </td>
                                        <td>12/12/2026</td>
                                        <td>site 5</td>
                                        <td>Domain</td>
                                        <td>Active</td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>b2m-tech2.com
                                        </td>
                                        <td>22/05/2026</td>
                                        <td>site 5</td>
                                        <td>Domain</td>
                                        <td>Active</td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>b2m-tech3.com
                                        </td>
                                        <td>11/09/2026</td>
                                        <td>eicra</td>
                                        <td>Domain</td>
                                        <td>Active</td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td>b2m-tech4.com
                                        </td>
                                        <td>12/10/2026</td>
                                        <td>site 5</td>
                                        <td>Domain</td>
                                        <td>Active</td>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td>b2m-tech5.com
                                        </td>
                                        <td>12/12/2027</td>
                                        <td>eicra</td>
                                        <td>Domain</td>
                                        <td>Active</td>
                                    </tr>
                                </tbody>

                            </table>
                            <!-- /.card-body -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="addNewDomainOrSSL" tabindex="-1" aria-labelledby="addNewDomainOrSSLLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addNewDomainOrSSLLabel">Create New Domain or SSL</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('domain.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="domainName" class="form-label">Domain Name</label>
                            <input type="text" class="form-control" id="domainName" placeholder="e.g. example.com"
                                required>
                        </div>

                        <div class="mb-3">
                            <label for="expirationDate" class="form-label">Expiration Date</label>
                            <input type="date" class="form-control" id="expirationDate" required>
                        </div>

                        <div class="mb-3">
                            <label for="client" class="form-label">Client</label>
                            <input type="text" class="form-control" id="client" placeholder="e.g. site 5" required>
                        </div>

                        <div class="mb-3">
                            <label for="typeDomain" class="form-label">Type/Domain</label>
                            <select class="form-select" id="typeDomain" required>
                                <option value="">Select type</option>
                                <option value="Domain">Domain</option>
                                <option value="SSL">SSL</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" required>
                                <option value="">Select status</option>
                                <option value="Active">Active</option>
                                <option value="Expired">Expired</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-success">Save</button>
                        <button type="reset" class="btn btn-secondary">Reset</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
@endsection
