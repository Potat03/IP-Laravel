<form action="/charge" method="POST">
    {{ csrf_field() }}
    <label for="amount">
        Amount (in cents):
        <input type="text" name="amount" id="amount">
    </label>

    <label for="email">
        Email:
        <input type="text" name="email" id="email">
    </label>

    <label for="card-element">
        Credit or debit card
    </label>
    <div id="card-element">
        <!-- A Stripe Element will be inserted here. -->
    </div>

    <!-- Used to display form errors. -->
    <div id="card-errors" role="alert"></div>

    <button type="submit">Submit Payment</button>
</form>

<!-- Stripe JS -->
<script src="https://js.stripe.com/v3/"></script>