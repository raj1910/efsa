@extends('app')
@section('content')
    <h1>Customer </h1>

    <div class="container">
        <table class="table table-striped table-bordered table-hover">
            <tbody>
            <tr class="bg-info">
            <tr>
                <td>Name</td>
                <td><?php echo ($customer['name']); ?></td>
            </tr>
            <tr>
                <td>Customer ID</td>
                <td><?php echo ($customer['cust_number']); ?></td>
            </tr>
            <tr>
                <td>Address</td>
                <td><?php echo ($customer['address']); ?></td>
            </tr>
            <tr>
                <td>City </td>
                <td><?php echo ($customer['city']); ?></td>
            </tr>
            <tr>
                <td>State</td>
                <td><?php echo ($customer['state']); ?></td>
            </tr>
            <tr>
                <td>Zip </td>
                <td><?php echo ($customer['zip']); ?></td>
            </tr>
            <tr>
                <td>Home Phone</td>
                <td><?php echo ($customer['home_phone']); ?></td>
            </tr>
            <tr>
                <td>Cell Phone</td>
                <td><?php echo ($customer['cell_phone']); ?></td>
            </tr>
            </tbody>
        </table>
    </div>


    <?php
    $stockprice=null;
    $stotal = 0;
    $svalue=0;
    $itotal = 0;
    $ivalue=0;
    $iportfolio = 0;
    $cportfolio = 0;
    ?>
    <br>
    <h2>Stocks </h2>
    <div class="container">
        <table class="table table-striped table-bordered table-hover">
            <thead>
            <tr class="bg-info">
                <th> Symbol </th>
                <th>Stock Name</th>
                <th>No. of Shares</th>
                <th>Purchase Price</th>
                <th>Purchase Date</th>
                <th>Original Value</th>
                <th>Current Price</th>
                <th>Current Value</th>
            </tr>
            </thead>

            <tbody>
            @foreach($customer->stocks as $stock)
                <tr>
                    <td>{{ $stock->symbol }}</td>
                    <td>{{ $stock->name }}</td>
                    <td>{{ $stock->shares }}</td>
                    <td>{{ $stock->purchase_price }}</td>
                    <td>{{ $stock->purchased }}</td>
                    <td>
                        <?php
                            $stktotal=$stock->purchase_price*$stock->shares;
                            echo $stktotal;
                            //To calculate total initial stock portfolio value
                            $itotal=$itotal+$stktotal;
                            ?>
                    </td>
                    <td>
                        <?php
                            $stksymbol=$stock->symbol;
                            $URL="http://finance.google.com/finance/info?client=ig&q=" . $stksymbol;
                            $file = fopen("$URL", "r");
                            $r = "";
                            do{
                                $data = fread($file, 500);
                                $r .= $data;
                            }
                            while (strlen($data)!=0);
                            $json = str_replace("\n", "", $r);
                            $data = substr($json, 4, strlen($json) - 5);
                            $json_output=json_decode($data,true);
                            $price = "\n" . $json_output['l'];
                            $cstkprice=$price;
                            echo $cstkprice;
                            ?>
                    </td>
                    <td>
                        <?php
                        $rstktotal=$cstkprice*$stock->shares;
                        echo $rstktotal;
                        //To calculate total current stock portfolio value
                        $stotal=$stotal+$rstktotal;
                        ?>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <h4>Total of initial Stock Portfolio $<?php echo $itotal; ?>  </h4>
    <h4>Total of Current Stock Portfolio $<?php echo $stotal; ?>  </h4>
    <h2>Investments </h2>
    <div class="container">
        <table class="table table-striped table-bordered table-hover">
            <thead>
            <tr class="bg-info">
                <th> Category </th>
                <th>Description</th>
                <th>Acquired Value</th>
                <th>Acquired Date</th>
                <th>Recent Value</th>
                <th>Recent Date</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $iinvest=0;
            $cinvest=0;
            ?>
            @foreach($customer->investments as $investment)
                <tr>
                    <td>{{ $investment->category }}</td>
                    <td>{{ $investment->description }}</td>
                    <td>{{ $investment->acquired_value }}
                        <?php
                        $iinvest=$iinvest+$investment->acquired_value;
                        $cinvest=$cinvest+$investment->recent_value;
                        ?></td>
                    <td>{{ $investment->acquired_date }}</td>
                    <td>{{ $investment->recent_value }}</td>
                    <td>{{ $investment->recent_date }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <h4>Total of initial Investment Portfolio $<?php echo $iinvest; ?>  </h4>
    <h4>Total of Current Investment Portfolio $<?php echo $cinvest; ?>  </h4>
    <br>
    <h3>Summary of Portfolio  </h3>
    <h4>Total of initial Portfolio Value $<?php echo $iinvest+$itotal; ?>  </h4>
    <h4>Total of Current Portfolio Value $<?php echo $cinvest+$stotal; ?>  </h4>
@stop