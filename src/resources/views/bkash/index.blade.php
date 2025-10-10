<div class="container mt-5 text-center">
    <h3 class="mb-4 text-danger">bKash Payment Demo (Softrang)</h3>
    <form action="{{ route('bkash.pay') }}" method="POST">
        @csrf
        <input type="number" name="amount" value="100" class="form-control mb-3" placeholder="Enter amount" required>
        <button class="btn btn-danger">Pay with bKash</button>
    </form>
</div>
