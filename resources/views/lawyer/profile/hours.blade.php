@php
$days = \App\Models\User::getDays();
$getTime = \App\Models\User::getTime();
@endphp

<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 working_hours">
    <div class="white-shadow-scnd-box mb-3" style="height:auto;">
        
		
        {{--
        <div class="form-heading">
            <h4 class="h4-design">Working Hours</h4>
		</div>
		 
        
        @foreach($days as $day)
		@php
		$hours = $user->lawyerHours()->where('day', $day)->get();
		@endphp
		
		<div class="custom-control custom-switch input_add">
			<input type="checkbox" class="custom-control-input hoursDay" name="day[{{$day}}][selected]" {{ @$hours ? 'checked' : '' }}><span> {{ $day }}</span>
			<label class="custom-control-label"></label>
			
			<button style="display:{{ @$hours ? '' : 'none' }}" type="button" class="btn btn-primary clickHours {{ $day }}" data-day="{{ $day }}">+</button>
		</div>
		
		
		<div class="addNewHoursLayout {{ $day }}" style="display:{{ @$hours ? '' : 'none' }}">
			
			@if($hours)
			@foreach($hours as $i => $hour)
			@php
			$j = $i+1;
			@endphp
			<div class="form-flex layout layout-{{$j}}">
				
				{!! Form::hidden('day['.$day.'][data]['.$j.'][id]', @$hour->id) !!}
				{!! Form::hidden('day['.$day.'][data]['.$j.'][delete]', 'no', ['class'=>'delete']) !!}
				
				<div class="form-grouph input-design{!! ($errors->has('from_time') ? ' has-error' : '') !!}">
					{!! Form::label('from_time','From Time*', ['class' => 'form-label']) !!}    
					<select name="day[{{$day}}][data][{{$j}}][from_time]">
						<option value="">Select From Time</option>
						@foreach($getTime as $ti => $time)
						<option value="{{$ti}}">{{$time}}</option>
						@endforeach
					</select>
					{!! $errors->first('from_time', '<span class="help-block">:message</span>') !!}
				</div>
				<div class="form-grouph input-design{!! ($errors->has('to_time') ? ' has-error' : '') !!}">
					{!! Form::label('to_time','To Time*', ['class' => 'form-label']) !!}    
					<select name="day[{{$day}}][data][{{$j}}][to_time]">
						<option value="">Select To Time</option>
						@foreach($getTime as $ti => $time)
						<option value="{{$ti}}">{{$time}}</option>
						@endforeach
					</select>
					{!! $errors->first('to_time', '<span class="help-block">:message</span>') !!}
				</div>
				<span class="btn_close deleteLayout" data-day="{{ $day }}" data-id="{{$j}}">X</span>
			</div>
			@endforeach
			@else
			<div class="form-flex layout layout-1">
				<div class="form-grouph input-design{!! ($errors->has('from_time') ? ' has-error' : '') !!}">
					{!! Form::label('from_time','From Time*', ['class' => 'form-label']) !!}    
					<select name="day[{{$day}}][data][{{$j}}][from_time]">
						<option value="">Select From Time</option>
						@foreach($getTime as $ti => $time)
						<option value="{{$ti}}">{{$time}}</option>
						@endforeach
					</select>
					{!! $errors->first('from_time', '<span class="help-block">:message</span>') !!}
				</div>
				<div class="form-grouph input-design{!! ($errors->has('to_time') ? ' has-error' : '') !!}">
					{!! Form::label('to_time','To Time*', ['class' => 'form-label']) !!}    
					<select name="day[{{$day}}][data][{{$j}}][to_time]">
						<option value="">Select To Time</option>
						@foreach($getTime as $ti => $time)
						<option value="{{$ti}}">{{$time}}</option>
						@endforeach
					</select>
					{!! $errors->first('to_time', '<span class="help-block">:message</span>') !!}
				</div>
			</div>
			
			@endif
			
		</div>
        @endforeach
        --}}
		
        @livewire('lawyer.hours')
		
		
		
		
		
		
        <div class="form-grouph select-design">
            <div class="form-grouph input-design">
                <h5 class="h5_titile_form pt-3">State bar admissions</h5>
			</div>
            <select id="mstate" name="state_category" class="select-block multiBoxes" multiple>
                @foreach ($stateBar as $state)
				<option value="{{$state->id}}" data-name="{{$state->name}}"
				@foreach ($lawyer_state_bar as $i=> $item)
					@if($state->id==$item->state_bar_id)
					data-year="{{$item->year_admitted}}"
					data-bar="{{$item->bar_number}}"
					selected
					@endif
					@endforeach
					>
					{{$state->name}}
				</option>
                @endforeach
			</select>
            {!! $errors->first('state_category', '<span class="help-block">:message</span>') !!}
            <div class="stateHtml cat"></div>
		</div>
		
		
		
		
        <div class="form-grouph select-design">
            <div class="form-grouph input-design">
                <h5 class="h5_titile_form pt-3">Federal court admissions</h5>
			</div>
            <select id="mcategory" name="lawyer_category" class="select-block multiBoxes" multiple>
				
				
                @foreach ($categories as $category)
				<optgroup label="{{ $category->name }}">
					@foreach($category->items as $i => $list)
					<option value="{{$list->id}}" data-cat="{{$category->id}}" data-name="{{$list->name}}" 
					@foreach ($lawyer_details as $i=> $item)
						@if($list->id==$item->item_id)
						data-year="{{$item->year_admitted}}"
						data-bar="{{$item->bar_number}}"
						selected
						@endif
						@endforeach
						>
						{{$list->name}}
					</option>
					@endforeach
				</optgroup>
                @endforeach
			</select>
            {!! $errors->first('lawyer_category', '<span class="help-block">:message</span>') !!}
            <div class="admissionHtml cat"></div>
		</div>
        
        
        <div class="form-grouph input-design{!! ($errors->has('year_experience') ? ' has-error' : '') !!}">
			<div class="question_div">
				<label class="w-auto">Years of Experience </label> 
				<div class="tooltip_div">
					<span  class="tooltip1">?</span>
					<p class="cntent_txt">Courtroom Experience</p>
				</div>
			</div>
            {!! Form::text('year_experience', $details->year_experience ?? null, ['class' => ($errors->has('year_experience') ? ' is-invalid' : ''), 'maxlength'=>'2']) !!}
            {!! $errors->first('year_experience', '<span class="help-block">:message</span>') !!}
		</div>
		
	</div>
    
	
    
	
</div>