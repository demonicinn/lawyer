@extends('layouts.app')
@section('content')
<section class="body-banner lawyer-directory-profile-sec min-height-100vh">
    <div class="container">
        <div class="heading-paragraph-design text-center position-relative go-back-wrap mb-5">
            <h2>Client Profile</h2>
            <a href="{{ url()->previous() ?? route('narrow.down') }}" class="go-back"><i class="fa-solid fa-arrow-left-long"></i> Back to Users</a>
        </div>
    </div>
	
    <div class="directory-profile-wrapper container">
        <form class="directory-form-information form-design">
            <div class="row justify-content-center">
                <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12">
                    <div class="white-shadow-third-box lawyer-directory_about-block">
                        <div class="form-flex">
                            <div class="form-grouph input-design">
                                {!! Form::label('first_name','First Name*', ['class' => 'form-label']) !!}
                                {!! Form::text('first_name', $user->first_name ?? null, ['disabled' => true,'class' => ($errors->has('first_name') ? ' is-invalid' : '')]) !!}
                            </div>
                            <div class="form-grouph input-design">
                                {!! Form::label('last_name','Last Name*', ['class' => 'form-label']) !!}
                                {!! Form::text('last_name', $user->last_name ?? null, ['disabled' => true,'class' => ($errors->has('last_name') ? ' is-invalid' : '')]) !!}
                            </div>
                        </div>
                        <div class="form-flex">
                           
                            <div class="form-grouph input-design">
                                {!! Form::label('email','Email*', ['class' => 'form-label']) !!}
                                {!! Form::email('email', $user->email ?? null, ['disabled' => true,'class' => ($errors->has('email') ? ' is-invalid' : '')]) !!}
                            </div>
                            <div class="form-grouph input-design">
                                {!! Form::label('contact_number','Phone*', ['class' => 'form-label']) !!}
                                {!! Form::text('contact_number', $user->contact_number ?? null, ['disabled' => true,'class' => ($errors->has('contact_number') ? ' is-invalid' : '')]) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    
	
	
		<div class="row justify-content-center">
			@livewire('admin.consultations', ['lawyerId' => $user->id])
			
			
			<div class="col-md-12 col-sm-12 mt-3">
				<div class="white-shadow-third-box">
					<h2 class="text-center">Canceled Consultations</h2>
					<div class="lawyer_conultation-wrapper">
						<div class="table-responsive table-design">
							<table style="width:100%" id="laravel_datatable">
								<thead>
									<tr>
										<th>Client Name</th>
										<th>Email</th>
										<th>Date</th>
										<th>Practice Area</th>
									</tr>
								</thead>
								<tbody>
									@foreach($cancelBooking as $booking)
									<tr>
										<td>{{$booking->user->name}}</td>
										<td>{{$booking->user->email}}</td>
										<td>{{date('m/d/Y', strtotime($booking->booking_date)) }}</td>
										<td>
											@if($booking->search_data)
											@php
											$search = json_decode($booking->search_data);
											@endphp
											@foreach($search as $id)
											@if($booking->search_type == 'litigations')
											{{ litigationsData($id) }}
											@else
											{{ contractsData($id) }}
											@endif
											@endforeach
											@endif
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
		
	</div>
	
</section>
@endsection



@section('script')
<script>
    function blockFunction() {

        Swal.fire({
            title: "Are you sure you want to block this?",
            //text: "Block lawyer!",
            //type: "danger",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes, block!",
            closeOnConfirm: false

        }).then((result) => {

            if (result.isConfirmed) {
                $("#formblock").submit();
            }
        });


    }

    function deActiveFunction() {

        Swal.fire({
            title: "Are you sure you want to de-active this?",
            //text: "De-active lawyer!",
            //type: "danger",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes, De-active!",
            closeOnConfirm: false

        }).then((result) => {

            if (result.isConfirmed) {
                $("#formdeactive").submit();
            }
        });
    }


    function activateFunction() {

        Swal.fire({
            title: "Are you sure you want to active this?",
            //text: "Active lawyer!",
            //type: "danger",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes, Active!",
            closeOnConfirm: false

        }).then((result) => {

            if (result.isConfirmed) {
                $("#formdeactive").submit();
            }
        });
    }

    function acceptFunction() {

        Swal.fire({
            title: "Are you sure you want to accept this?",
            //text: "Accept lawyer!",
            //type: "danger",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes, Accept!",
            closeOnConfirm: false

        }).then((result) => {

            if (result.isConfirmed) {
                $("#formaccept").submit();
            }
        });
    }

    function declinedFunction() {

        Swal.fire({
            title: "Are you sure you want to decline this?",
            //text: "Decline lawyer!",
            //type: "danger",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes, Decline!",
            closeOnConfirm: false

        }).then((result) => {

            if (result.isConfirmed) {
                $("#formdeclined").submit();
            }
        });
    }
</script>
@endsection