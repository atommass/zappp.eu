@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
    <img src="{{ route('email.logo') }}" class="logo" alt="{{ config('app.name', 'zippp.eu') }}" style="max-width:200px;height:auto;display:block;margin:0 auto;">
</a>
</td>
</tr>
