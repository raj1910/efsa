<?php
$imf=0;
$cmf=0;
?>
@foreach($customer->mutualfunds as $mutualfund)
<tr>
    <td>{{ $mutualfund->category }}</td>
    <td>{{ $mutualfund->name }}</td>
    <td>{{ $mutualfund->acquired_value }}
        <?php
        $imf=$imf+$mutualfund->acquired_value;
        $cinvest=$cmf+$mutualfund->recent_value;
        ?></td>
    <td>{{ $mutualfund->acquired_date }}</td>
    <td>{{ $mutualfund->recent_value }}</td>
    <td>{{ $mutualfund->recent_date }}</td>
</tr>
@endforeach
</tbody>
</table>
</div>

        