@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-tags"></i> {{ $pageTitle }}</h1>
            <p>{{ $subTitle }}</p>
        </div>
    </div>
    @include('admin.partials.flash')
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <table class="table table-hover custom-data-table-style table-striped" id="sampleTable">
                        <thead>
                        <tr>
                            <th>Order Id</th>
                            <th>Name</th>
                            <th>Mobile No</th>
                            <th>Order Date</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Payment Mode</th>
                            <th>Transaction Id</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('styles')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.css">
@endpush
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.js"></script>
    <script type="text/javascript" src="{{ asset('backend/js/plugins/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('backend/js/plugins/dataTables.bootstrap.min.js') }}"></script>
    <script type="text/javascript">
        // $('#sampleTable').DataTable({"ordering": false});
        $(function () {
            $('#sampleTable').DataTable({
                lengthMenu: [ 10, 25, 50, 75, 100 ],
                pageLength: 10,
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.orders.index') }}",
                columns: [
                    {data: 'unique_code', name: 'unique_code'},
                    {data: 'name', name: 'name'},
                    {data: 'id', name: 'id',
                        render: function( data, type, full, meta ) {
                            if(full.mobile.length > 0){
                                return full.mobile;
                            }else{
                                return 'N/A';
                            }
                        }
                    },
                    {data: 'id', name: 'id',
                        render: function( data, type, full, meta ) {
                            return full.order_date_time;
                        }
                    },
                    {data: 'id', name: 'id',
                        render: function( data, type, full, meta ) {
                            return parseInt(full.total_amount) + parseInt(full.tax_amount);
                        }
                    },
                    {data: 'id', name: 'id',
                        render: function( data, type, full, meta ) {
                            var orderStatus = '';
                            switch(parseInt(full.status)){
                                case 1:orderStatus = 'Order Pending';break;
                                case 2:orderStatus = 'Order Shipped';break;
                                case 3:orderStatus = 'Order Completed';break;
                                case 4:orderStatus = 'Order Modified';break;
                                case 5:orderStatus = 'Payment Link Raised';break;
                                default: orderStatus = 'Order Cancelled';break;
                            }
                            return orderStatus;
                        }
                    },
                    {data: 'id', name: 'id',
                        render: function( data, type, full, meta ) {
                            var payMode = '';
                            switch(parseInt(full.payment_mode)){
                                case 1:payMode = 'Online Payment';break;
                                case 2:payMode = 'With Wallet';break;
                                default: payMode = 'COD';break;
                            }
                            return payMode;
                        }
                    },
                    {data: 'transaction_id', name: 'transaction_id'},
                    {data: 'id', name: 'id',orderable: false, searchable: false,
                        render: function( data, type, full, meta ) {
                            var INVOICE = "{{url('admin/orders')}}/"+data+'/invoice';
                            var VIEW = "{{url('admin/orders')}}/"+data+'/view';
                            var returnData = '<div class="btn-group" role="group" aria-label="Second group"><a href="'+INVOICE+'" class="btn btn-sm btn-primary">Invoice</a><a href="'+VIEW+'" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i></a>';
                            if(full.status == 1){
                                returnData += '<a href="javascript:void(0);" data-toggle="modal" data-target="#myModal1'+data+'" class="btn btn-sm btn-primary"><i class="fa fa-truck" aria-hidden="true"></i></a>';
                            }else{
                                // returnData += '<a href="javascript:void(0);" data-toggle="modal" data-target="#myModal2'+data+'" class="btn btn-sm btn-primary">Courier Details</a>';
                            }
                            returnData += '<a href="javascript:void(0);" data-id="'+data+'" class="sa-remove btn btn-sm btn-danger edit-btn"><i class="fa fa-trash"></i></a></div>';

                            // modal-Content for status 1
                            var UpdateURL = "{{url('admin/orders/updatecourier')}}/"+data;
                            returnData += '<div class="modal fade" tabindex="-1" role="dialog" id="myModal1'+data+'"><div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button><h4 class="modal-title">Courier Details</h4></div><div class="modal-body"><form action="'+UpdateURL+'" method="post">@csrf<div class="row"><div class="col-md-8"><div class="form-group"><label class="control-label">Courier Name </label><select class="form-control" id="courier_name" name="courier_name" required="required"><option value="">Select Courier</option>@foreach ($couriers as $c) {<option value="{{$c->name}}">{{$c->name}}</option>@endforeach</select></div><div class="form-group"><label class="control-label">POD No</label><input type="text" placeholder="Insert POD No" class="form-control" id="pod_no" name="pod_no" required></div><div class="row"><div class="col-md-6"><button class="btn btn-yellow btn-block" type="submit">Assign Courier <i class="fa fa-arrow-circle-right"></i></button></div></div></div></div></form></div><div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">Close</button></div></div></div></div>';

                            // modal-Content for status 2
                            // returnData += '<div class="modal fade myModal2'+data+'" tabindex="-1" role="dialog" id="myModal2'+data+'"><div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button><h4 class="modal-title">Courier Details</h4></div><div class="modal-body"><p>Courier Name : <b>'+full.courier_name+' </b></p><p>POD No : <b>'+full.pod_no+' </b></p></div><div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">Close</button></div></div></div></div>';
                            return returnData;
                        }
                    },
                ],
            });

            $(document).on('click','.sa-remove',function(){
                var categoryId = $(this).data('id');
                swal({
                  title: "Are you sure?",
                  text: "Your will not be able to recover the record!",
                  type: "warning",
                  showCancelButton: true,
                  confirmButtonClass: "btn-danger",
                  confirmButtonText: "Yes, delete it!",
                  closeOnConfirm: false
                },
                function(isConfirm){
                  if (isConfirm) {
                    window.location.href = "orders/"+categoryId+"/delete";
                    } else {
                      swal("Cancelled", "Record is safe", "error");
                    }
                });
            });
        });
    </script>
@endpush