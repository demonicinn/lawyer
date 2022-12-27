@extends('layouts.app')
@section('content')
<section class="dashboard_profile-sec min-height-100vh">
    <div class="container">
        <div class="heading-paragraph-design text-center position-relative go-back-wrap mb-5">
            <h2>{{ @$title['title'] }}</h2>
            <a href="{{ route('admin.dashboard') }}" class="go-back"><i class="fa-solid fa-arrow-left-long"></i> Back to Dashboard</a>
        </div>

        
        <div class="table-responsive table-design">
            <table style="width:100%">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Date</th>
                        <th>Resume</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $item)
                    <tr>
                        <td>{{ @$item->name }}</td>
                        <td>{{ @$item->email }}</td>
                        <td>{{ @$item->created_at->format('Y-m-d') }}</td>
                        <td><a target="_blank" class="btn btn-primary" href="{{ @$item->resume_path }}">Resume</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div id="pagination-container" class="pagination-container-saved">{{$data->links()}}</div>

      
    </div>
</section>
@endsection