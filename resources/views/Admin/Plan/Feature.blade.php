@extends('admin.layout.main')

@section('title', 'Features')

@section('content')
<div class="row">
    
</div>

<div class="card mt-3">
    <div class="card-body">
        {{-- <div class="d-flex justify-content-end mb-3"> --}}
            <div class="card-header text-right mb-3" style="background-color: #e0e4e6">

            <button class="btn btn-primary btn-sm add_features">Add Feature</button>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                @php($i = $feature->firstItem())
                @foreach ($feature as $f)
                    <tr>
                        <td>{{ $i }}</td>
                        <td>{{ $f->name }}</td>
                        <td>
                            <a href="{{ route('Feature.add', $f->id) }}" class="update_features">
                                <i class="far fa-edit text-success"></i>
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('Feature.delete', $f->id) }}" onclick="return confirm('Are you sure you want to delete this feature?')">
                                <i class="fas fa-trash text-danger"></i>
                            </a>
                        </td>
                    </tr>
                    @php($i++)
                @endforeach
            </tbody>
        </table>
        
        <div class="d-flex justify-content-center mt-3">
            {{ $feature->links() }}
        </div>
    </div>
</div>

<!-- Modal for Adding Features -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <form action="" method="post" id="featureForm">
        @csrf
        <input type="hidden" name="id" id="feature_id" value="">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fs-5" id="staticBackdropLabel"><b>Feature</b></h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Feature Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Feature Name" required>
                    </div>
                </div>
                <div class="card-header text-right mb-3" style="background-color: #e0e4e6">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-sm">Save</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('.add_features').on('click', function() {
            $('#featureForm').attr('action', '{{ route('Feature.add') }}');
            $('#feature_id').val('');
            $('#name').val('');
            $('#staticBackdrop').modal('show');
        });

        $('.update_features').on('click', function(e) {
            e.preventDefault();
            const href = $(this).attr('href');
            $('#featureForm').attr('action', href);
            const featureName = $(this).closest('tr').find('td:nth-child(2)').text();
            $('#feature_id').val(href.split('/').pop());
            $('#name').val(featureName);
            $('#staticBackdrop').modal('show');
        });
        $('.btn-close').on('click', function(){
            $('#staticBackdrop').modal('hide'); 
        });

        $(".sidebar .nav-link").removeClass('active');
        $(".feature-link").addClass('active');
    });
</script>
@endsection
