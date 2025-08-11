@extends('layouts.app')

@section('content')

<div class="container">
    <style>
        /* Add your custom styles here */
        tags.tagify.tagify--noTags.tagify--empty {
            width: 100%;
            max-width: 466px;
            border-radius: 10px;
        }
        .action-btns form {
    display: inline-block;
}
    </style>

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">

                    <div class="d-flex justify-content-end mb-3">
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#addNewDomainOrSSL">
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
                    @if($editDomain)
                    <h2>Edit Domain</h2>
                    <form action="{{ route('domain.update', $editDomain->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label>Domain Name</label>
                            <input type="text" name="domainName" class="form-control"
                                value="{{ old('domainName', $editDomain->domain_name) }}" required>
                        </div>

                        <div class="mb-3">
                            <label>Expiration Date</label>
                            <input type="date" name="expirationDate" class="form-control"
                                value="{{ old('expirationDate', $editDomain->expiration_date) }}" required>
                        </div>

                        <div class="mb-3">
                            <label>Domain Buyer</label>
                            <input type="text" name="domainBuyer" class="form-control"
                                value="{{ old('domainBuyer', $editDomain->domain_buyer) }}" required>
                        </div>

                        <div class="mb-3">
                            <label>Type</label>
                            <select name="typeDomain" class="form-select" required>
                                <option value="Domain" {{ $editDomain->type_domain == 'Domain' ? 'selected' : ''
                                    }}>Domain
                                </option>
                                <option value="SSL" {{ $editDomain->type_domain == 'SSL' ? 'selected' : '' }}>SSL
                                </option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Client Email</label>
                            <input id="tagsInput" name="client_email"
                                value="{{ old('client_email', json_encode($editDomain->client_email)) }}">
                        </div>

                        {{-- <div class="mb-3">
                            <label>Status</label>
                            <select name="status" class="form-select" required>
                                <option value="Active" {{ $editDomain->status == 'Active' ? 'selected' : '' }}>Active
                                </option>
                                <option value="Expired" {{ $editDomain->status == 'Expired' ? 'selected' : '' }}>Expired
                                </option>
                                <option value="Inactive" {{ $editDomain->status == 'Inactive' ? 'selected' : ''
                                    }}>Inactive
                                </option>
                            </select>
                        </div> --}}

                        <div class="mb-3">
                            <label>Email Status</label>
                            <select name="email_status" class="form-select" required>
                                <option value="true" {{ $editDomain->email_status == 'true' ? 'selected' : '' }}>Send
                                </option>
                                <option value="false" {{ $editDomain->email_status == 'false' ? 'selected' : ''
                                    }}>No send
                                </option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Status</label>
                            <select name="status" class="form-select" required>
                                <option value="active" {{ $editDomain->status == 'active' ? 'selected' : '' }}>Active
                                </option>
                                <option value="inactive" {{ $editDomain->status == 'inactive' ? 'selected' : ''
                                    }}>Inactive
                                </option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-success">Update</button>
                        <a href="{{ route('home') }}" class="btn btn-secondary">Cancel</a>
                    </form>
                    @else

                    <table id="domainDataTable" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Domain Name</th>
                                <th>Expiration Date</th>
                                <th>Domain Buyer</th>
                                <th>Client Email</th>
                                <th>Email Status</th>
                                <th>Status</th>
                                <th>Type</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        @php
                        $sl = 1;
                        @endphp
                        <tbody>
                            @foreach($domainContents as $domain)
                            <tr>
                                <td>{{ $sl++ }}</td>
                                <td>{{ $domain->domain_name }}</td>
                                <td>{{ $domain->expiration_date }}</td>
                                <td>{{ $domain->domain_buyer }}</td>
                                <td>
                                    @foreach($domain->client_email as $client)
                                    {{ $client['value'] }}<br>
                                    @endforeach
                                </td>
                                {{-- <td>
                                    <pre>{{ json_encode($domain->client_email, JSON_PRETTY_PRINT) }}</pre>
                                </td> --}}
                                <td>{{ $domain->email_status == 'false' ? 'No Send' : 'Send' }}</td>
                                <td>{{ $domain->status }}</td>
                                <td>{{ $domain->type_domain }}</td>
                                {{-- <td>{{ date('Y-m-d', strtotime( $domain->created_at ));}}</td> --}}
                                <td class="action-btns">
                                    {{-- <a href="{{ route('domain.home', $domain->id) }}"
                                        class="btn btn-primary btn-sm display:inline-block;"><i class="fas fa-pen"></i></a> --}}
 <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#editNewDomainOrSSL">
                            Edit Domain
                        </button>

                                    <form class="display:inline-block;" action="{{ route('domain.destroy', $domain->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this domain?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addNewDomainOrSSL" tabindex="-1" aria-labelledby="addNewDomainOrSSLLabel"
    aria-hidden="true">
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
                        <input type="text" class="form-control" id="domainName" name="domainName"
                            placeholder="e.g. example.com" required>
                    </div>

                    <div class="mb-3">
                        <label for="expirationDate" class="form-label">Expiration Date</label>
                        <input type="date" class="form-control" id="expirationDate" name="expirationDate" required>
                    </div>

                    {{-- <div class="mb-3">
                        <label for="domainContent" class="form-label">Email Content</label>
                        <textarea class="form-control" name="domainContent" id="exampleFormControlTextarea1"
                            rows="3"></textarea>

                    </div> --}}

                    <div class="mb-3">
                        <label for="domainBuyer" class="form-label">Domain Buyer</label>
                        <input type="text" class="form-control" id="domainBuyer" name="domainBuyer"
                            placeholder="e.g. site 5" required>
                    </div>

                    <div class="mb-3">
                        <label for="Type/Domain" class="form-label">Type/Domain</label>
                        <select class="form-select" id="typeDomain" name="typeDomain" required>
                            <option value="">Select type</option>
                            <option value="Domain">Domain</option>
                            <option value="SSL">SSL</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">client_email</label>
                        <div style="margin-top:10px;">
                            <input id="tagsInput" name="client_email">
                        </div>
                    </div>

                    <div class="mb-3" style=" display: none;">
                        <label for="email_status" class="form-label">Email status</label>
                        <select class="form-select" id="email_status" name="email_status" required>
                            <option value="false">Select status</option>
                            <option value="false">false</option>
                            <option value="true">true</option>
                        </select>
                    </div>
                    <div class="mb-3" style=" display: none;">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="active">Select status</option>
                            <option value="active">active</option>
                            <option value="inactive">inactive</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success">Save</button>
                    <button type="reset" class="btn btn-secondary">Reset</button>
                </form>
            </div>

        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editNewDomainOrSSL" tabindex="-1" aria-labelledby="editNewDomainOrSSLLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editNewDomainOrSSLLabel">Edit Domain or SSL</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="#" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="domainName" class="form-label">Domain Name</label>
                        <input type="text" class="form-control" id="domainName" name="domainName"
                            placeholder="e.g. example.com" required>
                    </div>

                    <div class="mb-3">
                        <label for="expirationDate" class="form-label">Expiration Date</label>
                        <input type="date" class="form-control" id="expirationDate" name="expirationDate" required>
                    </div>

                    {{-- <div class="mb-3">
                        <label for="domainContent" class="form-label">Email Content</label>
                        <textarea class="form-control" name="domainContent" id="exampleFormControlTextarea1"
                            rows="3"></textarea>

                    </div> --}}

                    <div class="mb-3">
                        <label for="domainBuyer" class="form-label">Domain Buyer</label>
                        <input type="text" class="form-control" id="domainBuyer" name="domainBuyer"
                            placeholder="e.g. site 5" required>
                    </div>

                    <div class="mb-3">
                        <label for="Type/Domain" class="form-label">Type/Domain</label>
                        <select class="form-select" id="typeDomain" name="typeDomain" required>
                            <option value="">Select type</option>
                            <option value="Domain">Domain</option>
                            <option value="SSL">SSL</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">client_email</label>
                        <div style="margin-top:10px;">
                            <input id="tagsInput" name="client_email">
                        </div>
                    </div>

                    <div class="mb-3" style=" display: none;">
                        <label for="email_status" class="form-label">Email status</label>
                        <select class="form-select" id="email_status" name="email_status" required>
                            <option value="false">Select status</option>
                            <option value="false">false</option>
                            <option value="true">true</option>
                        </select>
                    </div>
                    <div class="mb-3" style=" display: none;">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="active">Select status</option>
                            <option value="active">active</option>
                            <option value="inactive">inactive</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success">Save</button>
                    <button type="reset" class="btn btn-secondary">Reset</button>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection
<script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.min.js"></script>
@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {

    const input = document.querySelector('#tagsInput');
    const tagify = new Tagify(input, {
        whitelist: [],
        enforceWhitelist: false,
        dropdown: { enabled: 0 }
    });

    document.querySelector('form').addEventListener('submit', function(){
        // JSON encode safely
        input.value = JSON.stringify(tagify.value.map(t => t.value));
    });
    });

</script>
<script>
    $(function () {
        $('#domainDataTable').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": false,
          "ordering": true,
          "info": true,
          "autoWidth": false,
          "responsive": true,
        });

    // $("#domainDataTable").DataTable({
    //   "responsive": true,
    //   "lengthChange": false,
    //   "autoWidth": false,
    //   "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    // }).buttons().container().appendTo('#domainDataTable_wrapper .col-md-6:eq(0)');


  });
</script>


@endpush
