@php
$days = \App\Models\User::getDays();
@endphp

<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 working_hours">
    <div class="white-shadow-scnd-box" style="height:auto;">
        <div class="form-heading">
            <h4 class="h4-design">Working Hours</h4>
        </div>

        @foreach($days as $day)
            @php
            $hours = $user->lawyerHours()->where('day', $day)->first();
            @endphp
            <div class="custom-control custom-switch input_add">
                <input type="checkbox" class="custom-control-input hoursDay" value="{{ $day }}" {{ @$hours ? 'checked' : '' }}> {{ $day }}
                <label class="custom-control-label"></label>

                <button style="display:{{ @$hours ? '' : 'none' }}" type="button" class="btn btn-primary clickHours {{ $day }}" data-day="{{ $day }}">+</button>
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

        <div class="form-grouph select-design">
                    @foreach ($categoriesMulti as $category)
                    <div class="form-grouph input-design">
                        @if ($category->is_category=='1')
                        <h5 class="h5_titile_form pt-3">Federal court admissions</h5>
                       ( {{ $category->name }})*
                        @else
                        <label> {{ $category->name }}*</label>
                        @endif

                    </div>
                    <select class="select-block multiBoxes" multiple>
                        @foreach($category->items as $i => $list)
                        <option value="{{$list->id}}" data-cat="{{$category->id}}" data-name="{{$list->name}}" @foreach ($lawyer_details as $i=> $item)
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
                    </select>
                    {!! $errors->first('lawyer_info.'.$category->id, '<span class="help-block">:message</span>') !!}
                    @endforeach
                </div>

                <div class="form-grouph input-design{!! ($errors->has('year_experience') ? ' has-error' : '') !!}">
                    <label>Years of Experience <span class="label_color">?</span></label>
                    {!! Form::text('year_experience', $details->year_experience ?? null, ['class' => ($errors->has('year_experience') ? ' is-invalid' : ''), 'maxlength'=>'2']) !!}
                    {!! $errors->first('year_experience', '<span class="help-block">:message</span>') !!}
                </div>
    </div>
</div>