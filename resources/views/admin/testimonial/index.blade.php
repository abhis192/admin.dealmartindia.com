@extends('layouts.backend.app')

@section('title')
<title>Testimonials | {{Auth::user()->role->name}}</title>
@endsection

@section('css')
@endsection

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">All testimonial</h4>

                    <div class="page-title-right">
                        <!-- <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                            <li class="breadcrumb-item active">All testimonial</li>
                        </ol> -->
                        <a href="{{route('admin.testimonial.create')}}" class="btn btn-primary waves-effect waves-light"><i class="fas fa-plus"></i> Add New testimonial</a>
                    </div>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="card border"> 
                    <div class="card-body"> 

                        <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th class="col-1">#</th> 
                                    <th>Name</th>  
                                    <th>Country</th>  
                                    <th class="col-1">Published</th>
                                    <th class="col-1">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($testimonials->count())
                                @foreach($testimonials as $key => $testimonial)
                                <tr> 
                                    <td>#{{$key+1}}</td>
                                    <td class="text-wrap">{{$testimonial->name}}</td> 
                                    <td class="text-wrap">{{$testimonial->country}}</td> 
                                    <td>
                                        <form method="POST" action="{{ route('admin.testimonial.toggle', $testimonial->id) }}">
                                            @csrf
                                            <button type="submit" class="square-switch btn btn-toggle">
                                                <input type="checkbox" id="square-switch{{$key}}" switch="status" name="status" {{ $testimonial->status == 1 ? "checked" : "" }} />
                                                <label for="square-switch{{$key}}" data-on-label="Yes" data-off-label="No"></label>
                                            </button>
                                        </form>
                                    </td>
                                    <td class="text-center">  
                                        <a href="{{ route('admin.testimonial.edit', $testimonial->id) }}" class="btn btn-soft-info btn-sm waves-effect waves-light"><i class="bx bx-pencil font-size-16"></i></a>
                                        <a href="javascript:void(0);" class="btn btn-soft-danger btn-sm waves-effect waves-light sa-delete" title="Delete Testimonial" data-id="{{ $testimonial->id }}" data-link="/admin/testimonial/destroy/"><i class="bx bx-trash font-size-16"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div> 
                </div>
            </div> <!-- end col -->

        </div>
    </div>
</div>
@endsection
