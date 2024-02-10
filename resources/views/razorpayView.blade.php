<form id="razorpay-form" action="{{ route('razorpay.payment.store') }}" method="POST" >
                @csrf
                <script src="https://checkout.razorpay.com/v1/checkout.js"
                        data-key="rzp_test_0Ihgj1t3Jmwv3i"
                        data-amount="{{($cartAmount['amount'] + defaultShippingCharges($cartItems, $cartAmount['amount'])) * 100}}"
                        data-buttontext="Pay {{$cartAmount['amount'] + defaultShippingCharges($cartItems, $cartAmount['amount'])}} INR"
                        data-name="MbizSpare"
                        data-description="Rozerpay"
                        data-image="https://www.itsolutionstuff.com/frontTheme/images/logo.png"
                        data-prefill.name="name"
                        data-prefill.email="email"
                        data-theme.color="#ff7529">
                </script>
            </form>