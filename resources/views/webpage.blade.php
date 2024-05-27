<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"><div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header"><h5 class="modal-title" id="exampleModalLabel">Modal title</h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body"></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button><button type="button" class="btn btn-primary">Save changes</button></div></div></div></div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">File Storage</div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                        <th>Product name</th>
                                        <th>Quantity in stock</th>
                                        <th>Price per item</th>
                                        <th>Total Value numbers</th>
                                        <th>Created</th>
                                        <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="show"></tbody>
                                    <tbody id="showtotal"></tbody>
                                </table>
                            </div>
                        </div>
                        <form id="submit_form" method="POST">
                        @csrf
                        <input type="hidden" name="created_at" id="created_at"  value="{{{Carbon\Carbon::now()->format('Y-m-d')."T".Carbon\Carbon::now()->format('H:i')}}}">
                            <div class="row mb-3">
                                <div class="col-lg-4"><input type="text" class="form-control" name="product_name" id="product_name"  placeholder="Product name" required /></div>
                                <div class="col-lg-4"><input type="text" class="form-control" name="quantity_in_stock" id="quantity_in_stock" placeholder="Quantity in stock" required /></div>
                                <div class="col-lg-4"><input type="text" class="form-control" name="price_per_item" id="price_per_item"  placeholder="Price per item" required /></div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-3"><button type="submit" class="btn btn-primary ms-auto" id="company_form_btn">Store</button></div>
                            </div>
                        </form>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    load_1();
    function load_1(){
        $.ajax({
            url:"http://127.0.0.1:8000/api",
            method:"GET",
            dataType: 'json',
            success: function(data){
                var nomor = 0;
                var total = 0;
                for(i=0; i<data.length; i++){
                  nomor++;
                  $('#show').append('<tr><th>'+data[i].product_name+'</th><th>'+data[i].quantity_in_stock+'</th><th>'+data[i].price_per_item+'</th><th>'+data[i].quantity_in_stock*data[i].price_per_item+'</th><th>'+data[i].created_at+'</th><th><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Edit</button></th></tr>');
                  total += parseInt(data[i].quantity_in_stock*data[i].price_per_item);
                }
                $('#showtotal').append('<tr><th></th><th></th><th></th><th>'+total+'</th><th></th></tr>');
            },
            // error: function(data){
            //     alert("Empty data!");
            // }
        })
    }
</script>

<script>
    $(document).on('submit', '#submit_form', function(e) {
            e.preventDefault();
            form = $(this);
            data = form.serializeArray();

            button = $(this).find('button');
            button.prop('disabled', true)
                .html(`<span class="spinner-border spinner-border-sm" role="status"></span> Please Wait...`);

            $.ajax({
                type: "POST",
                url: "/",
                data: data,
                dataType: "json",
                success: function(res) {
                    if (res.success) {
                        location.reload();
                    }
                }
            })
        });
</script>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>