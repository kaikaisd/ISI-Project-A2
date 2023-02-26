@extends('layouts.app')

@section('content')
<body>
  <div class="container">
    <h1>Checkout Page</h1>
    <div class="row">
      <div class="col-md-6">
        <h2>Step 1: Your Address</h2>
        <form>
          <div class="form-group">
            <label for="product">Product:</label>
            <input type="text" class="form-control" id="product" placeholder="Enter product name" required>
          </div>
          <div class="form-group">
            <label for="address">Address:</label>
            <textarea class="form-control" id="address" placeholder="Enter your address" required></textarea>
          </div>
          <button type="submit" class="btn btn-primary">Next</button>
        </form>
      </div>
      <div class="col-md-6">
        <h2>Step 2: Order Confirmation</h2>
        <div id="order-summary">
          <p>Your order for <span id="product-name"></span> will be delivered to:</p>
          <p id="address-summary"></p>
          <p>Your order number is: <span id="order-number"></span></p>
        </div>
      </div>
    </div>
  </div>

  <script>
    $(document).ready(function(){
      // Step 1 form submit
      $("form").submit(function(event){
        event.preventDefault();
        var product = $("#product").val();
        var address = $("#address").val();

        // Populate order summary with form data
        $("#product-name").text(product);
        $("#address-summary").text(address);

        // Generate random order number and display it in order summary
        $("#order-number").text({{ rand(1000, 9999) }});

        // Hide step 1 form and show step 2 order summary
        $(this).hide();
        $("#order-summary").show();
      });
    });
  </script>
</body>
</html>

@endsection