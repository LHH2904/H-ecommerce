@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Brand</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 card">
                    <div class="card-header">
                        <h4>Create brand</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.brand.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="">Logo</label>
                                <input type="file" class="form-control" name="logo">
                            </div>
                            <div class="form-group">
                                <label for="">Name</label>
                                <input type="text" class="form-control" name="name" value="">
                            </div>
                            <div class="form-group">
                                <label for="inputState">Is Featured</label>
                                <select id="inputState" class="form-control" name="is_featured">
                                    <option value="">Select</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="inputState">State</label>
                                <select id="inputState" class="form-control" name="status">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Create</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
