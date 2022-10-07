@php
$days = \App\Models\User::getDays();
@endphp

<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
    <div class="white-shadow-scnd-box">
        <div class="form-heading">
            <h4 class="h4-design">Working Hours</h4>
        </div>

        @foreach($days as $day)
            @php
            $hours = $user->lawyerHours()->where('day', $day)->first();
            @endphp
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input hoursDay" value="{{ $day }}" {{ @$hours ? 'checked' : '' }}> {{ $day }}
                <label class="custom-control-label"></label>

                <button style="display:{{ @$hours ? '' : 'none' }}" type="button" class="btn btn-primary clickHours {{ $day }}" data-day="{{ $day }}">Add</button>
            </div>



            <div class="addNewHoursLayout {{ $day }}" style="display:{{ @$hours ? '' : 'none' }}">
                
                <div class="form-flex layout layout-1">
                    <div class="form-grouph input-design{!! ($errors->has('from_time') ? ' has-error' : '') !!}">
                        {!! Form::label('from_time','From Time*', ['class' => 'form-label']) !!}    
                        {!! Form::time('day['.$day.'][1][from_time]', @$hours->from_time ?? null, ['class' => ($errors->has('from_time') ? ' is-invalid' : '')]) !!}
                        {!! $errors->first('from_time', '<span class="help-block">:message</span>') !!}
                    </div>
                    <div class="form-grouph input-design{!! ($errors->has('to_time') ? ' has-error' : '') !!}">
                        {!! Form::label('to_time','To Time*', ['class' => 'form-label']) !!}    
                        {!! Form::time('day['.$day.'][1][to_time]', @$hours->to_time ?? null, ['class' => ($errors->has('to_time') ? ' is-invalid' : '')]) !!}
                        {!! $errors->first('to_time', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>



            </div>



        @endforeach

    </div>
</div>