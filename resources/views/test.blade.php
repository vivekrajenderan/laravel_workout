<!doctype html>
<html>
    <head>
        <title>Look at me Login</title>
    </head>
    <body>
        <h1>Product Page</h1>
        @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <form method="post" autocomplete="off" id="login-form" action="product/ajax-product">
            <h1>Login Form</h1>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">


            <div class="form-group elVal">
                
                <input type="text" class="form-control" name="product[]" id="product1" placeholder="Product1" value="{{Request::old('product.0')}}"/>
            </div>
            <div class="form-group elVal">
                <input type="text" class="form-control" name="product[]" id="product2" placeholder="Product2" value="{{Request::old('product.1')}}"/>
                
            </div>
            <div>
                <button type="submit" class="btn btn-default submit"> Log in</button>              
            </div>

            <div class="clearfix"></div>

            <div class="separator">

                <div class="clearfix"></div>
                <br />

                <div>
                    <h1><i class="fa fa-paw"></i> Aadhar!</h1>
                    <p>©2016 All Rights Reserved. Aadhar APP. Privacy and Terms</p>
                </div>
            </div>
        </form>

    </body>
</html>