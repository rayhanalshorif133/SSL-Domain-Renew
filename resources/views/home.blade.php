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
                        <button type="button" class="btn btn-success btn-sm" onclick="openAddModal()">Add
                            Domain</button>
                    </div>


                </div>
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif


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
                                        class="btn btn-primary btn-sm display:inline-block;"><i
                                            class="fas fa-pen"></i></a> --}}



                                    <button type="button" class="btn btn-primary btn-sm"
                                        onclick='openEditModal(@json($domain))'>
                                        <i class="fas fa-pen"></i>
                                    </button>

                                    <form class="display:inline-block;"
                                        action="{{ route('domain.destroy', $domain->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this domain?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"><i
                                                class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add/edit Modal -->
<div class="modal fade" id="domainModal" tabindex="-1" aria-labelledby="domainModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="domainModalLabel">Create New Domain or SSL</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form id="domainForm" method="POST">
                    @csrf
                    <input type="hidden" name="_method" id="formMethod" value="POST">

                    <div class="mb-3">
                        <label for="domainName" class="form-label">Domain Name</label>
                        <input type="text" class="form-control" id="domainName" name="domainName"
                            placeholder="e.g. example.com" required>
                    </div>

                    <div class="mb-3">
                        <label for="expirationDate" class="form-label">Expiration Date</label>
                        <input type="date" class="form-control" id="expirationDate" name="expirationDate" required>
                    </div>

                    <div class="mb-3">
                        <label for="domainBuyer" class="form-label">Domain Buyer</label>
                        <input type="text" class="form-control" id="domainBuyer" name="domainBuyer"
                            placeholder="e.g. site 5" required>
                    </div>

                    <div class="mb-3">
                        <label for="typeDomain" class="form-label">Type/Domain</label>
                        <select class="form-select" id="typeDomain" name="typeDomain" required>
                            <option value="">Select type</option>
                            <option value="Domain">Domain</option>
                            <option value="SSL">SSL</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="tagsInput" class="form-label">Client Email</label>
                        <input id="tagsInput" name="client_email">
                    </div>

                    <div class="mb-3" style="display:none;">
                        <label for="email_status" class="form-label">Email status</label>
                        <select class="form-select" id="email_status" name="email_status" required>
                            <option value="false">false</option>
                            <option value="true">true</option>
                        </select>
                    </div>

                    <div class="mb-3" style="display:none;">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="active">active</option>
                            <option value="inactive">inactive</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success" id="saveBtn">Save</button>
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


    // Insert Mode
    function openAddModal() {
        $('#domainModalLabel').text('Create New Domain or SSL');
        $('#domainForm').attr('action', "{{ route('domain.store') }}");
        $('#formMethod').val('POST');
        $('#domainForm')[0].reset();
        $('#saveBtn').text('Save');
        $('#domainModal').modal('show');
    }

    let tagify = new Tagify(document.querySelector("#tagsInput"));
    // Edit Mode
    function openEditModal(domain) {

        $('#domainModalLabel').text('Update Domain or SSL');
        $('#domainForm').attr('action', "/domain/domain/" + domain.id);
        $('#formMethod').val('PUT');
        $('#domainName').val(domain.domain_name);
        $('#expirationDate').val(domain.expiration_date);
        $('#domainBuyer').val(domain.domain_buyer);
        $('#typeDomain').val(domain.type_domain);
        tagify.removeAllTags();
        tagify.addTags(domain.client_email);
        $('#email_status').val(domain.email_status);
        $('#status').val(domain.status);
        $('#saveBtn').text('Update');
        $('#domainModal').modal('show');
    }
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
  });
</script>


@endpush
