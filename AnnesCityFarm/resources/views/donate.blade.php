@extends('layouts.app')
@section('content')
    <div class="container mt-5">
        <h1 class="text-center">Donate Now</h1>
        <div class="row justify-content-center mt-4">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        {{-- <form action="/donate" method="post"> --}}
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="amount">Donation Amount</label>
                            <input type="number" class="form-control" id="amount" name="amount" required>
                        </div>
                        <div class="form-group">
                            <label for="payment-method">Payment Method</label>
                            <select class="form-control" id="payment-method" name="payment-method" required>
                                <option value="credit-card">Credit Card</option>
                                <option value="paypal">PayPal</option>
                                <option value="bank-transfer">Bank Transfer</option>
                            </select>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Donate</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
@endsection
