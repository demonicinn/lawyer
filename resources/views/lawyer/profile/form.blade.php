@php
$details = $user->details;
$lawyer_details = $user->lawyerInfo;

@endphp


<div class="lawyer_profile-wrapper">
    {!! Form::open(['route' => 'lawyer.profile.update', 'class'=>'lawyer_profile-information form-design']) !!}
    <div class="row">
        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
            <div class="white-shadow-scnd-box">
                <div class="form-heading">
                    <h4 class="h4-design">Information about you</h4>
                </div>

                <div class="lawyer_profile-img mb-3">
                    <div class="circle" id="uploaded">
                        <img class="profile-pic" src="{{ $user->profile_pic }}">
                    </div>
                    <div class="p-image">
                        <span class="pencil_icon"><i class="fa-solid fa-pencil upload-button"></i></span>
                        <input class="file-upload" id="upload" type="file" accept="image/*" />
                        <input type="hidden" name="image" id="upload-img" />
                    </div>
                </div>


                <div class="form-grouph textarea-design{!! ($errors->has('bio') ? ' has-error' : '') !!}">
                    {!! Form::label('bio','Bio*', ['class' => 'form-label']) !!}
                    {!! Form::textarea('bio', $details->bio ?? null, ['class' => ($errors->has('bio') ? ' is-invalid' : '')]) !!}
                    {!! $errors->first('bio', '<span class="help-block">:message</span>') !!}
                </div>

                <div class="form-grouph select-design">
                    @foreach ($categories as $category)
                    <div class="form-grouph input-design">

                        <label> {{ $category->name }}*</label>

                    </div>
                    <select name="lawyer_info[{{$category->id}}]" id="lawyer_info-{{$category->id}}">
                        <option value="">Select {{ $category->name }}</option>
                        @foreach($category->items as $i => $list)
                        <option value="{{$list->id}}" @foreach ($lawyer_details as $i=> $item) {{ ( $list->id== $item->item_id) ? 'selected' : '' }} @endforeach >
                            {{$list->name}}
                        </option>
                        @endforeach
                    </select>
                    {!! $errors->first('lawyer_info.'.$category->id, '<span class="help-block">:message</span>') !!}
                    @endforeach
                </div>


                <div class="form-grouph checkbox-label-block">
                    <div class="d-flex align-items-center justify-content-spacebw">
                        {!! Form::label('contingency_cases','Do you accept contingency cases?*', ['class' => 'form-label']) !!}
                        <div class="d-flex align-items-center">
                            <div class="checkbox-design position-relative">
                                <input type="radio" name="contingency_cases" value="yes" {{ @$details->contingency_cases=='yes'?'checked':'' }}>
                                <button class="checkbox-btn"></button>
                                <label>Yes</label>
                            </div>
                            <div class="checkbox-design position-relative">
                                <input type="radio" name="contingency_cases" value="no" {{ @$details->contingency_cases=='no'?'checked':'' }}>
                                <button class="checkbox-btn"></button>
                                <label>No</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-grouph checkbox-label-block">
                    <div class="d-flex align-items-center justify-content-spacebw">
                        {!! Form::label('is_consultation_fee','Do you want to charge a consultation fee?*', ['class' => 'form-label']) !!}
                        <div class="d-flex align-items-center">
                            <div class="checkbox-design position-relative">
                                <input type="radio" name="is_consultation_fee" value="yes" {{ @$details->is_consultation_fee=='yes'?'checked':'' }}>
                                <button class="checkbox-btn"></button>
                                <label>Yes</label>
                            </div>
                            <div class="checkbox-design position-relative">
                                <input type="radio" name="is_consultation_fee" value="no" {{ @$details->is_consultation_fee=='no'?'checked':'' }}>
                                <button class="checkbox-btn"></button>
                                <label>No</label>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="form-flex">
                    <div class="form-grouph input-design{!! ($errors->has('hourly_fee') ? ' has-error' : '') !!}">
                        {!! Form::label('hourly_fee','Hourly Fee*', ['class' => 'form-label']) !!}
                        {!! Form::number('hourly_fee', $details->hourly_fee ?? null, ['class' => ($errors->has('hourly_fee') ? ' is-invalid' : '')]) !!}
                        {!! $errors->first('hourly_fee', '<span class="help-block">:message</span>') !!}
                    </div>
                    <div class="form-grouph input-design{!! ($errors->has('consultation_fee') ? ' has-error' : '') !!}" id="consultation_fee">
                        {!! Form::label('consultation_fee','Consultation Fee*', ['class' => 'form-label']) !!}
                        {!! Form::number('consultation_fee', $details->consultation_fee ?? null, ['class' => ($errors->has('consultation_fee') ? ' is-invalid' : '')]) !!}
                        {!! $errors->first('consultation_fee', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>

                <div class="form-grouph input-design{!! ($errors->has('website_url') ? ' has-error' : '') !!}">
                    {!! Form::label('website_url','Website URL', ['class' => 'form-label']) !!}
                    {!! Form::url('website_url', $details->website_url ?? null, ['class' => ($errors->has('website_url') ? ' is-invalid' : '')]) !!}
                    {!! $errors->first('website_url', '<span class="help-block">:message</span>') !!}
                </div>

                <div class="form-flex">
                    <div class="form-grouph input-design{!! ($errors->has('first_name') ? ' has-error' : '') !!}">
                        {!! Form::label('first_name','First Name*', ['class' => 'form-label']) !!}
                        {!! Form::text('first_name', $user->first_name ?? null, ['class' => ($errors->has('first_name') ? ' is-invalid' : '')]) !!}
                        {!! $errors->first('first_name', '<span class="help-block">:message</span>') !!}
                    </div>
                    <div class="form-grouph input-design{!! ($errors->has('last_name') ? ' has-error' : '') !!}">
                        {!! Form::label('last_name','Last Name*', ['class' => 'form-label']) !!}
                        {!! Form::text('last_name', $user->last_name ?? null, ['class' => ($errors->has('last_name') ? ' is-invalid' : '')]) !!}
                        {!! $errors->first('last_name', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>

                <div class="form-flex">
                    <div class="form-grouph input-design{!! ($errors->has('contact_number') ? ' has-error' : '') !!}">
                        {!! Form::label('contact_number','Phone', ['class' => 'form-label']) !!}
                        {!! Form::number('contact_number', $user->contact_number ?? null, ['class' => ($errors->has('contact_number') ? ' is-invalid' : '')]) !!}
                        {!! $errors->first('contact_number', '<span class="help-block">:message</span>') !!}
                    </div>
                    <div class="form-grouph input-design{!! ($errors->has('email') ? ' has-error' : '') !!}">
                        {!! Form::label('email','Email', ['class' => 'form-label']) !!}
                        {!! Form::email('email', $user->email ?? null, ['class' => ($errors->has('email') ? ' is-invalid' : ''), 'disabled']) !!}
                        {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>

                <div class="form-grouph input-design{!! ($errors->has('address') ? ' has-error' : '') !!}">
                    {!! Form::label('address','Address*', ['class' => 'form-label']) !!}
                    {!! Form::text('address', $details->address ?? null, ['class' => ($errors->has('address') ? ' is-invalid' : '')]) !!}
                    {!! $errors->first('address', '<span class="help-block">:message</span>') !!}
                </div>

                <div class="form-flex three-columns">
                    <div class="form-grouph input-design{!! ($errors->has('city') ? ' has-error' : '') !!}">
                        {!! Form::label('city','City*', ['class' => 'form-label']) !!}
                        {!! Form::text('city', $details->city ?? null, ['class' => ($errors->has('city') ? ' is-invalid' : '')]) !!}
                        {!! $errors->first('city', '<span class="help-block">:message</span>') !!}
                    </div>
                    <div class="form-grouph select-design{!! ($errors->has('state') ? ' has-error' : '') !!}">
                        {!! Form::label('state','State*', ['class' => 'form-label']) !!}
                        {!! Form::select('state', $states, $details->state ?? null, ['class' => ($errors->has('state') ? ' is-invalid' : '')]) !!}
                        {!! $errors->first('state', '<span class="help-block">:message</span>') !!}
                    </div>
                    <div class="form-grouph input-design{!! ($errors->has('zip_code') ? ' has-error' : '') !!}">
                        {!! Form::label('zip_code','Zip Code*', ['class' => 'form-label']) !!}
                        {!! Form::text('zip_code', $details->zip_code ?? null, ['class' => ($errors->has('zip_code') ? ' is-invalid' : '')]) !!}
                        {!! $errors->first('zip_code', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>

                @livewire('lawyer.practice-areas')





                <div class="form-grouph select-design">
                    @foreach ($categoriesMulti as $category)
                    <div class="form-grouph input-design">
                        @if ($category->is_category=='1')
                        <h5>Federal court admissions</h5>
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


                <div class="admissionHtml"></div>

                <div class="form-grouph input-design{!! ($errors->has('year_experience') ? ' has-error' : '') !!}">
                    <label>Years of Experience <span class="label_color">?</span></label>
                    {!! Form::text('year_experience', $details->year_experience ?? null, ['class' => ($errors->has('year_experience') ? ' is-invalid' : ''), 'maxlength'=>'2']) !!}
                    {!! $errors->first('year_experience', '<span class="help-block">:message</span>') !!}
                </div>

            </div>
        </div>
        
        @include('lawyer.profile.hours')

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 text-center mt-5">
            <div class="form-grouph submit-design text-center">
                <button type="submit" class="btn-design-first">Update Profile</button>
            </div>
        </div>
    </div>
    {!! Form::close() !!}

</div>