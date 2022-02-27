<!DOCTYPE html>
<html>
<head>
    <title></title>

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
        }
        .table-bordered, .table-bordered th, .table-bordered > td {
            border: 1px solid black;
            border-collapse: collapse;
            font-size: 12px;
        }

        .table-bordered th, .table-bordered td {
            padding: 3px;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body style="width: 100%; height: 500px;">
@foreach($orders as $order)
    <div class="top">
        <div class="top-left" style="width: 348px; display: inline-block">
            <div class="logo" style="padding:0; margin:0;">
                @if ($logo_paths[$loop->index] != '')
                    <img src="{{ $logo_paths[$loop->index] }}" width="180px;"> <br>
                @endif
            </div>
            <div class="compaddress" style="font-size:13px;">
                {{ $order->vendor->billing_address }}<br>
                {{ ' '.$order->vendor->billing_city }}
                @if ($order->vendor->billingState == null)
                    {{ $order->vendor->billing_state }},
                @else
                    {{ $order->vendor->billingState->name }},
                @endif
                {{ $order->vendor->billingCountry->name.' - '.$order->vendor->billing_zip }}
            </div>
        </div>

        <div class="top-right" style="width: 348px; display: inline-block; vertical-align: top;">
            <table style="font-size: 13px;text-align: left; border: 1px solid black; width: 100%">
                <tr>
                    <th style="background:#efefef;">Order No.</th>
                    <td>{{ $order->order_number }}</td>
                </tr>

                <tr>
                    <th style="background: #efefef;">Order Date</th>
                    <td>{{ date('F d, Y h:i:s a', strtotime($order->created_at)) }}</td>
                </tr>

                <tr>
                    <th style="background:#efefef;">Invoice No.</th>
                    <td>{{ $order->invoice_number }}</td>
                </tr>
            </table>
        </div>
    </div>

    <br>

    <div class="address" style="margin-top: 30px;">
        <div class="billing" style="width: 348px; display: inline-block">
            <div class="header" style="border: 1px solid black; padding: 5px;font-size:15px; background:#efefef;">
                Billing Information
            </div>

            <div class="address-body" style="font-size:12px; border: 1px solid black; padding: 5px; border-top: none">
                <table style="width: 100%; text-align: left">
                    <tr>
                        <td style="width:20%">Company:</td>
                        <td>{{ $order->company_name }}</td>
                    </tr>

                    <tr>
                        <td>Contract:</td>
                        <td>{{ $order->name }}</td>
                    </tr>

                    <tr>
                        <td>Address:</td>
                        <td>{{ $order->billing_address }}<br>
                            {{ $order->billing_city }}, {{ $order->billing_state }}, {{ $order->billing_country }} - {{ $order->billing_zip }}</td>
                    </tr>

                    <tr>
                        <td>Phone:</td>
                        <td>{{ $order->billing_phone }}</td>
                    </tr>

                    <tr>
                        <td>Email:</td>
                        <td>{{ $order->email }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="billing" style="width: 348px; display: inline-block">
            <div class="header" style="border: 1px solid black; padding: 5px;font-size:15px; background:#efefef;">
                Shipping Information
            </div>

            <div class="address-body" style="font-size:12px;border: 1px solid black; padding: 5px; border-top: none">
                <table style="width: 100%; text-align: left">
                    <tr>
                        <td style="width:20%">Company:</td>
                        <td>{{ $order->company_name }}</td>
                    </tr>

                    <tr>
                        <td>Contract:</td>
                        <td>{{ $order->name }}</td>
                    </tr>

                    <tr>
                        <td>Address:</td>
                        <td>{{ $order->shipping_address }}<br>
                            {{ $order->shipping_city }}, {{ $order->shipping_state }}, {{ $order->shipping_country }} - {{ $order->shipping_zip }}</td>
                    </tr>

                    <tr>
                        <td>Phone:</td>
                        <td>{{ $order->shipping_phone }}</td>
                    </tr>

                    <tr>
                        <td>Email:</td>
                        <td>{{ $order->email }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="payment" style="width: 700px;">
        <table style="width: 100%" class="table-bordered">
            <tr>
                <th>PAYMENT TERMS</th>
                <th>SHIP VIA</th>
                <th>TRACKING NO.</th>
            </tr>

            <tr>
                <td>{{ ($order->card_number!='')?str_repeat("*", (strlen($order->card_number) - 4)).substr($order->card_number,-4,4):'' }}</td>
                <td>{{ $order->shipping }}</td>
                <td>{{ $order->tracking_number }}</td>
            </tr>
        </table>
    </div>

    <div class="items" style="width: 700px; margin-top: 5px;">
        <table class="table-bordered" style="width: 100%; text-align: center">
            <thead>
            <tr>
                <th>Style No.</th>
                <th class="text-center">Color</th>
                <th class="text-center">Size</th>
                <th class="text-center">Pack</th>
                <th class="text-center">Total Qty</th>
                <th class="text-center">Unit Price</th>
                <th class="text-center">Amount</th>
            </tr>
            </thead>

            <tbody>
            @foreach($all_items[$loop->index] as $item_id => $items)
                <tr>
                    <td>
                        {{ $items[0]->item->style_no }}
                    </td>

                    <td>
                        <table style="width: 100%; text-align: center">
                            <thead>
                            <tr>
                                <td style="border-top: none">&nbsp;</td>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($items as $item)
                                <tr>
                                    <td>{{ $item->color }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </td>

                    <td>
                        <?php
                        $sizes = explode("-", $items[0]->size);
                        ?>

                        <table style="width: 100%; text-align: center">
                            <thead>
                            <tr>
                                @foreach($sizes as $size)
                                    <th style="border: none">{{ $size }}</th>
                                @endforeach
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($items as $item)
                                <?php $packs = explode("-", $item->pack); ?>
                                <tr>
                                    @for($i=0; $i < sizeof($sizes); $i++)
                                        <td>{{ $packs[$i] }}</td>
                                    @endfor
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </td>

                    <td>
                        <table style="width: 100%; text-align: center">
                            <thead>
                            <tr>
                                <th style="border: none">&nbsp;</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($items as $item)
                                <tr>
                                    <td>
                                        {{ $item->qty }}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </td>

                    <td>
                        <table style="width: 100%; text-align: center">
                            <thead>
                            <tr>
                                <th style="border: none">&nbsp;</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($items as $item)
                                <tr>
                                    <td>
                                        <span class="total_qty">{{ $item->total_qty }}</span>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </td>

                    <td>
                        <table style="width: 100%; text-align: center">
                            <thead>
                            <tr>
                                <th style="border: none">&nbsp;</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($items as $item)
                                <tr>
                                    <td>
                                        ${{ sprintf('%0.2f', $item->per_unit_price) }}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </td>

                    <td>
                        <table style="width: 100%; text-align: center">
                            <thead>
                            <tr>
                                <th style="border: none">&nbsp;</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($items as $item)
                                <tr>
                                    <td>
                                        <span>${{ sprintf('%0.2f', $item->amount) }}</span>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="calculation" style="width: 698px; margin-top: 5px; border: 1px solid black">
        <table style="font-size:12px;margin-left: 390px">
            <tr>
                <th style="width: 100px;text-align: right;padding-right:15px;">Subtotal:</th>
                <td style="width: 50px">${{ sprintf('%0.2f', $order->subtotal) }}</td>
            </tr>

            <tr>
                <th style="width: 100px;text-align: right;padding-right:15px;">Discount:</th>
                <td style="width: 50px">${{ sprintf('%0.2f', $order->discount) }}</td>
            </tr>

            <tr >
                <th style="width: 100px;text-align: right;padding-right:15px;">Shipping Cost:</th>
                <td style="width: 50px">${{ sprintf('%0.2f', $order->shipping_cost) }}</td>
            </tr>

            <tr>
                <th style="width: 100px;text-align: right;padding-right:15px;">Total:</th>
                <td style="width: 50px">${{ sprintf('%0.2f', $order->total) }}</td>
            </tr>
        </table>
    </div>
    <div class="returnpolicy" style="width: 698px;margin-top:30px;border: 1px solid black;">
        <div class="returntitle" style="padding:5px 10px;background: #efefef;border-bottom: 1px solid black;">Privacy policy</div>
        <div calss="policy">
            {{-- <p style="font-size:12px; padding:10px;">Return Policy Our return policy is that return request must be requested within 12 days after receiving the item. All sales are not subject to a refund. In some cases, only merchandise exchanges or store credit may be issued. If an order cancellation is necessary, a written request to the manufacturer must be approved before any order can be cancelled. All returns will not have a restocking fee for 7 days if the returned merchandise is returned in unopened condition with the manufacturers' seal. If the package is returned in opened condition, there is a minimum 10% restocking fee. 20% restocking charge on ALL RETURNED GOODS FOR CREDIT after 7 days. It is the customer's responsibility to bring the products to our facility for exchange. No store credit is issued after 14 days. (Absolutely no returns for special orders.) $25.00 charge for any returned checks. Claims for any damage must be mad within 2 days upon receipt of merchandise and all items returned for credit must be in the original packaging with all parts included. Price on this invoice does not included shopping and handling fees. Shipping and handling are non refundable. (Including but not limited to all refused and unaccepted packages.)</p> --}}
            <p style="font-size:12px; padding:10px;">{!! $privacy_policy !!}</p>
        </div>
    </div>

    @if (!$loop->last)
        <div class="page-break"></div>
    @endif
@endforeach
</body>
</html>
