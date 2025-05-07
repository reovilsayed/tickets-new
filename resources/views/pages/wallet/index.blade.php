@extends('layouts.app')
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .card-header {
            border-radius: 10px 10px 0 0 !important;
            background-color: #bd3d06 !important;
        }

        .badge {
            font-size: 0.9em;
            padding: 5px 10px;
        }

        #dynamicQrContainer {
            transition: all 0.3s ease;
        }
    </style>
@endsection
@section('content')
    <section class="rooms1 section-padding bg-cream">
        <div class="container">
          
            <div class="row">

                <div class="col-lg-6 col-md-12 mb-4">
                    <!-- Wallet Balance Card -->
                    <div class="card mb-4">
                        <div class="card-header text-white">
                            <h4 class="mb-0">Wallet Balance</h4>
                        </div>
                        <div class="card-body text-center">
                            <h1 class="display-4">$1,250.00</h1>
                            <div class="d-flex justify-content-center mt-3">
                                <button class="btn btn-success mx-2" data-bs-toggle="modal" data-bs-target="#addMoneyModal">
                                    <i class="fas fa-plus-circle"></i> Add Money
                                </button>
                                <button class="btn btn-warning mx-2" data-bs-toggle="modal" data-bs-target="#withdrawModal">
                                    <i class="fas fa-minus-circle"></i> Withdraw
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- QR Payment Section -->
                    <div class="card mb-4">
                        <div class="card-header bg-info text-white">
                            <h4 class="mb-0">QR Payment System</h4>
                        </div>
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <img src="https://via.placeholder.com/200x200.png?text=Your+QR+Code" alt="Your QR Code"
                                    class="img-fluid" style="max-width: 200px;">
                                <p class="mt-2">Scan this QR code to receive payments</p>
                            </div>
                            <div class="form-group">
                                <label for="paymentAmount">Generate Payment Request</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="paymentAmount"
                                        placeholder="Enter amount">
                                    <button class="btn btn-primary" id="generatePaymentBtn">
                                        <i class="fas fa-qrcode"></i> Generate QR
                                    </button>
                                </div>
                            </div>
                            <div id="dynamicQrContainer" class="mt-3" style="display: none;">
                                <img id="dynamicQrImage" src="" alt="Dynamic QR Code" class="img-fluid"
                                    style="max-width: 200px;">
                                <p class="mt-2">Amount: $<span id="displayAmount">0.00</span></p>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-lg-6 col-md-12">
                    <div class="card">
                        <div class="card-header bg-secondary text-white">
                            <h4 class="mb-0">Transaction History</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Description</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>15 May 2023 14:30</td>
                                            <td>Wallet Deposit</td>
                                            <td class="text-success">+$500.00</td>
                                            <td><span class="badge bg-success">Completed</span></td>
                                        </tr>
                                        <tr>
                                            <td>10 May 2023 09:15</td>
                                            <td>Payment Received via QR</td>
                                            <td class="text-success">+$250.00</td>
                                            <td><span class="badge bg-success">Completed</span></td>
                                        </tr>
                                        <tr>
                                            <td>05 May 2023 16:45</td>
                                            <td>Withdrawal Request</td>
                                            <td class="text-danger">-$300.00</td>
                                            <td><span class="badge bg-success">Completed</span></td>
                                        </tr>

                                        <tr>
                                            <td>28 Apr 2023 13:10</td>
                                            <td>Pending Withdrawal</td>
                                            <td class="text-danger">-$200.00</td>
                                            <td><span class="badge bg-warning">Pending</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <nav aria-label="Transaction pagination">
                                    <ul class="pagination justify-content-center">
                                        <li class="page-item disabled">
                                            <a class="page-link" href="#" tabindex="-1">Previous</a>
                                        </li>
                                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                                        <li class="page-item">
                                            <a class="page-link" href="#">Next</a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Money Modal -->
        <div class="modal fade" id="addMoneyModal" tabindex="-1" aria-labelledby="addMoneyModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title" id="addMoneyModalLabel">Add Money to Wallet</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addMoneyForm">
                            <div class="form-group mb-3">
                                <label for="amount">Amount</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" class="form-control" id="amount" name="amount"
                                        min="1" step="0.01" required>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label class="mb-2">Payment Method</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="payment_method" id="creditCard"
                                        value="credit_card" checked>
                                    <label class="form-check-label" for="creditCard">
                                        Credit/Debit Card
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="payment_method"
                                        id="bankTransfer" value="bank_transfer">
                                    <label class="form-check-label" for="bankTransfer">
                                        Bank Transfer
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="payment_method" id="other"
                                        value="other">
                                    <label class="form-check-label" for="other">
                                        Other Payment
                                    </label>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-success" id="confirmAddMoney">Add Money</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Withdraw Modal -->
        <div class="modal fade" id="withdrawModal" tabindex="-1" aria-labelledby="withdrawModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-warning text-white">
                        <h5 class="modal-title" id="withdrawModalLabel">Withdraw Money</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="withdrawForm">
                            <div class="form-group mb-3">
                                <label for="withdrawAmount">Amount</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" class="form-control" id="withdrawAmount" name="amount"
                                        max="1250.00" min="1" step="0.01" required>
                                </div>
                                <small class="form-text text-muted">Available balance: $1,250.00</small>
                            </div>
                            <div class="form-group mb-3">
                                <label for="bankDetails">Bank Account Details</label>
                                <select class="form-control" id="bankDetails" name="bank_account_id" required>
                                    <option value="">Select Bank Account</option>
                                    <option value="1">Bank of America - ****3456 (John Doe)</option>
                                    <option value="2">Chase Bank - ****7890 (John Doe)</option>
                                </select>
                                <small class="form-text text-muted">
                                    <a href="#" id="addBankAccount">Add new bank account</a>
                                </small>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-warning" id="confirmWithdraw">Request Withdrawal</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // QR Code Generation
            document.getElementById('generatePaymentBtn').addEventListener('click', function() {
                const amount = document.getElementById('paymentAmount').value;
                if (amount && amount > 0) {
                    // In a real app, you would generate a QR code with payment details
                    document.getElementById('displayAmount').textContent = parseFloat(amount).toFixed(2);
                    document.getElementById('dynamicQrImage').src =
                        `https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=payment:${amount}`;
                    document.getElementById('dynamicQrContainer').style.display = 'block';
                } else {
                    alert('Please enter a valid amount');
                }
            });

            // Add Money Modal
            document.getElementById('confirmAddMoney').addEventListener('click', function() {
                const amount = document.getElementById('amount').value;
                if (amount && amount > 0) {
                    alert(`Deposit of $${amount} will be processed in live version`);
                    // Here you would submit the form via AJAX or regular form submission
                    bootstrap.Modal.getInstance(document.getElementById('addMoneyModal')).hide();
                } else {
                    alert('Please enter a valid amount');
                }
            });

            // Withdraw Modal
            document.getElementById('confirmWithdraw').addEventListener('click', function() {
                const amount = document.getElementById('withdrawAmount').value;
                const bankAccount = document.getElementById('bankDetails').value;

                if (!amount || amount <= 0) {
                    alert('Please enter a valid amount');
                    return;
                }
                if (!bankAccount) {
                    alert('Please select a bank account');
                    return;
                }

                alert(`Withdrawal request of $${amount} will be processed in live version`);
                // Here you would submit the form via AJAX or regular form submission
                bootstrap.Modal.getInstance(document.getElementById('withdrawModal')).hide();
            });

            // Add Bank Account link
            document.getElementById('addBankAccount').addEventListener('click', function(e) {
                e.preventDefault();
                alert('Bank account add functionality will work in live version');
            });
        });
    </script>
@endsection
