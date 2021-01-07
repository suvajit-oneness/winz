@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')

@php
$noofproduct = 0;
$totalamm = 0;
$totalqunatity = 0;
$taxamm = 0;
$discount = 0;
$extra_discount = 0;
$shippingcharge = 0;
@endphp
<li class="search-box">
    <button type="submit" class="btn btn-info btn-mini pull-right printbtn" onclick="printResultHandler()">Print</button>
</li>
<div class="row invoice" id="print_div" style="margin-top:20px;">
        <div class="col-sm-12">
            <div class="col-sm-6">
                <div class="logo"><img src="{{ asset('/images/logo.png') }}" style="width:200px;margin-bottom:20px;">
                <span style="display:block;font-size:20px;font-weight:500;margin-top:-25px;margin-left:82px;">Winz</span>
                </div>
            </div>
            {{-- <div class="col-sm-6">
                <h3 style="margin-top: 20px;"><b>Tax Invoice/Bill of Supply/Cash Memo</b></h3>
            </div> --}}
        </div>
         
        <div class="col-sm-12">
            <table class="table details">
                <tr>
                    <td style="border: none;">
                        <p style="margin: 0;"><strong>Sold By:</strong></p>
                        <p style="margin: 0;">Winz<br/>Test address,<br/></br> Test .</p>
                    </td>
                    <td align="right" style="border: none;">
                        <p style="margin: 0;"><strong>Buyer Details:</strong></p>
                        <p style="margin: 0;"><strong>Name:</strong> {{ $booking->name }} </p>
                        <p style="margin: 0;"><strong>Email:</strong> {{ $booking->email }}</p>
                        <p style="margin: 0;"><strong>Mobile:</strong>  {{ $booking->mobile }}</p>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><div class="spacer20"></div></td>
                </tr>
                <tr>
                    <td colspan="2" align="right" style="border: none;">
                        <p style="margin: 0;"><strong>Billing Address:</strong></p>
                        <p style="margin: 0;">{{ $booking->name }}</p>
                        <p style="margin: 0;"> {{ $booking->billing_address }} </br>{{ $booking->billing_city }} {{ $booking->billing_pin }}</p>
                    </td>
                </tr>

                <tr>
                    <td style="border: none;">
                        <p style="margin: 0;"><strong>GST Registration No.</strong> xxxxxxxxxx</p>
                    </td>
                    <td align="right" style="border: none;">
                        <p style="margin: 0;"><strong>Shipping Address:</strong></p>
                        <p style="margin: 0;"><?=$booking->name?></p>
                        <p style="margin: 0;">{{ $booking->shipping_address }} </br>{{ $booking->shipping_city }} {{ $booking->shipping_pin }}</p>
                        <p style="margin: 0;"><?=$booking->mobile?></p>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><div class="spacer20"></div></td>
                </tr>
                <tr>
                    <td style="border: none;">
                        <p style="margin: 0;"><strong>Order No:</strong> {{ $booking->unique_code }}</p>
                        <p style="margin: 0;"><strong>Order Date: </strong> {{ Carbon\Carbon::parse($booking->order_date_time)->format('d-M-Y') }}</p>
                    </td>

                    <td align="right" style="border: none;">
                        <p style="margin: 0;"><strong>Invoice No:</strong> IN- {{$booking->id}}</p>
                        <p style="margin: 0;"><strong>Invoice Date: </strong> {{ Carbon\Carbon::parse($booking->order_date_time)->format('d-M-Y') }} </p>
                    </td>
                </tr> 
                <tr>
                    <td colspan="2"><div class="spacer20"></div></td>
                </tr> 
                 <tr>
                    <td  style="border: none;">
                        <p style="margin: 0;"><strong>Payment Method:</strong> 
                            @if($booking->payment_mode==1){{'Online Payment'}}
                            @elseif($booking->payment_mode==2){{'With Wallet'}}
                            @elseif($booking->payment_mode==3){{'COD'}}
                            @endif</p>
                    </td>

                    {{-- <td align="right" style="border: none;">
                        <p style="margin: 0;"><strong>Shipping Method:</strong> Shiprocket</p>
                    </td> --}}
                </tr>      
            </table>
        </div>

        <div class="clearfix"></div>
        <div class="col-sm-12">
            <table class="table table-striped table-bordered table-hover table-full-width">
                <thead>
                    <tr style="background-color: black;">
                        <th>Sr No</th>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Tax Per Product</th>
                        <th>Price</th>
                        <th>Unit Cost</th>
                    </tr>
                </thead>

                <tbody>
                        @if(!empty($booking->bookingProduct))
                        @php $slno = 1; @endphp
                        @foreach($booking->bookingProduct as $key => $n)
                        @php
                        $totalamm += ($n->price * $n->quantity);
                        if($n->price >=1000){
                                $taxamm += (($n->price/112) *12) * $n->quantity;
                            } else {
                            $taxamm += (($n->price/105)*5) * $n->quantity;
                        }
                        @endphp
                            <tr >
                                <td>{{ $slno }}</td>
                                <td>{{ $n->product_name }} </br>
                                @if( ($n->quantity * $n->price) >=1000 ) 
                                @elseif( ($n->quantity * $n->price) < 1000 ) 
                                @endif
                                </td>
                                <td>{{ $n->quantity }}  &nbsp Pc(s)</td>
                                <td> {{ 0 }}
                                   
                                </td>
                                <td>{{ $n->price }}</td>
                                <td> {{ $n->quantity * $n->price }}
                                    
                                </td>
                            
                            </tr>
                        @php $slno++ ; @endphp    
                        @endforeach
                        @endif    
                    <tr>
                        <td colspan="4"></td>
                        <td>Basic Amount</td>
                        <td>{{ $totalamm }}</td>
                    </tr>
                    <tr>
                        <td colspan="4"></td>
                        <td>Tax Amount (GST) <span style="position: absolute;right: 14%;"> + </span> </td>
                        <td>{{ 0 }}</td>
                    </tr>
                    <tr>
                        <td colspan="4"></td>
                        <td>Discount Amount <span style="position: absolute;right: 14%;"> - </span></td>
                        <td>0</td>
                    </tr>
                    
                    <tr>
                        <td colspan="4"></td>
                        <td>Shipping Charge <span style="position: absolute;right: 14%;"> + </span> <br></td>
                        <td>{{ $booking->shipping_charge }}</td>
                    </tr>
                    <tr>
                        <td colspan="4"></td>
                        <td>Total Payable</td>
                        <td>{{ $booking->total_amount }}</td>
                    </tr>
                    <tr>
                        <td colspan="4"></td>
                        <td>Total Paid</td>
                        <td>{{ $booking->total_amount }}</td>
                    </tr>
                    <tr>
                        <td colspan="4"></td>
                        <td>Total Remaining</td>
                        <td>0</td>
                    </tr>
                    <tr>
                        <td colspan="6">
                            Amount In Word : <b>{{ convert_number_to_words($booking->total_amount) .' rupees only' }}</b>
                        </td>
                    </tr>
                    {{-- <tr>
                        <td colspan="5" align="right">
                            For Mashroo:
                            <br/>
                            <br/>
                            <br/>
                        </td>
                    </tr> --}}
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>

<!-- print view-->
<div class="header" style="display:none; border-bottom: 4px solid #12A4A3;" id="print_head">
    <style rel="stylesheet" media="print" type="text/css">
        @media print {
            .btn{
                display:none!important;
            }
        }
    </style>
</div>

<div id="bill_footer" style="display:none;">
    <table class="table">
        
    </table>
</div>
@endsection
@push('scripts')
<script type="text/javascript">
    function printResultHandler() {
        //Get the HTML of div
        var print_header = document.getElementById("print_head").innerHTML;
        var divElements = document.getElementById("print_div").innerHTML;
        var print_footer = document.getElementById("bill_footer").innerHTML;

        //Get the HTML of whole page
        var oldPage = document.body.innerHTML;
        //Reset the page's HTML with div's HTML only
        document.body.innerHTML =
                "<html><head><title></title></head><body><font size='2'>" +
                divElements + "</font>" + print_footer + "</body>";
        //Print Page
        window.print();
        //Restore orignal HTML
        document.body.innerHTML = oldPage;
        //bindUnbind();
    }
</script>
@endpush