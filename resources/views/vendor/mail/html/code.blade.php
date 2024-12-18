@props([
    'align' => 'center',
])
<table class="action" align="{{ $align }}" width="100%" cellpadding="0" cellspacing="0" role="presentation">
<tr>
<td align="{{ $align }}">
<table width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation">
<tr>
<td align="{{ $align }}">
<table border="0" cellpadding="0" cellspacing="0" role="presentation">
<tr>
<td>
<?php 
$part1 = substr($slot, 0, 3);
$part2 = substr($slot, -3);
?>
<div class="code-container"><p class="code l1">{{ $part1 }}</p><p class="code">{{ $part2 }}</p></div>
</td>
</tr>
</table>
</td>
</tr>
</table>
</td>
</tr>
</table>