<tr>
<td>
<table class="footer" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
<tr>
<td>

Essenciacompany<br> 
E-Mail: <a href="mailto:{{env('MAIL_FROM_ADDRESS')}}">{{ env('MAIL_FROM_ADDRESS') }}</a><br>
</td>

</tr>

<tr>
<td class="content-cell" align="center">
{{ Illuminate\Mail\Markdown::parse($slot) }}
</td>
</tr>
</table>
</td>
</tr>
