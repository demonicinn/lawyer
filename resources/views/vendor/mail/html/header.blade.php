<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
	
{{--
@if (trim($slot) === 'Laravel')
<img src="https://laravel.com/img/notification-logo.png" class="logo" alt="Laravel Logo">
@else
{{ $slot }}
@endif
--}}

<img src="{{ asset('assets/images/logo/logo.png') }}" class="logo" alt="{{ $slot }}" style="width:100%; height:56px">

</a>
</td>
</tr>
