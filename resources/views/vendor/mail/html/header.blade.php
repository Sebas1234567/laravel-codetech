@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="https://laravel.com/img/notification-logo.png" class="logo" alt="Laravel Logo">
@else
<img src="https://i.postimg.cc/gcQzT6bN/Banner.png" class="logo" alt="CodeTech">
@endif
</a>
</td>
</tr>
